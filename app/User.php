<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;

class User extends DynamoDbModel
{
    protected $primaryKey = 'username';
}
