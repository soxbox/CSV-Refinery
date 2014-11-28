<?php

class ApiControllerBase extends ControllerBase
{
    protected function getJsonResponse($data = null, $additionalErrors = null)
    {
        // we are implementing class REST.
        // if it's a GET method, just return the data
        if ($this->request->isGet())
        {
            $response = new Phalcon\Http\Response();
            $response->setJsonContent($data);
            return $response;
        }
        else
        {
            // if it's anything other than GET, return an ApiReturnValue
            if ($this->hasErrors())
            {
                return $this->getErrorJsonResponse($data, $additionalErrors);
            }
            else
            {
                return $this->getOkJsonResponse($data, $additionalErrors);
            }
        }
    }
    protected function getOkJsonResponse($data = null, $additionalErrors = null)
    {
        // we are implementing class REST.
        // if it's a GET method, just return the data
        if ($this->request->isGet())
        {
            $response = new Phalcon\Http\Response();
            $response->setJsonContent($data);
            return $response;
        }
        else
        {
            // if it's anything other than GET, return an ApiReturnValue
            return $this->doGetJsonResponse(ApiStatus::ok(), $data, null, $additionalErrors);
        }
    }
    protected function getErrorJsonResponse($data = null, $additionalErrors = null)
    {
        return $this->doGetJsonResponse(ApiStatus::error(), $data, null, $additionalErrors);
    }
    protected function getRedirectJsonResponse($redirectUrl)
    {
        return $this->doGetJsonResponse(ApiStatus::ok(), null, $redirectUrl, null);
    }
    protected function getRedirectOrErrorJsonResponse($redirectUrl)
    {
        if ($this->hasErrors()) {
            return $this->getErrorJsonResponse();
        }
        else {
            return $this->getRedirectJsonResponse($redirectUrl);
        }
    }

    private function doGetJsonResponse($jsonStatus, $data, $redirectUrl, $additionalErrors)
    {
        $this->appendErrors($additionalErrors);

        $this->view->disable();
        $returnValue = new ApiReturnValue();
        $returnValue->status = $jsonStatus;
        if ($this->hasErrors())
        {
            $returnValue->errors = $this->errors;
        }
        $returnValue->redirect = $redirectUrl;
        $returnValue->data = $data;
        $response = new Phalcon\Http\Response();
        $response->setJsonContent($returnValue);
        return $response;
    }
}
