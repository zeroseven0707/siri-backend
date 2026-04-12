<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __construct(private TransactionRepository $transactionRepo) {}

    public function index(Request $request): JsonResponse
    {
        $transactions = $this->transactionRepo->getUserTransactions($request->user()->id);

        return $this->success([
            'transactions' => TransactionResource::collection($transactions),
            'pagination'   => [
                'current_page' => $transactions->currentPage(),
                'last_page'    => $transactions->lastPage(),
                'per_page'     => $transactions->perPage(),
                'total'        => $transactions->total(),
            ],
        ]);
    }
}
