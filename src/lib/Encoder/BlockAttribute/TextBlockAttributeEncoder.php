<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\AutomatedTranslation\Encoder\BlockAttribute;

use Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;

final class TextBlockAttributeEncoder implements BlockAttributeEncoderInterface
{
    private const TYPE = 'text';

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
        return (string) $value;
    }

    public function decode(string $value, BlockAttributeDefinition $attributeDefinition): string
    {
        return $value;
    }
}

class_alias(TextBlockAttributeEncoder::class, 'EzSystems\EzPlatformAutomatedTranslation\Encoder\BlockAttribute\TextBlockAttributeEncoder');
