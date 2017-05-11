<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Promotion
 *
 * @ORM\Table(name="promotions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=false)
     */

    private $name;

    /**
     * @var int
     * @Assert\GreaterThan(0)
     * @Assert\LessThanOrEqual(100)
     * @ORM\Column(name="percent", type="integer")
     */
    private $percent;

    /**
     * @var \DateTime
     *  @Assert\Date()
     * @ORM\Column(name="start", type="date")
     */
    private $start;

    /**
     * @var \DateTime
     * @Assert\Date()
     * @ORM\Column(name="end", type="date")
     */
    private $end;

    /**
     * @var bool
     *
     * @ORM\Column(name="isGlobal", type="boolean")
     */

    private $isGlobal = false;

    /**
     * @ORM\ManytoMany(targetEntity="AppBundle\Entity\Product", mappedBy="promotions")
     */

    private $products;

    /**
     * @ORM\ManytoMany(targetEntity="AppBundle\Entity\Category")
     *  @ORM\JoinTable(name="categories_promotions",
     *      joinColumns={@ORM\JoinColumn(name="promotion_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */

    private $categories;

    public function __construct() {
        $this->products = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * Get percent
     *
     * @return int
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set percent
     *
     * @param integer $percent
     *
     * @return Promotion
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Promotion
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Promotion
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return bool
     */
    public function getIsGlobal()
    {
        return $this->isGlobal;
    }

    /**
     * @param mixed bool
     */
    public function setIsGlobal($isGlobal)
    {
        $this->isGlobal = $isGlobal;
    }
}

