<?php
namespace App\Libs;

class AutoPostCollection
{
    protected static $items = [];

    public static function add(AutoPost $post)
    {
        self::$items[] = $post;
    }

    public static function all()
    {
        return self::$items;
    }
}