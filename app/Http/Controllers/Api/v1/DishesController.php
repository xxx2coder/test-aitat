<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\DishService;
use Auth;
use App\Enums\Paginate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\DishResource;
use App\Models\Dish;
use App\Http\Requests\Api\v1\Dish\StoreRequest as DishStoreRequest;
use App\Http\Requests\Api\v1\Dish\UpdateRequest as DishUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DishesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'dishes' => DishResource::collection(
                Dish::query()
                    ->forAuth()
                    ->orderBy('name', 'ASC')
                    ->paginate(Paginate::Dish)
            )
        ]);
    }

    /**
     * @param DishStoreRequest $request
     * @param DishService $dishService
     * @return JsonResponse
     */
    public function store(DishStoreRequest $request, DishService $dishService): JsonResponse
    {
        $dish = $dishService->create($request->validated());

        if ($dish) {
            return response()->json([
                'message' => 'Вы успешно создали блюдо',
                'dish' => new DishResource($dish)
            ]);
        }

        return response()->json([
            'message' => 'Что-то пошло не так.. Повторите попытку позднее!'
        ], 400);
    }

    /**
     * @param Dish $dish
     * @return JsonResponse
     */
    public function show(Dish $dish): JsonResponse
    {
        if ($dish->user_id === Auth::id()) {
            return response()->json([
                'dish' => new DishResource($dish)
            ]);
        }

        return response()->json([
            'message' => 'Недостаточно прав для просмотра'
        ], 403);
    }

    /**
     * @param DishUpdateRequest $request
     * @param Dish $dish
     * @param DishService $dishService
     * @return JsonResponse
     */
    public function update(DishUpdateRequest $request, Dish $dish, DishService $dishService): JsonResponse
    {
        if ($dish->user_id === Auth::id()) {
            if ($dishService->update($dish, $request->validated())) {
                return response()->json([
                    'message' => 'Вы успешно обновили блюдо',
                    'dish' => new DishResource($dish->refresh())
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
     * @param Dish $dish
     * @param DishService $dishService
     * @return JsonResponse
     */
    public function destroy(Dish $dish, DishService $dishService): JsonResponse
    {
        if ($dish->user_id === Auth::id()) {
            if ($dishService->delete($dish)) {
                return response()->json([
                    'message' => 'Вы успешно удалили блюдо'
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
