<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class ControllerBase extends Controller
{
    private $errors;

    public function initialize()
    {
        $this->errors = array();
    }

/*    public function beforeExecuteRoute($dispatcher)
    {
        return true;
    }*/

    public function afterExecuteRoute($dispatcher)
    {
        if (!$this->view->isDisabled) {
            $this->view->errors = $this->errors;
        }
    }

    protected function appendErrors($errors)
    {
        Error::appendErrorsToArray($this->errors, $errors);
    }

    protected function appendErrorsFromEntity($entity)
    {
        $entity->appendErrorsToArray($this->errors);
    }

    protected function hasErrors()
    {
        return empty($this->errors) == false;
    }

    protected function getRedirectResponse($url, $ignoreErrors = false)
    {
        if (!$this->hasErrors()
            || ($this->hasErrors()
                && $ignoreErrors == true)) {

            $this->view->disable();
            $response = new \Phalcon\Http\Response();
            return $response->redirect($url);
        }
    }

    protected function getOkJsonResponse($data, $additionalErrors = null)
    {
        return $this->getJsonResponse(JsonStatus::ok(), $data, $additionalErrors);
    }
    protected function getErrorJsonResponse($data, $additionalErrors = null)
    {
        return $this->getJsonResponse(JsonStatus::error(), $data, $additionalErrors);
    }

    private function getJsonResponse($jsonStatus, $data, $additionalErrors = null)
    {
        $this->appendErrors($additionalErrors);

        $this->view->disable();
        $returnValue = new JsonReturnValue();
        $returnValue->status = $jsonStatus;
        if ($this->hasErrors())
        {
            $returnValue->errors = $this->errors;
        }
        $returnValue->result = $data;
        $response = new Phalcon\Http\Response();
        $response->setJsonContent($returnValue);
        return $response;
    }
}
