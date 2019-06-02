<?php namespace App;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use PicoFeed\Reader\Reader;


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


    /**
     * @param $q
     * @return Collection
     */
    public static function search($q)
    {
        $feeds = new Collection();

        // Looks like a URL or domain name, discover
        if (preg_match("#^(https?://)?[\w./]+\.\w{2,}(/.+)?$#", $q)) {
            try {
                $feeds = $feeds->merge(self::getFeedsFromUrl($q));
            } catch (\Exception $e) {
                // TODO: log the error.
            }
        };

        if ($q) {
            $res = Feed::where('name', 'like', "%$q%")->get();
        } else {
            $res = Feed::all();
        }

        $feeds = $feeds->merge($res);

        return $feeds;
    }

    protected static function getFeedsFromUrl($url)
    {
        $return = new Collection();
        $reader = new Reader;
        $resource = $reader->download($url);

        $feeds = $reader->find(
            $resource->getUrl(),
            $resource->getContent()
        );

        foreach ($feeds as $feed) {
            $resource = $reader->download($feed);

            $feed = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            )->execute();

            $return->push(new Feed([
                'name' => $feed->title,
                'url' => $feed->getFeedUrl(),
                'type' => self::TYPE_RSS
            ]));
        }

        return $return;
    }


}
