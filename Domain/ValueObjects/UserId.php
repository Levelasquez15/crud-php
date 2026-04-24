<?php
// Domain/ValueObjects/UserId.php
require_once __DIR__ . '/../Exceptions/InvalidUserIdException.php';

class UserId {
    private $value;
    public function __construct($value) {
        $v = trim((string)$value);
        if ($v === '') throw InvalidUserIdException::becauseValueIsEmpty();
        $this->value = $v;
    }
    public function value() { return $this->value; }
    public function equals(UserId $o) { return $this->value === $o->value(); }
    public function __toString() { return $this->value; }
}
