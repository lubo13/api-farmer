<?php

namespace App\Controller;

use App\Form\Filter\CustomEntityFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class ContractAssetAdminController extends EasyAdminController
{

    protected function renderContractAssetTemplate($actionName, $templatePath, array $parameters = [])
    {
        switch ($actionName) {
            case 'list':
                $templatePath = 'CRUD/contract_asset_list.html.twig';
                break;
        }

        return $this->render($templatePath, $parameters);
    }

}
