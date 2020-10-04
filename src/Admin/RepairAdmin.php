<?php

namespace App\Admin;

use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\Task\TaskAdminParent;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Card;
use App\Entity\Marking;
use App\Form\Type\AdminListType;
use App\Form\Type\Repair\RepairImageRequiredType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * 9. Комплектация в ремонт
 */
class RepairAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'repair/show.html.twig');
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
            ->add('comment')
            ->add('cards', AdminListType::class, [
                'class' => Card::class,
                'field_show_name' => 'generalName',
                'fields' => [
                  ['title' => 'Название', 'name' => 'generalName'],
                  ['title' => 'Фотография', 'name' => 'repairCardImgRequiredInput'],
                ],
                'multiple' => true,
                'label' => 'Карточки',
            ]);
        if($this->request->getMethod() === 'POST') {
            $editForm->add('cardImgRequired', CollectionType::class, [
                'entry_type' => RepairImageRequiredType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
        }
        $editForm->add('users', \Sonata\AdminBundle\Form\Type\ModelType::class, [
            'property' => 'fio',
            'multiple' => true,
            'label' => 'Исполнители',
            'btn_add' => false
        ])
            ->end();


        $this->formFieldsButton();
    }
}