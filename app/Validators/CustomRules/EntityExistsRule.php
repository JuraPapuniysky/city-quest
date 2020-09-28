<?php

declare(strict_types=1);

namespace App\Validators\CustomRules;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Rakit\Validation\Rule;

final class EntityExistsRule extends Rule
{
    private $message = ":attribute :not found";

    private $fillableParams = ['table', 'column', 'except'];

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except AND $except == $value) {
            return true;
        }

        /** @var ObjectRepository $repository */
        $repository = $this->entityManager->getRepository($table);
        $entity = $repository->findOneBy([
            $column => $value,
        ]);

        if ($entity === null) {
            return false;
        }

        return true;
    }
}