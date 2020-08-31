<?php

namespace App\Admin;


use App\Classes\Card\CardListFields;
use App\Classes\Card\CardListHelper;
use App\Classes\Card\CardStatusHelper;
use App\Classes\MainAdmin;
use App\Classes\Card\CardFieldsHelper;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\TopMenuButton\TopMenuButton;
use App\Controller\Admin\CardAdminController;
use App\Entity\Arrival;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\Kit;
use App\Entity\Marking;
use App\Entity\Reference\RefPipeStrengthGroup;
use App\Entity\Reference\RefTypeThread;
use App\Entity\Reference\RefWearClass;
use App\Entity\Repair;
use App\Entity\ReturnFromRepair;
use App\Form\Type\HistoryCallbackFilter;
use App\Repository\EquipmentRepository;
use App\Repository\RepairRepository;
use App\Service\AdminRouteService;
use App\Service\FieldDescriptionService;
use App\Service\Marking\TaskTopMenuButtonService;
use App\Service\TopMenuButtonService;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Query\Expr\Comparison;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 */
class CardTemporaryAdmin extends MainAdmin
{
    protected $baseRouteName = 'card_temporary';
    protected $baseRoutePattern = 'card-temporary';

    protected function configureRoutes(RouteCollection $collection)
    {
        if(CardListHelper::ins()->isAjax()) {
            $collection
                ->remove('delete')
            ;
        }
        $collection
            ->remove('acl')
            ;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('general', ['label' => 'Главная'])
                ->with("left", ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                    ->add('accounting', null, ['label' => 'Учет/Инвентаризация'])
                    ->add('ref_type_equipment', null, ['label' => 'Тип оборудования'])
                    ->add('rfidTagNo', null, ['label' => '№ Метки RFID'])
                    ->add('pipeSerialNumber', null, ['label' => 'Серийный № трубы'])
                    ->add('serialNoOfNipple', null, ['label' => 'Серийный № ниппеля'])
                    ->add('couplingSerialNumber', null, ['label' => 'Серийный № муфты'])
                    ->add('outer_diameter_of_the_pipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
                    ->add('pipe_wall_thickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
                    ->add('ref_type_disembarkation', null, ['label' => 'Тип высадки'])
                    ->add('ref_type_thread', ModelType::class, ['label' => 'Внутреннее покрытие', 'btn_add' => false])
                    ->add('odlock_nipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
                    ->add('nipple_nose_diameter', null, ['label' => 'Диаметр носика ниппеля'])
                    ->add('odlock_coupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
                    ->add('lbc_thread_length_coupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
                    ->add('qc_bore_diameter_coupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
                    ->add('idlock_nipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
                    ->add('pipe_length', null, ['label' => 'Длина трубы (м)'])
                    ->add('weight_of_pipe', null, ['label' => 'Вес трубы (кг)'])
                    ->add('shoulder_angle', null, ['label' => 'Угол заплечика (градус)'])
                    ->add('turnkey_length_nipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
                    ->add('turnkey_length_coupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
                    ->add('ref_thread_coating', null, ['label' => 'Покрытие резьбы'])
                    ->add('ref_inner_coating', ModelType::class, ['label' => 'Внутреннее покрытие', 'btn_add' => false])
                    ->add('ref_hardbanding_nipple', ModelType::class, ['label' => 'Хардбендинг (ниппель)', 'btn_add' => false])
                    ->add('ref_hardbanding_coupling', ModelType::class, ['label' => 'Хардбендинг (муфта)', 'btn_add' => false])
                // end left
                ->end()
                ->with('right', ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                    ->add('ref_wear_class', null, ['label' => 'Класс износа'])
                    ->add('ref_visual_control', null, ['label' => 'Визуальный контроль состояния внутреннего покрытия'])
                    ->add('depth_of_naminov', null, ['label' => 'Глубина наминов в зоне работы клиньев max (мм)'])
                    ->add('nipple_end_bend_max', null, ['label' => 'Изгиб ниппельного конца max (мм)'])
                    ->add('coupling_end_bend_max', null, ['label' => 'Изгиб муфтового конца max (мм)'])
                    ->add('the_total_bend_of_the_pipe_body_max', null, ['label' => 'Общий изгиб тела трубы max (мм)'])
                    ->add('ref_ipc_wedge_zone_and_landing_zone', null, ['label' => 'МПК зоны клинев и зоны высадки'])
                    ->add('ref_ultrasonic_testing', null, ['label' => 'УЗК зоны клиньев и зоны высадки'])
                    ->add('ref_emi_body_pipes', null, ['label' => 'EMI тела трубы (багги)'])
                    ->add('ref_pipe_body_class', null, ['label' => 'Класс тела трубы'])
                    ->add('ref_nipple_thread', null, ['label' => 'Контроль шага резьбы ниппеля плоским шаблоном'])
                    ->add('ref_nipple_thread_condition', null, ['label' => 'Состояние резьбы ниппеля'])
                    ->add('ref_state_persistent', null, ['label' => 'Состояние упорных торцев ниппеля'])
                    ->add('ref_ipc_thread_nipple', null, ['label' => 'МПК резьбы ниппеля'])
                    ->add('ref_hardbending_nipple_state', null, ['label' => 'Хардбендинг ниппель (состояние)'])
                    ->add('hardbanding_nipplemm_diameter', null, ['label' => 'Хардбендинг ниппель (диаметр) мм'])
                    ->add('hardbanding_nipple_height', null, ['label' => 'Хардбендинг ниппель (высота наплавки) мм'])
                    ->add('ref_lock_class_nipple', null, ['label' => 'Класс замка ниппель'])
                    ->add('ref_coupling_thread_condition', null, ['label' => 'Состояние резьбы муфты'])
                    ->add('ref_status_coupling_end_faces', null, ['label' => 'Состояние упорных торцев муфты'])
                    ->add('ref_ipc_thread_coupling', null, ['label' => 'МПК резьбы муфты'])
                    ->add('ref_uzk_thread_coupling', null, ['label' => 'УЗК резьбы муфты'])
                    ->add('ref_hardbendig_coupling_state', null, ['label' => 'Хардбендинг муфта (состояние)'])
                    ->add('hardbanding_coupler_diameter', null, ['label' => 'Хардбендинг муфта (диаметр) мм'])
                    ->add('hardbanding_coupling_height_mm', null, ['label' => 'Хардбендинг муфта (высота наплавки) мм'])
                    ->add('lock_class_coupling', null, ['label' => 'Класс замка муфта'])
            ->end()
        ->end()
        ->tab('media', ['label' => 'Медиа'])
            ->with('media', ['label' => 'Медиа'])
                ->add('images', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                    'entry_type' => \Sonata\MediaBundle\Form\Type\MediaType::class,
                    'label' => 'Изображения',
                    'entry_options' => array(
                        'provider' => 'sonata.media.provider.image',
                        'context' => 'card',
                        'empty_on_new' => false,
                        'new_on_update' => false,
                    ),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                ))
            ->end()
        ->end()
        ;
    }
}