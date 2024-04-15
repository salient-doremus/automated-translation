<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\AutomatedTranslation\Encoder\BlockAttribute;

use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;
use InvalidArgumentException;

final class BlockAttributeEncoderManager
{
    /** @var iterable|\Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface[] */
    private $blockAttributeEncoders;

    /**
     * @param iterable|\Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface[] $blockAttributeEncoders
     */
    public function __construct(iterable $blockAttributeEncoders = [])
    {
        $this->blockAttributeEncoders = $blockAttributeEncoders;
    }

    /**
     * @param mixed $value
     */
    public function encode(BlockAttributeDefinition $attributeDefinition, $value): string
    {
        foreach ($this->blockAttributeEncoders as $blockAttributeEncoder) {
            if ($blockAttributeEncoder->canEncode($attributeDefinition->getType())) {
                return $blockAttributeEncoder->encode($value, $attributeDefinition);
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unable to encode block attribute %s. Make sure block attribute encoder service for it is properly registered.',
                $attributeDefinition->getType()
            )
        );
    }

    /**
     * @throws \Ibexa\AutomatedTranslation\Exception\EmptyTranslatedAttributeException
     */
    public function decode(BlockAttributeDefinition $attributeDefinition, string $value): string
    {
        foreach ($this->blockAttributeEncoders as $blockAttributeEncoder) {
            if ($blockAttributeEncoder->canDecode($attributeDefinition->getType())) {
                return $blockAttributeEncoder->decode($value, $attributeDefinition);
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unable to decode block attribute %s. Make sure block attribute encoder service for it is properly registered.',
                $attributeDefinition->getType()
            )
        );
    }
}

class_alias(BlockAttributeEncoderManager::class, 'EzSystems\EzPlatformAutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderManager');
