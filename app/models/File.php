<?php

class File extends ModelBase
{

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
    public $uploadDate;

    /**
     *
     * @var integer
     */
    public $hasHeaderRow;

    /**
     *
     * @var integer
     */
    public $originalColumnCount;

    /**
     *
     * @var integer
     */
    public $originalRowCount;

    public function beforeSave()
    {
        $this->hasHeaderRow = ($this->hasHeaderRow == true) ? 1 : 0;
    }

    public function afterFetch()
    {
        $this->hasHeaderRow = ($this->hasHeaderRow == 1) ? true : false;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('File');
        $this->hasMany('id', "FileRow", "fileId", array(
            'alias' => 'Rows'
        ));
        $this->hasMany('id', "FileColumn", "fileId", array(
            'alias' => 'Columns'
        ));
        $this->hasMany('id', "FileCell", "fileId", array(
            'alias' => 'Cells'
        ));
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'uploadDate' => 'uploadDate', 
            'hasHeaderRow' => 'hasHeaderRow', 
            'originalColumnCount' => 'originalColumnCount', 
            'originalRowCount' => 'originalRowCount'
        );
    }

}
