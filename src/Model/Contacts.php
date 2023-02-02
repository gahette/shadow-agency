<?php

namespace App\Model;

use DateTime;
use Exception;

class Contacts
{
    private int $contacts_id;
    private string $contacts_lastname;
    private string $contacts_firstname;
    private $contacts_bod;
    private string $contacts_nickname;

    private array $nationalities = [];

    /**
     * @return int
     */
    public function getContactsId(): int
    {
        return $this->contacts_id;
    }

    /**
     * @return string
     */
    public function getContactsLastname(): string
    {
        return $this->contacts_lastname;
    }

    /**
     * @return string
     */
    public function getContactsFirstname(): string
    {
        return $this->contacts_firstname;
    }


    /**
     * @return DateTime
     * @throws Exception
     */
    public function getContactsBod(): DateTime
    {
        return new DateTime($this->contacts_bod);
    }

    /**
     * @return string
     */
    public function getContactsNickname(): string
    {
        return $this->contacts_nickname;
    }


}