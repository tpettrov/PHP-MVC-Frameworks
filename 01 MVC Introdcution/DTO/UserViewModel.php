<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 18:49
 */

namespace DTO;


class UserViewModel
{

    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;

    }

    public function getLastName(){

        return $this->lastName;
    }

}