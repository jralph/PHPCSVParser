<?php namespace Jralph\PHPCSVParser\Parsers;

use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;

class StringParser extends AbstractParser implements ParserInterface {

    protected $headings = true;

    protected $csv;

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

        $data = $this->combineHeadings($csv);

        return $this->createCsv($data);
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
