<?php


use Phalcon\Mvc\Model\Relation;

class FilterDefinition extends ModelBase
{
    const PHONE_NUMBER_FILTER_DEFINITION_ID = 1;
    const NAME_FILTER_DEFINITION_ID = 2;
    const FULL_NAME_FILTER_DEFINITION_ID = 3;
    const ADDRESS_LINE_FILTER_DEFINITION_ID = 4;
    const STATE_ABBREVIATION_FILTER_DEFINITION_ID = 5;
    const POSTAL_CODE_FILTER_DEFINITION_ID = 6;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $description;

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        );
    }

    public function initialize()
    {
        $this->setSource('FilterDefinition');
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'description' => 'description'
        );
    }
}
