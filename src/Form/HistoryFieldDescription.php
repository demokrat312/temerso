<?php


namespace App\Form;


use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

class HistoryFieldDescription extends FieldDescription
{
    const FIELD_PREFIX = 'history_';

    /**
     * @var array[] cached object field getters
     */
    private static $fieldGetters = [];
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ClassMetadata
     */
    private $metadata;

    public function __construct(EntityManagerInterface $em, ClassMetadata $metadata)
    {
        parent::__construct();
        $this->em = $em;
        $this->metadata = $metadata;
    }


    public function getName()
    {
        return self::FIELD_PREFIX . parent::getName();
    }

    public function getFieldValue($object, $fieldName)
    {
        $mapping        = $this->getAssociationMapping();
        $tableName      = $this->metadata->getTableName();
        $auditTableName = $tableName . '_audit';

        if (isset($this->metadata->associationMappings[$fieldName])) {
            $fieldName = $mapping['joinColumns'][0]['name'];
        }

        $historyValue = $this->getHistoryValue($fieldName, $auditTableName, $object->getId());

        if (empty($mapping['targetEntity'])) {
            return $historyValue;
        } else {
            return $this->em->getRepository($mapping['targetEntity'])->find($historyValue);
        }
    }


    private function getHistoryValue(string $fieldName, string $auditTableName, int $objectId)
    {
        $sql  = "SELECT ${fieldName} FROM ${auditTableName} WHERE id = ? ORDER BY id DESC LIMIT 1 ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $objectId);
        $stmt->execute();

        return $stmt->fetch(FetchMode::COLUMN);
    }

}