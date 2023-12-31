<?php

namespace App\Controller;

use App\Entity\PricingPlanBenefit;
use App\Form\PricingPlanBenefitType;
use App\Repository\PricingPlanBenefitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pricing/plan/benefit')]
class AdminPricingPlanBenefitController extends AbstractController
{
    #[Route('/', name: 'app_admin_pricing_plan_benefit_index', methods: ['GET'])]
    public function index(PricingPlanBenefitRepository $pricingPlanBenefitRepository): Response
    {
        return $this->render('admin_pricing_plan_benefit/index.html.twig', [
            'pricing_plan_benefits' => $pricingPlanBenefitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_pricing_plan_benefit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PricingPlanBenefitRepository $pricingPlanBenefitRepository): Response
    {
        $pricingPlanBenefit = new PricingPlanBenefit();
        $form = $this->createForm(PricingPlanBenefitType::class, $pricingPlanBenefit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanBenefitRepository->save($pricingPlanBenefit, true);

            return $this->redirectToRoute('app_admin_pricing_plan_benefit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan_benefit/new.html.twig', [
            'pricing_plan_benefit' => $pricingPlanBenefit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_benefit_show', methods: ['GET'])]
    public function show(PricingPlanBenefit $pricingPlanBenefit): Response
    {
        return $this->render('admin_pricing_plan_benefit/show.html.twig', [
            'pricing_plan_benefit' => $pricingPlanBenefit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_pricing_plan_benefit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PricingPlanBenefit $pricingPlanBenefit, PricingPlanBenefitRepository $pricingPlanBenefitRepository): Response
    {
        $form = $this->createForm(PricingPlanBenefitType::class, $pricingPlanBenefit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanBenefitRepository->save($pricingPlanBenefit, true);

            return $this->redirectToRoute('app_admin_pricing_plan_benefit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan_benefit/edit.html.twig', [
            'pricing_plan_benefit' => $pricingPlanBenefit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_benefit_delete', methods: ['POST'])]
    public function delete(Request $request, PricingPlanBenefit $pricingPlanBenefit, PricingPlanBenefitRepository $pricingPlanBenefitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricingPlanBenefit->getId(), $request->request->get('_token'))) {
            $pricingPlanBenefitRepository->remove($pricingPlanBenefit, true);
        }

        return $this->redirectToRoute('app_admin_pricing_plan_benefit_index', [], Response::HTTP_SEE_OTHER);
    }
}
