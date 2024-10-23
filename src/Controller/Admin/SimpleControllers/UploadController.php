<?php

namespace App\Controller\Admin\SimpleControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    #[Route('/admin/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request)
    {
        $file = $request->files->get('file');

        if ($file) {
            $uploadPath = $this->getUploadDirectory();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
            $file->move($uploadPath, $newFilename);

            return new JsonResponse([
                'location' => $this->getUploadPath($newFilename),
            ]);
        }

        return new JsonResponse(['error' => 'Invalid file'], 400);
    }

    private function getUploadDirectory()
    {
        return $this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('uploads_images');
    }

    private function getUploadPath(string $image)
    {
        return $this->parameterBag->get('app.host') . $this->parameterBag->get('uploads_base_dir') . $image;
    }
}
