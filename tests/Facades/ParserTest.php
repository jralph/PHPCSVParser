<?php

use Jralph\PHPCSVParser\Facades\Parser;

class ParserTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testParserReturnsInstanceOfParserInterface()
    {
        $parser = Parser::create(__DIR__.'/../_data/data.csv');

        $this->assertInstanceOf('Jralph\PHPCSVParser\Parsers\ParserInterface', $parser);
    }

}