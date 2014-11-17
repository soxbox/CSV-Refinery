<?php

class CsvFilesController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->files = File::find();
    }

    public function uploadAction()
    {
        if ($this->request->isPost())
        {
            $file = $this->saveUploadedFile();
            if ($this->hasErrors())
            {

            }
            else {
                $this->view->disable();

                // Getting a response instance
                $response = new \Phalcon\Http\Response();
                return $response->redirect("csvfiles/view/" . $file->id);
            }
        }
    }

    public function viewAction($fileId)
    {
        $file = File::findFirstById($fileId);
        $this->view->file = $file;
    }

    private function saveUploadedFile()
    {
        $file = null;
        if ($this->request->hasFiles() == true)
        {
                $rowIndex = 0;
                $maxColumnCount = 0;
                $allCells = array();
                if (($handle = fopen($_FILES['fileToUpload']['tmp_name'], "r")) !== false)
                {
                    $file = new File();

                    $rows = array();
                    $columns = array();
                    while (($data = fgetcsv($handle)) !== false)
                    {
                        $columnCount = count($data);
                        $maxColumnCount = $columnCount > $maxColumnCount ? $columnCount : $maxColumnCount;
                        // this ensures we create additional columns if found later
                        for ($c=count($columns); $c < $maxColumnCount; $c++) {
                            $column = new FileColumn();
                            $column->file = $file;
                            $column->columnNumber = $c + 1;
                            array_push($columns, $column);
                        }

                        // Create the row
                        $row = new FileRow();
                        $row->file = $file;
                        $row->isHeaderRow = false;
                        $row->rowNumber = $rowIndex + 1;
                        $row->skipInOutput = false;
                        array_push($rows, $row);

                        // Create the cells FOR THIS ROW ONLY
                        $cells = array();
                        // create the cells
                        // BUT this has a problem, if additional columns are found later, there will not be the correct amount of cells
                        // SO this will need to be fixed at the end
                        for ($c=0; $c < $columnCount; $c++) {
                            //echo $data[$c] . "<br />\n";
                            $cell = new FileCell();
                            $cell->file = $file;
                            $cell->originalValue = $data[$c];
                            $cell->row = $row;
                            $cell->column = $columns[$c];
                            array_push($cells, $cell);
                            array_push($allCells, $cell);
                        }
                        //$row->cells = $cells;

                        $rowIndex++;
                    }
                    fclose($handle);


                    //$file->rows = $rows;
                    //$file->columns = $columns;
                    //$file->cells = $allCells;
                    $file->name = $_FILES['fileToUpload']['name'];
                    $file->originalRowCount = $rowIndex;
                    $file->originalColumnCount = $maxColumnCount;
                    $file->hasHeaderRow = false;
                    $file->uploadDate = date("Y-m-d H:i:s:u");


                    if ($file->save() == false)
                    {
                        $this->appendErrorMessages($file);
                    }
                    foreach ($rows as $row)
                    {
                        if ($row->save() == false)
                        {
                            $this->appendErrorMessages($row);
                        }
                    }
                    foreach ($columns as $column)
                    {
                        if ($column->save() == false)
                        {
                            $this->appendErrorMessages($column);
                        }
                    }
                    foreach ($allCells as $cell)
                    {
                        if ($cell->save() == false)
                        {
                            $this->appendErrorMessages($cell);
                        }
                    }

                }
        }
        return $file;
    }
}

