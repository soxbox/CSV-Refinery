<?php

class FileRow extends ModelBase
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
    public $rowNumber;

    /**
     *
     * @var integer
     */
    public $skipInOutput;

    /**
     *
     * @var integer
     */
    public $isHeaderRow;

    public function beforeSave()
    {
        $this->skipInOutput = $this->skipInOutput == true ? 1 : 0;
        $this->isHeaderRow = $this->isHeaderRow == true ? 1 : 0;
    }

    public function afterFetch()
    {
        $this->skipInOutput = $this->skipInOutput == 1 ? true : false;
        $this->isHeaderRow = $this->isHeaderRow == 1 ? true : false;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('FileRow');
        $this->hasMany('id', "FileCell", "fileRowId", array(
            'alias' => 'Cells'
        ));
        $this->belongsTo('fileId', "File", "id", array(
            'alias' => 'File'
        ));
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'fileId' => 'fileId', 
            'rowNumber' => 'rowNumber', 
            'skipInOutput' => 'skipInOutput', 
            'isHeaderRow' => 'isHeaderRow'
        );
    }

}
