<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class RegistrationSpam extends Constraint
{

    public $message = 'Ботам здесь не место.';
}
