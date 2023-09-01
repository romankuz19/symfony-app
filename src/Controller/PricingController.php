<?php

namespace App\Controller;

use App\Entity\PricingPlan;
use App\Entity\PricingPlanFeature;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PricingController extends AbstractController
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry) {
        $this->registry = $registry;
    }
    #[Route('/pricing', name: 'app_pricing')]
    public function index(): Response
    {
        $pricingPlans = $this->registry->getRepository(PricingPlan::class)
            ->findBy([], ['id' => 'asc']);


        //Sort by price
//        usort($pricingPlans, function ($a, $b) {
//           return $a->getPrice() <=> $b->getPrice();
//        });

        $features = $this->registry->getRepository(PricingPlanFeature::class)->findAll();
        return $this->render('pricing/index.html.twig', [
            'pricing_plans' => $pricingPlans,
            'features' => $features,
        ]);
    }
}
