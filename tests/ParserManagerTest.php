<?php

use Jralph\PHPCSVParser\ParserManager;

class ParserManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->csvFile = __DIR__.'/_data/data.csv';
        $this->csvString = file_get_contents($this->csvFile);

        $this->manager = new ParserManager;
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testCreateReturnsInstanceOfParserInterface()
    {
        $manager = $this->manager;

        $parser = $manager->create($this->csvString);

        $this->assertInstanceOf('Jralph\PHPCSVParser\Parsers\ParserInterface', $parser);
    }

    public function testCreateReturnsInstanceOfStringParserIfFileDoesNotExist()
    {
        $manager = $this->manager;

        $parser = $manager->create('some/file/here');

        $this->assertInstanceOf('Jralph\PHPCSVParser\Parsers\StringParser', $parser);
    }

    public function testCreateReturnsInstanceOfFileParserIfFileExists()
    {
        $manager = $this->manager;

        $parser = $manager->create($this->csvFile);

        $this->assertInstanceOf('Jralph\PHPCSVParser\Parsers\FileParser', $parser);
    }

}