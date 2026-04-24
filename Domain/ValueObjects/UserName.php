<?php
// Domain/ValueObjects/UserName.php
require_once __DIR__ . '/../Exceptions/InvalidUserNameException.php';

class UserName {
    private $value;
    public function __construct($value) {
        $v = trim((string)$value);
        if ($v === '') throw InvalidUserNameException::becauseValueIsEmpty();
        if (strlen($v) < 3) throw InvalidUserNameException::becauseLengthIsTooShort(3);
        $this->value = $v;
    }
    public function value() { return $this->value; }
    public function equals(UserName $o) { return $this->value === $o->value(); }
    public function __toString() { return $this->value; }
}
