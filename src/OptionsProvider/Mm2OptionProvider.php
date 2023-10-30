<?php

namespace App\OptionsProvider;

use Pimcore\Db;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;
use Pimcore\Model\DataObject\Cable;

class Mm2OptionProvider implements SelectOptionsProviderInterface
{
    /**
     * @param array $context 
     * @param Data $fieldDefinition 
     * @return array
     */
    public function getOptions($context, $fieldDefinition): array
    {
        $fields = array();
        $object = $context["object"];

        if ($object instanceof Cable) {
            $db = Db::getConnection();
            
            $query = $db->fetchAllAssociative("SELECT DISTINCT mm2 FROM mm2_to_awg_conversion WHERE mm2 > 0 ORDER BY mm2");
            
            foreach ($query as $value) {
                $fields[] = array(
                    "key" => $value["mm2"],
                    "value" => $value["mm2"]
                );
            }   
            
        }
        return $fields;
    }

    /**
     * Returns the value which is defined in the 'Default value' field  
     * @param array $context 
     * @param Data $fieldDefinition 
     * @return mixed
     */
    public function getDefaultValue($context, $fieldDefinition): ?string
    {
        return null;
    }

    /**
     * @param array $context 
     * @param Data $fieldDefinition 
     * @return bool
     */
    public function hasStaticOptions($context, $fieldDefinition): bool
    {
        return true;
    }
}