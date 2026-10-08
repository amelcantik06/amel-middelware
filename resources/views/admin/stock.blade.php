@extends('layouts.app')

@section('title', 'Stok masuk')
@section('section', 'Inventaris · Stok masuk')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Pergerakan inventaris</p><h1>Stok masuk</h1><p class="subheading">Catat barang diterima. Jumlah stok dan harga modal akan diperbarui otomatis.</p></div>
        <a class="button secondary" href="{{ route('admin.suppliers.index') }}">Kelola supplier</a>
    </div>
    <section class="content-grid" style="grid-template-columns:minmax(0,1.2fr) minmax(300px,.8fr);align-items:start">
        <article class="card">
            <div class="card-heading"><div><h2>Penerimaan barang</h2><p>Harga modal disimpan sebagai harga pembelian terakhir.</p></div></div>
            @if($products->isEmpty())
                <div class="empty-state">Tambahkan produk sebelum membuat stok masuk.</div>
            @else
                <form action="{{ route('admin.stock.store') }}" method="POST" id="receipt-form">
                    @csrf
                    <div class="form-grid">
                        <div class="form-field"><label for="supplier_id">Supplier</label><select id="supplier_id" name="supplier_id"><option value="">Tidak ditentukan</option>@foreach($suppliers as $supplier)<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>@endforeach</select></div>
                        <div class="form-field"><label for="notes">Catatan</label><input id="notes" name="notes" maxlength="2000" placeholder="Nomor faktur atau catatan"></div>
                    </div>
                    <div class="form-grid" style="grid-template-columns:minmax(0,1fr) 100px 135px auto;align-items:end;margin-top:18px">
                        <div class="form-field"><label for="product-choice">Produk</label><select id="product-choice">@foreach($products as $product)<option value="{{ $product->id }}" data-name="{{ $product->name }}" data-cost="{{ $product->cost_price ?? 0 }}">{{ $product->name }}</option>@endforeach</select></div>
                        <div class="form-field"><label for="quantity-choice">Jumlah</label><input id="quantity-choice" type="number" min="1" step="1" value="1"></div>
                        <div class="form-field"><label for="cost-choice">Modal/unit</label><input id="cost-choice" type="number" min="0" step="1" value="{{ $products->first()->cost_price ?? 0 }}"></div>
                        <button class="button secondary" id="add-receipt-item" type="button">Tambah</button>
                    </div>
                    <p id="receipt-error" class="input-error" role="alert" hidden></p>
                    <div class="table-wrap" style="margin-top:20px"><table><thead><tr><th>Produk</th><th>Jumlah</th><th>Modal/unit</th><th>Subtotal</th><th></th></tr></thead><tbody id="receipt-items"><tr><td colspan="5"><div class="empty-state">Tambahkan produk yang diterima.</div></td></tr></tbody></table></div>
                    <div style="display:flex;justify-content:space-between;padding-top:17px;border-top:1px solid var(--line)"><span>Total modal penerimaan</span><strong class="money" id="receipt-total">Rp 0</strong></div>
                    <button class="button" type="submit" id="save-receipt" style="width:100%;margin-top:18px" disabled>Simpan stok masuk</button>
                </form>
            @endif
        </article>
        <article class="card">
            <div class="card-heading"><div><h2>Penerimaan terbaru</h2><p>Riwayat perubahan stok yang tercatat.</p></div></div>
            <div class="table-wrap"><table>
                <thead><tr><th>Nomor / waktu</th><th>Supplier</th><th>Nilai</th></tr></thead>
                <tbody>
                @forelse($receipts as $receipt)
                    <tr><td class="cell-title">{{ $receipt->receipt_number }}<div class="cell-muted">{{ $receipt->created_at->format('d/m/Y H:i') }} · {{ $receipt->items_count }} item</div><div class="cell-muted">{{ $receipt->items->map(fn ($item) => $item->product_name.' × '.$item->quantity)->implode(', ') }}</div></td><td>{{ $receipt->supplier?->name ?? '—' }}<div class="cell-muted">oleh {{ $receipt->receiver->name }}</div></td><td class="money">Rp {{ number_format($receipt->total_cost, 0, ',', '.') }}</td></tr>
                @empty<tr><td colspan="3"><div class="empty-state">Belum ada stok masuk.</div></td></tr>@endforelse
                </tbody>
            </table></div>
            @if($receipts->hasPages())<div class="pagination">{{ $receipts->links() }}</div>@endif
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const productChoice = document.getElementById('product-choice');
    if (productChoice) {
        const receiptItems = new Map();
        const tableBody = document.getElementById('receipt-items');
        const error = document.getElementById('receipt-error');
        const saveButton = document.getElementById('save-receipt');
        const fmt = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        productChoice.addEventListener('change', () => {
            document.getElementById('cost-choice').value = productChoice.selectedOptions[0].dataset.cost;
        });
        function drawReceipt() {
            tableBody.replaceChildren();
            let total = 0;
            let index = 0;
            for (const [id, item] of receiptItems) {
                const subtotal = item.quantity * item.cost;
                total += subtotal;
                const row = document.createElement('tr');
                for (const value of [item.name, String(item.quantity), fmt(item.cost), fmt(subtotal)]) {
                    const cell = document.createElement('td');
                    cell.textContent = value;
                    row.append(cell);
                }
                row.children[0].className = 'cell-title';
                row.children[3].className = 'money';
                const action = document.createElement('td');
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'button danger small';
                remove.textContent = 'Hapus';
                remove.addEventListener('click', () => { receiptItems.delete(id); drawReceipt(); });
                action.append(remove);
                row.append(action);
                for (const [name, value] of [['product_id', id], ['quantity', item.quantity], ['unit_cost', item.cost]]) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = `items[${index}][${name}]`;
                    hidden.value = value;
                    row.append(hidden);
                }
                tableBody.append(row);
                index++;
            }
            if (receiptItems.size === 0) {
                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.colSpan = 5;
                cell.className = 'empty-state';
                cell.textContent = 'Tambahkan produk yang diterima.';
                row.append(cell);
                tableBody.append(row);
            }
            document.getElementById('receipt-total').textContent = fmt(total);
            saveButton.disabled = receiptItems.size === 0;
            saveButton.style.opacity = saveButton.disabled ? '.55' : '1';
        }
        document.getElementById('add-receipt-item').addEventListener('click', () => {
            const option = productChoice.selectedOptions[0];
            const quantity = Number(document.getElementById('quantity-choice').value);
            const cost = Number(document.getElementById('cost-choice').value);
            if (!Number.isInteger(quantity) || quantity < 1 || !Number.isInteger(cost) || cost < 0) {
                error.textContent = 'Jumlah dan harga modal harus berupa angka yang valid.';
                error.hidden = false;
                return;
            }
            const id = option.value;
            const existing = receiptItems.get(id);
            receiptItems.set(id, {
                name: option.dataset.name,
                quantity: quantity + (existing?.quantity || 0),
                cost
            });
            error.hidden = true;
            drawReceipt();
        });
        drawReceipt();
    }
</script>
@endpush
