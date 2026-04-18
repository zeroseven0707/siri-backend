<div wire:poll.5s>
@if($count > 0)
    <span class="order-badge-count">{{ $count > 99 ? '99+' : $count }}</span>
@endif
</div>
