<?php

class IndexController extends ControllerBase
{
    public function notFoundAction()
    {
        $this->response->setHeader('HTTP/1.0 404','Not Found');
    }

//    /**
//     * @Get("/asynctest")
//     */
//    public function asyncAction()
//    {
//        $job = Job::start();
//        $this->appendErrors($job->getErrors());
//        $this->closeConnectionNowAndContinueProcessing("show this to the user");//, "/csvrefinery/?jobId=" . $job->id);
//
//        sleep(10);
//    }

    /**
     * @Route("/", methods={"POST", "GET"})
     */
    public function indexAction()
    {
        if ($this->request->isPost())
        {
            // the post handles the file upload which is a long-running process

            $job = Job::start();
            $this->appendErrors($job->getErrors());

            // TODO: pass it the job url

            // TODO: this should either redirect OR the upload should be ajax and this should pass back job info
            // TODO: fix urls
            $this->closeConnectionNowAndContinueProcessing("show this to the user");//, "/csvrefinery/?jobId=" . $job->id);

            // TODO: refactor to use the job to append progress updates to it
            // do an upload
            $handler = new FileUploadHandler();
            $handler->saveUploadedFile($this->request, $job);
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