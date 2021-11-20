<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $divisions_id
 * @property integer $business_id
 * @property integer $users_id
 * @property string $name
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Business $business
 * @property Division $division
 * @property User $users
 * @property Customer[] $customers
 * @property UpaZilla[] $upaZillas
 */
class Zilla extends Model
{
  //  use SoftDeletes;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['divisions_id', 'business_id', 'users_id', 'name', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo('App\Division', 'divisions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Customer', 'zillas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upaZillas()
    {
        return $this->hasMany('App\UpaZilla', 'zillas_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope);
    }
}
