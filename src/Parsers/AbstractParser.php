<?php namespace Jralph\PHPCSVParser\Parsers;

use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;
use Exception;

abstract class AbstractParser {

    protected function combineHeadings($rows)
    {
        if (!$this->headings)
        {
            return $rows;
        }

        $headings = array_shift($rows);
        $data = [];

        foreach ($rows as $row) {
            $data[] = array_combine($headings, $row);
        }

        return $data;
    }

}