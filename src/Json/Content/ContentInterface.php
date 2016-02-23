<?php

namespace Recommerce\Json\Content;

interface ContentInterface
{
    /**
     * @return mixed
     * @deprecated Use getDecodedContent
     */
    public function getJsonContent();

    /**
     * @return mixed
     */
    public function getDecodedContent();

    /**
     * @return string
     */
    public function getEncodedContent();
}
