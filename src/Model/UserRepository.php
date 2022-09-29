<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Model;

use FaaPz\PDO\Database;

class UserRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @throws \Exception
     */
    public function create(User $user): string
    {
        $insertStatement = $this->database->insert([
            'first_name',
            'last_name',
            'email',
            'gender',
            'is_active',
            'password'
        ])
            ->into('users')
            ->values([
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                $user->getGender(),
                $user->getisActive(),
                password_hash($user->getPassword(), PASSWORD_DEFAULT)
            ]);

        return $insertStatement->execute();
    }

    /**
     * @throws \Exception
     */
    public function readByLoginAndPassword(string $login, string $password): User
    {
        $selectStatement = $this->database->select()
            ->from('users')
            ->where('email', '=', $login);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();
        $user = User::createFromArray(is_array($data) ? $data : [$data]);

        if (empty($user->getUserId())) {
            throw new \Exception('User with given login does not exists!');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new \Exception('Password is not correct! Try again!');
        }

        return $user;
    }

    /**
     * @throws \Exception
     */
    public function getUserById(int $userId): User
    {
        $selectStatement = $this->database->select()
            ->from('users')
            ->where('user_id', '=', $userId);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();
        unset($data['password']);
        $user = User::createFromArray(is_array($data) ? $data : [$data]);

        if (empty($user->getUserId())) {
            throw new \Exception('User with given user_id does not exists!');
        }

        return $user;
    }

    public function getUsers(int $limit = 100): array
    {
        $selectStatement = $this->database->select()
            ->from('users')
            ->limit($limit)
        ;

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $users = [];

        foreach ($data as $i => $part) {
            unset($part['password']);
            $users[] = User::createFromArray($part);
        }

        return $users;
    }
}
