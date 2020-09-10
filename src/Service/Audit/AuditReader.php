<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 09.05.2020
 * Time: 20:05
 */

namespace App\Service\Audit;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use SimpleThings\EntityAudit\AuditConfiguration;
use SimpleThings\EntityAudit\Exception\NotAuditedException;
use SimpleThings\EntityAudit\Metadata\MetadataFactory;
use SimpleThings\EntityAudit\Revision;

class AuditReader extends \SimpleThings\EntityAudit\AuditReader
{
    private $em;

    public function __construct(EntityManagerInterface $em, AuditConfiguration $config, MetadataFactory $factory)
    {
        parent::__construct($em, $config, $factory);
        $this->em = $em;
    }


    /**
     * Find all revisions that were made of entity class with given id.
     *
     * @param string $className
     * @param mixed $id
     * @return Revision[]
     * @throws NotAuditedException
     */
    public function findRevisions($className, $id)
    {
        /** @var ClassMetadataInfo|ClassMetadata $class */
        $class = $this->em->getClassMetadata($className);
        $tableName = $this->getConfiguration()->getTableName($class);

        if (!is_array($id)) {
            $id = array($class->identifier[0] => $id);
        }

        $whereSQL = "";
        foreach ($class->identifier AS $idField) {
            if (isset($class->fieldMappings[$idField])) {
                if ($whereSQL) {
                    $whereSQL .= " AND ";
                }
                $whereSQL .= "e." . $class->fieldMappings[$idField]['columnName'] . " = :id";
            } else if (isset($class->associationMappings[$idField])) {
                if ($whereSQL) {
                    $whereSQL .= " AND ";
                }
                $whereSQL .= "e." . $class->associationMappings[$idField]['joinColumns'][0] . " = :id";
            }
        }

        $join = '';
        if ($className === Card::class) {
            // Дополнительные поля
            $join .= ' LEFT JOIN (select distinct (rev) as rev, card_id
                   from card_fields_audit) field on field.rev = r.id ';
            $whereSQL .= ' OR field.card_id = :id';

            // Поля из задач (коментарий и др)
            $join .= ' LEFT JOIN (select distinct (rev) as rev, card_id
                   from task_card_other_field_audit) task_card_other_field_audit on task_card_other_field_audit.rev = r.id ';
            $whereSQL .= ' OR task_card_other_field_audit.card_id = :id';
        }

        $query = "SELECT r.* FROM " . $this->getConfiguration()->getRevisionTableName() . " r " .
            "LEFT JOIN " . $tableName . " e ON r.id = e." . $this->getConfiguration()->getRevisionFieldName() . $join . " WHERE " . $whereSQL . " ORDER BY r.id DESC";
        $revisionsData = $this->em->getConnection()->fetchAll($query, $id);

        $revisions = array();


        foreach ($revisionsData AS $row) {
            $revisions[] = new Revision(
                $row['id'],
                \DateTime::createFromFormat($this->em->getConnection()->getDatabasePlatform()->getDateTimeFormatString(), $row['timestamp']),
                $row['username']
            );
        }

        return $revisions;
    }

}