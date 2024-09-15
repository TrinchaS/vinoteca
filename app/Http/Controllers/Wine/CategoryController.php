<?php

namespace App\Http\Controllers\Wine;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
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

    public function store(CategoryRequest $request){//:RedirectResponse{
        //$validado = $request->validated();
        //ray($validado);
        $this->repository->create($request->validated());
        return redirect()->route('categories.index');
    }
}
