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

    // ================================ Community Roles ================================ //
    'roles_structure' => [
        // Super Admin
        'superadmin' => [
            'news' => true,
            'events' => true,
            'buy-and-sell' => true,
            'jobs' => true,
            'forms' => true,
            'admins' => true,
            'terms-and-conditions' => true,
            'privacy-policy' => true,
            'members' => true,
            'about' => true,
            'rewards' => true,
        ],

        // Admin
        'admin' => [],

        // User
        'user' => [],
    ],

    // ================================ Suppliers Roles ================================ //
    'roles_structure_suppliers' => [
        // Owner
        'owner' => [],

        // Manager
        'manager' => [],

        // Cashier
        'cashier' => [],
    ],
];