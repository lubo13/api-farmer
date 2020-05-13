<?php
/**
 * @package App
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AssetRentPercent extends Constraint
{
    public $message = 'The sum of the rented rent for the property exceeds 100% -> "%sum%"';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
