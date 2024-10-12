<?php

namespace App\Controller\Front;

use App\Services\Menu\BreadCrumbsBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NotificationController extends AbstractController
{
    public function __construct(
        protected BreadCrumbsBuilder $breadCrumbsBuilder
    ){}

    #[Route('/notifications', name: 'notifications')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $this->initBreadCrumbs();

        return $this->render('front/notifications/index.html.twig');
    }

    private function initBreadCrumbs()
    {
        $this->breadCrumbsBuilder->addIndexRoute();
        $this->breadCrumbsBuilder->addBreadCrumbs('Уведомления', $this->generateUrl('notifications'));
    }
}
