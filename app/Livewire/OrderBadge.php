<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderBadge extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->count = Order::where('status', 'accepted')->count();
    }

    public function render()
    {
        $this->count = Order::where('status', 'accepted')->count();
        return view('livewire.order-badge');
    }
}
