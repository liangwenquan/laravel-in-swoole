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

    public function getTypeName()
    {
        return 'currency_type_name';
    }

    public function addToIndex()
    {
    }

    #模型中被写入文档的字断
    public function getIndexDocumentData()
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'symbol' => $this->symbol,
            'contract_address' => $this->contract_address,
        ];
    }
}
