<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function updateProfileData(User $user, array $data): User
    {
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        $user->fill($data);
        $user->save();

        // LOG ACTIVITY: Consistency fix to strictly use Auth::user()
        activity()
            ->useLog('user-profile')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User updated their own profile details');

        return $user;
    }

    public function updatePassword(User $user, string $newPassword): void
    {
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // LOG ACTIVITY: Consistency fix to strictly use Auth::user()
        activity()
            ->useLog('security')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User changed their security credentials (password)');
    }
}