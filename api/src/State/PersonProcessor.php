<?php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\PersonDto;
use App\Entity\Person;
use DateTime;

class PersonProcessor implements ProcessorInterface
{
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        dump($data);
        if (!$data instanceof Person) {
            return $data;
        }

        $output = new PersonDto();
        $output->firstname = $data->getFirstname();
        $output->lastname = $data->getLastname();
        $birthdate = $data->getBirthday();
        $today = new DateTime('now');
        $age = $birthdate->diff($today)->y;
        $output->age = $age;
        $output->currentJobs =  $data->getJobs();
        return $output;
    }

    public function supports(Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $operation->isCollection() && $operation->getMethod() === 'GET' && $operation->getProcessor() === self::class;
    }
}
