<?php

use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;
use Illuminate\Support\Collection;

class CSVTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->headings = [
            'heading1',
            'heading2'
        ];

        $this->rows = [
            new CSVRow([
                'data1',
                'data2'
            ]),
            new CSVRow([
                'something1',
                'something2'
            ])
        ];

        $this->array = [
            'headings' => [
                'heading1',
                'heading2'
            ],
            'rows' => [
                [
                    'data1',
                    'data2'
                ],
                [
                    'something1',
                    'something2'
                ]
            ]
        ];

        $this->csv = new CSV($this->headings, $this->rows);
        $this->blankCsv = new CSV;
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testBlankCsvCanSetHeadings()
    {
        $csv = $this->blankCsv;

        $csv->setHeadings($this->headings);

        $this->assertEquals(new Collection($this->headings), $csv->headings());
    }

    public function testBlankCsvCanSetRows()
    {
        $csv = $this->blankCsv;

        $csv->setRows($this->rows);

        $this->assertEquals(new Collection($this->rows), $csv->rows());
    }

    public function testCsvCanReturnSingleRow()
    {
        $csv = $this->csv;

        $this->assertEquals($this->rows[0], $csv->getRow(0));
    }

    public function testCanReturnArray()
    {
        $csv = $this->csv;

        $this->assertEquals($this->array, $csv->toArray());
    }

    public function testCanReturnJson()
    {
        $csv = $this->csv;

        $this->assertEquals(json_encode($this->array), $csv->toJson());
    }

}