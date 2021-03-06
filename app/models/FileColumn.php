<?php

use Phalcon\Mvc\Model\Relation;

class FileColumn extends ModelBase
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
    public $columnNumber;

    /**
     *
     * @var string
     */
    public $originalName;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $filterDefinitionId;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('FileColumn');
/*        $this->hasMany('id', "FileCell", "fileColumnId", array(
            'alias' => 'Cells',
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
        $this->belongsTo('fileId', "File", "id", array(
            'alias' => 'File'
        ));*/
        $this->hasOne('filterDefinitionId', 'FilterDefinition', 'id', array(
            'alias' => 'FilterDefinition'
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
            'columnNumber' => 'columnNumber', 
            'originalName' => 'originalName',
            'filterId' => 'filterId',
            'name' => 'name'
        );
    }

}
