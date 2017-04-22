<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
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
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="cart")
     *
     */

    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinTable(name="carts_products",
     *      joinColumns={@ORM\JoinColumn(name="cart_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */

    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Cart
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     *
     * add product to the Cart
     *
     * @param Product $product
     * @return $this
     */

    public function addProduct(Product $product)
    {

        $this->products[] = $product;

        return $this;

    }


    /**
     * @return int
     */
    public function getProductCount()
    {

        return count($this->products);

    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {

        return $this->products;

    }

    public function Empty()
    {

        $this->products = new ArrayCollection();
        return $this;

    }


}

