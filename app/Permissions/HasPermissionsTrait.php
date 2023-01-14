<?php
namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait {
  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission);
  }

  public function hasPermissionThroughRole($permission) {
    // dd($this->roles);
    foreach ($permission->roles as $role){
      if($this->roles->id == $role->id) {
        return true;
      }
    }
    return false;
  }

  public function roles() {

    return $this->belongsTo(Role::class, 'role_id');

  }

}
