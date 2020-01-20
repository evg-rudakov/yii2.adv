<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 13/01/2020
 * Time: 19:32
 */

namespace console\components;

use frontend\models\ChatLog;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage; // Для хранения технической информации об присоединившихся клиентах используется технология SplObjectStorage, встроенная в PHP
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->sendHelloMessage($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        var_dump($msg);
        $msgArray = json_decode($msg, true);

        ChatLog::create($msgArray);

        if ($msgArray['type'] === ChatLog::SHOW_HISTORY) {
            $this->showHistory($from, $msgArray);
        } else {
            foreach ($this->clients as $client) {
                /**
                 * @var ConnectionInterface $client
                 */
                $msgArray['created_at'] = \Yii::$app->formatter->asDatetime(time());
                $this->sendMessage($client, $msgArray);
            }
        }
    }


    private function showHistory(ConnectionInterface $conn, array $msg)
    {
        $chatLogsQuery = ChatLog::find()->orderBy('created_at ASC');

        if (isset($msg['task_id'])) {
            $chatLogsQuery->andWhere(['task_id' => (int) $msg['task_id']]);
        }

        if (isset($msg['project_id'])) {
            $chatLogsQuery->andWhere(['project_id' => (int) $msg['project_id']]);
        }

        foreach ($chatLogsQuery->each() as $chatLog) {
            /**
             * @var ChatLog $chatLog
             */
            $this->sendMessage($conn, [
                'message'=>$chatLog->message,
                'username'=>$chatLog->username,
                'created_at'=>\Yii::$app->formatter->asDatetime($chatLog->created_at)
            ]);
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param array $msg
     */
    private function sendMessage(ConnectionInterface $conn, array $msg)
    {
        $conn->send(json_encode($msg));
    }

    /**
     * @param ConnectionInterface $conn
     */
    private function sendHelloMessage(ConnectionInterface $conn)
    {

        $this->sendMessage($conn,['message' => 'Всем привет', 'username' => 'Чат студентов geekbrains.ru']);
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}