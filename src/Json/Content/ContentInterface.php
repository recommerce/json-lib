<?php

namespace Recommerce\Json\Content;

interface ContentInterface
{
    /**
     * @return string
     */
    public function getJsonContent();

    /**
     * @return string
     */
    public function getEncodedContent();
}
