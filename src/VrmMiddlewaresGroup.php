<?php namespace Listbees\VRM;

use Illuminate\Database\Eloquent\Model;

class VrmMiddlewaresGroup extends Model
{
    protected $table = 'vrm_middlewares_group';

    protected $fillable = ['name', 'prefix', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [];
}