<?php
// Domain/Enums/UserStatusEnum.php
require_once __DIR__ . '/../Exceptions/InvalidUserStatusException.php';

class UserStatusEnum {
    const ACTIVE   = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const PENDING  = 'PENDING';
    const BLOCKED  = 'BLOCKED';

    public static function values() {
        return [self::ACTIVE, self::INACTIVE, self::PENDING, self::BLOCKED];
    }
    public static function isValid($v) {
        return in_array($v, self::values(), true);
    }
    public static function ensureIsValid($v) {
        if (!self::isValid($v))
            throw InvalidUserStatusException::becauseValueIsInvalid($v);
    }
}
