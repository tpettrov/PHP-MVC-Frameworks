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

    /**
     * @ORM\Column(name="cost", type="decimal", precision=5, scale=2)
     */

    private $cost;


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
        $this->cost += $product->getPrice();

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


    /**
     * @return Cart
     *
     * Empty the cart after ordering
     * Probably will be good to move products in Order entity and stuff but not enough time
     *
     */
    public function Empty()
    {

        $this->products = new ArrayCollection();
        $this->cost = 0.00;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }


}

