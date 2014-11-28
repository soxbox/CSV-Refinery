<?php

/**
 * @RoutePrefix("/api/jobs")
 */
class JobsApiController extends RestApiControllerBase
{
    protected function query()
    {
        return Job::find();
    }

    protected function getEntity($entityId)
    {
        return Job::findFirstById($entityId);
    }
}

