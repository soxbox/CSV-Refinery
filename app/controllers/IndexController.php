<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        return $this->getRedirectResponse("csvfiles/");
    }


}