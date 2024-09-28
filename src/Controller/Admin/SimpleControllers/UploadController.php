<?php

namespace App\Controller\Admin\SimpleControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/admin/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request)
    {

    }
}
