<?php

class ModelBase extends \Phalcon\Mvc\Model
{
    public function getErrors()
    {
        $errors = array();
        foreach ($this->getMessages() as $error)
        {
            Error::appendErrorsToArray($errors, $error);
        }
    }
}
