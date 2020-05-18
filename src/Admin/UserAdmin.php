<?php
/**
 * Created by PhpStorm.
 * User: back
 * Date: 30.03.2020
 * Time: 11:18
 */

namespace App\Admin;


use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends BaseUserAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        // define group zoning
        $formMapper
            ->tab('User')
                ->with('Profile', ['class' => 'col-md-6'])->end()
                ->with('General', ['class' => 'col-md-6'])->end()
//                ->with('Social', ['class' => 'col-md-6'])->end()
            ->end()
            ->tab('Security')
                ->with('Status', ['class' => 'col-md-6'])->end()
                ->with('Groups', ['class' => 'col-md-6'])->end()
//                ->with('Keys', ['class' => 'col-md-4'])->end()
                ->with('Roles', ['class' => 'col-md-12'])->end()
            ->end()
        ;

        $now = new \DateTime();

        $genderOptions = [
            'choices' => \call_user_func([$this->getUserManager()->getClass(), 'getGenderList']),
            'required' => true,
            'translation_domain' => $this->getTranslationDomain(),
        ];

        $formMapper
            ->tab('User')
                ->with('General')
                    ->add('username')
                    ->add('email')
                    ->add('plainPassword', TextType::class, [
                        'required' => (!$this->getSubject() || null === $this->getSubject()->getId()),
                    ])
                ->end()
                ->with('Profile')
                    ->add('dateOfBirth', \Sonata\Form\Type\DatePickerType::class, [
                        'required' => false,
                    ])
                    ->add('firstname', null, ['required' => false])
                    ->add('lastname', null, ['required' => false])
//                    ->add('website', UrlType::class, ['required' => false])
//                    ->add('biography', TextType::class, ['required' => false])
                    ->add('gender', ChoiceType::class, $genderOptions)
//                    ->add('locale', LocaleType::class, ['required' => false])
//                    ->add('timezone', TimezoneType::class, ['required' => false])
                    ->add('phone', null, ['required' => false])
                ->end()
//                ->with('Social')
//                    ->add('facebookUid', null, ['required' => false])
//                    ->add('facebookName', null, ['required' => false])
//                    ->add('twitterUid', null, ['required' => false])
//                    ->add('twitterName', null, ['required' => false])
//                    ->add('gplusUid', null, ['required' => false])
//                    ->add('gplusName', null, ['required' => false])
//                ->end()
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
//                ->with('Keys')
//                    ->add('token', null, ['required' => false])
//                    ->add('twoStepVerificationCode', null, ['required' => false])
//                ->end()
            ->end()
        ;
    }
}