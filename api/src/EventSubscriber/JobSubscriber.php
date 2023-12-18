<?php
namespace App\EventSubscriber;

use App\Entity\Job;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class JobSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->validateJob($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->validateJob($args);
    }

    private function validateJob(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Job) {
            return;
        }

        $entityManager = $args->getObjectManager();
        $person = $entity->getPerson();

        $jobs = $entityManager->getRepository(Job::class)
            ->findBy(['person' => $person]);

        foreach ($jobs as $job) {
            if ($job === $entity) {
                continue;
            }

            if ($this->doDatesOverlap($entity->getStartAt(), $entity->getEndAt(), $job->getStartAt(), $job->getEndAt())) {
                throw new \Exception('Les dates d\'emploi se chevauchent avec un autre emploi de cette personne.');
            }
        }
    }

    private function doDatesOverlap($startAt1, $endAt1, $startAt2, $endAt2): bool
    {
        $endAt1 = $endAt1 ?? new \DateTime('9999-12-31');
        $endAt2 = $endAt2 ?? new \DateTime('9999-12-31');

        return $startAt1 < $endAt2 && $startAt2 < $endAt1;
    }
}
