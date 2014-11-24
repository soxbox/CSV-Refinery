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

        $this->view->columnToClean = $columnToClean;
    }

    public function setFilterAction($columnId, $filterName)
    {
        $column = FileColumn::findFirstById($columnId);
        $column->filter = $filterName;
        $column->save();
        foreach ($column->cells as $cell)
        {
            $cell->value = null;
            $cell->isCleaned = false;
            $cell->isValid = false;
            $cell->save();
        }

        $this->view->disable();

        // Getting a response instance
        $response = new \Phalcon\Http\Response();
        return $response->redirect("datacleaning/column/" . $columnId);
    }

    public function applyFilterAction($columnId)
    {
        $column = FileColumn::findFirstById($columnId);
        foreach ($column->cells as $cell)
        {
            $this->applyFilterToCell($cell);
            $cell->save();
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
        if (is_null($cell->column->filter)) {
            $cell->value = $cell->originalValue;
            $cell->isCleaned = false;
            $cell->isValid = false;
        }
        else if ($cell->column->filter == "Phone Number")
        {

        }
        else if ($cell->column->filter == "Name- 1 Word")
        {

        }
        else if ($cell->column->filter == "Address Line")
        {

        }
        else if ($cell->column->filter == "State- 2 Character Code")
        {

        }
        else if ($cell->column->filter == "City")
        {

        }
        else if ($cell->column->filter == "Zip Code")
        {

        }
        else
        {

        }
    }

}

