<?php

namespace App\Libraries\Wablas;

use App\Models\User;

class WablasChannel
{
    protected $wablas;

    public function __construct(Wablas $wablas)
    {
        $this->wablas = $wablas;
    }

    private function getNotifiableWhatsappNumber(User $user)
    {
        if (app()->isLocal() && config('app.debug')) {
            return config('wablas.debug_number');
        }
    }
}
