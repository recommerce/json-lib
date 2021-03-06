<?php

namespace Recommerce\Json\Content;

class EncodedContent implements ContentInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var DecodedContent
     */
    private $decodedContent;

    /**
     * @param string $encodedContent
     */
    public function __construct($encodedContent)
    {
        $this->content = $encodedContent;
        $this->decodedContent = new DecodedContent(json_decode($this->content));
    }

    /**
     * @return mixed
     * @deprecated Use getDecodedContent
     */
    public function getJsonContent()
    {
        return $this->getDecodedContent();
    }

    /**
     * @return mixed
     */
    public function getDecodedContent()
    {
        return $this->decodedContent->getDecodedContent();
    }

    /**
     * @return string
     */
    public function getEncodedContent()
    {
        return $this->content;
    }
}
