<?php

declare(strict_types=1);

namespace App\Validators\CustomRules;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Rakit\Validation\Rule;

final class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

    protected EntityManagerInterface $entityManager;

    protected ?string $entityUuid;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except !== null && $except === $value) {
            return true;
        }

        /** @var ObjectRepository $repository */
        $repository = $this->entityManager->getRepository($table);
        $entity = $repository->findOneBy([
           $column => $value,
        ]);

        if ($entity === null) {
            return true;
        }

        if ($entity->getUuid() === $except) {
            return true;
        }

        return false;
    }
}