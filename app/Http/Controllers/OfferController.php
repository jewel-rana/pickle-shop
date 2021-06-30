<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferStoreRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function index()
    {
        return Offer::all();
    }

    public function store(OfferStoreRequest $request)
    {
        try {
            $this->offerService->create($request->validated());
            return response()->success(__('Offer successfully created'));
        } catch (\Throwable $exception) {
            return response()->error(__('Error!'), $exception->getMessage());
        }
    }

    public function show($id)
    {
        return Offer::findOfFail($id);
    }

    public function update(OfferUpdateRequest $request, $id)
    {
        try {
            $this->offerService->create($request->validated());
            return response()->success(__('Offer successfully updated'));
        } catch (\Throwable $exception) {
            return response()->error(__('Error!'), $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->offerService->delete($id)) {
                throw new \Exception(__('Offer cannot be deleted'));
            }
            return response()->success(__('Offer successfully deleted'));
        } catch (\Throwable $exception) {
            return response()->error(__('Offer failed to delete'));
        }
    }
}
