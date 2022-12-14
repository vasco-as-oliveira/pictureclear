<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

class ProfileController extends Controller
{
    public function editProfile(){
        $user =  User::select('*')->where('id','=',Auth::user()->id)->get();
       return view('editProfile', ['user'=>$user]);
    }
    public function editProfileSave(Request $request){
           $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
           ]); 
           DB::update('update users set firstname=?, lastname=?, description=? where id=?', [$request->firstname,$request->lastname, $request->about, Auth::user()->id]);
           $user =  User::select('*')->where('id','=',Auth::user()->id)->get();
           return view('editProfile', ['user'=>$user]);
    }

    private function storePhoto(){

    }
}
