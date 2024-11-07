<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Locales;


class ProfileController extends Controller
{
    public function index(){
        return view('dashboard.profile.index',[
            'user' => Auth::user(),
            'countries' =>  Countries::getNames() ,
            'locales'   =>  Locales::getNames()
        ]);
    }

    public function edit(){
        return view('dashboard.profile.edit',[
            'user' => Auth::user(),
            'countries' =>  Countries::getNames() ,
            'locales'   =>  Locales::getNames()
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'first_name'   => ['required' ,'string'  ,'max:255' ],
            'last_name'    => ['required' ,'string'  ,'max:255' ],
            'birthday'     => ['nullable' , 'date' , 'before:today'],
            'gender'       => ['in:male,female'],
            'country'      => ['required' , 'string' , 'size:2' ],
        ]);

        $user = $request->user();
        $user->profile->fill($request->all())->save();


        return redirect()->route('dashboard.profile.edit')
                ->with('success' , 'Profile Updated Successfully');

    }
}
