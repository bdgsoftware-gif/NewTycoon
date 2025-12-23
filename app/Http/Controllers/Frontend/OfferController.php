<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Services\Offer\OfferService;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    public function __construct(
        protected OfferService $offerService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $offers = Offer::active()
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 12));

        return response()->json([
            'data' => $offers,
            'message' => 'Offers retrieved successfully',
        ]);
    }

    /**
     * Get offers for homepage.
     */
    public function homepage()
    {
        $offers = $this->offerService->getActiveOffers(3);

        return response()->json([
            'data' => $offers,
            'message' => 'Homepage offers retrieved successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        $offerData = $this->offerService->getOfferWithProducts($offer);

        return response()->json([
            'data' => $offerData,
            'message' => 'Offer retrieved successfully',
        ]);
    }

    /**
     * Record offer click.
     */
    public function recordClick(Offer $offer)
    {
        $this->offerService->recordClick($offer);

        return response()->json([
            'message' => 'Click recorded successfully',
        ]);
    }
}
