<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMerchantRequest;
use App\Http\Resources\MerchantCollection;
use App\Http\Resources\MerchantDetailResource;
use App\Http\Resources\MerchantResource;
use Illuminate\Http\Request;
use App\Models\Merchant;
use Illuminate\Support\Facades\Storage;

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
        return new MerchantCollection($merchants);
    }

    public function show($id): MerchantResource
    {
        $merchant = Merchant::with(['user'])->findOrFail($id);
        return new MerchantResource($merchant);
    }

    public function detail($id): MerchantDetailResource
    {
        $merchant = Merchant::with(['user', 'menus'])->findOrFail($id);
        return new MerchantDetailResource($merchant);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,user_id',
            'description' => 'nullable|string',
            'openHour' => 'nullable|date_format:H:i:s',
            'closeHour' => 'nullable|date_format:H:i:s',
            'photoUrl' => 'nullable|url',
        ]);

        $merchant = Merchant::create($validated);
        return response()->json(['success' => true, 'data' => $merchant], 201);
    }

    public function update(UpdateMerchantRequest $request, $id)
    {
        Merchant::findOrFail($id);
        $merchant = Merchant::update($request->validated());
        return response()->json(['success' => true, 'data' => $merchant]);
    }


}
