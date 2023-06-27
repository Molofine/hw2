<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class ProfiloController extends BaseController
{
    public function profilo() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user = User::find(session()->get('user_id'));
        return view('profilo')->with('username', $user->username);
    }

    public function carica_db() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user_id = session()->get('user_id');
        $images = Favorite::where('userid', $user_id)->get();

        foreach($images as $image) {
            $rows[] = array('userid' => $image['userid'],
                            'imgid' => $image['imgid'], 
                            'info' => json_decode($image['info']));;
        }
        return json_encode(array_reverse($rows ?? []));
    }

    public function carica_upload() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user_id = session()->get('user_id');
        $user = User::find($user_id);
        $username = $user->username;
        $images = Upload::where('username', $username)->get();

        return $images;
    }

    public function cancella_img($img_id)
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        Upload::where('id', $img_id)->delete();
        Favorite::where('imgid', $img_id)->delete();
        return json_encode("Fatto");
    }

    public function cancella_account()
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user_id = session()->get('user_id');
        $user = User::find($user_id);
        $username = $user->username;

        $uploads = Upload::where('username', $username)->get();

        foreach ($uploads as $upload) 
        {
            $img_id = $upload->id;
            Favorite::where('imgid', $img_id)->delete();
            $upload->delete();
        }

        Favorite::where('userid', $user_id)->delete();

        $user->delete();
        return redirect('logout');
    }
}