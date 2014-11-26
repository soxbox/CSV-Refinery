<?php

class ModelBase extends \Phalcon\Mvc\Model
{
    public function appendErrorsToArray($errors)
    {
        foreach ($this->getMessages() as $error)
        {
            Error::appendErrorsToArray($errors, $error);
        }
    }
}
