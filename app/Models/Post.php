<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'date',
        'image',
        'text',
        'description',
        'posted',
        'type',
        'category_id'
    ];

    // Un post pertenece a una categoria
    public function category()
    {   
        // Uno a muchos o uno a uno
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        // Relaciones polimorficas muchos a muchos
        return $this->morphToMany(Tag::class, 'taggables');
    }

}
