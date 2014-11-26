<?php


use Phalcon\Mvc\Model\Relation;

class Filter extends ModelBase
{
    const PHONE_NUMBER_FILTER_ID = 1;
    const NAME_FILTER_ID = 2;
    const FULL_NAME_FILTER_ID = 3;
    const ADDRESS_LINE_FILTER_ID = 4;
    const STATE_ABBREVIATION_FILTER_ID = 5;
    const POSTAL_CODE_FILTER_ID = 6;

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

    public function initialize()
    {
        $this->setSource('Filter');
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
