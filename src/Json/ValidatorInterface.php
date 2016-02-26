<?php

namespace Recommerce\Json;

use Recommerce\Json\Content\ContentInterface;
use Recommerce\Json\Exception\JsonFormatException;

interface ValidatorInterface
{
    /**
     * @return string
     */
    public function getSchemaContent();

    /**
     * @param ContentInterface $jsonContent
     * @throws JsonFormatException
     */
    public function validate(ContentInterface $jsonContent);

    /**
     * @param string $jsonEncodedContent
     * @return mixed json decoded content
     */
    public function validateEncodedContent($jsonEncodedContent);
}