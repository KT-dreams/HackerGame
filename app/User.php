<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;

class User extends DynamoDbModel
{
    protected $fillable = ['username'];
    protected $primaryKey = 'user_id';
    
    protected $dynamoDbIndexKeys = [
        'UsernameIndex' => [
            'hash' => 'username'
        ],
    ];
}
