<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;

use App\Models\User;

use Illuminate\Support\Facades\Storage;

use Session;

class UserController extends Controller
{
    //
    protected function uploadAvatar(Request $request) 
    
     {

        if($request->hasFile('image'))
        {
            User::uploadAvatar($request->image);
            // $filename = $request->image->getClientOriginalName();
            // $this->deleteOldImage();
            // $request->image->storeAs('images', $filename, 'public');
            // auth()->user()->update(['avatar' => $filename]);
            // -----------------------------
            // User::find(1)->update(['avatar' => $filename]);
            // dd($request->image->getClientOriginalName());
            // session()->put('message', 'Image Uploaded.'); //success message
            // $request->session->flash('message', 'Image Uploaded.');
              return redirect()->back()->with('message', 'Image Uploaded.');
          }
        //   $request->session->flash('error', 'Image not Uploaded.'); //error message
         return redirect()->back()->with('error', 'Image not Uploaded.');
        // $request->image->store('images', 'public');
        // User::find(1)->update(['avatar' => 'sdsffsd']);
    }

    // Storage::delete('/public/images/'.auth()->user()->avatar);
    // protected function deleteOldImage(){
    //     if(auth()->user()->avatar){
    //         Storage::delete('/public/images/'.auth()->user()->avatar);
    //     }
    // }

    public function index()
    {
        $data = [
        'name' => 'Elon',
        'email' => 'elon@bitfumes.com',
        'password' => 'password',
        'mobile' => '39485',
        ];
        User::create($data);
        // User::where('id',6) -> delete();

        // User::where('id', 8)->update(['name' => 'bitfumessss']);
// facade part for showing data
        $user = User::all();
        return $user;

        // -----
        // $user = new User();
        // $user -> name = 'sarthak';
        // $user -> email = 'sarthak@bitfumes.com';
        // $user -> password = bcrypt('password');
        // $user -> save();
        //  return $user;
        //    ....
        // DB::insert('insert into users (name,email,password) values (?,?,?)', [
        //     'sarthak', 'sarthak@bitfumes.com', 'password'
        // ]);

        // DB::update('update users set name = ? where id = 1' , ['bitfumes']);

        // DB::delete('delete from users where id = 1');

        //  $users = DB::select('select * from users');
        //  return $users;

         return view('home');
    }
}
