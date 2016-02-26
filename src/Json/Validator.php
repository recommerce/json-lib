<?php

namespace Recommerce\Json;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Validator as ExternalValidator;
use Recommerce\Json\Content\ContentInterface;
use Recommerce\Json\Content\DecodedContent;
use Recommerce\Json\Content\EncodedContent;
use Recommerce\Json\Content\FileContent;
use Recommerce\Json\Exception\JsonFormatException;

class Validator implements ValidatorInterface
{
    /**
     * @param ContentInterface
     */
    private $schemaContent;

    /**
     * @var ConstraintInterface
     */
    private $validator;

    /**
     * @param ContentInterface $schemaContent
     * @param ConstraintInterface $validator
     */
    public function __construct(ContentInterface $schemaContent, ConstraintInterface $validator = null)
    {
        $this->schemaContent = $schemaContent;

        if (!$validator) {
            $this->validator = new ExternalValidator();
        }
    }

    /**
     * @return ContentInterface
     */
    public function getSchemaContent()
    {
        return $this->schemaContent;
    }

    /**
     * @param ContentInterface $jsonContent
     * @throws JsonFormatException
     */
    public function validate(ContentInterface $jsonContent)
    {
        $this->validator->check(
            $jsonContent->getDecodedContent(),
            $this->schemaContent->getDecodedContent()
        );

        if (!$this->validator->isValid()) {
            throw new JsonFormatException(
                sprintf(
                    "Given json content is not valid : %s",
                    json_encode($jsonContent->getDecodedContent())
                )
            );
        }
    }

    /**
     * @param mixed $jsonDecodedContent
     * @return mixed json decoded content
     */
    public function validateDecodedContent($jsonDecodedContent)
    {
        return $this->validateContent(
            new DecodedContent($jsonDecodedContent)
        );
    }

    /**
     * @param string $jsonFile
     * @return mixed json decoded content
     */
    public function validateFileContent($jsonFile)
    {
        return $this->validateContent(
            new FileContent($jsonFile)
        );
    }

    /**
     * @param string $jsonEncodedContent
     * @return mixed json decoded content
     */
    public function validateEncodedContent($jsonEncodedContent)
    {
        return $this->validateContent(
            new EncodedContent($jsonEncodedContent)
        );
    }

    /**
     * @param ContentInterface $jsonContent
     * @return mixed
     */
    private function validateContent(ContentInterface $jsonContent)
    {
        $this->validate($jsonContent);

        return $jsonContent->getDecodedContent();
    }
}
