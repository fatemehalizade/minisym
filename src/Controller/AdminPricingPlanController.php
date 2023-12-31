<?php

namespace App\Controller;

use App\Entity\PricingPlan;
use App\Form\PricingPlanType;
use App\Repository\PricingPlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pricing/plan')]
class AdminPricingPlanController extends AbstractController
{
    #[Route('/', name: 'app_admin_pricing_plan_index', methods: ['GET'])]
    public function index(PricingPlanRepository $pricingPlanRepository): Response
    {
        return $this->render('admin_pricing_plan/index.html.twig', [
            'pricing_plans' => $pricingPlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_pricing_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PricingPlanRepository $pricingPlanRepository): Response
    {
        $pricingPlan = new PricingPlan();
        $form = $this->createForm(PricingPlanType::class, $pricingPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanRepository->save($pricingPlan, true);

            return $this->redirectToRoute('app_admin_pricing_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan/new.html.twig', [
            'pricing_plan' => $pricingPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_show', methods: ['GET'])]
    public function show(PricingPlan $pricingPlan): Response
    {
        return $this->render('admin_pricing_plan/show.html.twig', [
            'pricing_plan' => $pricingPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_pricing_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PricingPlan $pricingPlan, PricingPlanRepository $pricingPlanRepository): Response
    {
        $form = $this->createForm(PricingPlanType::class, $pricingPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingPlanRepository->save($pricingPlan, true);

            return $this->redirectToRoute('app_admin_pricing_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_pricing_plan/edit.html.twig', [
            'pricing_plan' => $pricingPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_pricing_plan_delete', methods: ['POST'])]
    public function delete(Request $request, PricingPlan $pricingPlan, PricingPlanRepository $pricingPlanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricingPlan->getId(), $request->request->get('_token'))) {
            $pricingPlanRepository->remove($pricingPlan, true);
        }

        return $this->redirectToRoute('app_admin_pricing_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
