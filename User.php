<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $guarded= [];
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function uploadAvatar($image) {

            $filename = $image->getClientOriginalName();
            (new self())->deleteOldImage();
            $image->storeAs('images', $filename, 'public');
            auth()->user()->update(['avatar' => $filename]);
      
        }
    
    protected function deleteOldImage(){
        if($this->avatar){
            Storage::delete('/public/images/'.$this->avatar);
        }
    }
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
    // public function setPasswordAttribute($password){
    //     $this->attributes['password'] = bcrypt($password);
    // }

    // public function getNameAttribute($name){
    //   return 'my anme is: ' .ucfirst($name);
    // }
}
