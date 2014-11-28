<?php

/**
 * @RoutePrefix("/api/filterdefinitions")
 */
class FilterDefinitionsApiController extends RestApiControllerBase
{
    protected function query()
    {
        return FilterDefinition::find();
    }

    protected function getEntity($entityId)
    {
        return FilterDefinition::findFirstById($entityId);
    }
}

