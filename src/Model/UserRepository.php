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
        throw new Exception('Hola hola panie Henry!');
    }
}
