<?php namespace Listbees\VRM;

use Illuminate\Database\Eloquent\Model;

class VrmMiddlewares extends Model
{
    protected $table = 'vrm_middlewares';

    protected $fillable = ['name', 'status'];

    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [];

    public function routes()
    {
        return $this->belongsToMany(VrmRoutes::class);
    }
}