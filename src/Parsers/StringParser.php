<?php namespace Jralph\PHPCSVParser\Parsers;

use Illuminate\Support\Collection;
use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;

class StringParser implements ParserInterface {

    private $headings = true;

    private $csv;

    public function __construct($csv)
    {
        $this->csv = $csv;
    }

    public function withoutHeadings()
    {
        $this->headings = false;

        return $this;
    }

    public function parse($delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        $lines = explode("\n", $this->csv);

        $csv = [];

        foreach ($lines as $line) {
            $csv[] = str_getcsv($line, $delimiter, $enclosure, $escape);
        }

        if ($this->headings) {
            $data = $this->combineHeadings($csv);
        } else {
            $data = $csv;
        }

        return $this->createCsv($data);
    }

    private function combineHeadings($rows)
    {
        $headings = array_shift($rows);

        $data = [];

        foreach ($rows as $row) {
            $data[] = array_combine($headings, $row);
        }

        return $data;
    }

    private function createRows($rows)
    {
        $csvRows = [];

        foreach ($rows as $row)
        {
            $csvRows[] = new CSVRow($row);
        }

        return $csvRows;
    }

    private function createCsv($rows)
    {
        $headings = $this->headings ? array_keys($rows[0]) : null;

        $rows = $this->createRows($rows);

        return new CSV($headings, $rows);
    }

}