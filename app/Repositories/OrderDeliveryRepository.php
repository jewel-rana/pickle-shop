<?php


namespace App\Repositories;


use App\Models\OrderDelivery;

class OrderDeliveryRepository extends BaseRepository
{
    public function __construct(OrderDelivery $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {
        return parent::create($data);
    }

    public function update(array $data, $id)
    {
        return parent::update($data, $id);
    }
}
