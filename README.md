[![Build Status](https://travis-ci.org/recommerce/json-lib.svg?branch=master)](https://travis-ci.org/recommerce/json-lib) [![Code Climate](https://codeclimate.com/github/recommerce/json-lib/badges/gpa.svg)](https://codeclimate.com/github/recommerce/json-lib) [![Test Coverage](https://codeclimate.com/github/recommerce/json-lib/badges/coverage.svg)](https://codeclimate.com/github/recommerce/json-lib/coverage)

# Recommerce json-lib

This library provides json validation feature (based on justinrainbow/json-schema).

## Installation with composer

```sh
composer require recommerce/json-lib:^0.0
composer update
```

## Usage examples

### Json file validation
```php
    use Recommerce\Json\Content\FileContent;
    use Recommerce\Json\Exception\JsonException;
    use Recommerce\Json\Validator;

    $jsonSchema = new FileContent('my-json-schema-file.json');
    $jsonContent = new EncodedContent('{"attribute": "value"}');

    try {
        $validator = new Validator($jsonSchema);
        $validator->validate($jsonContent); // throw exception on failure
    } catch (JsonException $e) {

    }
```
