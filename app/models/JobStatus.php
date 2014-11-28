<?php

class JobStatus extends ModelBase
{
    const PROCESSING_ID = 1;
    const COMPLETE_SUCCEEDED_ID = 2;
    const COMPLETE_FAILED_ID = 3;

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

    public function toArrayOfValues()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('JobStatus');
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'name' => 'name'
        );
    }

}
