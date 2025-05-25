<?php

if (!function_exists('is_active')) {
    function is_active($route): bool
    {
        return request()->routeIs($route . '*');
    }
}

if (!function_exists('parse_boolean')) {
    function parse_boolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
