<?php

/**
 * @RoutePrefix("/api/files")
 */
class FilesApiController extends RestApiControllerBase
{
    protected function query()
    {
        return File::find();
    }

    protected function getEntity($entityId)
    {
        return File::findFirstById($entityId);
    }

    protected function populateOrCreateEntityFromPost($entity = null)
    {
        if ($entity != null) {
            // edit not supported
            throw new Exception("Update not supported");
        }
        else {
            return $this->saveUploadedFile();
        }
    }

    protected function deleteEntity($entityId)
    {
        // TODO: this needs to be done using a query to be more efficient

        $file = File::findFirstById($entityId);
        if ($file != false) {
            foreach ($file->cells as $cell)
            {
                $cell->delete();
                $this->appendErrors($cell->getErrors());
            }
            foreach ($file->columns as $column)
            {
                $column->delete();
                $this->appendErrors($column->getErrors());
            }
            foreach ($file->rows as $row)
            {
                $row->delete();
                $this->appendErrors($row->getErrors());
            }
            $file->delete();
            $this->appendErrors($file->getErrors());
        }
    }

    /**
     * @Post("/{fileId:[0-9]}/toggleHeaderRow")
     */
    public function toggleHeaderRowAction($fileId)
    {
        $file = File::findFirstById($fileId);
        $file->hasHeaderRow = !$file->hasHeaderRow;
        $file->save();
        $this->appendErrors($file->getErrors());
        $firstRow = FileRow::findFirst(
            array(
                '(rowNumber = 1) AND (fileId = :fileId:)',
                'bind' => array('fileId' => $fileId)
            )
        );
        $firstRow->isHeaderRow = $file->hasHeaderRow;
        $firstRow->save();
        $this->appendErrors($firstRow->getErrors());
        if ($file->hasHeaderRow) {
            foreach ($file->columns as $column) {
                $correspondingFirstRowCell = FileCell::findFirst(
                    array(
                        '(fileColumnId = :fileColumnId:) AND (fileRowId = :fileRowId:)',
                        'bind' => array('fileColumnId' => $column->id, 'fileRowId' => $firstRow->id)
                    )
                );
                $column->originalName = $correspondingFirstRowCell->originalValue;
                $column->save();
                $this->appendErrors($column->getErrors());
            }
        } else {
            foreach ($file->columns as $column) {
                $column->originalName = "Column " . $column->columnNumber;
                $column->save();
                $this->appendErrors($column->getErrors());
            }
        }

        return $this->getRedirectOrErrorJsonResponse("view/" . $file->id);
    }
}

