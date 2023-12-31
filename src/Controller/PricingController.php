<?php

namespace App\Controller;

use App\Entity\PricingPlan;
use App\Entity\PricingPlanBenefit;
use App\Entity\PricingPlanFeature;
use App\Repository\PricingPlanBenefitRepository;
use App\Repository\PricingPlanFeatureRepository;
use App\Repository\PricingPlanRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PricingController extends AbstractController
{
    public function __construct(
        #[Autowire(service: 'monolog.logger.request')] LoggerInterface $logger
    ) {
        
    }
    #[Route('/pricing', name: 'app_pricing')]
    public function index(PricingPlanRepository $pricingPlanRepository,PricingPlanBenefitRepository $pricingPlanBenefitRepository,PricingPlanFeatureRepository $pricingPlanFeatureRepository): Response 
    {
        $pricingPlans=$pricingPlanRepository->findAll();
        $features=$pricingPlanFeatureRepository->findAllFeaturePricings();
        $benefits=$pricingPlanBenefitRepository->findAllBenefitPricings();
        return $this->render('pricing/index.html.twig', [
            'pricing_plans' => $pricingPlans,
            'benefits' => $benefits,
            'features' => $features
        ]);
    }
}
