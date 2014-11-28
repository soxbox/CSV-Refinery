<?php

class FileUploadHandler
{
    private $errors = array();

    public function getErrors()
    {
        return $this->errors;
    }

    public function saveUploadedFile($request)
    {
        $file = null;
        if ($request->hasFiles() == true)
        {
            $rowIndex = 0;
            $maxColumnCount = 0;
            if (($handle = fopen($_FILES['fileToUpload']['tmp_name'], "r")) !== false)
            {
                $file = new File();
                $file->name = $_FILES['fileToUpload']['name'];
                $file->originalRowCount = $rowIndex;
                $file->originalColumnCount = $maxColumnCount;
                $file->hasHeaderRow = false;
                $file->uploadDate = date("Y-m-d H:i:s:u");
                $file->save();
                Error::appendErrorsToArray($this->errors,$file->getErrors());

                $columns = array();
                while (($data = fgetcsv($handle)) !== false)
                {
                    $columnCount = count($data);
                    $maxColumnCount = $columnCount > $maxColumnCount ? $columnCount : $maxColumnCount;
                    // this ensures we create additional columns if found later
                    for ($c=count($columns); $c < $maxColumnCount; $c++) {
                        // create the column, and hold onto it as we will need it for the columnId for the cell
                        $column = new FileColumn();
                        $column->fileId = $file->id;
                        $column->columnNumber = $c + 1;
                        $column->originalName = "Column " . $column->columnNumber;
                        $column->save();
                        Error::appendErrorsToArray($this->errors,$column->getErrors());;
                        array_push($columns, $column);
                    }

                    // Create the row, but no need to hang onto it beyond this iteration
                    $row = new FileRow();
                    $row->fileId = $file->id;
                    $row->isHeaderRow = false;
                    $row->rowNumber = $rowIndex + 1;
                    $row->skipInOutput = false;
                    $row->save();
                    Error::appendErrorsToArray($this->errors,$row->getErrors());

                    // Create the cells FOR THIS ROW ONLY
                    $cells = array();
                    // create the cells
                    // BUT this has a problem, if additional columns are found later, there will not be the correct amount of cells for that row
                    // SO this will need to be fixed at the end
                    for ($c=0; $c < $columnCount; $c++) {
                        //echo $data[$c] . "<br />\n";
                        $cell = new FileCell();
                        $cell->fileId = $file->id;
                        $cell->originalValue = $data[$c];
                        $cell->isCleaned = false;
                        $cell->isValid = false;
                        $cell->fileRowId = $row->id;
                        $cell->fileColumnId = $columns[$c]->id;
                        $cell->save();
                        Error::appendErrorsToArray($this->errors,$cell->getErrors());
                    }
                    //$row->cells = $cells;

                    $rowIndex++;
                }
                fclose($handle);

                $file->originalRowCount = $rowIndex;
                $file->originalColumnCount = $maxColumnCount;
                $file->save();
                Error::appendErrorsToArray($this->errors,$file->getErrors());
            }
        }
        return $file;
    }
}

