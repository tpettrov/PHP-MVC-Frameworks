<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{

    const FOR_SALE = 1;

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
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price", type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */

    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="ownedProducts")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     *
     */

    private $owner;

    /**
     * @var bool
     *
     * @ORM\Column(name="forsale", type="boolean")
     */

    private $forsale = self::FOR_SALE;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Promotion", inversedBy="products")
     * @ORM\JoinTable(name="products_promotions")
     *
     *
     */

    private $promotions;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
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
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Product
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get price
     *
     * @return decimal
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($user_id)
    {
        $this->owner = $user_id;
    }

    /**
     * @return boolean
     */
    public function getForsale()
    {
        return $this->forsale;
    }

    /**
     * @param mixed $forsale
     */
    public function setForsale($forsale)
    {
        $this->forsale = $forsale;
    }

    /**
     * @return mixed
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @param mixed $promotions
     */
    public function setPromotions($promotions)
    {
        $this->promotions = $promotions;
    }

}

