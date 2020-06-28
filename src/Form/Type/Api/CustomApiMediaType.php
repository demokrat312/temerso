<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.06.2020
 * Time: 15:50
 */

namespace App\Form\Type\Api;


use App\Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Provider\Pool;

class CustomApiMediaType extends \Sonata\MediaBundle\Form\Type\ApiMediaType
{
    public function __construct(Pool $mediaPool)
    {
        $class = Media::class;
        parent::__construct($mediaPool, $class);
    }

}