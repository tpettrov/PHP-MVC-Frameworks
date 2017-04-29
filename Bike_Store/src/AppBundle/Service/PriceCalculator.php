<?php

namespace AppBundle\Service;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;


class PriceCalculator
{
    /** @var  ArrayCollection */
    protected $manager;
    protected $activePromotions;


    public function __construct(PromotionManager $manager)
    {
        $this->manager = $manager;
        $this->activePromotions = $manager->getActivePromotions();


    }


    /**
     * @param Product $product
     *
     * @return \AppBundle\Entity\decimal|float
     */
    public function calculate($product)
    {

        $bestPromotion = $this->findBestPromotion($product, $product->getCategory());
        $productPrice = $product->getPrice();


        return $productPrice - $productPrice * ($bestPromotion / 100);
    }


    /**
     * @param PersistentCollection $productPromotions
     * @return int
     */
    private function findBestPromotion(Product $product, Category $category)
    {

        $promotionsToCompare = [0];

        /** @var Promotion $promotion */

        foreach ($this->activePromotions as $promotion) {

            if ($promotion->getProducts()->contains($product)
                || $promotion->getCategories()->contains($category) || $promotion->getIsGlobal()
            ) {

                $promotionsToCompare[] = $promotion->getPercent();
            }

        }


        return max($promotionsToCompare);

    }
}
