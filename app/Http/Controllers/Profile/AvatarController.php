<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateAvatarRequest;


class AvatarController extends Controller
{
    
    public function update(UpdateAvatarRequest $request)
    {
        $path = Storage::disk('public')->put('avatars',$request->file('avatar'));
        

        if($old_avatar = $request->user()->avatar){
            
            Storage::disk('public')->delete($old_avatar);
        }

        auth()->user()->update(['avatar' => $path]);
        
        return redirect(route('profile.edit'))->with('message', 'Avatar changed');
    }

}
