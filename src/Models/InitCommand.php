<?php

namespace Nonsapiens\LaravelAppInit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InitCommand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'command_name',
    ];
}