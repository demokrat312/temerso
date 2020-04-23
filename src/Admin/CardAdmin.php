<?php

namespace App\Admin;


use App\Classes\MainAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 22.04.2020
 * Time: 20:44
 */
class CardAdmin extends MainAdmin
{
    public $supportsPreviewMode = true;

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with("left", ['class' => 'col-md-6', 'description' => 'Lorem ipsum', 'label' => 'Характеристики'])
            ->add('id')
            ->add('ref_type_equipment', null, ['label' => 'Тип оборудования'])
            ->add('status', null, ['label' => 'Статус'])
            ->add('location', null, ['label' => 'Местоположение'])
            ->add('operating_hours', null, ['label' => 'Наработкgа моточасов'])
            ->add('ref_warehouse', ModelType::class, ['label' => '№ Склада'])
            ->add('rfid_tag_serial_no', null, ['label' => 'Серийный № метки RFID'])
            ->add('rfid_tag_no', null, ['label' => '№ Метки RFID'])
            ->add('pipe_serial_number', null, ['label' => 'Серийный № трубы'])
            ->add('serial_no_of_nipple', null, ['label' => 'Серийный № ниппеля'])
            ->add('coupling_serial_number', null, ['label' => 'Серийный № муфты'])
            ->add('serial_no_after_repair', null, ['label' => 'Серийный № после ремонта'])
            ->add('outer_diameter_of_the_pipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
            ->add('pipe_wall_thickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
            ->add('ref_type_disembarkation', null, ['label' => 'Тип высадки'])
            ->add('ref_pipe_strength_group', null, ['label' => 'Группа прочности трубы'])
            ->add('ref_type_thread', ModelType::class, ['label' => 'Тип резьбы'])
            ->add('odlock_nipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
            ->add('dfchamfer_nipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
            ->add('lpc_thread_length_nipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
            ->add('nipple_nose_diameter', null, ['label' => 'Диаметр носика ниппеля'])
            ->add('odlock_coupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
            ->add('dfchamfer_coupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
            ->add('lbc_thread_length_coupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
            ->add('qc_bore_diameter_coupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
            ->add('idlock_nipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
            ->add('pipe_length', null, ['label' => 'Длина трубы (м)'])
            ->add('weight_of_pipe', null, ['label' => 'Вес трубы (кг)'])
            ->add('shoulder_angle', null, ['label' => 'Угол заплечика (градус)'])
            ->add('turnkey_length_nipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
            ->add('turnkey_length_coupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
            ->add('ref_thread_coating', null, ['label' => 'Покрытие резьбы'])
            ->add('ref_inner_coating', ModelType::class, ['label' => 'Внутреннее покрытие'])
            ->add('ref_hardbanding_nipple', ModelType::class, ['label' => 'Хардбендинг (ниппель)'])
            ->add('ref_hardbanding_coupling', ModelType::class, ['label' => 'Хардбендинг (муфта)'])
            // end left
            ->end()->with('right', ['class' => 'col-md-6', 'description' => 'Lorem ipsum', 'label' => 'Характеристики'])
            // start right
            ->add('bt_certificate_number', null, ['label' => 'Номер Сертификата на комплект БТ'])
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
            ->add('min_the_width_thrust_shoulder', null, ['label' => 'Миним. ширина упорного уступа ниппеля при эксцентрич износе мм'])
            ->add('min_width_stop_shoulder', null, ['label' => 'Миним. ширина упорного уступа муфты при эксцентрич износе мм'])
            ->add('min_length_transition_section', null, ['label' => 'Миним. Длина переходного участка высадки miu,  мм'])
            ->add('ref_label_resurfacing', null, ['label' => 'Метка для перешлифовки'])
            ->add('the_minimum_moment', null, ['label' => 'Минимальный момент свинчивания замка, кНм'])
            ->add('the_maximum_moment', null, ['label' => 'Максимальный момент свинчивания замка, кНм'])
            ->add('the_limiting_moment', null, ['label' => 'Предельный  момент кручения  замка, кНм'])
            ->add('the_ultimate_tensile', null, ['label' => 'Предельная растягивающая нагрузка замка, Кн'])
            ->add('the_ultimate_torque_of_the_tube', null, ['label' => 'Предельный  момент кручения  трубы, кНм'])
            ->add('the_ultimate_tensile_load_of_the_pipe', null, ['label' => 'Предельная растягивающая нагрузка трубы, Кн'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->addIdentifier($listMapper, 'id');

        // Name of the action (show, edit, history, delete, etc)
        $listMapper->add('_action', null, [
            'actions' => [
                'show' => [],
                'edit' => [
                    // You may add custom link parameters used to generate the action url
                    'link_parameters' => [
                        'full' => true,
                    ]
                ],
                'delete' => [],
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('image', 'collection', array(
//                 'entry_type' => 'sonata_media_type',
//                 'entry_options' => array(
//                     'provider' => 'sonata.media.provider.image',
//                     'context'  => 'default',
//                     'empty_on_new' => true,
//                 ),
//                 'allow_add' => true,
//                 'by_reference' => false,
//             ))
            ->with("left", ['class' => 'col-md-6', 'description' => 'Lorem ipsum', 'label' => 'Характеристики'])
            ->add('ref_type_equipment', null, ['label' => 'Тип оборудования'])
            ->add('status', null, ['label' => 'Статус'])
            ->add('location', null, ['label' => 'Местоположение'])
            ->add('operating_hours', null, ['label' => 'Наработкgа моточасов'])
            ->add('ref_warehouse', ModelType::class, ['label' => '№ Склада'])
            ->add('rfid_tag_serial_no', null, ['label' => 'Серийный № метки RFID'])
            ->add('rfid_tag_no', null, ['label' => '№ Метки RFID'])
            ->add('pipe_serial_number', null, ['label' => 'Серийный № трубы'])
            ->add('serial_no_of_nipple', null, ['label' => 'Серийный № ниппеля'])
            ->add('coupling_serial_number', null, ['label' => 'Серийный № муфты'])
            ->add('serial_no_after_repair', null, ['label' => 'Серийный № после ремонта'])
            ->add('outer_diameter_of_the_pipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
            ->add('pipe_wall_thickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
            ->add('ref_type_disembarkation', null, ['label' => 'Тип высадки'])
            ->add('ref_pipe_strength_group', null, ['label' => 'Группа прочности трубы'])
            ->add('ref_type_thread', ModelType::class, ['label' => 'Тип резьбы'])
            ->add('odlock_nipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
            ->add('dfchamfer_nipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
            ->add('lpc_thread_length_nipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
            ->add('nipple_nose_diameter', null, ['label' => 'Диаметр носика ниппеля'])
            ->add('odlock_coupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
            ->add('dfchamfer_coupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
            ->add('lbc_thread_length_coupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
            ->add('qc_bore_diameter_coupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
            ->add('idlock_nipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
            ->add('pipe_length', null, ['label' => 'Длина трубы (м)'])
            ->add('weight_of_pipe', null, ['label' => 'Вес трубы (кг)'])
            ->add('shoulder_angle', null, ['label' => 'Угол заплечика (градус)'])
            ->add('turnkey_length_nipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
            ->add('turnkey_length_coupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
            ->add('ref_thread_coating', null, ['label' => 'Покрытие резьбы'])
            ->add('ref_inner_coating', ModelType::class, ['label' => 'Внутреннее покрытие'])
            ->add('ref_hardbanding_nipple', ModelType::class, ['label' => 'Хардбендинг (ниппель)'])
            ->add('ref_hardbanding_coupling', ModelType::class, ['label' => 'Хардбендинг (муфта)'])
            // end left
            ->end()->with('right', ['class' => 'col-md-6', 'description' => 'Lorem ipsum', 'label' => 'Характеристики'])
            // start right
            ->add('bt_certificate_number', null, ['label' => 'Номер Сертификата на комплект БТ'])
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
            ->add('min_the_width_thrust_shoulder', null, ['label' => 'Миним. ширина упорного уступа ниппеля при эксцентрич износе мм'])
            ->add('min_width_stop_shoulder', null, ['label' => 'Миним. ширина упорного уступа муфты при эксцентрич износе мм'])
            ->add('min_length_transition_section', null, ['label' => 'Миним. Длина переходного участка высадки miu,  мм'])
            ->add('ref_label_resurfacing', null, ['label' => 'Метка для перешлифовки'])
            ->add('the_minimum_moment', null, ['label' => 'Минимальный момент свинчивания замка, кНм'])
            ->add('the_maximum_moment', null, ['label' => 'Максимальный момент свинчивания замка, кНм'])
            ->add('the_limiting_moment', null, ['label' => 'Предельный  момент кручения  замка, кНм'])
            ->add('the_ultimate_tensile', null, ['label' => 'Предельная растягивающая нагрузка замка, Кн'])
            ->add('the_ultimate_torque_of_the_tube', null, ['label' => 'Предельный  момент кручения  трубы, кНм'])
            ->add('the_ultimate_tensile_load_of_the_pipe', null, ['label' => 'Предельная растягивающая нагрузка трубы, Кн'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function getNewInstance()
    {
        /** @var \App\Entity\Card $object */
        $object = parent::getNewInstance();

        return $object;
    }
}