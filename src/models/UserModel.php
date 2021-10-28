<?php
declare(strict_types=1);

namespace App\models;


class UserModel extends AbstractModel
{
    public function createNewUser(string $email, string $password): int
    {
        $statement = $this->connection->prepare(
            'INSERT INTO `users` (`email`, `password`) values (:email, :password)'
        );

        $password = password_hash($password, PASSWORD_BCRYPT);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->execute();

        return (int)$this->connection->lastInsertId();
    }


    public function getUser(string $email): ?array
    {
        $statement = $this->connection->prepare('SELECT `password`, `user_id`, `email` FROM `users` WHERE `email` = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();

        return $statement->fetch() ?: [];
    }
}


