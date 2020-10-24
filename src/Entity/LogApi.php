<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-24
 * Time: 14:08
 */

namespace App\Entity;

use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogApiRepository")
 * @ORM\Table(name="log_api")
 */
class LogApi implements CreatedByListenerInterface
{
    const RESPONSE_TYPE_SUCCESS = 1;
    const RESPONSE_TYPE_ERROR = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $url;

    /**
     * @ORM\Column(type="text")
     */
    private $requestContent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $responseContent;

    /**
     * @ORM\Column(type="integer")
     */
    private $responseType = self::RESPONSE_TYPE_SUCCESS;

    public function __construct()
    {
        $this->createAt = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     * @return $this
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestContent()
    {
        return $this->requestContent;
    }

    /**
     * @param mixed $requestContent
     * @return $this
     */
    public function setRequestContent($requestContent)
    {
        $this->requestContent = $requestContent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponseContent()
    {
        return $this->responseContent;
    }

    /**
     * @param mixed $responseContent
     * @return $this
     */
    public function setResponseContent($responseContent)
    {
        $this->responseContent = $responseContent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @param mixed $responseType
     * @return $this
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
        return $this;
    }
}