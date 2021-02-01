<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CardFieldValueChangeCommand extends Command
{
    protected static $defaultName = 'app:card-field-value-change';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $cardTableName = 'card';
        $cardAuditTableName = 'card_audit';
        $cards = $this->getRows($cardTableName);
        $cardsAudit = $this->getRows($cardAuditTableName);

        $fieldName = 'rfid_tag_no';


        $this->renameFieldValue($cards, $fieldName, $cardTableName);
        $this->renameFieldValue($cardsAudit, $fieldName, $cardAuditTableName);


        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function getRows($tableName)
    {
        $conn = $this->em->getConnection();
        $sql = '
            SELECT * FROM ' . $tableName . ' c
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function update($tableName, $update, $where)
    {
        $updateStr = "${update[0]} = '${update[1]}'";
        $whereStr = "${where[0]} = '$where[1]'";
        $conn = $this->em->getConnection();
        $sql = "
            UPDATE ${tableName} SET ${updateStr} WHERE ${whereStr}
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    private function addSpace($fieldValue)
    {
        // Удаляем пробелы если есть
        $fieldValueNoSpace = str_replace(' ', '', $fieldValue);
        $newFieldValue = '';

        // Добавляем пробелы
        for ($i = 0; $i < strlen($fieldValueNoSpace); $i++) {
            if ($i !== 0 && $i % 2 === 0) $newFieldValue .= ' ';
            $newFieldValue .= $fieldValueNoSpace[$i];
        }
        return $newFieldValue;
    }

    /**
     * @param array $rows
     * @param string $fieldName
     * @param string $tableName
     */
    protected function renameFieldValue(array $rows, string $fieldName, string $tableName): void
    {
        foreach ($rows as $row) {
            $fieldValue = $row[$fieldName];

            if ($fieldValue) {
                $newFieldValue = $fieldValue;
//                $newFieldValue = $this->addPrefix($newFieldValue);
                $newFieldValue = $this->addSpace($newFieldValue);
//                $newFieldValue = $this->renamePart('0000', '00 00', $newFieldValue);
                if ($fieldValue !== $newFieldValue) {
                    $this->update($tableName, [$fieldName, $newFieldValue], [$fieldName, $fieldValue]);
                }
            }
        }
    }

    /**
     * @param string $fieldValue
     * @return string
     */
    protected function addPrefix(string $fieldValue): string
    {
        $fieldValue .= '3000';
        return $fieldValue;
    }

    /**
     * @param string $fieldValue
     * @return string
     */
    protected function renamePart(string $find, string $replace, string $fieldValue): string
    {
        preg_replace($find, $replace, $$fieldValue);
        return $fieldValue;
    }
}
