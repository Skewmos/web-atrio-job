<?php

namespace App\EventSubscriber;

use App\Entity\Person;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PersonSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Person) {
            return;
        }

        $birthday = $entity->getBirthday();
        $today = new \DateTime();
        $age = $today->diff($birthday)->y;

        if ($age > 150) {
            throw new BadRequestHttpException('L\'âge de la personne ne peut pas dépasser 150 ans.');
        }
    }
}
