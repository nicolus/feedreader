<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        return $this->belongsToMany('App\Article');
    }

    public function attachArticle(Article $article)
    {
        return $this->articles()->attach($article->id);
    }
}
