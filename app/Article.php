<?php namespace App;

use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Article extends \Eloquent
{
    use Searchable;

    protected $fillable = ['title', 'content', 'full_content', 'url'];

    public function toSearchableArray()
    {
        return array_only(
            $this->toArray(),
            ['id', 'title', 'content']
        );
    }

    public function feed()
    {
        return $this->belongsTo('App\Feed');
    }

    public function setCreatedAtAttribute(Carbon $date)
    {
        $date->setTimezone('UTC');
        $this->attributes['created_at'] = $date;
    }

    public function setUpdatedAtAttribute(Carbon $date)
    {
        $date->setTimezone('UTC');
        $this->attributes['updated_at'] = $date;
    }

    public function findImage()
    {
        if (preg_match("#<img[^>]* src=\"(.+)\"#", $this->full_content, $m)) {
            return $m[1];
        }

        return null;
    }

}
