<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService {

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    //Syntax diatas adalah proses depedency injection

    public function getAll(array $fields)
    {
        return $this->categoryRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->categoryRepository->getById($id, $fields);
    }

    public function create(array $data)
    {
        if(isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
        //Pengecekan apakah data yang dikirim berisikan foto?, dan apakah foto tersebut bagian dari file fisik yang diunggah?
            $data['photo'] = $this->uploadPhoto($data['photo']);
            //Jika sesuai maka foto tsb akan diubah dari file fisik menjadi path saja
        }

        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['id', 'photo'];
        //Variable untuk parameter function
        $category = $this->categoryRepository->getById($id, $fields);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if (!empty($category->photo)) {
                $this->deletePhoto($category->photo);
            }

            $data['photo'] = $this->uploadPhoto($data['photo']);
        }
        //Saat update data baru yang berisikan foto baru, maka foto lama harus dihapus supaya database tidak penuh

        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $fields = ['id', 'photo'];
        $category = $this->categoryRepository->getById($id, $fields);

        if ($category->photo) {
            $this->deletePhoto($category->photo);
        }

        return $this->categoryRepository->delete($id);
    }

    private function uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('categories', 'public');
        //Function bantuan untuk menentukan path data foto disimpan
    }

    private function deletePhoto(string $photoPath)
    {
        $relativePath = 'categories/' . basename($photoPath);
        //variable yang berisikan untuk mencari lokasi photo yang telah disimpan

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
