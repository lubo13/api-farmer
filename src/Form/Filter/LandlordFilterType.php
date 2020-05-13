<?php
/**
 * @package App
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace App\Form\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\FilterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

/**
 * Class LandlordFilterType
 * @package App\Form\Filter
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class LandlordFilterType extends FilterType
{
    public function getParent()
    {
        return TextType::class;
    }

    public function filter(QueryBuilder $queryBuilder, FormInterface $form, array $metadata)
    {
        if ($data = $form->getData()) {
            $field    = $metadata['property'];
            $allAlias = $queryBuilder->getAllAliases();
            if (!in_array('cra', $allAlias)) {
                $queryBuilder
                    ->leftJoin('entity.contractRentAssets', 'cra');
            }
            if (!in_array('l', $allAlias)) {
                $queryBuilder
                    ->leftJoin('cra.landlord', 'l');
            }
            $queryBuilder
                ->andWhere("l.$field LIKE :$field")
                ->setParameter($field, "%$data%");
        }
    }
}
