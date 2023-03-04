<?php

use OptimMVC\Core\Response;

function dd(...$vars)
{
    echo '<style>pre {background-color:#4f4c4c;border:1px solid #1b2026;padding:10px;margin:20px; color: #7fc002}</style>';
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    die();
}

function dump(...$vars)
{
    echo '<style>pre {background-color:#4f4c4c;border:1px solid #1b2026;padding:10px;margin:20px; color: #7fc002}</style>';
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

function response() {
    return new Response('');
}