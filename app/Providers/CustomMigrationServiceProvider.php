<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Migrations\MigrationServiceProvider;
use Illuminate\Database\MigrationServiceProvider as DatabaseMigrationServiceProvider;

class CustomMigrationServiceProvider extends DatabaseMigrationServiceProvider
{
    /**
     * Get the migration path.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return database_path('migrations/mind'); // Set the default path for mind
    }
}
