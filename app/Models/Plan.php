<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }
}