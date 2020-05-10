<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\CardFields;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AppExtension constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('sonata_compare', [$this, 'sonataCompare']),
            new TwigFilter('revision_date', [$this, 'revisionDate']),
        ];
    }

    /**
     * @param CardFields $cardField
     * @param CardFields[] $cardFieldsOld
     * @param $isSecondBlock
     * @return string
     */
    public function sonataCompare($cardField, $cardFieldsOld, $isSecondBlock)
    {
        $class = '';
        if (!$isSecondBlock) {
            foreach ($cardFieldsOld as $fieldOld) {
                $findById = $cardField->getId() === $fieldOld->getId();
                $differentValue = $cardField->getValue() !== $fieldOld->getValue();
                if ($findById && $differentValue) {
                    $class = 'diff';
                    break;
                }
            }
        }
        return $class;
    }

    public function revisionDate(int $revisionId)
    {
        $query = "SELECT r.* FROM revisions r WHERE id = ?";
        $revisionsData = $this->em->getConnection()->fetchAll($query, [$revisionId]);

        $dateTime = \DateTime::createFromFormat($this->em->getConnection()->getDatabasePlatform()->getDateTimeFormatString(), $revisionsData[0]['timestamp']);
        return $dateTime->format('d.m.Y H:i');
    }
}
