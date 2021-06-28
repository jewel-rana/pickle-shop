<?php


namespace App\Services;


use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderDeliveryRepository;

class DeliveryService
{
    /**
     * @var OrderDeliveryRepository
     */
    private $deliveryRepository;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        OrderDeliveryRepository $deliveryRepository,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->deliveryRepository = $deliveryRepository;
        $this->orderRepository = $orderRepository;
    }

    public function create(array $data)
    {
        return $this->deliveryRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->deliveryRepository->update($data, $id);
    }
}
