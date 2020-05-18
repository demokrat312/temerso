<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.04.2020
 * Time: 20:14
 */
namespace App\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
        $this->roles = array('ROLE_USER');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}