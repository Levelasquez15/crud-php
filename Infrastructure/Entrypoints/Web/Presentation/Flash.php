<?php
// Infrastructure/Entrypoints/Web/Presentation/Flash.php

class Flash {
    public static function start(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void {
        self::start();
        $_SESSION['_flash'][$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed {
        self::start();
        if (!isset($_SESSION['_flash'][$key])) {
            return $default;
        }
        $value = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    public static function setOld(array $data): void {
        self::set('old', $data);
    }

    public static function old(): array {
        $d = self::get('old', []);
        return is_array($d) ? $d : [];
    }

    public static function setErrors(array $errors): void {
        self::set('errors', $errors);
    }

    public static function errors(): array {
        $e = self::get('errors', []);
        return is_array($e) ? $e : [];
    }

    public static function setMessage(string $msg): void {
        self::set('message', $msg);
    }

    public static function message(): string {
        $m = self::get('message', '');
        return is_string($m) ? $m : '';
    }

    public static function setSuccess(string $msg): void {
        self::set('success', $msg);
    }

    public static function success(): string {
        $m = self::get('success', '');
        return is_string($m) ? $m : '';
    }
}
