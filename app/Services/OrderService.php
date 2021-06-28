<?php


namespace App\Services;


use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderDeliveryRepository;

class OrderService
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
        OrderRepositoryInterface $orderRepository,
        OrderDeliveryRepository $deliveryRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->deliveryRepository = $deliveryRepository;
    }

    public function create(array $data)
    {
        $order = $this->orderRepository->create($data);
    }

    public function update(array $data, $id)
    {
        $order = $this->orderRepository->show($id);
    }
}
