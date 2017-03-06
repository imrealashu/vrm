<?php namespace Listbees\VRM;

use Illuminate\Database\Eloquent\Model;

class VrmPrefixes extends Model
{
    protected $table = 'vrm_prefixes';

    protected $fillable = ['name', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [];
}