<?php namespace App;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Feed extends \Eloquent  {
    const TYPE_RSS = 1;
    const TYPE_TWITTER = 2;

    protected $fillable = ['name', 'url', 'type'];


    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function scopeRss($query)
    {
        return $query->where('type', self::TYPE_RSS);
    }

    public function scopeTwitter($query)
    {
        return $query->where('type', self::TYPE_TWITTER);
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

}
