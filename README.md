# PHP CSV Parser [![Build Status](https://travis-ci.org/jralph/PHPCSVParser.svg)](https://travis-ci.org/jralph/PHPCSVParser) #

[![Latest Stable Version](https://poser.pugx.org/jralph/phpcsvparser/v/stable.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![Total Downloads](https://poser.pugx.org/jralph/phpcsvparser/downloads.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![Latest Unstable Version](https://poser.pugx.org/jralph/phpcsvparser/v/unstable.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![License](https://poser.pugx.org/jralph/phpcsvparser/license.svg)](https://packagist.org/packages/jralph/phpcsvparser)

PHP CSV Parser is a simple csv parser written in php. It can parse csv strings or files.

It utilises [Laravel's Collection Object](http://laravel.com/api/class-Illuminate.Support.Collection.html) to help with organising csv rows. 

### Contents ###

- [Installation](#installation)
- [Usage](#usage)
    - [Using the Constructor](#using-the-constructor)
    - [Setting the File/String Manually](#setting-the-filestring-manually)
    - [Accessing Headings](#accessing-headings)
- [Parser Options](#parser-options)
- [Collection Methods](#collection-methods)

## Installation ##

PHP CSV Parser is available as a composer package and can be added to your composer.json like so.

```
"require": {
    ...
    "jralph/phpcsvparser": "1.*"
    ...
}
```

## Usage ##

Using PHP CSV Parser is nice and easy. You have a few options when instancing the object.

__NOTE: All data prased by the parser will use the first line as the headings.__
__*ALL CSV FILES MUST HAVE HEADINGS FOR THE PARSER TO WORK*__

### Using the constructor. ###

The easiest way to parse a csv is to use the constructor of the object to pass in a file path or a csv string.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser(__DIR__.'/mycsvfile.csv'); // Or new Parser('"csv","string","here"');
 
$data = $parser->parse();

foreach ($data as $row) {
    // Do something with each row.
    echo $row->phone_number;
}
?>
```

### Setting the file/string manually. ###

If you do not want to use the constructor, you can use one of the provided methods to load in a string or file.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser;

$parser->loadFile('path/to/file.csv');

// OR

$parser->loadString('"csv","string","here"');

$data = $parser->parse();

foreach ($data as $row) {
    // Do something with each row.
    echo $row->phone_number;
}

?>
```

### Accessing Headings ###

At times, you may want to access the headings used in the csv file. This is easily doable by using the `getHeadings` method.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser;

$parser->loadFile('path/to/file.csv');

// OR

$parser->loadString('"csv","string","here"');

$data = $parser->parse();

$headings = $parser->getHeaders();

var_dump($headings);

?>
```

If the above example processed a csv file with the heading of `Heading 1, Heading 2 and Heading 3`, the var_dump will contain 3 strings equaling those headings.

## Parser Options ##

When parsing a csv file you may need to use a different delimiter (such as the pipe `|`). Or maybe you have a different enclosure or escape characters.

This is easily changable by using the optional arguments for the `parse()` method.

The parse method can accept the following methods.

```
$parser->parse([string $delimiter = ',' [, string $enclosure = '"' [, string $escape = '\\']]]);

// Example
$parser->parse('|', '');
```

The above example would parse a csv file/string usign the pipe as a delimiter, with no field enclosures. Below is an example of some csv data that could be parsed by the above example.

```
Heading 1|Heading 2|Heading 3
Data1|Data2|Data3
```

## Collection Methods ##

Laravel's collection object has some very useful methods for interacting with our data.

Below you can find some of the methods that are useful when used with the CSV Parser. For a full list, check out the [Laravel API Documentation](http://laravel.com/api/class-Illuminate.Support.Collection.html).

### ToArray and ToJson ###

Need to convert the CSV data into a simple array or into json, no problem.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser(__DIR__.'/mycsvfile.csv'); // Or new Parser('"csv","string","here"');
 
$data = $parser->parse();

$array = $data->toArray();

$json = $data->toJson();

?>
```

### Filter ###

You can easily filter data within the collection by using the filter method.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser(__DIR__.'/mycsvfile.csv'); // Or new Parser('"csv","string","here"');
 
$data = $parser->parse();

$filtered = $data->filter(function($row)
{
    if (in_array($row->name, ['bob', 'jim'])) return true;
});

foreach ($filtered as $row) {
    // Do something to the data for bob and jim.
    echo $row->phone_number;
}

?>
```

The above example will only return the data when the name column of the csv data is equal to 'bob' or 'jim'.

### Each ###

Iterating over each array item is also nice and easy. Say you have a csv containing people's phone number, but you want to replace the country code (+44 and so on) with a 0. This is really easy to do.

```
<?php

use Jralph\PHPCSVParser\Parser;

$parser = new Parser(__DIR__.'/mycsvfile.csv'); // Or new Parser('"csv","string","here"');
 
$data = $parser->parse();

$data->each(function($row)
{
    $row->phone_number = str_replace('+44', '0', $row->phone_number);

    return $row;
});

foreach ($data as $row) {
    // Do something to the data.
    echo $row->phone_number;
}

?>
```

In the above example, any phone numbers containing +44 have had the +44 part replaced with a 0.
