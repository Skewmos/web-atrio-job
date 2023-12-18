<?php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PersonRepository;

class PersonProvider implements ProviderInterface
{
    private PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation->getName() === 'get' && $operation->getProvider() === self::class) {
            return $this->personRepository->findBy([], ['name' => 'ASC']);
        }

        return null;
    }

    public function supports(Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $operation->getProvider() === self::class;
    }
}
