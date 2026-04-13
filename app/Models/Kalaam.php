<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Kalaam extends Model
{
    protected $table = 'kalaam';

    protected $fillable = [
        'title',
        'slug',
        'poet_name',
        'content',
        'lines_per_sheir',
        'thumbnail',
        'is_active'
    ];

        /**
     * Accessor → content ko sheirs me convert karega
     */
    public function getSheirsAttribute()
    {
        $sheirs = preg_split("/\n\s*\n/", trim($this->content));

        return collect($sheirs)->map(function ($sheir) {
            return explode("\n", trim($sheir));
        });
    }

}
