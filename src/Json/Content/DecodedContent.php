<?php

namespace Recommerce\Json\Content;

class DecodedContent implements ContentInterface
{
    /**
     * @return string
     */
    private $content;

    /**
     * @param $decodedContent
     */
    public function __construct($decodedContent)
    {
        $this->content = $decodedContent;
    }

    /**
     * @return string
     */
    public function getJsonContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getEncodedContent()
    {
        return json_encode($this->content);
    }
}
