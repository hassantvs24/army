<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class BusinessScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()) {
            $builder->where('business_id', Auth::user()->business_id);
        }
    }

}