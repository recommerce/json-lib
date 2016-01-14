<?php

namespace Recommerce\Json;

use Recommerce\Json\Content\ContentInterface;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    private $jsonContent;

    private $schemaContent;

    private $jsonSchema = <<<'EOD'
{
    "title": "Validate json for queue message",
    "type": "object",
    "properties": {
        "barcode": {
            "type": "string",
            "required": true
        },
        "route": {
            "$ref": "#/definitions/route",
            "required": true
        }
    },
    "definitions": {
        "route": {
            "type": "object",
            "properties": {
                "place": {
                    "type": "string",
                    "required": true
                },
                "action": {
                    "type": "string",
                    "required": true
                }
            }
        }
    }
}
EOD;

    public function setUp()
    {
        $this->jsonContent = $this->getMock(ContentInterface::class);

        $this->schemaContent = $this->getMock(ContentInterface::class);
        $this
            ->schemaContent
            ->method('getJsonContent')
            ->willReturn(json_decode($this->jsonSchema));

        $this->instance = new Validator($this->schemaContent);
    }

    public function testGetSchemaContent()
    {
        $this->assertSame($this->schemaContent, $this->instance->getSchemaContent());
    }

    public function testValidate()
    {
        $jsonContent = <<<'EOD'
{
    "barcode": "BAR-32786",
    "route": {
        "place": "Paris",
        "action": "Boire une bière"
    }
}
EOD;

        $this
            ->jsonContent
            ->expects($this->once())
            ->method('getJsonContent')
            ->willReturn(json_decode($jsonContent));

        $this->assertNull($this->instance->validate($this->jsonContent));
    }

    /**
     * @expectedException \Recommerce\Json\Exception\JsonFormatException
     */
    public function testValidateException()
    {
        $jsonContent = <<<'EOD'
{
    "barcode": "BAR-32786"
}
EOD;

        $this
            ->jsonContent
            ->expects($this->exactly(2))
            ->method('getJsonContent')
            ->willReturn(json_decode($jsonContent));

        $this->instance->validate($this->jsonContent);
    }
}
