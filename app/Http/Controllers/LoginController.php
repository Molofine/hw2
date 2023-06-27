<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    public function signup_form() 
    {
        if(session()->get('user_id')) 
        {
            return redirect('home');
        }

        $empty = session()->get('empty');
        $invalid = session()->get('invalid');
        $used = session()->get('used');

        session()->forget('empty');
        session()->forget('invalid');
        session()->forget('used');

        return view('signup')
            ->with('empty', $empty)
            ->with('invalid', $invalid)
            ->with('used', $used);
    }

    public function signup_do()
    {   
        if(session()->get('user_id')) 
        {
            return redirect('home');
        }

        $empty = array();
        $invalid = array(); 
        $used = array();
 
        if(empty(request('username'))) array_push($empty, "username");
        else if(!preg_match('/^[a-zA-Z0-9_]{2,15}$/', request('username'))) array_push($invalid, "username");
        else if(User::where('username', request('username'))->first()) array_push($used, "username");

        if(empty(request('email'))) array_push($empty, "email");
        else if (!filter_var(request('email'), FILTER_VALIDATE_EMAIL)) array_push($invalid, "email");
        else if (User::where('email', request('email'))->first()) array_push($used, "email");

        if(empty(request('confirm_email'))) array_push($empty, "confirm_email");
        else if (strcmp(request('email'), request('confirm_email')) != 0) array_push($invalid, "confirm_email");

        if(empty(request('password'))) array_push($empty, "password");
        else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', request('password'))) array_push($invalid, "password");

        if(empty(request('confirm_password'))) array_push($empty, "confirm_password");
        else if (strcmp(request('password'), request('confirm_password')) != 0) array_push($invalid, "confirm_password");

        if(empty(request('allow'))) array_push($empty, "allow");
        
        if(count($empty) == 0 && count($invalid) == 0 && count($used) == 0) 
        {
            $user = new User;
            $user->username = request('username');
            $user->email = request('email');
            $user->password = password_hash(request('password'), PASSWORD_DEFAULT);
            $user->name = request('name');
            $user->surname = request('surname');
            $user->save();

            session()->put('user_id', $user->id);
            return redirect('home');
        } 
        else 
        {
            session()->put('empty', $empty);
            session()->put('invalid', $invalid);
            session()->put('used', $used);
            return redirect('signup')->withInput();
        }
    }

    public function check_username($username)
    {
        if(session()->get('user_id')) 
        {
            return redirect('login');
        }

        $user = User::where('username', request('username'))->first();
        return json_encode(array('exists' => $user ? true : false));
    }

    public function check_email($email)
    {
        if(session()->get('user_id')) 
        {
            return redirect('login');
        }

        $email = User::where('email', request('email'))->first();
        return json_encode(array('exists' => $email ? true : false));
    }

    public function login_form() 
    {
        if(session()->get('user_id')) 
        {
            return redirect('home');
        }

        $empty = session()->get('empty');
        $invalid = session()->get('invalid');

        session()->forget('empty');
        session()->forget('invalid');

        return view('login')
            ->with('empty', $empty)
            ->with('invalid', $invalid);
    }

    public function login_do()
    {   
        if(session()->get('user_id')) 
        {
            return redirect('home');
        }

        $empty = array();
        $invalid = array(); 

        $user = User::where('username', request('username'))->first();
 
        if(empty(request('username'))) array_push($empty, "username");
        else if(!($user)) array_push($invalid, "username");

        else if(empty(request('password'))) array_push($empty, "password");
        else if(!(password_verify(request('password'), $user->password))) array_push($invalid, "password");

        if(count($empty) == 0 && count($invalid) == 0) 
        {
            session()->put('user_id', $user->id);
            return redirect('home');
        } 
        else 
        {
            session()->put('empty', $empty);
            session()->put('invalid', $invalid);
            return redirect('login')->withInput();
        }
    }

    public function logout() 
    {
        session()->flush();
        return redirect('login');
    }
}
