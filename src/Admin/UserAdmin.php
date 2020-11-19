<?php
/**
 * Created by PhpStorm.
 * User: back
 * Date: 30.03.2020
 * Time: 11:18
 */

namespace App\Admin;


use App\Classes\Utils;
use App\Entity\User;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserAdmin extends BaseUserAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('acl')
        ;
    }

    public function configure()
    {
        $this->setTemplate('edit', 'user/edit.html.twig');
    }

    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();

        $options = $this->formOptions;
//        $options['validation_groups'] = (!$this->getSubject() || null === $this->getSubject()->getId()) ? 'Registration' : 'Profile';
        $options['validation_groups'] = '';

        $formBuilder = $this->getFormContractor()->getFormBuilder($this->getUniqid(), $options);

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        // define group zoning
        $formMapper
            ->tab('User')
                ->with('Profile', ['class' => 'col-md-6'])->end()
                ->with('General', ['class' => 'col-md-6'])->end()
            ->end()
            ->tab('Security')
                ->with('Status', ['class' => 'col-md-6'])->end()
                ->with('Groups', ['class' => 'col-md-6'])->end()
                ->with('Roles', ['class' => 'col-md-12'])->end()
            ->end();

        $genderOptions = [
            'choices' => \call_user_func([$this->getUserManager()->getClass(), 'getGenderList']),
            'required' => true,
            'translation_domain' => $this->getTranslationDomain(),
        ];

        $formMapper
            ->tab('User')
                ->with('General')
                    ->add('username')
                    ->add('email', null, ['required' => false])
                    ->add('plainPassword', TextType::class, [
                        'required' => (!$this->getSubject() || null === $this->getSubject()->getId()),
                    ])
                    ->add('positionName', null, ['required' => false])
                ->end()
                ->with('Profile')
                    ->add('firstname', null, ['required' => false])
                    ->add('lastname', null, ['required' => false])
                    ->add('gender', ChoiceType::class, $genderOptions)
                    ->add('dateOfBirth', \Sonata\Form\Type\DatePickerType::class, [
                        'required' => false,
                    ])
                    ->add('phone', null, ['required' => false])
                ->end()
            ->end()
            ->tab('Security')
                ->with('Status')
                    ->add('enabled', null, ['required' => false])
                ->end()
                ->with('Groups')
                    ->add('groups', ModelType::class, [
                        'required' => false,
                        'expanded' => true,
                        'multiple' => true,
                    ])
                ->end()
                ->with('Roles')
                    ->add('realRoles', SecurityRolesType::class, [
                        'label' => 'form.label_roles',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false,
                    ])
                ->end()
            ->end();

        if (!$this->isAdmin($this->getCurrentUser())) {
            $formMapper
                ->removeGroup('Status', 'Security')
                ->removeGroup('Groups', 'Security')
                ->removeGroup('Roles', 'Security', true);
        }
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('username')
            ->add('fio', null, ['mapped' => false])
            ->add('groups')
            ->add('enabled', null, ['editable' => true])
            ->add('createdAt')
        ;

//        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
//            $listMapper
//                ->add('impersonating', 'string', ['template' => '@SonataUser/Admin/Field/impersonating.html.twig'])
//            ;
//        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper): void
    {
        $filterMapper
            ->add('username')
            ->add('email')
            ->add('groups')
            ->add('firstname')
            ->add('all', CallbackFilter::class, [
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $qb
                        ->andWhere($qb->expr()->orX(
                            $qb->expr()->like(sprintf('LOWER(%s.firstname)', $alias), '?1'),
                            $qb->expr()->like(sprintf('LOWER(%s.lastname)', $alias), '?1'),
                            $qb->expr()->like(sprintf('LOWER(%s.username)', $alias), '?1')
                        ))
                        ->setParameter('1', '%' . strtolower($value['value']) . '%');

                    return true;
                }
            ]);
    }

    public function checkAccess($action, $object = null)
    {
        parent::checkAccess($action, $object);
        $this->checkUserAccess();
    }

    private function checkUserAccess()
    {
        $curUser = $this->getCurrentUser();
        if (!$this->isAdmin($curUser)) {
            $editUser = $this->getSubject();
            if ($editUser != $curUser) {
                $redirection = new RedirectResponse($this->getConfigurationPool()->getContainer()->get('router')
                    ->generate('admin_app_user_show', ['id' => $curUser->getId()]));
                $redirection->send();
            }
        }
    }

    private function isAdmin(User $user): bool
    {
        return Utils::in_array([User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN], $user->getRoles());
    }

    private function getCurrentUser(): User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }
}