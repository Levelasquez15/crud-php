<?php
// Domain/Enums/UserRoleEnum.php
require_once __DIR__ . '/../Exceptions/InvalidUserRoleException.php';

class UserRoleEnum {
    const ADMIN    = 'ADMIN';
    const MEMBER   = 'MEMBER';
    const REVIEWER = 'REVIEWER';

    public static function values() {
        return [self::ADMIN, self::MEMBER, self::REVIEWER];
    }
    public static function isValid($v) {
        return in_array($v, self::values(), true);
    }
    public static function ensureIsValid($v) {
        if (!self::isValid($v))
            throw InvalidUserRoleException::becauseValueIsInvalid($v);
    }
}
