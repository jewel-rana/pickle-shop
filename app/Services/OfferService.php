<?php


namespace App\Services;


use App\Repositories\Interfaces\OfferRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OfferService
{
    private $offerRepository;

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
}
