<?php

namespace App\Controller;

use App\Entity\PricingPlanFeature;
use App\Form\PricingPlanFeatureType;
use App\Repository\PricingPlanFeatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pricing/plan/feature')]
class AdminPricingPlanFeatureController extends AbstractController
{
    #[Route('/', name: 'app_admin_pricing_plan_feature_index', methods: ['GET'])]
    public function index(PricingPlanFeatureRepository $pricingPlanFeatureRepository): Response
    {
        return $this->render('admin_pricing_plan_feature/index.html.twig', [
            'pricing_plan_features' => $pricingPlanFeatureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_pricing_plan_feature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PricingPlanFeatureRepository $pricingPlanFeatureRepository): Response
    {
        $pricingPlanFeature = new PricingPlanFeature();
        $form = $this->createForm(PricingPlanFeatureType::class, $pricingPlanFeature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanFeatureRepository->save($pricingPlanFeature, true);

            return $this->redirectToRoute('app_admin_pricing_plan_feature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan_feature/new.html.twig', [
            'pricing_plan_feature' => $pricingPlanFeature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_feature_show', methods: ['GET'])]
    public function show(PricingPlanFeature $pricingPlanFeature): Response
    {
        return $this->render('admin_pricing_plan_feature/show.html.twig', [
            'pricing_plan_feature' => $pricingPlanFeature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_pricing_plan_feature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PricingPlanFeature $pricingPlanFeature, PricingPlanFeatureRepository $pricingPlanFeatureRepository): Response
    {
        $form = $this->createForm(PricingPlanFeatureType::class, $pricingPlanFeature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanFeatureRepository->save($pricingPlanFeature, true);

            return $this->redirectToRoute('app_admin_pricing_plan_feature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan_feature/edit.html.twig', [
            'pricing_plan_feature' => $pricingPlanFeature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_feature_delete', methods: ['POST'])]
    public function delete(Request $request, PricingPlanFeature $pricingPlanFeature, PricingPlanFeatureRepository $pricingPlanFeatureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricingPlanFeature->getId(), $request->request->get('_token'))) {
            $pricingPlanFeatureRepository->remove($pricingPlanFeature, true);
        }

        return $this->redirectToRoute('app_admin_pricing_plan_feature_index', [], Response::HTTP_SEE_OTHER);
    }
}
