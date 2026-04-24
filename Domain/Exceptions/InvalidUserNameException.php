<?php

class InvalidUserNameException extends InvalidArgumentException {
    public static function becauseValueIsEmpty() {
        return new self('El nombre de usuario no puede estar vacio.');
    }
    public static function becauseLengthIsTooShort($min) {
        return new self('El nombre de usuario debe tener al menos ' . $min . ' caracteres.');
    }
}
