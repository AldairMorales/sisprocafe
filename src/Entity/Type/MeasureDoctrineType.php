<?php

declare(strict_types=1);

namespace Pidia\Apps\Demo\Entity\Type;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pidia\Apps\Demo\Entity\ValueObject\Measure;

final class MeasureDoctrineType extends StringType
{
    public const NAME = 'measure';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }
    public function getName(): string
    {
        return self::NAME;
    }

    /** @param Measure $value */

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }
        return $value->valor() . '|' . $value->unidad();
    }
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }
        [$valor, $unidad] = explode('|', $value);
        return new Measure((float)$valor, $unidad);
    }
}
