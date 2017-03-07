<?php namespace Listbees\VRM;

use Illuminate\Database\Eloquent\Model;

class VrmControllers extends Model
{
    protected $table = 'vrm_controllers';

    protected $fillable = ['name', 'namespace', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [];

    public function routes()
    {
        return $this->hasMany(VrmRoutes::class, 'controller_id')->with('prefix', 'middlewares', 'controller');
    }
}