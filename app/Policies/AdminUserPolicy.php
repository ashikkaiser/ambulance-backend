<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserPolicy
{
    use HandlesAuthorization;

    public function haveAdminAccess(AdminUser $admin) {
        if($admin->user_category !== 'Admin') {
            return false;
        }
        return true;
    }

    public function haveModeratorAccess(AdminUser $admin) {
        if($admin->user_category == 'Moderator') {
            return true;
        }
        return false;       
    }

    public function havePartnerAccess(AdminUser $admin) {
        if($admin->user_category == 'Partner') {
            return true;
        }
        return false;       
    }

    public function haveAgentAccess(AdminUser $admin) {
        if($admin->user_category == 'Agent') {
            return true;
        }
        return false;       
    }
}
