<?php

namespace App\Repositories\Category;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    //nos devuelve una instancia vacia del modelo o si el slug no es null no devuelve una instancia del modelo que encontro en la base de dato
    public function model(?string $slug = null): Category;

    public function paginate(array $counts = [], array $relationships = [], int $perPage = 10);

    public function create(array $data);

    public function update(array $data, Category $category);

    public function delete(Category $category);
}
