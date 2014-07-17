<?php

use Jralph\PHPCSVParser\Parser;
use Illuminate\Support\Collection;

/**
 * @codeCoverageIgnore
 */
class ParserTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->csvFile = __DIR__.'/_data/data.csv';
        $this->csvString = file_get_contents($this->csvFile);
        $this->expected = new Collection([
            (object) [
                'Some' => 'Actual',
                'Data' => 'Row',
                'Headings' => 'Data'
            ],
            (object) [
                'Some' => 'Actual',
                'Data' => 'Row',
                'Headings' => 'Data'
            ]
        ]);
        $this->expectedHeadings = [
            'Some',
            'Data',
            'Headings'
        ];

        $this->csvFilePipe = __DIR__.'/_data/delimiter.csv';
        $this->csvStringPipe = file_get_contents($this->csvFilePipe);
        $this->expectedPipe = new Collection([
            (object) [
                'Some' => 'Actual',
                'Data' => 'Row',
                'Headings' => 'Data'
            ],
            (object) [
                'Some' => 'Actual',
                'Data' => 'Row',
                'Headings' => 'Data'
            ]
        ]);
        $this->expectedHeadingsPipe = [
            'Some',
            'Data',
            'Headings'
        ];

        $this->expectedHeadingsNormalized = [
            'some',
            'data',
            'headings'
        ];
    }

    public function testClassExists()
    {
        $parser = new Parser;

        $this->assertInstanceOf('Jralph\PHPCSVParser\Parser', $parser);
    }

    public function testConstructAcceptsFilePath()
    {
        $parser = new Parser($this->csvFile);

        $this->assertEquals('file', $parser->getMode());
    }

    public function testConstructAcceptsString()
    {
        $parser = new Parser($this->csvString);

        $this->assertEquals('string', $parser->getMode());
    }

    public function testFileCanBeSetOutsideConstructor()
    {
        $parser = new Parser;

        $parser->loadFile($this->csvFile);

        $this->assertEquals('file', $parser->getMode());
    }

    public function testStringCanBeSetOutsideConstructor()
    {
        $parser = new Parser;

        $parser->loadString($this->csvString);

        $this->assertEquals('string', $parser->getMode());
    }

    public function testErrorIsThrownWhenFileIsRequestedAndDoesNotExist()
    {
        $parser = new Parser;

        $this->setExpectedException('Exception');

        $parser->loadFile('someFileThatDoesNotExist.csv');
    }

    public function testFileParseReturnsCollection()
    {
        $parser = new Parser($this->csvFile);

        $collection = $parser->parse();

        $this->assertInstanceOf('Illuminate\Support\Collection', $collection);
    }

    public function testStringParseReturnsCollection()
    {
        $parser = new Parser($this->csvString);

        $collection = $parser->parse();

        $this->assertInstanceOf('Illuminate\Support\Collection', $collection);
    }

    public function testFileParseReturnsCorrectFormat()
    {
        $parser = new Parser($this->csvFile);

        $collection = $parser->parse();

        $this->assertEquals($this->expected, $collection);
    }

    public function testStringParseReturnsCorrectFormat()
    {
        $parser = new Parser($this->csvString);

        $collection = $parser->parse();

        $this->assertEquals($this->expected, $collection);
    }

    public function testGetHeadingsReturnsExpected()
    {
        $parser = new Parser($this->csvString);

        $parser->parse();

        $this->assertEquals($this->expectedHeadings, $parser->getHeadings());
    }

    public function testGetModeIsNullWhenNoDataIsProvided()
    {
        $parser = new Parser;

        $this->assertNull($parser->getMode());
    }

    public function testGetModeReturnsStringWhenDataIsProvided()
    {
        $parser = new Parser($this->csvString);

        $this->assertInternalType('string', $parser->getMode());
    }

    public function testFileParseCanParseWithOtherDelimiter()
    {
        $parser = new Parser($this->csvFilePipe);

        $collection = $parser->parse('|');

        $this->assertEquals($this->expectedPipe, $collection);
    }

    public function testStringParseCanParseWithOtherDelimiter()
    {
        $parser = new Parser($this->csvStringPipe);

        $collection = $parser->parse('|');

        $this->assertEquals($this->expectedPipe, $collection);
    }

    public function testFileParseCanParseWithOtherDelimiterHasCorrectHeadings()
    {
        $parser = new Parser($this->csvFilePipe);

        $collection = $parser->parse('|');

        $headings = $parser->getHeadings();

        $this->assertEquals($this->expectedHeadingsPipe, $headings);
    }

    public function testStringParseCanParseWithOtherDelimiterHasCorrectHeadings()
    {
        $parser = new Parser($this->csvStringPipe);

        $collection = $parser->parse('|');

        $headings = $parser->getHeadings();

        $this->assertEquals($this->expectedHeadingsPipe, $headings);
    }

    public function testParserCanNormalizeHeadings()
    {
        $parser = new Parser($this->csvFile);

        $parser->setNormalize();
        $parser->parse();

        $headings = $parser->getHeadings();

        $this->assertEquals($this->expectedHeadingsNormalized, $headings);
    }

}
