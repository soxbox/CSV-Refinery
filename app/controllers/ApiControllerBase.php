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
            $this->appendErrors($additionalErrors);
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

    protected function returnOkJsonNowAndContinueProcessing($data = null, $additionalErrors = null)
    {
        $this->appendErrors($additionalErrors);
        // only non-gets would be using this for long-running scripts
        // so we will use an ApiReturnValue always
        $returnValue = new ApiReturnValue();
        $returnValue->status = ApiStatus::ok();
        if ($this->hasErrors())
        {
            $returnValue->errors = $this->errors;
        }
        //$returnValue->redirect = $redirectUrl;
        $returnValue->data = $data;

        $json = json_encode($returnValue);

        $this->closeConnectionNowAndContinueProcessing($json);
    }

    protected function returnErrorJsonNowAndContinueProcessing($data = null, $additionalErrors = null)
    {
        $this->appendErrors($additionalErrors);
        // only non-gets would be using this for long-running scripts
        // so we will use an ApiReturnValue always
        $returnValue = new ApiReturnValue();
        $returnValue->status = ApiStatus::error();
        if ($this->hasErrors())
        {
            $returnValue->errors = $this->errors;
        }
        //$returnValue->redirect = $redirectUrl;
        $returnValue->data = $data;

        $json = json_encode($returnValue);

        $this->closeConnectionNowAndContinueProcessing($json);
    }

    protected function returnRedirectJsonNowAndContinueProcessing($redirectUrl)
    {
        // only non-gets would be using this for long-running scripts
        // so we will use an ApiReturnValue always
        $returnValue = new ApiReturnValue();
        $returnValue->status = ApiStatus::ok();
        $returnValue->redirect = $redirectUrl;

        $json = json_encode($returnValue);

        $this->closeConnectionNowAndContinueProcessing($json);
    }

    protected function returnRedirectOrErrorJsonNowAndContinueProcessing($redirectUrl)
    {
        if ($this->hasErrors())
        {
            $this->returnErrorJsonNowAndContinueProcessing();
        }
        else
        {
            $this->returnRedirectJsonNowAndContinueProcessing($redirectUrl);
        }
    }

    protected function returnJsonNowAndContinueProcessing($data = null, $additionalErrors = null)
    {
        // this won't be used for GETs as it is for long-running processes

        $this->appendErrors($additionalErrors);
        // if it's anything other than GET, return an ApiReturnValue
        if ($this->hasErrors())
        {
            return $this->returnErrorJsonNowAndContinueProcessing($data, $additionalErrors);
        }
        else
        {
            return $this->returnOkJsonNowAndContinueProcessing($data, $additionalErrors);
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
