<?php
declare(strict_types=1);

namespace App\models;

use PDO;

class TodoModel extends AbstractModel
{
    public function getAll($userId): array
    {
        $statement = $this->connection->prepare('SELECT * FROM `list` WHERE `user_id` = :user_id');
        $statement->bindParam(':user_id', $userId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        return $statement->fetchAll();
    }

    public function getDone($userId): array
    {
        $statement = $this->connection->prepare('SELECT * FROM `list` where `completed` = 1 and `user_id` = :user_id ');
        $statement->bindParam(':user_id', $userId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        return $statement->fetchAll();
    }

    public function updateStatus(int $id): void
    {
        $statement = $this->connection->prepare('UPDATE `list` SET `completed` = 1 where `id` = :id ');
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function newTask(string $task, $userId):void
    {
        $statement = $this->connection->prepare('INSERT INTO `list` (task, user_id) values (:task, :user_id)');
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':task', $task);
        $statement->execute();
    }

    public function delete(int $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM `list` where `id` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
}

