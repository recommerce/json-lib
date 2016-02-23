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
