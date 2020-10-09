<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;

    public static $relativeImagePath = "public/uploads/users/images";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function getImageAttribute($value)
    {
        return Storage::url(self::$relativeImagePath . '/' . $value);
    }

    /**
     * Get the tweets for the user.
     */
    public function tweets()
    {
        return $this->hasMany('App\Tweet');
    }

    /**
     * Save a new user and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $imagePath = $attributes['image']->store(self::$relativeImagePath);
        $imageParams = explode("/", $imagePath);
        $attributes['image'] = end($imageParams);

        $attributes['password'] = Hash::make($attributes['password']);
        
        $model = new self($attributes);
        $model->save();

        return $model;
    }
}
