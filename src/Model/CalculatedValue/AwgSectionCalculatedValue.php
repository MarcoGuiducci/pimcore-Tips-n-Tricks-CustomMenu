<?php

namespace App\Model\CalculatedValue;

use Pimcore\Db;
use Pimcore\Model\DataObject\Cable;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\ClassDefinition\CalculatorClassInterface;
use Pimcore\Model\DataObject\Data\CalculatedValue;
 
class AwgSectionCalculatedValue implements CalculatorClassInterface
{
    public function compute(Concrete $object, CalculatedValue $context): string
    {
        return $this->doCompute($object, $context);
    }

    public function getCalculatedValueForEditMode(Concrete $object, CalculatedValue $context): string
    {
        return $this->doCompute($object, $context);
    }

    public function doCompute(Concrete $object, CalculatedValue $context) : string
    {
        if($object instanceof Cable && $context->getFieldname() == "awgSection"){
            $mm2Section = $object->getMm2Section();

            if(!empty($mm2Section)){
                $db = Db::getConnection();

                $awgSection = $db->fetchOne("SELECT awg FROM mm2_to_awg_conversion WHERE mm2 = ?", array($mm2Section));

                return $awgSection ?? "";
            }
        }

        return "";
    }
} 