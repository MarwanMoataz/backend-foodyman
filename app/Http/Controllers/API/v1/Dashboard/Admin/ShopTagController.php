<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use App\Helpers\ResponseError;
use App\Http\Requests\FilterParamsRequest;
use App\Http\Requests\ShopTag\StoreRequest;
use App\Http\Resources\ShopTagResource;
use App\Models\ShopTag;
use App\Repositories\ShopTagRepository\ShopTagRepository;
use App\Services\ShopTagService\ShopTagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShopTagController extends AdminBaseController
{
    private ShopTagService $service;
    private ShopTagRepository $repository;

    /**
     * @param ShopTagService $service
     * @param ShopTagRepository $repository
     */
    public function __construct(ShopTagService $service, ShopTagRepository $repository)
    {
        parent::__construct();

        $this->service    = $service;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param FilterParamsRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(FilterParamsRequest $request): AnonymousResourceCollection
    {
        $shopTag = $this->repository->paginate($request->all());

        return ShopTagResource::collection($shopTag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $result = $this->service->create($validated);

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        return $this->successResponse(
            __('web.record_successfully_created'),
            ShopTagResource::make(data_get($result, 'data'))
        );
    }

    /**
     * @param ShopTag $shopTag
     * @return JsonResponse
     */
    public function show(ShopTag $shopTag): JsonResponse
    {
        return $this->successResponse(
            __('web.coupon_found'),
            ShopTagResource::make($this->repository->show($shopTag))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShopTag $shopTag
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function update(ShopTag $shopTag, StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $result = $this->service->update($shopTag, $validated);

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        return $this->successResponse(
            __('web.record_has_been_successfully_updated'),
            ShopTagResource::make(data_get($result, 'data'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FilterParamsRequest $request
     * @return JsonResponse
     */
    public function destroy(FilterParamsRequest $request): JsonResponse
    {
        $result = $this->service->delete($request->input('ids', []));

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse(['code' => ResponseError::ERROR_404]);
        }

        return $this->successResponse(__('web.record_has_been_successfully_delete'));
    }

    /**
     * @return JsonResponse
     */
    public function dropAll(): JsonResponse
    {
        $this->service->dropAll();

        return $this->successResponse(__('web.record_was_successfully_updated'), []);
    }

    /**
     * @return JsonResponse
     */
    public function truncate(): JsonResponse
    {
        $this->service->truncate();

        return $this->successResponse(__('web.record_was_successfully_updated'), []);
    }

    /**
     * @return JsonResponse
     */
    public function restoreAll(): JsonResponse
    {
        $this->service->restoreAll();

        return $this->successResponse(__('web.record_was_successfully_updated'), []);
    }

}
