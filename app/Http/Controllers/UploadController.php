<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Upload;
use Illuminate\Routing\Controller as BaseController;

class UploadController extends BaseController
{
    public function upload_form() 
    {
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $empty = session()->get('empty');
        $invalid = session()->get('invalid');

        session()->forget('empty');
        session()->forget('invalid');

        $user = User::find(session()->get('user_id'));

        return view('upload')
            ->with('empty', $empty)
            ->with('invalid', $invalid)
            ->with('username', $user->username);
    }

    public function upload_do()
    {   
        if(!(session()->get('user_id'))) 
        {
            return redirect('login');
        }

        $empty = array();
        $invalid = array();

        $file = request('foto');

        if(empty($file)) array_push($empty, "foto"); 
        else
        {
            $type = exif_imagetype($file->path());
            $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg');
            
            if(!isset($allowedExt[$type])) array_push($invalid, "foto");
            else $file = $file->store('storage/uploads', 'public');
        }

        if(empty(request('description'))) array_push($empty, "description");

        if(count($empty) == 0 && count($invalid) == 0) 
        {
            $user = User::find(session()->get('user_id'));

            $upload = new Upload;
            $upload->username = $user->username;
            $upload->destination = $file;
            $upload->descrip = request('description');
            $upload->alt_desc = request('alt_description');
            $upload->created = date("Y-m-d");
            $upload->save();

            array_push($empty, "correct");
            session()->put('empty', $empty);
            return redirect('upload')->withInput();
        } 
        else 
        {
            session()->put('empty', $empty);
            session()->put('invalid', $invalid);
            return redirect('upload')->withInput();
        }     
    }
}
