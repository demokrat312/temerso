<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Classes\Arrival\ArrivalCells;
use App\Classes\Arrival\ExcelHelper;
use App\Entity\Arrival;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @link https://symfony.com/doc/master/bundles/SonataAdminBundle/cookbook/recipe_custom_action.html
 */
class ArrivalAdminController extends CRUDController
{
    /**
     * @link https://packagist.org/packages/onurb/excel-bundle
     */
    public function excelAction(int $id)
    {
        /** @var Arrival $arrival */
        $arrival = $this->admin->getSubject();

        if (!$arrival) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $excelHelper = new ExcelHelper($this->get('phpspreadsheet'));
        $excelHelper->setSource('templates/excelFile/arrival_excel.xlsx');

//        $excelHelper->getActiveSheet()->insertNewRowBefore(5,10);
//        $excelHelper->getActiveSheet()->duplicateStyle($excelHelper->getActiveSheet()->getStyle('A4'),'A5:A13');


        // Задаем общию информацию
        $arrivalСells = new ArrivalCells();
        $arrivalСells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setDateArrival($arrival->getDateArrival())
            ->setNumberAndDatePurchase($arrival->getNumberAndDatePurchase());

        if ($arrival->getCards()->count() > 0) {
            $arrivalСells
                ->addCardRow($arrival->getCards()->count())
                ->setTotal($arrival->getCards()->count())
                ->setCars($arrival->getCards());
        }

        $excelHelper->print();
    }
}
