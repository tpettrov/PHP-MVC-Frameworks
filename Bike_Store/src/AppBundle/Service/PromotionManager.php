<?php

namespace AppBundle\Service;


use AppBundle\Entity\Promotion;
use AppBUndle\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;

class PromotionManager
{
    protected $active_promotions;

    /**
     * @var ArrayCollection $active_promotions_products
     */
    protected $active_promotions_products = [];

    protected $active_promotions_categories = [];

    /**
     * PriceCalculator constructor.
     *
     * @param PromotionRepository $repo
     */
    public function __construct(PromotionRepository $repo)
    {
        $this->active_promotions = $repo->fetchActivePromotions();

    }

    /**
     * @return ArrayCollection
     */

    public function getActivePromotions()
    {

        return $this->active_promotions;
    }


    public function getActivePromotionsProducts(){

    foreach ($this->active_promotions as $promotion) {

        /** @var Promotion $promotion */
         $this->active_promotions_products = array_merge($promotion->getProducts()->toArray(), $this->active_promotions_products);

    }

    return new ArrayCollection($this->active_promotions_products);


    }


    public function getActivePromotionsCategories(){

        foreach ($this->active_promotions as $promotion) {

            /** @var Promotion $promotion */
            $this->active_promotions_categories = array_merge($promotion->getProducts()->toArray(), $this->active_promotions_categories);

        }

        return new ArrayCollection($this->active_promotions_categories);


    }




}
