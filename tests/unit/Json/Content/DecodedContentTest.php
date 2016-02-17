<?php

namespace Recommerce\Json\Content;

class DecodedContentTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEncodedContent()
    {
        $content = new DecodedContent([
            'attr1' => 'value1',
            'attr2' => 'value2'
        ]);

        $this->assertSame(
            '{"attr1":"value1","attr2":"value2"}',
            $content->getEncodedContent()
        );
    }
}
