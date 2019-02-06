<?php

namespace JaroslawZielinski\Runner\Model;

use Exception;
use Slim\PDO\Database;

/**
 * Class UserRepository
 * @package JaroslawZielinski\Runner\Model
 */
class UserRepository
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * UserRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param User $user
     * @return string
     * @throws Exception
     */
    public function create(User $user)
    {
        $insertStatement = $this->database->insert(['first_name', 'last_name', 'email', 'gender', 'is_active', 'password'])
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
     * @param $login
     * @param $password
     * @return User
     * @throws Exception
     */
    public function readByLoginAndPassword($login, $password)
    {
        $selectStatement = $this->database->select()
            ->from('users')
            ->where('email', '=', $login);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();
        $user = User::createFromArray($data);

        if (empty($user->getUserId())) {
            throw new Exception('User with given login does not exists!');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new Exception('Password is not correct! Try again!');
        }

        return $user;
    }

    /**
     * @param $userId
     * @return User
     * @throws Exception
     */
    public function getUserById($userId)
    {
        $selectStatement = $this->database->select()
            ->from('users')
            ->where('user_id', '=', $userId);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();
        unset($data['password']);
        $user = User::createFromArray($data);

        if (empty($user->getUserId())) {
            throw new Exception('User with given user_id does not exists!');
        }

        return $user;
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getUsers($limit = 100)
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
