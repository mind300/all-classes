<?php

namespace App\Http\Controllers\Api\Tests;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class TestController extends Controller
{
    // Test Role User
    public function testRole()
    {
        // $roles = Role::get();
        // return contentResponse($roles->load('permissions'));
        $user = User::find(1);
        $user->syncRoles(['admin']);
        return contentResponse($user->allPermissions());
    }
}
