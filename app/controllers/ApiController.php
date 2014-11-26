<?php

class ApiController extends ControllerBase
{
    public function filtersListAction()
    {
        $filters = Filter::find();
        $data = array();
        foreach ($filters as $filter) {
            $data[] = array(
                'id' => $filter->id,
                'name' => $filter->name,
                'description' => $filter->description
            );
        }
//        $this->setJsonResponse();
//        return $data;


        $this->view->disable();
        $response = new Phalcon\Http\Response();
        $response->setJsonContent($data);
        return $response;
    }

    protected function getJsonResponse($data, $errors)
    {

    }
}

