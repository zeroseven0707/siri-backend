<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function getUserTransactions(string $userId): LengthAwarePaginator
    {
        return Transaction::where('user_id', $userId)
            ->latest()
            ->paginate(15);
    }
}
