<?php

class IndexController extends ControllerBase
{
    public function notFoundAction()
    {
        $this->response->setHeader('HTTP/1.0 404','Not Found');
    }

    public function asyncAction()
    {
        $this->view->disable();
        ob_end_clean();
        header("Connection: close");
        ignore_user_abort(); // optional
        ob_start();
        echo ('Text the user will see');
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();     // Will not work
        flush();            // Unless both are called !

        // At this point, the browser has closed connection to the web server

        // Do processing here
        include('/../../app/custom/longThing.php');

        echo('Text user will never see');
    }

    /**
     * @Route("/", methods={"POST", "GET"})
     */
    public function indexAction()
    {
        if ($this->request->isPost())
        {
            // do an upload
            $handler = new FileUploadHandler();
            $handler->saveUploadedFile($this->request);
            $this->appendErrors($handler->getErrors());
        }
        $this->view->files = File::find();
    }

    /**
     * @Get("/view/{fileId:[0-9]}")
     */
    public function viewAction($fileId)
    {
        $file = File::findFirstById($fileId);
        $this->view->file = $file;

        $firstColumn = FileColumn::findFirst(
            array(
                '(columnNumber = 1) AND (fileId = :fileId:)',
                'bind' => array('fileId' => $fileId)
            )
        );
        $this->view->firstColumnId = $firstColumn->id;
    }

    /**
     * @Get("/clean/{columnId:[0-9]}")
     */
    public function cleanAction($columnId)
    {
        $columnToClean = $this->getColumnData($columnId);
        $filters = Filter::find();

        $this->view->columnToClean = $columnToClean;
        $this->view->filters = $filters;
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
}