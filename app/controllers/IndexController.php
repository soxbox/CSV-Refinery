<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->disable();

        // Getting a response instance
        $response = new \Phalcon\Http\Response();
        return $response->redirect("csvfiles");
    }


}