<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/api/jobs/by_person/{personId}/{startDate}/{endDate}', name: 'api_jobs_by_person', methods: ['GET'])]
    public function getByPersonAndDateRange(
        JobRepository $repository,
        $personId,
        $startDate,
        $endDate): Response
    {
        $jobs = $repository->findJobsByPersonAndDateRange($personId, new \DateTime($startDate), new \DateTime($endDate));
        return $this->json($jobs);
    }
}
