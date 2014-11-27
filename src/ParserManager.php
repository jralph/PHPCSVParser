<?php namespace Jralph\PHPCSVParser;

use Jralph\PHPCSVParser\Parsers\ParserInterface;
use Jralph\PHPCSVParser\Parsers\FileParser;
use Jralph\PHPCSVParser\Parsers\StringParser;

class ParserManager {

    /**
     * Create a new parser object based on the type of csv.
     *
     * @param  string $csv
     * @return ParserInterface
     */
    public function create($csv = null)
    {
        if ($this->isPathToFile($csv))
        {
            return $this->parser(new FileParser($csv));
        }

        return $this->parser(new StringParser($csv));
    }

    /**
     * Is the string a path to a file.
     *
     * @param  string  $string
     * @return boolean
     */
    private function isPathToFile($string)
    {
        if (is_readable($string))
        {
            return true;
        }

        return false;
    }

    /**
     * Return the parser instance created.
     *
     * @param  ParserInterface $parser
     * @return ParserInterface
     */
    private function parser(ParserInterface $parser)
    {
        return $parser;
    }

}
