<?php


namespace App\Services;


use App\Events\DeliveryManAssignedEvent;
use App\Events\OrderDeliveryUpdateEvent;
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
        $orderDelivery = $this->deliveryRepository->create($data);
        event(new DeliveryManAssignedEvent($orderDelivery));
    }

    public function update(array $data, $id)
    {
        if($this->deliveryRepository->update($data, $id)) {
            event(new OrderDeliveryUpdateEvent($data));
        }
    }
}
