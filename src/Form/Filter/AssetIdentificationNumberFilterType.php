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
 * Class AssetIdentificationNumberFilterType
 * @package App\Form\Filter
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class AssetIdentificationNumberFilterType extends FilterType
{
    public function getParent()
    {
        return TextType::class;
    }

    public function filter(QueryBuilder $queryBuilder, FormInterface $form, array $metadata)
    {
        if ($data = $form->getData()) {
            $allAlias = $queryBuilder->getAllAliases();
            if (!in_array('cra', $allAlias)) {
                $queryBuilder
                    ->leftJoin('entity.contractRentAssets', 'cra');
            }
            $queryBuilder
                ->leftJoin('cra.asset', 'ass')
                ->andWhere('ass.identificationNumber LIKE :identificationNumber')
                ->setParameter('identificationNumber', "%$data%");
        }
    }
}
