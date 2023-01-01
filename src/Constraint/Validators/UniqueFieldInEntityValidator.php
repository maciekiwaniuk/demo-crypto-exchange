<?php

namespace App\Constraint\Validators;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueFieldInEntityValidator extends ConstraintValidator
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        $field = $constraint->field;
        $entityClassName = $constraint->entityClassName;

        $foundRecord = $this->doctrine->getRepository($entityClassName)
            ->findOneBy([$field => $value]);

        if (!$foundRecord) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ field }}', ucfirst($field))
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}