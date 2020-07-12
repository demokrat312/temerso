<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-12
 * Time: 22:16
 */

namespace App\Classes;


use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Task\InstanceTrait;
use Doctrine\Common\Collections\Collection;
use Sonata\MediaBundle\Generator\IdGenerator;

class MediaHelper
{
    use InstanceTrait;

    public function getImageLink(Collection $images)
    {
        $arImages = [];
        if ($images) {
            $generator = new IdGenerator();
            $images->map(function (Media $media) use ($generator, &$arImages) {
//                $arImages[] = $media;
                $arImages[] = Media::PATH . $generator->generatePath($media) . '/' . $media->getProviderReference();
            });
        }
        return $arImages;
    }
}