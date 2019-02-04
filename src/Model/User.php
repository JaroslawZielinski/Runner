<?php

namespace JaroslawZielinski\Runner\Model;

/**
 * Class User
 * @package JaroslawZielinski\Runner\Model
 */
class User
{
    /**
     * @var
     */
    protected $userId;

    /**
     * @var
     */
    protected $firstName;

    /**
     * @var
     */
    protected $lastName;

    /**
     * @var
     */
    protected $email;

    /**
     * @var
     */
    protected $gender;

    /**
     * @var
     */
    protected $isActive;

    /**
     * @var
     */
    protected $password;

    /**
     * @var
     */
    protected $createdAt;

    /**
     * @var
     */
    protected $updatedAt;

    /**
     * User constructor.
     * @param $userId
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $gender
     * @param $isActive
     * @param $password
     * @param $createdAt
     * @param $updatedAt
     */
    public function __construct($userId, $firstName, $lastName, $email, $gender, $isActive, $password, $createdAt, $updatedAt)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->gender = $gender;
        $this->isActive = $isActive;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param array $fields
     * @return User
     */
    public static function createFromArray($fields = [])
    {
        $now = date('Y-m-d H:i:s');
        return new User(
            isset($fields['user_id']) ? $fields['user_id'] : 0,
            isset($fields['first_name']) ? $fields['first_name'] : "John",
            isset($fields['last_name']) ? $fields['last_name'] : "Doe",
            isset($fields['email']) ? $fields['email'] : "john.doe@gmail.com",
            isset($fields['gender']) ? $fields['gender'] : "male",
            isset($fields['is_active']) ? $fields['is_active'] : true,
            isset($fields['password']) ? $fields['password'] : "secret",
            isset($fields['created_at']) ? $fields['created_at'] : $now,
            isset($fields['updated_at']) ? $fields['updated_at'] : $now
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s %s&lt;%s&gt;", $this->getFirstName(), $this->getLastName(), $this->getEmail());
    }
}
