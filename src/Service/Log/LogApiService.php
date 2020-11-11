<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-24
 * Time: 20:17
 */

namespace App\Service\Log;


use App\Classes\Utils;
use App\Entity\LogApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LogApiService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /** @var LogApi */
    private $lastLog;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function writeRequestLog(Request $request)
    {
        if(!$this->isApiRequest($request)) return;

        $logApi = new LogApi();

        if($request->getContent()) {
            $content = $request->getContent();
        } else {
            $content = json_encode($request->request->all());
        }

        $logApi
            ->setIp($request->getClientIp())
            ->setUrl($request->getRequestUri())
            ->setRequestContent($content)
        ;

        $this->lastLog = $logApi;
    }

    public function writeResponseLog($response, int $responseType)
    {
        $this->lastLog
            ->setResponseContent($response)
            ->setResponseType($responseType)
        ;
    }

    public function hasLog()
    {
        return !!$this->lastLog;
    }

    public function onTerminate()
    {
        if($this->lastLog){
            $this->em->persist($this->lastLog);
            $this->em->flush();
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isApiRequest(Request $request): bool
    {
        return $request->headers->has('authorization');
    }

}