<?php

namespace HotelReview\Http\Controllers;

use Illuminate\Http\Request;
use HotelReviews\Http\Services\SignatureVerifier;
use HotelReviews\Http\Services\PolygonRelayer;

class ReviewController
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'required|string',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
            'author' => 'required|string',
            'signature' => 'required|string',
        ]);

        $verifier = new SignatureVerifier();
        if (!$verifier->isValid($data)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $relayer = new PolygonRelayer();
        $txHash = $relayer->send($data);

        return response()->json(['txHash' => $txHash]);
    }
}
