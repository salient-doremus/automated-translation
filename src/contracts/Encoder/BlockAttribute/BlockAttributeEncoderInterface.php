<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute;

use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;

interface BlockAttributeEncoderInterface
{
    public function canEncode(string $type): bool;

    public function canDecode(string $type): bool;

    /**
     * @param mixed $value
     */
    public function encode($value, BlockAttributeDefinition $attributeDefinition): string;

    public function decode(string $value, BlockAttributeDefinition $attributeDefinition): string;
}

class_alias(BlockAttributeEncoderInterface::class, 'EzSystems\EzPlatformAutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface');
