<?php

/**
 * @RoutePrefix("/api/cells")
 */
class CellsApiController extends RestApiControllerBase
{
    protected function query()
    {
        return FileCell::find();
    }

    protected function getEntity($entityId)
    {
        return FileCell::findFirstById($entityId);
    }

    /**
     * @Post("/{cellId:[0-9]}/overrideValue")
     */
    public function overrideValueAction($cellId)
    {
    }

    /**
     * @Post("/{cellId:[0-9]}/approve")
     */
    public function approveAction($cellId)
    {
    }
}

