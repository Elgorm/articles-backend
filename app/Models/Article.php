<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFilter;
use Illuminate\Support\Facades\Cache;
use Str;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property string $published_at
 * @property int $views
 * @property int $likes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cover_url
 * @property-read mixed $photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article filter(\App\Filters\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereViews($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article published()
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereSlug($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use HasFactory, HasFilter;

    protected $fillable = ['title', 'content', 'short_content', 'published_at', 'likes', 'views', 'slug'];
    protected $appends = ['photo_url', 'cover_url'];

    protected static function booted()
    {
        static::saving(function ($article) {

            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }

            $article->short_content = mb_substr($article->content, 0, 100);
        });
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPhotoUrlAttribute()
    {
        return 'https://place-hold.it/1300x500';
    }

    public function getCoverUrlAttribute()
    {
        return 'https://place-hold.it/200x150';
    }

    private function getStatsCacheKey($key)
    {
        return "article:{$this->id}:$key";
    }

    public function incrementStatsKey($key)
    {
        Cache::increment($this->getStatsCacheKey($key));
    }

    public function syncStatsToDatabase()
    {
        $views = $this->getViews();
        $likes = $this->getLikes();
        $this->views = $views;
        $this->likes = $likes;
        $this->save();
    }

    public function getViews()
    {
        return Cache::get($this->getStatsCacheKey('views'), $this->views);
    }

    public function getLikes()
    {

        return Cache::get($this->getStatsCacheKey('likes'), $this->likes);
    }
}
