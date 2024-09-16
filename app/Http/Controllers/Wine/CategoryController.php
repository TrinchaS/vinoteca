<?php

namespace App\Http\Controllers\Wine;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use function Laravel\Prompts\alert;

class CategoryController extends Controller
{
    //inyeccion de dependencia para acceder con $this 
    public function __construct(private readonly CategoryRepositoryInterface $repository){     
    }

    public function index():View {
        return view('wine.category.index',[
            'categories' => $this->repository->paginate(
                counts:['wines'],
            )
        ]);
    }

    public function create():View{
        return view('wine.category.create',[
            'category' => $this->repository->model(),
            'action' => route('categories.store'),
            'method' => 'POST',
            'submit' => 'Crear',
        ]);
    }

    public function store(CategoryRequest $request):RedirectResponse{
        $this->repository->create($request->validated());
        session()->flash('success','Categoría creada con éxito');
        return redirect()->route('categories.index');
    }

    public function edit(Category $category):View{
        return view('wine.category.edit',[
            'category' => $category,
            'action' => route('categories.update',$category),
            'method' => 'PUT',
            'submit' => 'Actualizar',
        ]);
    }

    public function update(CategoryRequest $request, Category $category):RedirectResponse{
        $this->repository->update($request->validated(), $category);
        session()->flash('success','Categoría actualizada con éxito');
        return redirect()->route('categories.index');
    }
}
