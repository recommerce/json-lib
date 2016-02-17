<?php

namespace Recommerce\Json\Content;

class FileContentTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    private $fileSchema;

    public function setUp()
    {
        $this->fileSchema = __DIR__ . '/json-schema-test.json';
        $this->instance = new FileContent($this->fileSchema);
    }

    public function testCreateObject()
    {
        $this->assertInstanceOf(ContentInterface::class, $this->instance);
    }

    public function testGetJsonContent()
    {
        $this->assertEquals(
            json_decode(file_get_contents($this->fileSchema)),
            $this->instance->getJsonContent()
        );
    }

    public function testGetEncodedContent()
    {
        $this->assertEquals(
            file_get_contents($this->fileSchema),
            $this->instance->getEncodedContent()
        );
    }

    /**
     * @expectedException \Recommerce\Json\Exception\JsonContentException
     */
    public function testCreateObjectException()
    {
        new FileContent('non-existing_file.json');
    }
}
