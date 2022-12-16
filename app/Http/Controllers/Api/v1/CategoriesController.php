<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\CategoryService;
use Auth;
use App\Enums\Paginate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Models\Category;
use App\Http\Requests\Api\v1\Category\StoreRequest as CategoryStoreRequest;
use App\Http\Requests\Api\v1\Category\UpdateRequest as CategoryUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'categories' => CategoryResource::collection(
                Category::query()
                    ->forAuth()
                    ->orderBy('name', 'ASC')
                    ->paginate(Paginate::Category)
            )
        ]);
    }

    /**
     * @param CategoryStoreRequest $request
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function store(CategoryStoreRequest $request, CategoryService $categoryService): JsonResponse
    {
        $category = $categoryService->create($request->validated());

        if ($category) {
            return response()->json([
                'message' => 'Вы успешно создали категорию',
                'category' => new CategoryResource($category)
            ]);
        }

        return response()->json([
            'message' => 'Что-то пошло не так.. Повторите попытку позднее!'
        ], 400);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        if ($category->user_id === Auth::id()) {
            return response()->json([
                'category' => new CategoryResource($category)
            ]);
        }

        return response()->json([
            'message' => 'Недостаточно прав для просмотра'
        ], 403);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category, CategoryService $categoryService): JsonResponse
    {
        if ($category->user_id === Auth::id()) {
            if ($categoryService->update($category, $request->validated())) {
                return response()->json([
                    'message' => 'Вы успешно обновили категорию',
                    'category' => new CategoryResource($category->refresh())
                ]);
            }

            return response()->json([
                'message' => 'Что-то пошло не так.. Повторите попытку позднее!'
            ], 400);
        }

        return response()->json([
            'message' => 'Недостаточно прав для редактирования'
        ], 403);
    }

    /**
     * @param Category $category
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function destroy(Category $category, CategoryService $categoryService): JsonResponse
    {
        if ($category->user_id === Auth::id()) {
            if ($categoryService->delete($category)) {
                return response()->json([
                    'message' => 'Вы успешно удалили категорию'
                ]);
            }

            return response()->json([
                'message' => 'Что-то пошло не так.. Повторите попытку позднее!'
            ], 400);
        }

        return response()->json([
            'message' => 'Недостаточно прав для удаления'
        ], 403);
    }
}
