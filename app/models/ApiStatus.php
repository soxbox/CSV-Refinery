<?php

class ApiStatus
{
    const OK_ID = 0;
    const OK_DESCRIPTION = "ok";
    const ERROR_ID = 1;
    const ERROR_DESCRIPTION = "error";

    public static function error()
    {
        return new ApiStatus(ApiStatus::ERROR_ID, ApiStatus::ERROR_DESCRIPTION);
    }

    public static function ok()
    {
        return new ApiStatus(ApiStatus::OK_ID, ApiStatus::OK_DESCRIPTION);
    }

    private function __construct($id, $description) {
        $this->id = $id;
        $this->description = $description;
    }

    public $id;
    public $description;
}
