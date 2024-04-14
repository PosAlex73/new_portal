<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/about-us', name: 'about_us')]
    public function aboutUs(): Response
    {
        return $this->render('front/pages/about_us.html.twig', [

        ]);
    }

    #[Route('/help', name: 'help')]
    public function help(): Response
    {
        return $this->render('front/pages/help.html.twig', [

        ]);
    }

    #[Route('service-statement', name: 'service_statement')]
    public function serviceStatement(): Response
    {
        return $this->render('front/pages/service_statement.html.twig', [

        ]);
    }
}
