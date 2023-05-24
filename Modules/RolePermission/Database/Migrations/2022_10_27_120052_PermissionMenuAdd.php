<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class PermissionMenuAdd extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Custom CSS & JS', 'route' => 'frontend.customJsCss', 'type' => 2, 'parent_route' => 'frontend_CMS'],
        ];
        foreach ($routes as $route) {
            Permission::updateOrCreate([
                'route' => $route['route'],
            ], [
                    'name' => $route['name'],
                    'route' => $route['route'],
                    'parent_route' => $route['parent_route'],
                    'type' => $route['type'],
                    'ecommerce' => 0,
                    'module' => $route['module'] ?? ''
                ]
            );
        }
    }

    public function down()
    {
        //
    }
}
