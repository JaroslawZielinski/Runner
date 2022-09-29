<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Model;

class User
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var int
     */
    protected $isActive;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $updatedAt;

    public function __construct(
        int $userId,
        string $firstName,
        string $lastName,
        string $email,
        string $gender,
        int $isActive,
        string $password,
        string $createdAt,
        string $updatedAt
    ) {
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

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getIsActive(): int
    {
        return $this->isActive;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * strip_tags used for html injection attack prevention
     */
    public static function createFromArray(array $fields = []): User
    {
        $now = date('Y-m-d H:i:s');
        return new User(
            isset($fields['user_id']) ? (int)$fields['user_id'] : 0,
            isset($fields['first_name']) ? strip_tags($fields['first_name']) : 'John',
            isset($fields['last_name']) ? strip_tags($fields['last_name']) : 'Doe',
            isset($fields['email']) ? strip_tags($fields['email']) : 'john.doe@gmail.com',
            isset($fields['gender']) ? strip_tags($fields['gender']) : 'male',
            isset($fields['is_active']) ? (int)$fields['is_active'] : 1,
            isset($fields['password']) ? strip_tags($fields['password']) : 'secret',
            isset($fields['created_at']) ? strip_tags($fields['created_at']) : $now,
            isset($fields['updated_at']) ? strip_tags($fields['updated_at']) : $now
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s<%s>', $this->getFirstName(), $this->getLastName(), $this->getEmail());
    }
}
