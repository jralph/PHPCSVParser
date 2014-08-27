# PHP CSV Parser [![Build Status](https://travis-ci.org/jralph/PHPCSVParser.svg)](https://travis-ci.org/jralph/PHPCSVParser) #

[![Latest Stable Version](https://poser.pugx.org/jralph/phpcsvparser/v/stable.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![Total Downloads](https://poser.pugx.org/jralph/phpcsvparser/downloads.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![Latest Unstable Version](https://poser.pugx.org/jralph/phpcsvparser/v/unstable.svg)](https://packagist.org/packages/jralph/phpcsvparser) [![License](https://poser.pugx.org/jralph/phpcsvparser/license.svg)](https://packagist.org/packages/jralph/phpcsvparser)

PHP CSV Parser is a simple csv parser written in php. It can parse csv strings or files.

It utilises [Laravel's Support Library](http://laravel.com/api/namespace-Illuminate.Support.html) to help with providing a simple and clean structure.

### Contents ###

- [Installation](#installation)
- [Usage](#usage)
    - [Working with the CSV](#working-with-the-csv)
    - [CSV Rows](#csv-rows)

## Installation ##

PHP CSV Parser is available as a composer package and can be added to your composer.json like so.

```
"require": {
    ...
    "jralph/phpcsvparser": "2.*"
    ...
}
```

## Usage ##

Using the CSV parser is simple and can be done by directly accessing the `Jralph\PHPCSVParser\ParserManager` class, or either of the Parser classes (`Jralph\PHPCSVParser\Parsers\StringParser` or `Jralph\PHPCSVParser\Parsers\FileParser`).

For ease of use, there is also a `facade` that has been created. `Jralph\PHPCSVParser\Facades\Parser`. This `facade` can call the `create` method on the `ParserManager` object.

```
<?php

use Jralph\PHPCSVParser\Facades\Parser;
use Jralph\PHPCSVParser\ParserManager;
use Jralph\PHPCSVParser\Parsers\FileParser;
use Jralph\PHPCSVParser\Parsers\StringParser;

// Using the Facade (AUTO DETECTS STRING OR FILE)
$parser = Parser::create('csv string or path to file here.');

// Using the ParserManager (AUTO DETECTS STRING OR FILE)
$parser = new ParserManager;
$parser->create('csv string of path to file here.');

// Using the File Parser (NO AUDO DETECTION)
$parser = new FileParser('path/to/file/here');

// Using the String Parser (NO AUDO DETECTION)
$parser = new StringParser('"csv","string","here"');

// Once you have an instance of a parser, you can parse the csv.
// You can optionally pass in any of the paramaters below.
$csv = $parser->parse($delimiter = ',', $enclosure = '"', $escape = '\\');

// Or no paramaters at all.
$csv = $parser->parse();

// Maybe your csv does not have column headings.
$csv = $parser->withoutHeadings()->parse();

?>
```

### Working with the CSV ###

Once you have parsed the CSV, you will be given a `CSV` object. This object contains a collection of headers (if any) and a collection of all of the csv rows.

```
<?php

use Jralph\PHPCSVParser\Facades\Parser;
use Jralph\PHPCSVParser\ParserManager;
use Jralph\PHPCSVParser\Parsers\FileParser;
use Jralph\PHPCSVParser\Parsers\StringParser;

$parser = Parser::create('csv string or path to file here.');

$csv = $parser->parse();

foreach ($csv->rows() as $row) {
    // Do something with the rows.
}

?>
```

#### CSV Rows ####

When looping through csv rows, each row is returned as an instance of the CSVRow object.

You can access data through this object in many ways.

```
<?php

use Jralph\PHPCSVParser\Facades\Parser;
use Jralph\PHPCSVParser\ParserManager;
use Jralph\PHPCSVParser\Parsers\FileParser;
use Jralph\PHPCSVParser\Parsers\StringParser;

$parser = Parser::create('csv string or path to file here.');

$csv = $parser->parse();

foreach ($csv->rows() as $row) {
    // We have not told the parser to process without headings, so we can access
    // each row by its heading name.
    echo $row->heading1; // As an object.
    echo $row['heading2']; // As an array.
    echo $row->getRow('heading3'); // By a method.
}

// If we do not have or know the headings, we can loop through the row attributes.
foreach ($csv->rows() as $row) {
    // Loop through the $row object.
    foreach ($row as $column) {
        echo $column;
    }

    // Get an array of all attributes.
    $attributes = $row->getAttributes();
}

?>
```

## Arrays and JSON ##

The following objects contain convertors to convert the object to an array and to json.

- `CSV`
- `CSVRow`

```
<?php

use Jralph\PHPCSVParser\Facades\Parser;
use Jralph\PHPCSVParser\ParserManager;
use Jralph\PHPCSVParser\Parsers\FileParser;
use Jralph\PHPCSVParser\Parsers\StringParser;

$parser = Parser::create('csv string or path to file here.');

$csv = $parser->parse();

echo $csv->toJson(); // Echo the entire csv, headings and rows, as json.

foreach ($csv->rows() as $row) {
    echo $row->toJson(); // Echo the entire row as json.
}

?>
```
