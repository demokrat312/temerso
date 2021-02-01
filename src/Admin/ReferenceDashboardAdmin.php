<?php

namespace App\Admin;


use App\Classes\MainAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ReferenceDashboardAdmin extends MainAdmin
{
    protected $baseRouteName = 'reference_dashboard';
    protected $baseRoutePattern = 'reference-dashboard';

    protected function configureFormFields(FormMapper $form)
    {
        $url = $this->generateUrl('list');
        header('Location: ' . $url);
        die();
    }
}