<?php

declare(strict_types=1);

namespace App;

final class UserRepository
{
    private \mysqli $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function userExists(string $username, string $password): bool
    {
        $result = $this->connection
            ->query(sprintf(
                'select count(*) as usersCount from users where username = "%s" and password = "%s"',
                $this->connection->real_escape_string($username),
                $this->connection->real_escape_string($password)
            ));

        return '1' === $result->fetch_assoc()['usersCount'];
    }

    public function getAmount(string $username): int
    {
        return (int) $this->connection
            ->query(sprintf(
                'select amount from users where username = "%s"',
                $this->connection->real_escape_string($username)
            ))
            ->fetch_assoc()['amount'];
    }

    public function withdraw(string $username, int $withdraw): void
    {
        $this->connection->begin_transaction();
        $this->connection
            ->query(sprintf(
                'update users set amount = amount - %s where username = "%s"',
                $withdraw,
                $this->connection->real_escape_string($username)
            ));
        $this->connection->commit();
    }
}
