<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use AppBundle\Entity\Promotion;
use AppBundle\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;


class PriceCalculator
{
    /** @var  ArrayCollection */
    protected $activePromotions;

    public function __construct(PromotionRepository $repo)
    {
        $this->activePromotions = $repo->fetchActivePromotions();
    }


    /**
     * @param Product $product
     *
     * @return \AppBundle\Entity\decimal|float
     */
    public function calculate($product)
    {

        $productPromotions = $product->getPromotions();

        $bestPromotion = $this->findBestPromotion($productPromotions);


        return $product->getPrice() - $product->getPrice() * ($bestPromotion / 100);
    }


    /**
     * @param PersistentCollection $productPromotions
     * @return int
     */
    private function findBestPromotion(PersistentCollection $productPromotions)
    {

        $promotionsToCompare = [0];

        foreach ($productPromotions as $promotion) {

            if ($this->activePromotions->contains($promotion)) {

                /** @var Promotion $promotion */
                $promotionsToCompare[] = $promotion->getPercent();
            }

        }

        return max($promotionsToCompare);

    }
}
