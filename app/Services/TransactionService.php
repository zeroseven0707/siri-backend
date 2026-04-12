<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(private TransactionRepository $transactionRepo) {}

    public function recordPayment(User $user, Order $order): Transaction
    {
        return $this->transactionRepo->create([
            'user_id'   => $user->id,
            'order_id'  => $order->id,
            'amount'    => $order->price,
            'type'      => 'payment',
            'status'    => 'success',
            'reference' => 'PAY-' . strtoupper(uniqid()),
        ]);
    }
}
