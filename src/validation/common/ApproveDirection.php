<?php

namespace App\Validation\Common;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class ApproveDirection extends AbstractEnumType
{
    public const POSITIVE = 'POSITIVE';
    public const NEGATIVE = 'NEGATIVE';
}