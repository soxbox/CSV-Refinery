<?php

/**
 * @RoutePrefix("/api/columns")
 */
class ColumnsApiController extends RestApiControllerBase
{
    protected function query()
    {
        return FileColumn::find();
    }

    protected function getEntity($entityId)
    {
        return FileColumn::findFirstById($entityId);
    }

    protected function populateOrCreateEntityFromPost($entity = null)
    {
        if ($entity != null) {
            // TODO: implement
        }
        else {
            throw new Exception("Add not supported");
        }
    }

    /**
     * @Post("/{columnId:[0-9]}/applyFilter")
     */
    public function applyFilterAction($columnId)
    {
        $filterId = intval($this->request->getPost("filterId"));
        $column = FileColumn::findFirstById($columnId);
        $column->filterId = $filterId > 0 ? $filterId : null;
        $column->save();
        $this->appendErrors($column->getErrors());
        foreach ($column->cells as $cell)
        {
            $this->applyFilterToCell($cell);
        }

        return $this->getRedirectResponse("clean/" . $columnId);
    }

    private function applyFilterToCell($cell)
    {
        $cell->isCleaned = true;
        $cell->isValid = true;
        if (is_null($cell->column->filterId))
        {
            $cell->value = $cell->originalValue;
            $cell->isCleaned = true;
            $cell->isValid = true;
        }
        else {
            if ($cell->column->filterId == Filter::ADDRESS_LINE_FILTER_DEFINITION_ID) {
                $cell->value = "ADDRESS LINE FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::FULL_NAME_FILTER_DEFINITION_ID) {
                $cell->value = "FULL NAME FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::NAME_FILTER_DEFINITION_ID) {
                $cell->value = "NAME FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::PHONE_NUMBER_FILTER_DEFINITION_ID) {
                $cell->value = "PHONE NUMBER FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::POSTAL_CODE_FILTER_DEFINITION_ID) {
                $cell->value = "POSTAL CODE FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::STATE_ABBREVIATION_FILTER_DEFINITION_ID) {
                $cell->value = "STATE ABBREVIATION FILTER LOGIC NOT YET IMPLEMENTED";
            } else {
                $cell->value = "FILTER NOT FOUND";
                $cell->isCleaned = false;
                $cell->isValid = false;
            }
        }

        $cell->save();
        $this->appendErrors($cell->getErrors());
    }
}

