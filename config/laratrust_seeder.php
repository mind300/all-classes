<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [  
        // Super Admin
        'superadmin' => [
            'home' => true,
            'applications' => true,
            'members' => true,
            'admins' => true,
            'news' => true,
            'events' => true,
            'calendar' => true,
            'history' => true,
            'jobs' => true,
            'buy&sell' => true,
            'chatRoom' => true,
        ],

        // Admin
        'admin' => [],

        // User
        'user' => [],

    ],
];
