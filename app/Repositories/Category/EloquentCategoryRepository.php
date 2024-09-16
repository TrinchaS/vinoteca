<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Traits\CRUDOperations;
use Exception;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
   use CRUDOperations;

   protected string $model = Category::class;

   protected function deleteChecks(Category $category):void{
      if($category->wines()->exists()){
         throw new Exception('No se puede eliminar la categoría porque tiene vinos asociados.');
      }
   }
   
}
