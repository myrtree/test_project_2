<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company', 'phone', 'email', 'comment',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    /**
     * Связь с таблицей назначенных встреч.
     */
    public function meetings()
    {
        return $this->hasMany('App\Models\Meeting');
    }

    /**
     * Связь с таблицей меток.
     */
    public function labels()
    {
        return $this->belongsToMany('App\Models\Label');
    }
}
