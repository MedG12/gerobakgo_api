<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLocationRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Http\Resources\MerchantCollection;
use App\Http\Resources\MerchantDetailResource;
use App\Http\Resources\MerchantResource;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Events\LocationUpdated;
use Illuminate\Support\Facades\Redis;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): MerchantCollection
    {
        $merchants = Merchant::with(['user'])->get();
        $redis = Redis::pipeline();

        $merchants->each(function ($merchant) use ($redis) {
            $redis->get("location_" . $merchant->user_id);
        });

        $locations = $redis->execute();

        $merchants->each(function ($merchant, $index) use ($locations) {
            $location = $locations[$index];
            $merchant->location = $location
                ? json_decode($location, true)
                : null;

        });
        return new MerchantCollection($merchants);
    }

    public function show($id): MerchantResource
    {
        $merchant = Merchant::with(['user'])->findOrFail($id);
        $location = Redis::get('location_' . $merchant->user_id);
        $merchant->location = $location ? json_decode($location, true) : null;
        return new MerchantResource($merchant);
    }

    public function detail($id): MerchantDetailResource
    {
        $merchant = Merchant::with(['user', 'menus'])->findOrFail($id);
        $location = Redis::get('location_' . $merchant->user_id);
        $merchant->location = $location ? json_decode($location, true) : null;
        return new MerchantDetailResource($merchant);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,user_id',
            'description' => 'nullable|string',
            'openHour' => 'nullable|date_format:H:i',
            'closeHour' => 'nullable|date_format:H:i',
            'photoUrl' => 'nullable|url',
        ]);

        $merchant = Merchant::create($validated);
        return response()->json(['success' => true, 'data' => $merchant], 201);
    }

    public function update(UpdateMerchantRequest $request, $id): MerchantDetailResource
    {
        $merchant = Merchant::with(['user'])->findOrFail($id);
        $merchant->update($request->validated());
        return new MerchantDetailResource($merchant);
    }

    public function updateLocation(UpdateLocationRequest $request, $id)
    {
        $merchant = Merchant::with(['user'])->findOrFail($id);

        $locationData = [
            'user_id' => $merchant->user_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'last_updated' => now(),
        ];

        Redis::set('location_' . $merchant->user_id, json_encode($locationData), 'EX', 600);

        broadcast(new LocationUpdated(
            $merchant->user_id,
            $request->latitude,
            $request->longitude,
            $locationData['last_updated']
        ))->toOthers();

        return response()->json($locationData);
    }
}
