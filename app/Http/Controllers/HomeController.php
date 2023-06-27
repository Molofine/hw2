<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function home() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user = User::find(session()->get('user_id'));
        return view('home')->with('username', $user->username);
    }

    public function cerca_db($query)
    {
        if(!(session()->get('user_id'))) 
        {
            return [];
        }

        $upload = Upload::where('descrip', 'like', '%'.$query.'%')->orWhere('alt_desc', 'like', '%'.$query.'%')->get();
        return $upload;
    }

    public function cerca_img($query)
    {
        if(!(session()->get('user_id'))) 
        {
            return [];
        }

        $key = env('UNSPLASH_KEY');
        $url = 'https://api.unsplash.com/search/photos?client_id='.$key.'&query='.urlencode($query).'&page=1&per_page=30';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    public function salva_img() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $user_id = session()->get('user_id');
        $present = Favorite::where('userid', $user_id)->where("imgid", request('id'))->first();
        
        if($present) 
        {
            $present->delete();
            return json_encode(array('presente' => true));
        } 
        else 
        {
            $favorite = new Favorite;
            $favorite->userid = $user_id;
            $favorite->imgid = request('id');
            $info = [
                        'id' => request('id'), 
                        'description' => request('description'), 
                        'alt_description' => request('alt_description'), 
                        'created' => request('created'), 
                        'author' => request('author'), 
                        'image' => request('image')
                    ];
            $favorite->info = json_encode($info);
            $favorite->save();
            return json_encode(array('presente' => false));
        }                           
    }
}
