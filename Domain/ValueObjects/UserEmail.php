<?php
// Domain/ValueObjects/UserEmail.php
require_once __DIR__ . '/../Exceptions/InvalidUserEmailException.php';

class UserEmail {
    private $value;
    public function __construct($value) {
        $v = trim(strtolower((string)$value));
        if ($v === '') throw InvalidUserEmailException::becauseValueIsEmpty();
        if (!filter_var($v, FILTER_VALIDATE_EMAIL)) throw InvalidUserEmailException::becauseFormatIsInvalid($v);
        $this->value = $v;
    }
    public function value() { return $this->value; }
    public function equals(UserEmail $o) { return $this->value === $o->value(); }
    public function __toString() { return $this->value; }
}
