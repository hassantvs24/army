<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class CommonObserver
{
    public $userID;
    public $businessID;

    public function __construct(){
        if (auth()->check()) {
            $this->userID = Auth::user()->id;
            $this->businessID = Auth::user()->business_id;
        }
    }

    public function saving($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }

    public function saved($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }


    public function updating($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }

    public function updated($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }


    public function creating($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }

    public function created($model)
    {
        $model->users_id = $this->userID;
        $model->business_id = $this->businessID;
    }
}
