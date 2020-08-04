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

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 */
class CardAdminController extends DefaultAdminController
{
    const ROUTER_DISPOSAL = 'disposal';

    /**
     * @link https://packagist.org/packages/onurb/excel-bundle
     */
    public function disposalAction()
    {
        // filter[broken][value]=1
        $url = $this->admin->generateUrl('list', ['filter' => ['broken' => ['value' => 1]]]);
        return new RedirectResponse($url);
    }
}
