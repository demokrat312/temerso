<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\CardFields;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sonata_compare', [$this, 'sonataCompare']),
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
}
