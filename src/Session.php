<?php

namespace App;

class Session
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $_SESSION;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    public static function set(string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $ref = &$_SESSION;

        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                $ref[$k] = $value;
            } else {
                if (!isset($ref[$k]) || !is_array($ref[$k])) {
                    $ref[$k] = [];
                }
                $ref = &$ref[$k];
            }
        }
    }

    public static function has(string $key): bool
    {
        $keys = explode('.', $key);
        $value = $_SESSION;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return false;
            }
            $value = $value[$k];
        }

        return true;
    }

    public static function remove(string $key): void
    {
        $keys = explode('.', $key);
        $ref = &$_SESSION;

        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                unset($ref[$k]);
            } else {
                if (!isset($ref[$k])) {
                    return;
                }
                $ref = &$ref[$k];
            }
        }
    }

    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            self::set("_flash.{$key}", $value);
            return null;
        }

        $value = self::get("_flash.{$key}");
        self::remove("_flash.{$key}");
        return $value;
    }

    public static function user(): ?array
    {
        return self::get('user');
    }

    public static function isAuthenticated(): bool
    {
        return self::has('user');
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user && $user['role'] === 'admin';
    }

    public static function isVendedor(): bool
    {
        $user = self::user();
        return $user && $user['role'] === 'vendedor';
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }
}
