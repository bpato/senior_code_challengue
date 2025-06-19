<?php

namespace App\Api\Cart\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class BaseRequest
{

    public function __construct(
        public ValidatorInterface $validator
    ) {
    }

    public function populate(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }

    public function validate(Constraint|array|null $constraints = null, string|GroupSequence|array|null $groups = null): array
    {
        $errors = [];

        $violations = $this->validator->validate($this, $constraints, $groups);

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }

        return $errors;
    }

}
