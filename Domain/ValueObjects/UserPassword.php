<?php
// Domain/ValueObjects/UserPassword.php
require_once __DIR__ . '/../Exceptions/InvalidUserPasswordException.php';

class UserPassword {
    private $value;
    public function __construct($value) {
        $v = trim((string)$value);
        if ($v === '') throw InvalidUserPasswordException::becauseValueIsEmpty();
        if (strlen($v) < 8) throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        $this->value = $v;
    }
    public static function fromPlainText($raw) {
        $v = trim((string)$raw);
        if ($v === '') throw InvalidUserPasswordException::becauseValueIsEmpty();
        if (strlen($v) < 8) throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        $instance = new self(password_hash($v, PASSWORD_BCRYPT));
        return $instance;
    }
    public static function fromHash($hash) {
        $instance = new self($hash);
        return $instance;
    }
    public function verifyPlain($plain): bool {
        return password_verify($plain, $this->value);
    }
    public function value() { return $this->value; }
    public function equals(UserPassword $o) { return $this->value === $o->value(); }
    public function __toString() { return $this->value; }
}
