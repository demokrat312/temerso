<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 10.06.2020
 * Time: 10:00
 */

namespace App\Form\Type;


use Doctrine\DBAL\FetchMode;
use Sonata\AdminBundle\Form\Type\Operator\NumberOperatorType;

class HistoryCallbackFilter extends \Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter
{
    public function getDefaultOptions()
    {
        $options = parent::getDefaultOptions();

        $options['operator_type'] = NumberOperatorType::class;

        $options['callback'] = function ($queryBuilder, $alias, $field, $value) {
            if (!$value['value']) {
                return false;
            }

            //<editor-fold desc="Параметры для запроса">
            $qb = $queryBuilder;
            $em = $qb->getEntityManager();

            $className = $queryBuilder->getDQLPart('from')[0]->getFrom();
            $tableName = $em->getClassMetadata($className)->getTableName();
            $fieldName = isset($this->getOptions()['association_mapping']) ?
                $this->getOptions()['association_mapping']['joinColumns'][0]['name'] :
                $field;
            $operator = $this->getOperator($value['type']);
            //</editor-fold>



            // Получаем первые записи из истории и фильтруем по значению из фильтра
            $query = "
                        SELECT id
                          FROM ${tableName}_audit
                         WHERE ${fieldName} ${operator} ? AND rev IN (
                                       SELECT min(rev)
                                         FROM ${tableName}_audit
                                        GROUP BY id
                                     );
                    ";


            //<editor-fold desc="Получаем массив id основной сущности для фильтрации списка">
            $stmt = $em->getConnection()->prepare($query);
            $stmt->bindValue(1, is_object($value['value']) ? $value['value']->getId() : $value['value']);
            $stmt->execute();

            $entityIds = $stmt->fetchAll(FetchMode::COLUMN);
            //</editor-fold>

            //<editor-fold desc="Фильтруем по ids">
            $qb
                ->andWhere($qb->expr()->in(sprintf('LOWER(%s.id)', $alias), '?1'))
                ->setParameter('1', $entityIds);
            //</editor-fold>

            return true;
        };

        return $options;
    }

    private function getOperator(?int $type) {
        switch ($type) {
            case NumberOperatorType::TYPE_GREATER_EQUAL:
                return '>=';
            case NumberOperatorType::TYPE_GREATER_THAN:
                return '>';
            case NumberOperatorType::TYPE_EQUAL:
                return '=';
            case NumberOperatorType::TYPE_LESS_EQUAL:
                return '<=';
            case NumberOperatorType::TYPE_LESS_THAN:
                return '<';
            default:
                return '=';
        }
    }

}