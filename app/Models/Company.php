<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function getLogoAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/default/logo.png');
        }
    }

    public function getFavAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/default/favicon.ico');
        }
    }
}
