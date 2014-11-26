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

        return $this->getOkJsonResponse($data);
    }
}

