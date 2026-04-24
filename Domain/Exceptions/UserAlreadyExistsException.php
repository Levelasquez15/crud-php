<?php

class UserAlreadyExistsException extends RuntimeException {
    public static function becauseEmailAlreadyExists($email) {
        return new self('El email ya esta en uso: ' . $email);
    }
}
