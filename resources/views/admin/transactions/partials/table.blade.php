<tbody id="table-body">
    @forelse($transactions as $i => $transaction)
    <tr>
        <td><div class="userDatatable-content">{{ $transactions->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $transaction->user->name ?? 'N/A' }}</span>
                <small class="color-light">{{ $transaction->user->email ?? '' }}</small>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge badge-round badge-primary">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content fw-500 color-success">
                Rp {{ number_format($transaction->amount) }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($transaction->status === 'completed')
                    <span class="badge badge-round badge-success">Completed</span>
                @elseif($transaction->status === 'pending')
                    <span class="badge badge-round badge-warning">Pending</span>
                @else
                    <span class="badge badge-round badge-danger">Failed</span>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $transaction->created_at->format('d M Y') }}<br>
                <small class="color-light">{{ $transaction->created_at->format('H:i') }}</small>
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="view" title="View">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center py-30">
            <i class="uil uil-usd-circle fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No transactions found</p>
        </td>
    </tr>
    @endforelse
</tbody>
