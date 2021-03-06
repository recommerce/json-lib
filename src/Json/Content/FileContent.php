<?php

namespace Recommerce\Json\Content;

use Recommerce\Json\Exception\JsonContentException;

class FileContent implements ContentInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var EncodedContent
     */
    private $encodedContent;

    /**
     * @param string $file
     * @throws JsonContentException
     */
    public function __construct($file)
    {
        if (!is_file($file)) {
            throw new JsonContentException(
                sprintf("Given file %s does not exist", $file)
            );
        }

        $this->file = $file;
        $this->encodedContent = new EncodedContent(file_get_contents($file));
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
        return $this->encodedContent->getDecodedContent();
    }

    /**
     * @return string
     */
    public function getEncodedContent()
    {
        return $this->encodedContent->getEncodedContent();
    }
}
