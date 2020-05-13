<?php

namespace App\Doctrine\Filter;

use App\Entity\CustomUserInterface;
use Doctrine\ORM\Mapping\ClassMetadata,
    Doctrine\ORM\Query\Filter\SQLFilter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of UserFilter
 *
 * @author Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class UserFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->reflClass->implementsInterface(UserInterface::class) && $this->hasParameter('user_id')) {
            return $targetTableAlias . '.id = ' . $this->getParameter('user_id');
        }

        if ($targetEntity->reflClass->implementsInterface(CustomUserInterface::class) && $this->hasParameter('user_id')) {
            return $targetTableAlias . '.user_id = ' . $this->getParameter('user_id');
        }

        return '';
    }

}
