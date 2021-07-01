<?php


namespace App\Services;


use App\Models\Offer;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OfferService
{
    private $offerRepository;
    private $discount = 0;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function create(array $data)
    {
        DB::transaction(function() use($data) {
            $offer = $this->offerRepository->create($data);
            $offer->products()->attach($data['product_ids']);
        }, 2);
    }

    public function update(array $data, int $id)
    {
        DB::transaction(function() use($data, $id){
            $ids = $data['product_ids'];
            unset($data['product_ids']);
            $offer = $this->offerRepository->update($data, $id);
            $offer = $this->offerRepository->show($offer);
            $offer->products()->sync($ids);
        }, 2);
    }

    public function delete(int $id)
    {
        return $this->offerRepository->delete($id);
    }

    public function calculateOfferDiscount($activeOffer, $price, $qty)
    {
        return $this->{$activeOffer->type}($activeOffer, $price, $qty);
    }

    private function discount(Offer $offer, $price, $qty): float
    {
        if($offer->min_order <= $qty) {
            $this->discount += $offer->discount_type == 'percent' ? $this->calculatePercent($price, $offer->amount) * $qty : ($offer->amount * $qty);
        }
        return $this->getDiscount();
    }

    private function bulk_order(Offer $offer, $price, $qty)
    {
        return $this->discount($offer, $price, $qty);
    }

    private function buy_one_get_one(Offer $offer, $price, $qty)
    {
        //TODO Need to implement logic here
        return $this->getDiscount();
    }

    private function min_amount()
    {
        //TODO Need to implement logic here
        return $this->getDiscount();
    }

    private function calculatePercent($price, $discount): float
    {
        return $price * ($discount / 100);
    }

    private function getDiscount(): float
    {
        return round($this->discount, 2);
    }
}
