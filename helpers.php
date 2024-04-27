<?php

function debug($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}
