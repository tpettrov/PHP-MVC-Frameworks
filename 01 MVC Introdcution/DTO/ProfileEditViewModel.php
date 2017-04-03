<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/27/2017
 * Time: 21:15
 */

namespace DTO;


class ProfileEditViewModel
{

    private $id;
    private $username;
    private $password;
    private $email;
    private $birthday;

    public function __construct($id, $username, $password, $email, $birthday)
    {

        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->birthday =  $birthday;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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

}