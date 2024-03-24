<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class Permissions extends Controller
{
    public function __invoke(Request $request)
    {
        //get permissions
        $permissions = Permission::when(request()->q, function($permissions) {
            $permissions = $permissions->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //return inertia view
        return inertia('Permissions/Index', [
            'permissions' => $permissions
        ]);
    }
}
