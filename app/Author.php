<?php

namespace App;

use App\ModelTraits\RequestMediaTrait;
use App\ModelTraits\RequestTranslatableTrait;
use App\ModelTraits\UserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Author
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $backlinks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author query()
 * @mixin \Eloquent
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 */
class Author extends Model implements HasMedia
{
    use UserRelationTrait;
    use InteractsWithMedia;
    use RequestTranslatableTrait;
    use RequestMediaTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'backlinks',
    ];

    protected $casts = [
        'backlinks' => 'array'
    ];

    public $translatable = ['description'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->width(120)
            ->height(80)
            ->nonOptimized();

        $this->addMediaConversion('medium')
            ->width(400)
            ->height(300)
            ->nonOptimized();

        $this->addMediaConversion('large')
            ->width(800)
            ->height(600)
            ->nonOptimized();
    }
}
