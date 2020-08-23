<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ConsoleCommandsHelpers {

    public function getContext()
    {
        if(!$this->validateRequest(['messageOptions.requestUuid'=>'required']))
        {
            return false;
        }

        return Cache::get('requests')[request('messageOptions.requestUuid')] ?? False;
    }
    
    public function validateRequest($validationOptions)
    {
        $validator = Validator::make(request()->all(), $validationOptions);
        
        return !$validator->fails();
    }
    
    public function generateUuid()
    {
        return Str::uuid()->toString();
    }
}