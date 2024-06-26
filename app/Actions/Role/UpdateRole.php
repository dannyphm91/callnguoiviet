<?php

namespace App\Actions\Role;

class UpdateRole
{
    public static function update(object $request, object $role)
    {
        if (! empty($request->permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permissions);
        }

        return true;
    }
}
