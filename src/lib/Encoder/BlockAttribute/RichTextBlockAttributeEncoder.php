<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\AutomatedTranslation\Encoder\BlockAttribute;

use Ibexa\AutomatedTranslation\Encoder\RichText\RichTextEncoder;
use Ibexa\AutomatedTranslation\Exception\EmptyTranslatedAttributeException;
use Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;

final class RichTextBlockAttributeEncoder implements BlockAttributeEncoderInterface
{
    private const TYPE = 'richtext';

    private RichTextEncoder $richTextEncoder;

    public function __construct(
        RichTextEncoder $richTextEncoder
    ) {
        $this->richTextEncoder = $richTextEncoder;
    }

    public function canEncode(string $type): bool
    {
        return $type === self::TYPE;
    }

    public function canDecode(string $type): bool
    {
        return $type === self::TYPE;
    }

    public function encode($value, BlockAttributeDefinition $attributeDefinition): string
    {
        return $this->richTextEncoder->encode((string) $value);
    }

    public function decode(string $value, BlockAttributeDefinition $attributeDefinition): string
    {
        $decodedValue = $this->richTextEncoder->decode($value);

        if (strlen($decodedValue) === 0) {
            throw new EmptyTranslatedAttributeException();
        }

        return $decodedValue;
    }
}

class_alias(RichTextBlockAttributeEncoder::class, 'EzSystems\EzPlatformAutomatedTranslation\Encoder\BlockAttribute\RichTextBlockAttributeEncoder');
