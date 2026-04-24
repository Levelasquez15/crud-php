<?php

class InvalidUserStatusException extends InvalidArgumentException {
    public static function becauseValueIsInvalid($value) {
        return new self('El estado ingresado no es valido: ' . $value);
    }
}
