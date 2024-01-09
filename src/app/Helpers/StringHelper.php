<?php

namespace App\Helpers;

/**
 * Прячет половину email.
 * Не проверяет, что email корректный, ошибки не будет.
 *
 * @param $email
 * @return string
 */
function hideEndEmail($email): string
{
    $em   = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em)-1));
    $len  = floor(strlen($name)/2);

    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
}
