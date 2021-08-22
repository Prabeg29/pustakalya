<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static chunk(int $int, \Closure $param)
 * @method static where(string $string, string $string1, int $id)
 * @method static paginate()
 */
class Book extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'qty'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * @param $collection
     */
    public function commaSeparate($collection)
    {
        $arr = [];
        foreach($collection as $object)
        {
            $arr[] = $object["name"];
        }
        return implode(",", $arr);
    }
}
