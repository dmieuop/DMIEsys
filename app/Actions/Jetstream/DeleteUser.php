<?php

namespace App\Actions\Jetstream;

use App\Traits\System;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    use System;
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        try {
            $user->tokens->each->delete();
            $user->active_status = false;
            $user->save();
            $this->passed($user->name . ' has deactivated the account.');
        } catch (\Throwable $th) {
            $this->failed($th);
        }
    }
}
