<?php

use Jralph\PHPCSVParser\Parsers\FileParser;

class FileParserTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->csvFile = __DIR__.'/../_data/data.csv';
        $this->csvString = file_get_contents($this->csvFile);

        $this->parser = new FileParser($this->csvFile);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testFileParserIsInstanceOfParserInterface()
    {
        $this->assertInstanceOf('Jralph\PHPCSVParser\Parsers\ParserInterface', $this->parser);
    }

    public function testParserReturnsWithoutHeadings()
    {
        $this->assertEquals(null, $this->parser->withoutHeadings()->parse()->headings());
    }

    public function testParserReturnsCollectionOfHeadings()
    {
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->parser->parse()->headings());
    }

    public function testParserReturnsCollectionOfRows()
    {
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->parser->parse()->rows());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Unable to read file: somecsv.csv
     */
    public function testParserThrowsExceptionIfCSVIsNotReadable()
    {
        $parser = new FileParser('somecsv.csv');

        $parser->parse();
    }

}
