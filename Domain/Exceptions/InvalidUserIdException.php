<?php

class InvalidUserIdException extends InvalidArgumentException {
    public static function becauseValueIsEmpty() {
        return new self('El ID de usuario no puede estar vacio.');
    }
}
