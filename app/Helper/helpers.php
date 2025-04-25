<?php

use Illuminate\Support\Facades\Route;

/** Set Sidebar Item Active */

function setActive(array $routes, $class = 'active'): string
{
    foreach ($routes as $route) {
        if (Route::is($route)) {
            return $class;
        }
    }

    return '';
}
