<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class PermissionMenuReOrder3 extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Quiz Re-Test', 'route' => 'quizReTest', 'type' => 3, 'parent_route' => 'online-quiz'],
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
