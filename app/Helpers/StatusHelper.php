<?php

namespace App\Helpers;

class StatusHelper
{
    public static function formatStatus($status)
    {
        return $status === 'Kadaluarsa' ? 'Kedaluwarsa' : $status;
    }
} 