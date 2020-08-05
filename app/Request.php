<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;

class Request extends DynamoDbModel
{
    protected $primaryKey = 'request_uuid';
}
