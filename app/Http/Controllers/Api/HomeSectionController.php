<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeSectionItemRequest;
use App\Http\Requests\HomeSectionRequest;
use App\Http\Resources\HomeSectionResource;
use App\Models\HomeSection;
use App\Models\HomeSectionItem;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class HomeSectionController extends Controller
{
    use ApiResponse;

    // Public: get all active sections with items (for mobile home page)
    public function index(): JsonResponse
    {
        $sections = HomeSection::with(['items' => fn($q) => $q->where('is_active', true)])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return $this->success(HomeSectionResource::collection($sections));
    }

    // Admin: list all sections (including inactive)
    public function adminIndex(): JsonResponse
    {
        $sections = HomeSection::with('items')->orderBy('order')->get();

        return $this->success(HomeSectionResource::collection($sections));
    }

    // Admin: create section
    public function store(HomeSectionRequest $request): JsonResponse
    {
        $section = HomeSection::create($request->validated());

        return $this->success(new HomeSectionResource($section), 'Section created', 201);
    }

    // Admin: update section
    public function update(HomeSectionRequest $request, string $id): JsonResponse
    {
        $section = HomeSection::find($id);

        if (!$section) {
            return $this->error('Section not found', 404);
        }

        $section->update($request->validated());

        return $this->success(new HomeSectionResource($section->load('items')), 'Section updated');
    }

    // Admin: delete section
    public function destroy(string $id): JsonResponse
    {
        $section = HomeSection::find($id);

        if (!$section) {
            return $this->error('Section not found', 404);
        }

        $section->delete();

        return $this->success(null, 'Section deleted');
    }

    // Admin: reorder sections
    public function reorder(): JsonResponse
    {
        $items = request()->validate([
            'sections'         => 'required|array',
            'sections.*.id'    => 'required|uuid|exists:home_sections,id',
            'sections.*.order' => 'required|integer|min:0',
        ])['sections'];

        foreach ($items as $item) {
            HomeSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return $this->success(null, 'Sections reordered');
    }

    // --- Section Items ---

    public function addItem(HomeSectionItemRequest $request, string $sectionId): JsonResponse
    {
        $section = HomeSection::find($sectionId);

        if (!$section) {
            return $this->error('Section not found', 404);
        }

        $item = $section->items()->create($request->validated());

        return $this->success($item, 'Item added', 201);
    }

    public function updateItem(HomeSectionItemRequest $request, string $sectionId, string $itemId): JsonResponse
    {
        $item = HomeSectionItem::where('home_section_id', $sectionId)->find($itemId);

        if (!$item) {
            return $this->error('Item not found', 404);
        }

        $item->update($request->validated());

        return $this->success($item, 'Item updated');
    }

    public function deleteItem(string $sectionId, string $itemId): JsonResponse
    {
        $item = HomeSectionItem::where('home_section_id', $sectionId)->find($itemId);

        if (!$item) {
            return $this->error('Item not found', 404);
        }

        $item->delete();

        return $this->success(null, 'Item deleted');
    }

    public function reorderItems(string $sectionId): JsonResponse
    {
        $items = request()->validate([
            'items'         => 'required|array',
            'items.*.id'    => 'required|uuid|exists:home_section_items,id',
            'items.*.order' => 'required|integer|min:0',
        ])['items'];

        foreach ($items as $item) {
            HomeSectionItem::where('id', $item['id'])
                ->where('home_section_id', $sectionId)
                ->update(['order' => $item['order']]);
        }

        return $this->success(null, 'Items reordered');
    }
}
