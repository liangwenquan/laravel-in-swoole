<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Currency extends Model
{
    use ElasticquentTrait;

    protected $table = 'currency';

    #ES索引名称
    public function getIndexName()
    {
        return 'currency';
    }

    function getTypeName()
    {
        return 'currency_type_name';
    }
}
