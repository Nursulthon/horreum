<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WarehouseRepository {

    public function getAll(array $fields)
    {
        return Warehouse::select($fields)->with('products.categories')->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Warehouse::select($fields)->with('products.categories')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Warehouse::create($data);
    }

    public function update(int $id, array $data)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($data);
        return $warehouse;
    }

    public function delete(int $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
    }
}
