<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-07
 * Time: 16:12
 */

namespace App\Admin\Equipment;


use App\Classes\MainAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Комлектация в аренду. Комплект. Характеристики
 *
 * Class EquipmentKitSpecification
 * @package App\Admin\Equipment
 */
class EquipmentKitSpecificationAdmin extends MainAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('refTypeEquipment', null, ['label' => 'Тип оборудования'])
            ->add('refTypeDisembarkation', null, ['label' => 'Тип высадки'])
            ->add('outerDiameterOfThePipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
            ->add('pipeWallThickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
            ->add('refTypeThread', null, ['label' => 'Тип резьбы'])
            ->add('odlockNipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
            ->add('idlockNipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
            ->add('pipeLength', null, ['label' => 'Длина трубы'])
            ->add('shoulderAngle', null, ['label' => 'Угол заплетчика'])
            ->add('turnkeyLengthNipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
            ->add('turnkeyLengthCoupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
            ->add('refThreadCoating', null, ['label' => 'Покрытие резьбы'])
            ->add('refInnerCoating', null, ['label' => 'Внутреннее покрытие'])
            ->add('refHardbandingCoupling', null, ['label' => 'Хардбендинг (муфта)'])
            ->add('comment', null, ['label' => 'Комментарий'])
            ;
    }

}