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
    protected $dbase;

    /**
     * UserRepository constructor.
     * @param Database $dbase
     */
    public function __construct(Database $dbase)
    {
        $this->dbase = $dbase;
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public function create(User $user)
    {
        //TODO: create user to database
        throw new Exception('Hola hola panie Henry!');
    }

    /**
     * @param $login
     * @param $password
     * @return User
     */
    public function readByLoginAndPassword($login, $password)
    {
        //TODO: read a user from database using login-email and password
        return User::createFromArray();
    }
}
