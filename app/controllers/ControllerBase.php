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

    protected function redirectNowAndContinueProcessing($redirectUrl)
    {
        $this->closeConnection(null, $redirectUrl);
    }

    protected function closeConnectionNowAndContinueProcessing($content = null)
    {
        $this->closeConnection($content);
    }

    private function closeConnection($content = null, $redirectUrl = null)
    {
        $this->view->disable();

        // taken from: http://php.net/manual/en/features.connection-handling.php#71172

        // there is an added layer of buffering that Phalcon adds.
        // this while loop kills ALL buffering levels
        while(ob_get_level()) {
            //echo ("1\r\n");
            ob_end_flush();
        }
        ignore_user_abort(true);//avoid apache to kill the php running
        ob_start();//start buffer output

        if (!empty($content)) {
            echo $content;
        }

        session_write_close();//close session file on server side to avoid blocking other requests
        header("Content-Encoding: none");//send header to avoid the browser side to take content as gzip format
        header("Content-Length: " . ob_get_length());//send length header
        header("Connection: close");//or redirect to some url: header('Location: http://www.google.com');
        if (!empty($redirectUrl))  {
            // TODO: fix to include the urlBase
            header("Location: $redirectUrl", true);
        }
        ob_end_flush();
        flush();//really send content, can't change the order:1.ob buffer to normal buffer, 2.normal buffer to output

        // if you're using sessions, this prevents subsequent requests
        // from hanging while the background process executes
        if (session_id()) session_write_close();
    }
}
