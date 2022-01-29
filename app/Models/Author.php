<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'surname',
        'name',
        'patronymic'
    ];

    protected $casts = [];

    #================================== [RELATIONSHIP METHOD] ==================================#

    public function books()
    {

    }

    public function book()
    {

    }

}
