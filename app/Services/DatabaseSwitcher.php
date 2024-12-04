<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseSwitcher
{
    public function setConnection($database)
    {
        config(['database.default' => $database]);
        // DB::purge($database); // Clear the connection cache to switch effectively
        DB::reconnect($database); // Reconnect with the new database
    }
}
