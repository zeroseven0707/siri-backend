<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTable extends Component
{
    use WithPagination;

    public string $activeTab = 'accepted';
    public string $search = '';

    protected $queryString = [
        'activeTab' => ['except' => 'accepted'],
        'search'    => ['except' => ''],
    ];

    // Reset halaman saat filter berubah
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedActiveTab(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $statusOrder = ['accepted', 'pending', 'on_progress', 'completed', 'cancelled'];

        $query = Order::with(['user', 'driver', 'foodItems.foodItem.store', 'service'])
            ->when($this->search, function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $this->search . '%'));
            })
            ->where('status', $this->activeTab)
            ->orderBy('updated_at', 'asc');

        $orders = $query->paginate(15);

        $counts = [
            'accepted'    => Order::where('status', 'accepted')->count(),
            'pending'     => Order::where('status', 'pending')->count(),
            'on_progress' => Order::where('status', 'on_progress')->count(),
            'completed'   => Order::where('status', 'completed')->count(),
            'cancelled'   => Order::where('status', 'cancelled')->count(),
        ];

        return view('livewire.orders-table', compact('orders', 'counts'));
    }
}
