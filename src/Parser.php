<?php namespace Jralph\PHPCSVParser;

use Exception;
use Illuminate\Support\Collection;

/**
 * A simple class for parsing csv files and strings.
 *
 * @author Joseph Ralph <joe@josephralph.co.uk>
 */
class Parser {

    /**
     * The resulting collection from a parsed csv string/file.
     * 
     * @var Illuminate\Support\Collection
     */
    private $collection;

    /**
     * The path to the csv file, if any.
     * 
     * @var string
     */
    private $file;

    /**
     * The csv string, if any.
     * 
     * @var string
     */
    private $string;

    /**
     * The retrieved headings from the csv file.
     * 
     * @var array
     */
    private $headings = [];

    /**
     * The mode (file or string) being used by the parser.
     * 
     * @var string
     */
    private $mode = null;

    /**
     * Optioanlly construct the class with the string or file path.
     * 
     * @param string $string The CSV string or file path.
     */
    public function __construct($string = null)
    {
        if (!$string) {
            return;
        }

        if ($this->isFile($string)) {
            $this->loadFile($string);
            $this->mode = 'file';
        } else {
            $this->loadString($string);
            $this->mode = 'string';
        }
    }

    /**
     * Load the requested file ready to be parsed.
     * 
     * @param  string $filePath The path to the file.
     * @return void
     */
    public function loadFile($filePath)
    {
        if ($this->exists($filePath)) {
            $this->file = fopen($filePath, 'r');
            $this->mode = 'file';
        } else {
            throw new Exception('Requested file "'.$filePath.'" was not found.');
        }
    }

    /**
     * Load a CSV string ready to be parsed.
     * 
     * @param  string $string The CSV string to parse.
     * @return void
     */
    public function loadString($string)
    {
        $this->string = $string;
        $this->mode = 'string';
    }

    /**
     * Check if a given string is a file or not.
     * 
     * @param  string  $string The file path.
     * @return boolean
     */
    public function isFile($string)
    {
        return $this->exists($string);
    }

    /**
     * Check that a given file path exists.
     * 
     * @param  string $path The file path.
     * @return boolean
     */
    private function exists($path)
    {
        return is_readable($path);
    }

    /**
     * Parse the loaded string or file and return a collection of rows.
     * 
     * @param  boolean $headings
     * @param  string  $delimiter
     * @param  string  $enclosure
     * @param  string  $escape
     * @return Illuminate\Support\Collection
     */
    public function parse($headings = true, $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        switch ($this->mode) {
            case 'string':
                $data = $this->parseString($headings, $delimiter, $enclosure, $escape);
                break;
            case 'file':
            default:
                $data = $this->parseFile($headings, $delimiter, $enclosure, $escape);
        }

        return $data;
    }

    /**
     * When mode is string, parse and return a collection of rows from the string.
     * 
     * @param  string $getHeadings
     * @param  string $delimiter
     * @param  string $enclosure
     * @param  string $escape
     * @return Illuminate\Support\Collection
     */
    private function parseString($getHeadings, $delimiter, $enclosure, $escape)
    {
        $lines = explode("\n", $this->string);

        $csv = [];

        foreach ($lines as $line) {
            $csv[] = str_getcsv($line, $delimiter, $enclosure, $escape);
        }

        $headings = array_shift($csv);

        if ($getHeadings) {
            $this->headings = $headings;
        }

        $data = [];

        foreach ($csv as $row) {
            $data[] = (object) array_combine($headings, $row);
        }

        return new Collection($data);
    }

    /**
     * When the mode is file, parse and return a collection of rows from the file.
     * 
     * @param  string $getHeadings
     * @param  string $delimiter
     * @param  string $enclosure
     * @param  string $escape
     * @return Illuminate\Support\Collection
     */
    private function parseFile($getHeadings, $delimiter, $enclosure, $escape)
    {
        $headings = null;
        $data = [];

        while (($row = fgetcsv($this->file)) !== false) {
            if (!$headings && $getHeadings) {
                $headings = $row;
                $this->headings = $row;
                continue;
            }

            $data[] = (object) array_combine($headings, $row);
        }
        fclose($this->file);

        return new Collection($data);
    }

    /**
     * Return an array of headings found in the csv file.
     *
     * @return array
     */
    public function getHeadings()
    {
        return $this->headings;
    }

    /**
     * Return the mode being used by the parser.
     * 
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

}