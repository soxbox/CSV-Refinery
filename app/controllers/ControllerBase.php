<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class ControllerBase extends Controller
{
    protected function appendErrorMessages($entity)
    {
        foreach ($entity->getMessages() as $error)
        {
            array_push($this->view->errors, $error);
        }
    }

    protected function hasErrors()
    {
        return count($this->view->errors) > 0;
    }
}
