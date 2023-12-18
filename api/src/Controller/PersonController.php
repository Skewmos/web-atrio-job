<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/api/persons/by_company/{companyId}', name: 'api_persons_by_company', methods: ['GET'])]
    public function getByCompany(
        PersonRepository $repository,
        $companyId): Response
    {
        $persons = $repository->findByCompany($companyId);
        return $this->json($persons);
    }
}
