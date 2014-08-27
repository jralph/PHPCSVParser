<?php

use Jralph\PHPCSVParser\CSV;
use Jralph\PHPCSVParser\CSVRow;
use Illuminate\Support\Collection;

class CSVRowTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->attributes = [
            'heading1' => 'some',
            'heading2' => 'data',
            'heading3' => 'here'
        ];

        $this->row = new CSVRow($this->attributes);
        $this->blankRow = new CSVRow;
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testBlankRowHasNoAttributes()
    {
        $row = $this->blankRow;

        $this->assertEquals([], $row->getAttributes());
    }

    public function testAttributesReturnsArrayOfAttributes()
    {
        $row = $this->row;

        $this->assertEquals($this->attributes, $row->getAttributes());
    }

    public function testAttributesCanBeSet()
    {
        $row = $this->blankRow;

        $row->setAttributes($this->attributes);

        $this->assertEquals($this->attributes, $row->getAttributes());
    }

    public function testCanGetAttributeByKey()
    {
        $row = $this->row;

        $this->assertEquals($this->attributes['heading1'], $row->heading1);
    }

    public function testCanSetSingleAttribute()
    {
        $row = $this->row;

        $row->heading4 = 'hello';

        $attributes = array_merge($this->attributes, ['heading4' => 'hello']);

        $this->assertEquals($attributes, $row->getAttributes());
    }

    public function testCanCheckIfAttributeIsSet()
    {
        $row = $this->row;

        $this->assertTrue(isset($row->heading3));
    }

    public function testCanUnsetAttribute()
    {
        $row = $this->row;

        $attributes = $this->attributes;

        array_shift($attributes);

        unset($row->heading1);

        $this->assertEquals($attributes, $row->getAttributes());
    }

    public function testCanConvertToArray()
    {
        $row = $this->row;

        $this->assertEquals($this->attributes, $row->toArray());
    }

    public function testCanConvertToJson()
    {
        $row = $this->row;

        $this->assertEquals(json_encode($this->attributes), $row->toJson());
    }

    public function testAttributesCanBeAccessedAsArray()
    {
        $row = $this->row;

        $this->assertEquals($this->attributes['heading1'], $row['heading1']);

        $this->assertTrue(isset($row['heading2']));

        $attributes = array_merge($this->attributes, ['heading4' => 'hello']);

        $row['heading4'] = 'hello';

        $this->assertEquals($attributes, $row->getAttributes());

        unset($row['heading4']);

        $this->assertEquals($this->attributes, $row->getAttributes());
    }

}
