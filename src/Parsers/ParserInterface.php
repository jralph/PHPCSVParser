<?php namespace Jralph\PHPCSVParser\Parsers;

interface ParserInterface {

    public function __construct($csv);
    public function withoutHeadings();
    public function parse($delimiter = ',', $enclosure = '"', $escape = '\\');

}
