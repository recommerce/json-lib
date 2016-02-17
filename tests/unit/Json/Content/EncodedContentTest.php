<?php

namespace Recommerce\Json\Content;

class EncodedContentTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEncodedContent()
    {
        $encodedContent = '{"attr1":"value1","attr2":"value2"}';
        $content = new EncodedContent($encodedContent);

        $this->assertSame(
            $encodedContent,
            $content->getEncodedContent()
        );
    }
}
