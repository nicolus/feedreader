<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function feeds()
    {
        return $this->belongsToMany('App\Feed');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Article')->withPivot(['read', 'starred']);
    }

    public function attachArticle(Article $article, $fields = [])
    {
        return $this->articles()->attach($article->id, $fields);
    }
}
