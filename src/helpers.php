<?php

use Felix\Tag\Tag;

if (!function_exists('tag')) {
    function tag(string $type): Tag
    {
        return new Tag($type);
    }
}
