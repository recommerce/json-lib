<?php

namespace Recommerce\Json\Content;

interface ContentInterface
{
    /**
     * @return string
     * @deprecated Use getDecodedContent
     */
    public function getJsonContent();

    /**
     * @return string
     */
    public function getDecodedContent();

    /**
     * @return string
     */
    public function getEncodedContent();
}
