<?php namespace Listbees\VRM;

use Illuminate\Database\Eloquent\Model;

class VrmRoutes extends Model
{
    protected $table = 'vrm_routes';

    protected $fillable = ['middlewares_group_id', 'namespace', 'where', 'domain', 'path', 'full_path', 'as', 'prefix_id', 'controller_id', 'action', 'method', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [];

    public function middlewares()
    {
        return $this->belongsToMany(VrmMiddlewares::class, 'vrm_middlewares_vrm_routes', 'route_id', 'middleware_id');
    }

    public function controller()
    {
        return $this->hasOne(VrmControllers::class, 'id', 'controller_id');
    }

    public function prefix()
    {
        return $this->hasOne(VrmPrefixes::class, 'id', 'prefix_id');
    }

    public function group()
    {
        return $this->belongsTo(VrmMiddlewaresGroup::class, 'middlewares_group_id');
    }
}