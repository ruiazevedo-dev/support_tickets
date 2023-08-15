<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
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

    public function generate(Request $request)
    {

       $result = OpenAI::images()->create([
                'prompt' => 'create avatar for one user with tech style',
                'n' => 1,
                'size' => '256x256'
        ]);

        $contents = file_get_contents($result->data[0]->url);

        $filename = Str::random(25);

        if($old_avatar = $request->user()->avatar){
            
            Storage::disk('public')->delete($old_avatar);
        }


        Storage::disk('public')->put("avatars/$filename.jpg",$contents);

        auth()->user()->update(['avatar' => "avatars/$filename.jpg"]);

        return redirect(route('profile.edit'))->with('message', 'Avatar changed');

        
    }

}
