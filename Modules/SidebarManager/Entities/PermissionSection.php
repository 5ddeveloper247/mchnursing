<?php

namespace Modules\SidebarManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\RolePermission;
use Spatie\Translatable\HasTranslations;

class PermissionSection extends Model
{
    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['name'];


    public function frontendPermissions()
    {
        $permissoins = $this->hasMany(Permission::class, 'section_id');

        $permissoins->where('menu_status', 1)
            ->where('backend', 0)
            ->orderBy('position');


        return $permissoins;
    }

    public function permissions()
    {


        $permissoins = $this->hasMany(Permission::class, 'section_id');

        $user = \auth()->user();

        if ($user->role_id != 1) {
            $query = RolePermission::select('permission_id');
            if (isModuleActive('OrgInstructorPolicy')) {
                $query->where('policy_id', $user->policy_id);
            } else {
                $query->where('role_id', $user->role_id);
            }
            $ids = $query->pluck('permission_id')->toArray();
            $permissoins->whereIn('id', $ids);
        }
        if (!showEcommerce()) {
            $permissoins->where('ecommerce', 0);
        }
        $permissoins->where('menu_status', 1)
            ->where('backend', 1)
            ->orderBy('position');

        if (hasDynamicPage()) {
            $ignoreDynamicPage = [
                'frontend.homeContent', 'frontend.privacy_policy', 'frontend.privacy_policy', 'frontend.AboutPage', 'frontend.ContactPageContent'
            ];
            $permissoins->whereNotIn('route', $ignoreDynamicPage);
        }
        return $permissoins;
    }

    public function activeMenus()
    {
        return $this->permissions()->where('type', 1)->where('menu_status', 1);
    }

    public function activeSubmenus()
    {
        return $this->permissions()->where('type', 2)->where('menu_status', 1);
    }

    public function activeActions()
    {
        return $this->permissions()->where('type', 3)->where('menu_status', 1);
    }

    public function inActiveMenus()
    {
        return $this->permissions()->where('type', 1)->where('menu_status', 0);
    }

    public function inActiveSubmenus()
    {
        return $this->permissions()->where('type', 2)->where('menu_status', 0);
    }

    public function inActiveActions()
    {
        return $this->permissions()->where('type', 3)->where('menu_status', 0);
    }
}
