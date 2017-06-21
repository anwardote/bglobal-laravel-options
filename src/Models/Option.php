<?php

namespace Bglobal\Options\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;
    protected $fillable = ['key', 'value', 'description'];

}
