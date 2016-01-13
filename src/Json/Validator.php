<?php

namespace Recommerce\Json;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Validator as ExternalValidator;
use Recommerce\Json\Content\ContentInterface;
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
            $jsonContent->getJsonContent(),
            $this->schemaContent->getJsonContent()
        );

        if (!$this->validator->isValid()) {
            throw new JsonFormatException(
                sprintf(
                    "Given json content is not valid : %s",
                    json_encode($jsonContent->getJsonContent())
                )
            );
        }
    }
}
