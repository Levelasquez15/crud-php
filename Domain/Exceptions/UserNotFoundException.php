<?php

class UserNotFoundException extends RuntimeException {
    public static function becauseIdWasNotFound($id) {
        return new self('El usuario con id ' . $id . ' no fue encontrado.');
    }
}
