<?php

namespace App\Helpers;

class Paginate
{
    public static function buttonStatus(int $total, int $page, int $limit): bool
    {
        return !($total <= ($page * $limit));
    }

    public static function totalPages(int $total, int $limit): int
    {
        return ceil($total / $limit);
    }
}
