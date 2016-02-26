<?php

namespace Recommerce\Json;

use Recommerce\Json\Content\ContentInterface;
use Recommerce\Json\Content\DecodedContent;
use Recommerce\Json\Content\EncodedContent;
use Recommerce\Json\Content\FileContent;

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
            ->method('getDecodedContent')
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
            ->method('getDecodedContent')
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
            ->method('getDecodedContent')
            ->willReturn(json_decode($jsonContent));

        $this->instance->validate($this->jsonContent);
    }

    public function testValidateDecodedContent()
    {
        $jsonDecodedContent = [
            'attr1' => 'val1',
            'attr2' => 'val2'
        ];

        $instance = $this
            ->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();

        $instance
            ->expects($this->once())
            ->method('validate')
            ->with(new DecodedContent($jsonDecodedContent))
            ->willReturn(null);

        $this->assertSame(
            $jsonDecodedContent,
            $instance->validateDecodedContent($jsonDecodedContent)
        );
    }

    public function testValidateEncodedContent()
    {
        $jsonEncodedContent = json_encode([
            'attr1' => 'val1',
            'attr2' => 'val2'
        ]);

        $instance = $this
            ->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();

        $instance
            ->expects($this->once())
            ->method('validate')
            ->with(new EncodedContent($jsonEncodedContent))
            ->willReturn(null);

        $this->assertEquals(
            json_decode($jsonEncodedContent),
            $instance->validateEncodedContent($jsonEncodedContent)
        );
    }

    public function testValidateFileContent()
    {
        $jsonFile = 'resources/tests/json-schema-test.json';

        $instance = $this
            ->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();

        $instance
            ->expects($this->once())
            ->method('validate')
            ->with(new FileContent($jsonFile))
            ->willReturn(null);

        $this->assertEquals(
            json_decode(file_get_contents($jsonFile)),
            $instance->validateFileContent($jsonFile)
        );
    }
}
