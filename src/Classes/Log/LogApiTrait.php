<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-25
 * Time: 01:11
 */

namespace App\Classes\Log;

use App\Entity\LogApi;

/**
 * @mixin LogApi
 */
trait LogApiTrait
{
    public function getRequestContentDecode()
    {
        try {
            return json_decode($this->getRequestContent());
        } catch (\Exception $exception) {
            return [];
        }
    }
    public function getResponseContentDecode()
    {
        try {
            return json_decode($this->getResponseContent());
        } catch (\Exception $exception) {
            return [];
        }
    }
}