<?php namespace Jralph\PHPCSVParser;

use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;
use ArrayAccess;

class CSVRow implements ArrayableInterface, JsonableInterface, ArrayAccess {

    /**
     * An array of attributes related to the csv row.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Construct the csv row with an optional array of attributes.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = null)
    {
        if ($attributes) $this->setAttributes($attributes);
    }

    /**
     * Set the attributes of a csv row.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $attribute)
        {
            $this->attributes[$key] = $attribute;
        }
    }

    /**
     * Return the attributes of the row.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Magic getter to return an attribute value.
     *
     * @param  mixed $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Magic setter to set an attribute.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Magic isset method to check if an attribute exists.
     *
     * @param  mixed  $key
     * @return boolean
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Magic unset method to remove an attribute.
     *
     * @param mixed $key
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Convert the row to an array.
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Convert the row to json.
     *
     * @param  integer $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Check if an offset exists on the attributes.
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Get an offset on the attributes.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    /**
     * Set an offset on the attributes.
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Unset an offset on the attributes.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

}