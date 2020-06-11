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
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @AttributeOverrides({
 *     @AttributeOverride(name="email",
 *         column=@ORM\Column(
 *             name="email",
 *             type="string",
 *             length=180,
 *             nullable=true
 *         )
 *     ),
 *     @AttributeOverride(name="emailCanonical",
 *         column=@ORM\Column(
 *             name="email_canonical",
 *             type="string",
 *             length=180,
 *             unique=true,
 *             nullable=true
 *         )
 *     )
 * })
 */
class User extends BaseUser
{
    const ROLE_INSPECTOR = 'ROLE_INSPECTOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_STOREKEEPER = 'ROLE_STOREKEEPER'; // Кладовщик
    const ROLE_STAFF = 'ROLE_STAFF'; // Кладовщик и инспектор

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Не меньшее {{ limit }} символов",
     *     groups={"Profile", "Registration", "Default"}
     * )
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * Должность
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $positionName;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
        $this->roles = array('ROLE_USER');
    }

    public function __toString()
    {
        return $this->getFio();
    }


    public function getFio() {
        return sprintf('%s %s', $this->lastname, $this->firstname);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPositionName(): ?string
    {
        return $this->positionName;
    }

    public function setPositionName(?string $positionName): self
    {
        $this->positionName = $positionName;

        return $this;
    }
}