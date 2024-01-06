<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'users_list')]
    public function index(): Response
    {
        return $this->render('admin/users/list.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
