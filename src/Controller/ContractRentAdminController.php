<?php

namespace App\Controller;

use App\Form\Filter\CustomEntityFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class ContractRentAdminController extends EasyAdminController
{

    protected function renderContractRentTemplate($actionName, $templatePath, array $parameters = [])
    {
        switch ($actionName) {
            case 'list':
                $templatePath = 'CRUD/contract_rent_list.html.twig';
                break;
        }

        return $this->render($templatePath, $parameters);
    }

}
