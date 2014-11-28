<?php

class FileCell extends ModelBase
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $fileId;

    /**
     *
     * @var integer
     */
    public $fileColumnId;

    /**
     *
     * @var integer
     */
    public $fileRowId;

    /**
     *
     * @var string
     */
    public $originalValue;

    /**
     *
     * @var string
     */
    public $value;

    /**
     *
     * @var integer
     */
    public $isCleaned;

    /**
     *
     * @var integer
     */
    public $isValid;

    public function beforeSave()
    {
        $this->isCleaned = ($this->isCleaned == true) ? 1 : 0;
        $this->isValid = ($this->isValid == true) ? 1 : 0;
    }

    public function afterFetch()
    {
        $this->isCleaned = ($this->isCleaned == 1) ? true : false;
        $this->isValid = ($this->isValid == 1) ? true : false;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('FileCell');
/*        $this->belongsTo('fileId', "File", "id", array(
            'alias' => 'File'
        ));
        $this->belongsTo('fileColumnId', "FileColumn", "id", array(
            'alias' => 'Column'
        ));
        $this->belongsTo('fileRowId', "FileRow", "id", array(
            'alias' => 'Row'
        ));*/
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'fileId' => 'fileId',
            'fileColumnId' => 'fileColumnId', 
            'fileRowId' => 'fileRowId',
            'isCleaned' => 'isCleaned',
            'originalValue' => 'originalValue',
            'isValid' => 'isValid',
            'value' => 'value'
        );
    }

}
