<?php

namespace Recommerce\Json\Content;

class FileContentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateObject()
    {
        $fileSchema = __DIR__ . '/json-schema-test.json';

        $jsonContent = new FileContent($fileSchema);

        $this->assertInstanceOf(ContentInterface::class, $jsonContent);
        $this->assertEquals(
            json_decode(file_get_contents($fileSchema)),
            $jsonContent->getJsonContent()
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
