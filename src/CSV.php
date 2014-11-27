<?php namespace Jralph\PHPCSVParser;

use Illuminate\Support\Collection;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;

class CSV implements ArrayableInterface, JsonableInterface  {

    protected $headings = null;

    protected $rows = null;

    public function __construct(array $headings = null, array $rows = null)
    {
        if ($headings) {
            $this->setHeadings($headings);
        }

        if ($rows) {
            $this->setRows($rows);
        }
    }

    public function setHeadings(array $headings)
    {
        $this->headings = new Collection($headings);
    }

    public function headings()
    {
        return $this->headings;
    }

    public function setRows(array $rows)
    {
        $this->rows = new Collection($rows);
    }

    public function rows()
    {
        return $this->rows;
    }

    public function getRow($key)
    {
        return $this->rows->get($key);
    }

    public function toArray()
    {
        return [
            'headings' => $this->headings->toArray(),
            'rows' => $this->rows->toArray()
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

}
