<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class SubscriptionController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.subscription');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'logo_color' => ['required', 'max:255'],
            'logo_light' => ['required', 'max:255'],
            'logo_dark' => ['required', 'max:255'],
        ]);

        $data['logo_color'] = '';
        $data['logo_light'] = '';
        $data['logo_dark'] = '';

        //dd($request);

        if($request->file('logo_color')){           
            
            $filename= $request->slug.'_logo_color.png';
            //$file-> move(public_path('templates'), $filename);
            Storage::disk('digitalocean')->put('familia-metalife/logos/'.$filename, file_get_contents($request->logo_color), 'public');
            $data['logo_color']= $filename;
        } 
        //LOGO LIGHT VERSION
        if($request->file('logo_light')){            
            
            $filename= $request->slug.'_logo_light.png';
            //$file-> move(public_path('templates'), $filename);
            Storage::disk('digitalocean')->put('familia-metalife/logos/'.$filename, file_get_contents($request->logo_light), 'public');
            $data['logo_light']= $filename;
        } 
        //DARK VERSION
        if($request->file('logo_dark')){            
           
            $filename= $request->slug.'_logo_dark.png';
            //$file-> move(public_path('templates'), $filename);
            Storage::disk('digitalocean')->put('familia-metalife/logos/'.$filename, file_get_contents($request->logo_dark), 'public');
            $data['logo_dark']= $filename;
        } 

       

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cnpj' => $request->cnpj,
            'slug' => $request->slug,
            'trade_name' => $request->trade_name,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'logo_color' => $data['logo_color'],
            'logo_light' => $data['logo_light'],
            'logo_dark' => $data['logo_dark'],

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
