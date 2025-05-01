<?php

if (!function_exists('is_active')) {
    function is_active($route): bool
    {
        return request()->routeIs($route . '*');
    }
}
