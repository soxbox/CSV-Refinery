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
        return $response->redirect("datacleaning/cleancolumn/" . $firstColumn->id);
    }

    public function cleanColumnAction($columnId)
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

        $this->view->column = $column;
        $this->view->previousColumnId = $previousColumnId;
        $this->view->nextColumnId = $nextColumnId;
    }


}

