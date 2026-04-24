<?php

class InvalidCredentialsException extends RuntimeException {
    public static function becauseCredentialsAreInvalid() {
        return new self('Email o contraseña incorrectos.');
    }
    public static function becauseUserIsNotActive() {
        return new self('El usuario no esta activo.');
    }
}
