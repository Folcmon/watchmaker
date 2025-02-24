<?php

namespace App\Controller;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class FileController extends BaseController
{
    #[Route('/upload', name: 'file_upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $uploadedFile = $request->files->get('file'); // "file" - klucz z Uppy

        if (!$uploadedFile instanceof UploadedFile) {
            return new JsonResponse(['error' => 'Nie przesłano pliku'], 400);
        }

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $uploadedFile->guessExtension() ?? 'bin';
        $uuid = Uuid::v4();

        // Tworzenie ścieżki YYYY/MM/DD/
        $datePath = (new \DateTime())->format('Y/m/d');
        $fileName = sprintf('%s.%s', $uuid, $extension);
        $relativePath = sprintf('%s/%s', $datePath, $fileName);
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $datePath;

        // Tworzenie katalogu jeśli nie istnieje
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Przenoszenie pliku do katalogu
        $uploadedFile->move($uploadDir, $fileName);

        // Tworzenie encji pliku
        $fileEntity = new File($uuid, $originalFilename, $extension);
        $fileEntity->setUsedTimes(0);
        $entityManager->persist($fileEntity);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Plik zapisany!',
            'fileId' => $fileEntity->getId(),
            'path' => '/uploads/' . $relativePath
        ]);
    }

    #[Route('/files/{id}', name: 'file_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $fileRepository = $entityManager->getRepository(File::class);
        $file = $fileRepository->find($id);

        if (!$file) {
            return new JsonResponse(['error' => 'Plik nie istnieje'], 404);
        }

        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $file->getPath();

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $entityManager->remove($file);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Plik usunięty']);
    }
}