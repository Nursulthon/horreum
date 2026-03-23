<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseProductRequest;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseProductController extends Controller
{
    private $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function attach(int $warehouseId, WarehouseProductRequest $request)
    {
        $data = $request->validated();

        $this->warehouseService->attachProduct(
            $warehouseId,
            $data['product_id'],
            $data['stock']
        );

        return response()->json([
            'message' => 'Product attached successfully.'
        ]);
    }

    public function detach(int $warehouseId, int $productId)
    {
        $this->warehouseService->detachProduct($warehouseId, $productId);

        return response()->json([
            'message' => 'Product removed successfully.'
        ]);
    }

    public function update(int $warehouseId, WarehouseProductRequest $request)
    {
        $data = $request->validated();

        $warehouseProductUpdatedStock = $this->warehouseService->updateProductStock(
            $warehouseId,
            $data['product_id'],
            $data['stock'],
        );

        return response()->json([
            'message' => 'Stock updated successfully',
            'data' => $warehouseProductUpdatedStock
        ]);
    }
}
