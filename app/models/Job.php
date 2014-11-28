<?php

class Job extends ModelBase
{

    public static function start()
    {
        $job = new Job();
        $job->status = JobStatus::findFirstById(JobStatus::PROCESSING_ID);
        $job->progressDescription = "Starting...";
        $job->save();
        return $job;
    }

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $statusId;

    /**
     *
     * @var string
     */
    public $progressDescription;

    public function toArrayOfValues()
    {
        return array(
            'id' => $this->id,
            'statusId' => $this->statusId,
            'statusName' => $this->status->name,
            'statusDescription' => $this->statusDescription
        );
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('Job');

        $this->hasOne('statusId', 'JobStatus', 'id', array(
            'alias' => 'Status'
        ));
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'statusId' => 'statusId', 
            'progressDescription' => 'progressDescription'
        );
    }

}
