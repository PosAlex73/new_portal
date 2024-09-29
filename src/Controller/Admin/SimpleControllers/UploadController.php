<?php

namespace App\Controller\Admin\SimpleControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/admin/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request)
    {
        $file = $request->files->get('file');

        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $newFilename);

            return new JsonResponse([
                'url' => '/uploads/images/'.$newFilename,
            ]);
        }

        return new JsonResponse(['error' => 'Invalid file'], 400);
    }
}
