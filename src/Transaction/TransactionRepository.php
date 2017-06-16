<?php

namespace SwedbankPaymentPortal\Transaction;

use Doctrine\Common\Cache\FilesystemCache;
use SwedbankPaymentPortal\Transaction\TransactionRepositoryInterface;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\Transaction\TransactionContainer;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var FilesystemCache
     */
    protected $fileCache;

    /**
     * @var int
     */
    protected $timeInterval;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var string Where are the list of keys stored.
     */
    private $KEY_LIST_CACHE_ID;

    /**
     * TransactionRepository constructor.
     *
     * @param Serializer $serializer
     * @param string     $prefix
     * @param int        $timeInterval Time interval in minutes after which purchase should be returned as unfinished.
     * @param string     $dir
     */
    public function __construct(Serializer $serializer, $prefix = '', $timeInterval = 30, $dir = null)
    {
        $this->serializer        = $serializer;
        $this->KEY_LIST_CACHE_ID = "KEYS_$prefix";
        $this->timeInterval      = $timeInterval;
        $this->fileCache         = new FilesystemCache($dir ? $dir : sys_get_temp_dir() . '/banklink');
    }

    /**
     * {@inheritdoc}
     */
    public function persist(TransactionContainer $transactionContainer)
    {
        $this->addKey($transactionContainer->getKey(), $transactionContainer->isPendingResult());
        $this->fileCache->save($transactionContainer->getKey(), $this->serialize($transactionContainer));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $data = $this->fileCache->fetch($key);

        if (!$data) {
            throw new \RuntimeException("Cannot find key in cache: $key");
        }

        return $this->deSerialize($data);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $this->removeKey($key);

        return $this->fileCache->delete($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getPendingTransactions()
    {
        $result = [];

        foreach ($this->getKeys() as $key => $isPending) {
            if ($isPending) {
                $result[] = $this->get($key);
            }
        }

        return $result;
    }

    /**
     * Serializes TransactionContainer object into a string.
     *
     * @param TransactionContainer $transactionContainer
     *
     * @return string
     */
    private function serialize(TransactionContainer $transactionContainer)
    {
        $result = [
            'key'                         => $transactionContainer->getKey(),
            'frames'                      => [],
            'callback'                    => $transactionContainer->getCallback(),
            'pending_results'             => $transactionContainer->isPendingResult(),
            'entered_to_success_url_time' => $transactionContainer->getEnteredToSuccessUrlTime(),
            'last_querying_time'          => $transactionContainer->getLastQueryingTime(),
            'created_at'                  => $transactionContainer->getCreatedAt(),
        ];

        foreach ($transactionContainer->getFrames() as $frame) {
            $result['frames'][] = $this->serializeFrame($frame);
        }

        return serialize($result);
    }

    /**
     * Serializes TransactionFrame object into a string.
     *
     * @param TransactionFrame $transactionFrame
     *
     * @return string
     */
    private function serializeFrame(TransactionFrame $transactionFrame)
    {
        return serialize(
            [
                'request' => [
                    'object' => $this->serializer->getXml($transactionFrame->getRequest()),
                    'class' => get_class($transactionFrame->getRequest()),
                ],
                'response' => [
                    'object' => $this->serializer->getXml($transactionFrame->getResponse()),
                    'class' => get_class($transactionFrame->getResponse()),
                ],
            ]
        );
    }

    /**
     * Deserializes string into TransactionContainer object.
     *
     * @param string $data
     *
     * @return TransactionContainer
     */
    private function deSerialize($data)
    {

        $arrayData = unserialize($data);

        $transactionContainer = new TransactionContainer(
            $arrayData['key'],
            $arrayData['callback'],
            $arrayData['pending_results'],
            $arrayData['entered_to_success_url_time'],
            $arrayData['last_querying_time'],
            isset($arrayData['created_at']) ? $arrayData['created_at'] : null
        );

        foreach ($arrayData['frames'] as $frame) {
            $transactionContainer->addFrame($this->deSerializeFrame($frame));
        }

        return $transactionContainer;
    }

    /**
     * Deserializes string into TransactionFrame object.
     *
     * @param string $data
     *
     * @return TransactionFrame
     */
    private function deSerializeFrame($data)
    {
        $arrayData = unserialize($data);
        $transactionFrame = new TransactionFrame(
            $this->serializer->getObject($arrayData['request']['object'], $arrayData['request']['class'])
        );
        $transactionFrame->setResponse(
            $this->serializer->getObject($arrayData['response']['object'], $arrayData['response']['class'])
        );

        return $transactionFrame;
    }

    /**
     * Adds timestamp with key to the timestamp cache.
     *
     * @param string $key
     * @param bool   $pendingResult
     */
    private function addKey($key, $pendingResult)
    {
        $keys = $this->getKeys();
        $keys[$key] = $pendingResult;
        $this->fileCache->save($this->KEY_LIST_CACHE_ID, $keys);
    }

    /**
     * Removes timestamp from the timestamp cache.
     *
     * @param string $key
     */
    private function removeKey($key)
    {
        $keys = $this->getKeys();
        unset($keys[$key]);
        $this->fileCache->save($this->KEY_LIST_CACHE_ID, $keys);
    }

    /**
     * Returns all timestamps.
     *
     * @return array
     */
    private function getKeys()
    {
        $keys = $this->fileCache->fetch($this->KEY_LIST_CACHE_ID);
        $keys = !$keys ? [] : $keys;

        return $keys;
    }
}
