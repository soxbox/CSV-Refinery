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

/*    protected $_isJsonResponse = false;

    // Call this func to set json response enabled
    public function setJsonResponse() {
        $this->view->disable();

        $this->_isJsonResponse = true;
        $this->response->setContentType('application/json', 'UTF-8');
    }

    // After route executed event
    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
        if ($this->_isJsonResponse) {
            $data = $dispatcher->getReturnedValue();
            if (is_array($data)) {
                $data = json_encode($data);
            }

            $this->response->setContent($data);
        }
    }*/
}
