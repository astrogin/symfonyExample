<?php

namespace App\Validation\Constraints\Ean;

use Symfony\Component\Validator\Constraint;

/**
 * Class Ean
 *
 */
class Ean extends Constraint
{
    public $message = 'The string "%string%" is not a valid EAN code.';
}