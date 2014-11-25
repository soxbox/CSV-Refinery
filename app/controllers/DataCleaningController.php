<?php

class DataCleaningController extends ControllerBase
{

    public function indexAction($fileId)
    {
        $firstColumn = FileColumn::findFirst(
            array(
                '(columnNumber = 1) AND (fileId = :fileId:)',
                'bind' => array('fileId' => $fileId)
            )
        );

        $this->view->disable();

        // Getting a response instance
        $response = new \Phalcon\Http\Response();
        return $response->redirect("datacleaning/column/" . $firstColumn->id);
    }

    public function columnAction($columnId)
    {
        $columnToClean = $this->getColumnData($columnId);
        $filters = Filter::find();

        $this->view->columnToClean = $columnToClean;
        $this->view->filters = $filters;
    }

    public function applyFilterAction($columnId)
    {
        $filterId = intval($this->request->getPost("filterId"));
        $column = FileColumn::findFirstById($columnId);
        $column->filterId = $filterId > 0 ? $filterId : null;
        $column->save();
        foreach ($column->cells as $cell)
        {
            $this->applyFilterToCell($cell);
        }

        $this->view->disable();

        // Getting a response instance
        $response = new \Phalcon\Http\Response();
        return $response->redirect("datacleaning/column/" . $columnId);
    }

    private function getColumnData($columnId)
    {
        $column = FileColumn::findFirstById($columnId);
        $previousColumnId = null;
        $nextColumnId = null;
        if ($column->columnNumber > 1)
        {
            $previousColumn = FileColumn::findFirst(
                array(
                    '(columnNumber = :previousColumnNumber:) AND (fileId = :fileId:)',
                    'bind' => array('previousColumnNumber' => $column->columnNumber - 1, 'fileId' => $column->fileId)
                )
            );
            $previousColumnId = $previousColumn->id;
        }
        $nextColumn = FileColumn::findFirst(
            array(
                '(columnNumber = :nextColumnNumber:) AND (fileId = :fileId:)',
                'bind' => array('nextColumnNumber' => $column->columnNumber + 1, 'fileId' => $column->fileId)
            )
        );
        if (!is_null($nextColumn))
        {
            $nextColumnId = $nextColumn->id;
        }

        $columnToClean = new ColumnToClean();
        $columnToClean->column = $column;
        $columnToClean->previousColumnId = $previousColumnId;
        $columnToClean->nextColumnId = $nextColumnId;

        return $columnToClean;
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
            if ($cell->column->filterId == Filter::ADDRESS_LINE_FILTER_ID) {
                $cell->value = "ADDRESS LINE FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::FULL_NAME_FILTER_ID) {
                $cell->value = "FULL NAME FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::NAME_FILTER_ID) {
                $cell->value = "NAME FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::PHONE_NUMBER_FILTER_ID) {
                $cell->value = "PHONE NUMBER FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::POSTAL_CODE_FILTER_ID) {
                $cell->value = "POSTAL CODE FILTER LOGIC NOT YET IMPLEMENTED";
            } else if ($cell->column->filterId == Filter::STATE_ABBREVIATION_FILTER_ID) {
                $cell->value = "STATE ABBREVIATION FILTER LOGIC NOT YET IMPLEMENTED";
            } else {
                $cell->value = "FILTER NOT FOUND";
                $cell->isCleaned = false;
                $cell->isValid = false;
            }
        }

        $cell->save();
    }

}

