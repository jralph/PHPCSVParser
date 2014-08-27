<?php namespace Jralph\PHPCSVParser\Parsers;

use Illuminate\Support\Collection;
use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;
use Exception;

class FileParser implements ParserInterface {

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
        if (!is_readable($this->csv))
        {
            throw new Exception('Unable to raed file: '.$this->csv);
        }

        $file = fopen($this->csv, 'r');

        $csv = [];

        while (($row = fgetcsv($file, 0, $delimiter, $enclosure, $escape)) !== false) {
            $csv[] = $row;
        }
        fclose($file);

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