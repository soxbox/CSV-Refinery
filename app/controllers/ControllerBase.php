<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class ControllerBase extends Controller
{
    protected $errors;

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
            $this->view->urlBase = $this->url->getBaseUri();
        }
    }

    protected function appendErrors($errors)
    {
        Error::appendErrorsToArray($this->errors, $errors);
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
}
