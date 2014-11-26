<?php

class JsonStatus
{
    const OK_ID = 0;
    const OK_DESCRIPTION = "ok";
    const ERROR_ID = 1;
    const ERROR_DESCRIPTION = "error";

    public static function error()
    {
        return new JsonStatus(JsonStatus::ERROR_ID, JsonStatus::ERROR_DESCRIPTION);
    }

    public static function ok()
    {
        return new JsonStatus(JsonStatus::OK_ID, JsonStatus::OK_DESCRIPTION);
    }

    private function __construct($id, $description) {
        $this->id = $id;
        $this->description = $description;
    }

    public $id;
    public $description;
}
