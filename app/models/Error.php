<?php

class Error
{
    const GENERAL_ERROR_TYPE_ID = 0;

    public $errorTypeId;
    public $message;

    public function __construct($errorTypeId, $message) {
        $this->errorTypeId = $errorTypeId;
        $this->message = $message;
    }

    public static function general($message)
    {
        return new Error(Error::GENERAL_ERROR_TYPE_ID, $message);
    }

    public static function appendErrorsToArray(&$array, $errors)
    {
        if (!is_null($errors))
        {
            if (is_array($errors)
                && !empty($errors))
            {
                foreach ($errors as $error)
                {
                    if (is_string($errors)
                        && !empty($errors)) {
                        array_push($array, Error::general($error));
                    }
                    else if (is_a($error, "Error"))
                    {
                        array_push($array, $error);
                    }
                    else
                    {
                        throw new Exception("Object type not supported as an error");
                    }
                }
            }
            else if (is_string($errors)
                && !empty($errors))
            {
                array_push($array, Error::general($errors));
            }
        }
    }
}
