<?php

class RestApiControllerBase extends ApiControllerBase
{
    /**
     * @Get("/")
     */
    public function queryAction()
    {
        $entities = $this->query();
        $data = array();
        foreach ($entities as $entity) {
            $data[] = $entity->toArrayOfValues();
        }

        return $this->getOkJsonResponse($data);
    }

    /**
     * @Get("/{entityId:[0-9]}")
     */
    public function getAction($entityId)
    {
        $entity = $this->getEntity($entityId);

        return $this->getOkJsonResponse($entity->toArrayOfValues());
    }

    /**
     * @Post("/")
     */
    public function addAction()
    {
        $entity = $this->populateOrCreateEntityFromPost();
        $entity->save();
        $this->appendErrors($entity.getErrors());

        return $this->getJsonResponse($entity->toArrayOfValues());
    }

    /**
     * @Post("/{entityId:[0-9]}")
     */
    public function updateAction($entityId)
    {
        $entity = $this->getEntity($entityId);
        $entity = $this->populateOrCreateEntityFromPost($entity);
        $entity->save();
        $this->appendErrors($entity.getErrors());

        return $this->getJsonResponse($entity->toArrayOfValues());
    }

    /**
     * @Delete("/{entityId:[0-9]}")
     */
    public function deleteAction($entityId)
    {
        $this->deleteEntity($entityId);
        return $this->getJsonResponse();
    }

    protected function query()
    {
        throw new Exception("Query not supported");
    }

    protected function getEntity($entityId)
    {
        throw new Exception("Get not supported");
    }

    protected function populateOrCreateEntityFromPost($entity = null)
    {
        throw new Exception("Add and Update not supported");
    }

    protected function deleteEntity($entityId)
    {
        throw new Exception("Delete not supported");
    }
}

