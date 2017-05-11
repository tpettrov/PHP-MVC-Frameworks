<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("eMail", message="This e-mail is already registered. Please try another one.")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $fName;

    /**
     * @var string
     *
     * @ORM\Column(name="lName", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $lName;

    /**
     * @var string
     *
     * @ORM\Column(name="eMail", type="string", length=255, unique=true)
     *
     * @Assert\Email()
     *
     */
    private $eMail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     */
    private $password;

    /**
     *
     * @Assert\Length(max=4096)
     * @Assert\Length(min=6)
     */
    private $rawPassword;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *     )
     */

    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="Cart", inversedBy="user")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */

    private $cart;


    /**
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="owner")
     *
     */

    private $ownedProducts;
    /**
     *
     * @ORM\Column(name="cash", type="decimal", precision=5, scale=2)
     */

    private $cash;


    /**
     * @var bool
     *
     * @ORM\Column(name="isNotBanned", type="boolean")
     */

    private $isNotBanned;

    public function __construct()
    {
        $this->isNotBanned = true;
        $this->roles = new ArrayCollection();
        $this->ownedProducts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get fName
     *
     * @return string
     */
    public function getFName()
    {
        return $this->fName;
    }

    /**
     * Set fName
     *
     * @param string $fName
     *
     * @return User
     */
    public function setFName($fName)
    {
        $this->fName = $fName;

        return $this;
    }

    /**
     * Get lName
     *
     * @return string
     */
    public function getLName()
    {
        return $this->lName;
    }

    /**
     * Set lName
     *
     * @param string $lName
     *
     * @return User
     */
    public function setLName($lName)
    {
        $this->lName = $lName;

        return $this;
    }

    /**
     * Get eMail
     *
     * @return string
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * Set eMail
     *
     * @param string $eMail
     *
     * @return User
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $stringRoles = [];

        foreach ($this->roles as $role) {

            /** @var $role Role */

            $stringRoles[] = $role->getRole();

        }

        return $stringRoles;
    }

    /**
     * @param \AppBundle\Entity\Role $role
     *
     *
     */

    public function addRole(Role $role)
    {


        $this->roles[] = $role;

        return $this;

    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->fName . " " . $this->lName;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getRawPassword()
    {
        return $this->rawPassword;
    }

    /**
     * @param mixed $rawPassword
     */
    public function setRawPassword($rawPassword)
    {
        $this->rawPassword = $rawPassword;
    }

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash)
    {
        $this->cash = $cash;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }


    public function getRolesCollection()
    {
        return $this->roles;
    }

    /**
     * @return mixed
     */
    public function getOwnedProductsCount()
    {
        return count($this->ownedProducts);
    }

    /**
     * @return mixed
     */
    public function getOwnedProducts()
    {
        return $this->ownedProducts;
    }

    /**
     * @param mixed $ownedProducts
     */
    public function setOwnedProducts($ownedProducts)
    {
        $this->ownedProducts = $ownedProducts;
    }

    public function isEnabled(){

        return $this->isNotBanned;
    }


    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->eMail,
            $this->password,
            $this->isNotBanned

        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->eMail,
            $this->password,
            $this->isNotBanned

            ) = unserialize($serialized);
    }

    /**
     * @return bool
     */
    public function isIsNotBanned(): bool
    {
        return $this->isNotBanned;
    }

    /**
     * @param bool $isBanned
     */
    public function setIsNotBanned(bool $isBanned)
    {
        $this->isNotBanned = $isBanned;
    }

    public function __toString()
    {
        return $this->fName . " " . $this->lName;
    }
}

