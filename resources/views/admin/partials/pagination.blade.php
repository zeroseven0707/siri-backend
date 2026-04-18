@php
    // Support both $data and named variables
    $paginator = $data ?? $users ?? $orders ?? $stores ?? $services ?? $sections ?? $notifications ?? $transactions ?? $requests ?? null;
@endphp

@if($paginator && $paginator->hasPages())
<div class="d-flex justify-content-between align-items-center pt-20 flex-wrap gap-2">
    <div class="color-light fs-13">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
    </div>
    <ul class="dm-pagination d-flex mb-0">
        {{-- Previous --}}
        <li class="dm-pagination__item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() ?? '#' }}" class="dm-pagination__link {{ !$paginator->onFirstPage() ? 'pagination-ajax' : '' }}" data-page="{{ $paginator->currentPage() - 1 }}">
                <span class="la la-angle-left"></span>
            </a>
        </li>

        {{-- Pages --}}
        @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
            <li class="dm-pagination__item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                <a href="{{ $url }}" class="dm-pagination__link {{ $page != $paginator->currentPage() ? 'pagination-ajax' : '' }}" data-page="{{ $page }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Next --}}
        <li class="dm-pagination__item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a href="{{ $paginator->nextPageUrl() ?? '#' }}" class="dm-pagination__link {{ $paginator->hasMorePages() ? 'pagination-ajax' : '' }}" data-page="{{ $paginator->currentPage() + 1 }}">
                <span class="la la-angle-right"></span>
            </a>
        </li>
    </ul>
</div>
@endif
