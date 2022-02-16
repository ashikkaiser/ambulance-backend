<?php
namespace App\Views\Composers;

use App\Models\Agent;
use App\Models\Partner;
use App\Models\Moderator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HeaderComposer {

    public function compose(View $view) {
        $user = Auth::guard('admin_user')->user();

        if($user !== null) {
            if($user->user_category == 'Admin') {
                $data = $user;
                $data->isAdmin = true;
                $data->imgPath = 'Html/assets/images/brand/user.png';
            }
            elseif($user->user_category == 'Moderator') {
                $data = Moderator::where('email', $user->email)->first();
                $data->isAdmin = false;
                $data->imgPath = 'images/moderator_picture/';
            }
            elseif($user->user_category == 'Partner') {
                $data = Partner::where('email', $user->email)->first();
                $data->isAdmin = false;
                $data->imgPath = 'images/partner_picture/';
            }
            elseif($user->user_category == 'Agent') {
                $data = Agent::where('email', $user->email)->first();
                $data->isAdmin = false;
                $data->imgPath = 'images/agent_picture/';
            }
        }
        else {
            $data = [];
        }

        $view->with('data', $data);
    }
}

?>