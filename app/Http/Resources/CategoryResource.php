<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Category|JsonResource $this */
        $locales = $this->relationLoaded('translations') ?
            $this->translations->pluck('locale')->toArray() : null;

        return [
            'id'                => $this->id,
            'uuid'              => $this->when($this->uuid, $this->uuid),
            'keywords'          => $this->when($this->keywords, $this->keywords),
            'parent_id'         => $this->when($this->parent_id, $this->parent_id),
            'type'              => $this->when($this->type, data_get(Category::TYPES_VALUES, $this->type)),
            'receipts_count'    => $this->when($this->receipts_count, $this->receipts_count),
            'input'             => $this->when($this->input, $this->input),
            'shop_id'           => $this->when($this->shop_id, $this->shop_id),
            'img'               => $this->img,
            'active'            => (bool) $this->active,
            'status'            => $this->when($this->status, $this->status),
            'created_at'        => $this->when($this->created_at, $this->created_at?->format('Y-m-d H:i:s') . 'Z'),
            'updated_at'        => $this->when($this->updated_at, $this->updated_at?->format('Y-m-d H:i:s') . 'Z'),
            'deleted_at'        => $this->when($this->deleted_at, $this->deleted_at?->format('Y-m-d H:i:s') . 'Z'),
            'products_count'    => $this->when($this->products_count, $this->products_count),
            'stocks_count'      => $this->when($this->stocks_count, $this->stocks_count),

            'shop'			    => ShopResource::make($this->whenLoaded('shop')),
            'shop_category'     => ShopCategoryResource::collection($this->whenLoaded('shopCategory')),
            'translation'       => TranslationResource::make($this->whenLoaded('translation')),
            'translations'      => TranslationResource::collection($this->whenLoaded('translations')),
            'locales'           => $this->when($locales, $locales),
            'children'          => CategoryResource::collection($this->whenLoaded('children')),
            'parent'            => CategoryResource::make($this->whenLoaded('parent')),
            'products'          => ProductResource::collection($this->whenLoaded('products')),
            'receipts'          => ReceiptResource::collection($this->whenLoaded('receipts')),
            'stocks'            => StockResource::collection($this->whenLoaded('stocks')),
            'meta_tags'         => MetaTagResource::collection($this->whenLoaded('metaTags')),
            'logs'              => ModelLogResource::collection($this->whenLoaded('logs')),
        ];
    }
}
