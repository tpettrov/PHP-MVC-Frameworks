<?php
/**
 * Created by PhpStorm.
 * User: apetrov
 * Date: 3/13/2017
 * Time: 11:23 AM
 */

namespace DTO;


class ProfileEditBindingModel
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $birthday;



    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getId()
    {
        return $this->id;
    }






}