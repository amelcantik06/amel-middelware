@extends('layouts.app')

@section('title', 'Transaksi Kasir')
@section('section', 'Kasir · Transaksi pembayaran')

@push('styles')
<style>
    .pos-heading { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:18px; }
    .pos-heading h1 { margin-bottom:5px; font-size:32px; }
    .pos-invoice { color:var(--muted); font-size:11px; text-align:right; }
    .pos-invoice strong { display:block; margin-top:4px; color:var(--ink); font-size:13px; }
    .pos-store { display:flex; justify-content:space-between; align-items:center; gap:20px; margin-bottom:13px; padding:4px 2px; }
    .pos-store-name { font-weight:800; letter-spacing:.08em; }
    .pos-store-address { margin-top:4px; color:var(--muted); font-size:11px; }
    .pos-layout { display:grid; grid-template-columns:minmax(0,1fr) 310px; gap:14px; align-items:start; }
    .pos-main { display:grid; gap:13px; }
    .pos-panel { padding:18px; border:1px solid var(--line); border-radius:12px; background:#fff; box-shadow:var(--shadow); }
    .pos-label { display:block; margin-bottom:8px; color:#536259; font-size:11px; font-weight:750; }
    .pos-search-row { display:grid; grid-template-columns:minmax(0,1fr) 86px; gap:8px; }
    .pos-search { height:42px; padding:0 13px; border:1px solid #dce4dd; border-radius:8px; outline:0; }
    .pos-search:focus { border-color:#67917c; box-shadow:0 0 0 3px rgb(25 91 72 / 9%); }
    .pos-customer-row { display:grid; grid-template-columns:minmax(0,1fr) minmax(0,1fr); gap:10px; margin-top:13px; }
    .pos-products { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:8px; margin-top:11px; }
    .pos-product { display:flex; justify-content:space-between; align-items:center; gap:10px; min-width:0; padding:9px 10px; border:1px solid #e8ede8; border-radius:9px; background:#fbfcfa; }
    .pos-product-name { overflow:hidden; font-size:11px; font-weight:700; text-overflow:ellipsis; white-space:nowrap; }
    .pos-product-meta { margin-top:4px; color:var(--muted); font-size:10px; }
    .pos-product-add { flex:0 0 auto; width:29px; height:29px; border:0; border-radius:7px; background:#eaf3ea; color:var(--green); cursor:pointer; font-size:18px; font-weight:700; }
    .pos-product-add:hover { background:#dcebdc; }
    .pos-cart-heading { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
    .pos-cart-heading h2 { font-size:19px; }
    .pos-count { color:var(--muted); font-size:11px; }
    .pos-cart-table th { padding:9px 8px; }
    .pos-cart-table td { padding:9px 8px; }
    .pos-qty { width:74px; height:34px; padding:0 6px; border:1px solid #dce4dd; border-radius:6px; text-align:center; }
    .pos-remove { border:0; background:transparent; color:#a54b43; cursor:pointer; font-size:11px; font-weight:700; }
    .pos-empty { padding:26px 12px; color:var(--muted); text-align:center; font-size:12px; }
    .pos-payment { position:sticky; top:16px; padding:17px; border:1px solid var(--line); border-radius:12px; background:#fff; box-shadow:var(--shadow); }
    .pos-payment h2 { margin:0 0 14px; font-family:inherit; font-size:13px; font-weight:800; letter-spacing:.05em; text-transform:uppercase; }
    .pos-summary { display:grid; gap:10px; }
    .pos-summary-row { display:grid; grid-template-columns:minmax(0,1fr) 112px; align-items:center; gap:8px; color:#64736a; font-size:11px; }
    .pos-summary-row strong { color:var(--ink); font-size:11px; text-align:right; }
    .pos-summary-row .pos-mini-input { width:100%; height:31px; padding:0 8px; border:1px solid #e0e6e0; border-radius:6px; text-align:right; }
    .pos-summary-total { display:flex; justify-content:space-between; align-items:center; margin:14px -2px 0; padding:13px 12px; border-radius:8px; background:#f3f4f9; }
    .pos-summary-total span { color:#657168; font-size:11px; font-weight:700; }
    .pos-summary-total strong { color:#153f33; font-family:Georgia,serif; font-size:22px; }
    .pos-cash-box { margin-top:12px; padding:13px; border:1px solid #d8e6ef; border-radius:9px; background:#f3f8fc; }
    .pos-cash-box label { display:block; margin:0 0 7px; color:#536778; font-size:11px; font-weight:750; }
    .pos-cash-input { width:100%; height:39px; padding:0 10px; border:1px solid #c9dce9; border-radius:7px; outline:0; text-align:right; font-weight:700; }
    .pos-change { display:flex; justify-content:space-between; align-items:center; margin-top:10px; padding:10px; border-radius:7px; background:#eaf5ed; color:#41664f; font-size:11px; }
    .pos-change strong { color:#205336; font-size:15px; }
    .pos-methods { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:6px; margin-top:13px; }
    .pos-method { min-height:32px; border:1px solid #e1e7e1; border-radius:6px; background:#fff; color:#58675e; cursor:pointer; font-size:10px; font-weight:700; }
    .pos-method.active { border-color:#236d55; background:#e9f3eb; color:#18513e; }
    .pos-actions { display:grid; grid-template-columns:1fr 1fr; gap:7px; margin-top:13px; }
    .pos-actions .button { min-height:37px; padding:0 8px; font-size:10px; }
    .pos-actions .pay-button { grid-column:1/-1; min-height:42px; background:#1d7952; font-size:11px; }
    .pos-actions .pay-button:disabled { cursor:not-allowed; opacity:.55; transform:none; }
    .pos-error { margin-top:9px; color:#a3382c; font-size:10px; line-height:1.45; }
    .pos-error:empty { display:none; }
    .pos-parked { margin-top:13px; }
    .pos-parked summary { color:var(--green); cursor:pointer; font-size:11px; font-weight:700; }
    .pos-parked-list { display:grid; gap:6px; margin-top:8px; }
    .pos-parked-item { display:flex; justify-content:space-between; align-items:center; gap:8px; padding:8px; border:1px solid var(--line); border-radius:7px; font-size:10px; }
    @media(max-width:1050px) { .pos-layout { grid-template-columns:minmax(0,1fr) 285px; } .pos-products { grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); } }
    @media(max-width:760px) {
        .pos-layout { grid-template-columns:1fr; }
        .pos-payment { position:static; }
        .pos-heading h1 { font-size:27px; }
        .pos-store { align-items:flex-start; }
        .pos-products { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .pos-customer-row { grid-template-columns:1fr; }
    }
    @media print {
        .pos-heading,.pos-store,.pos-entry,.pos-payment,.no-print { display:none!important; }
        .pos-layout { display:block; }
        .pos-main { display:block; }
        .pos-panel { border:0; box-shadow:none; padding:0; }
    }
</style>
@endpush

@section('content')
    <div class="pos-heading">
        <div><p class="eyebrow">Ruang kerja kasir</p><h1>Transaksi pembayaran</h1><p class="subheading">Cari barang, lengkapi pembayaran, lalu cetak struk.</p></div>
        <div style="display:flex;align-items:center;gap:8px">
            <a class="button secondary no-print" href="{{ route('kasir.transactions') }}">◷ Riwayat transaksi</a>
            <div class="pos-invoice">Preview no. transaksi<strong id="invoice-preview">{{ $invoicePreview }}</strong></div>
        </div>
    </div>

    <div class="pos-store">
        <div><div class="pos-store-name">{{ config('app.name', 'MINIMARKET') }}</div><div class="pos-store-address">Kasir: {{ auth()->user()->name }} · {{ now()->locale('id')->translatedFormat('d F Y, H:i') }}</div></div>
        <div style="display:flex;gap:15px;color:var(--muted);font-size:11px"><span>{{ number_format($todaySales, 0, ',', '.') }} transaksi hari ini</span><span>Omzet Rp {{ number_format($todayRevenue, 0, ',', '.') }}</span></div>
    </div>

    @if($products->isEmpty())
        <section class="card"><div class="empty-state">Belum ada produk dengan stok tersedia. Hubungi admin untuk memperbarui inventaris.</div></section>
    @else
        <form id="sale-form" action="{{ route('kasir.sales.store') }}" method="POST">
            @csrf
            <input type="hidden" name="invoice_number" value="{{ $invoicePreview }}">
            <div class="pos-layout">
                <div class="pos-main">
                    <section class="pos-panel pos-entry">
                        <label class="pos-label" for="product-search">Tambah barang · cari nama / kode / barcode</label>
                        <div class="pos-search-row">
                            <input class="pos-search" id="product-search" type="search" autocomplete="off" placeholder="Cari barang atau pindai barcode..." aria-label="Cari barang berdasarkan nama, kode, atau barcode">
                            <button class="button" id="search-button" type="button">Cari</button>
                        </div>
                        <div class="pos-products" id="product-results" aria-live="polite"></div>
                        <div class="pos-customer-row">
                            <div class="form-field"><label for="customer-name">Pelanggan</label><input class="input" id="customer-name" name="customer_name" value="{{ old('customer_name') }}" maxlength="255" placeholder="Umum"></div>
                            <div class="form-field"><label for="customer-reference">No. Member / HP</label><input class="input" id="customer-reference" name="customer_reference" value="{{ old('customer_reference') }}" maxlength="100" placeholder="Opsional"></div>
                        </div>
                    </section>

                    <section class="pos-panel">
                        <div class="pos-cart-heading"><h2>Keranjang belanja</h2><span class="pos-count"><span id="cart-count">0</span> item</span></div>
                        <div class="table-wrap">
                            <table class="pos-cart-table">
                                <thead><tr><th style="width:34px">No.</th><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                                <tbody id="cart-items"><tr><td class="pos-empty" colspan="6">Keranjang masih kosong. Cari atau pindai barang untuk mulai.</td></tr></tbody>
                            </table>
                        </div>
                    </section>
                    <div class="pos-error" id="sale-error" role="alert" aria-live="polite">@if($errors->any()){{ $errors->first() }}@endif</div>
                </div>

                <aside class="pos-payment">
                    <h2>Ringkasan pembayaran</h2>
                    <div class="pos-summary">
                        <div class="pos-summary-row"><span>Total item</span><strong id="total-items">0</strong></div>
                        <div class="pos-summary-row"><span>Subtotal</span><strong id="subtotal-display">Rp 0</strong></div>
                        <div class="pos-summary-row"><label for="discount-percent">Diskon (%)</label><input class="pos-mini-input" id="discount-percent" name="discount_percent" type="number" min="0" max="100" step="0.01" value="{{ old('discount_percent', 0) }}"></div>
                        <div class="pos-summary-row"><label for="discount-amount">Diskon (Rp)</label><input class="pos-mini-input" id="discount-amount" name="discount_amount" type="number" min="0" step="1" value="{{ old('discount_amount', 0) }}"></div>
                        <div class="pos-summary-row"><label for="tax-amount">Pajak / PPN</label><input class="pos-mini-input" id="tax-amount" name="tax_amount" type="number" min="0" step="1" value="{{ old('tax_amount', 0) }}"></div>
                        <div class="pos-summary-row"><label for="additional-fee">Biaya lain</label><input class="pos-mini-input" id="additional-fee" name="additional_fee" type="number" min="0" step="1" value="{{ old('additional_fee', 0) }}"></div>
                    </div>
                    <div class="pos-summary-total"><span>Total akhir</span><strong id="grand-total">Rp 0</strong></div>

                    <div class="pos-cash-box">
                        <label for="amount-paid">Uang dibayar</label>
                        <input class="pos-cash-input" id="amount-paid" name="amount_paid" type="number" min="0" step="1" value="{{ old('amount_paid', 0) }}" required>
                        <div class="pos-change"><span>Kembalian</span><strong id="change-due">Rp 0</strong></div>
                    </div>

                    <div style="margin-top:13px;color:#536259;font-size:11px;font-weight:750">Metode pembayaran</div>
                    <input type="hidden" name="payment_method" id="payment-method" value="{{ old('payment_method', 'cash') }}">
                    <div class="pos-methods">
                        <button class="pos-method active" type="button" data-method="cash">Tunai</button>
                        <button class="pos-method" type="button" data-method="qris">QRIS</button>
                        <button class="pos-method" type="button" data-method="debit">Debit</button>
                        <button class="pos-method" type="button" data-method="credit">Kredit</button>
                        <button class="pos-method" type="button" data-method="e_wallet">E-Wallet</button>
                        <button class="pos-method" type="button" data-method="transfer">Transfer</button>
                    </div>

                    <div class="pos-actions">
                        <button class="button secondary" id="park-sale" type="button">Tahan</button>
                        <button class="button danger" id="clear-sale" type="button">Batal</button>
                        <button class="button pay-button" id="checkout" type="submit" disabled>Bayar & cetak</button>
                    </div>
                    <details class="pos-parked no-print">
                        <summary>Transaksi ditahan <span id="parked-count">0</span></summary>
                        <div class="pos-parked-list" id="parked-list"></div>
                    </details>
                </aside>
            </div>
        </form>
    @endif
@endsection

@push('scripts')
<script>
    const products = @json($productData);

    const searchInput = document.getElementById('product-search');
    if (searchInput) {
        const cart = new Map();
        const cartBody = document.getElementById('cart-items');
        const resultContainer = document.getElementById('product-results');
        const amountPaid = document.getElementById('amount-paid');
        const discountPercent = document.getElementById('discount-percent');
        const discountAmount = document.getElementById('discount-amount');
        const taxAmount = document.getElementById('tax-amount');
        const additionalFee = document.getElementById('additional-fee');
        const checkout = document.getElementById('checkout');
        const saleError = document.getElementById('sale-error');
        const paymentMethod = document.getElementById('payment-method');
        const formatMoney = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        const parkedKey = 'minimarket:parked-sales:v1:{{ auth()->id() }}';

        function selectedProducts() {
            const term = searchInput.value.trim().toLocaleLowerCase('id-ID');
            const filtered = products.filter((product) =>
                !term || product.name.toLocaleLowerCase('id-ID').includes(term)
                || String(product.barcode || '').toLocaleLowerCase('id-ID').includes(term)
                || String(product.category || '').toLocaleLowerCase('id-ID').includes(term)
                || String(product.id) === term
            );
            return { filtered, term };
        }

        function addProduct(product) {
            const current = cart.get(String(product.id));
            if (current && current.quantity >= product.stock) {
                saleError.textContent = `Stok ${product.name} hanya ${product.stock} unit.`;
                return;
            }
            cart.set(String(product.id), { ...product, quantity: (current?.quantity || 0) + 1 });
            saleError.textContent = '';
            renderCart();
        }

        function renderProducts() {
            const { filtered, term } = selectedProducts();
            resultContainer.replaceChildren();
            for (const product of filtered.slice(0, 8)) {
                const card = document.createElement('div');
                card.className = 'pos-product';
                const details = document.createElement('div');
                details.style.minWidth = '0';
                const name = document.createElement('div');
                name.className = 'pos-product-name';
                name.textContent = product.name;
                const meta = document.createElement('div');
                meta.className = 'pos-product-meta';
                meta.textContent = `${formatMoney(product.price)} · stok ${product.stock}`;
                details.append(name, meta);
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'pos-product-add';
                button.textContent = '+';
                button.setAttribute('aria-label', `Tambah ${product.name}`);
                button.addEventListener('click', () => addProduct(product));
                card.append(details, button);
                resultContainer.append(card);
            }
            if (filtered.length === 0) {
                const noResult = document.createElement('span');
                noResult.className = 'cell-muted';
                noResult.textContent = 'Barang tidak ditemukan.';
                resultContainer.append(noResult);
            } else if (filtered.length > 8) {
                const hint = document.createElement('span');
                hint.className = 'cell-muted';
                hint.textContent = `${filtered.length - 8} barang lainnya. Persempit pencarian.`;
                resultContainer.append(hint);
            }
        }

        function renderCart() {
            cartBody.replaceChildren();
            let subtotal = 0;
            let itemCount = 0;
            let index = 0;
            for (const [id, item] of cart) {
                const lineTotal = item.price * item.quantity;
                subtotal += lineTotal;
                itemCount += item.quantity;
                const row = document.createElement('tr');
                const numberCell = document.createElement('td');
                numberCell.textContent = String(index + 1);
                const nameCell = document.createElement('td');
                const name = document.createElement('strong');
                name.className = 'cell-title';
                name.textContent = item.name;
                const barcode = document.createElement('div');
                barcode.className = 'cell-muted';
                barcode.textContent = item.barcode || `ID ${item.id}`;
                nameCell.append(name, barcode);
                const priceCell = document.createElement('td');
                priceCell.textContent = formatMoney(item.price);
                const quantityCell = document.createElement('td');
                const quantityControls = document.createElement('div');
                quantityControls.style.display = 'flex';
                quantityControls.style.alignItems = 'center';
                quantityControls.style.gap = '3px';
                for (const [label, delta] of [['−', -1], ['+', 1]]) {
                    const control = document.createElement('button');
                    control.type = 'button';
                    control.className = 'pos-product-add';
                    control.style.width = '24px';
                    control.style.height = '28px';
                    control.textContent = label;
                    control.setAttribute('aria-label', `${delta < 0 ? 'Kurangi' : 'Tambah'} ${item.name}`);
                    control.addEventListener('click', () => {
                        const next = item.quantity + delta;
                        if (next < 1) {
                            cart.delete(id);
                        } else if (next <= item.stock) {
                            item.quantity = next;
                        }
                        renderCart();
                    });
                    quantityControls.append(control);
                    if (delta < 0) {
                        const quantity = document.createElement('input');
                        quantity.type = 'number';
                        quantity.className = 'pos-qty';
                        quantity.min = '1';
                        quantity.max = String(item.stock);
                        quantity.value = String(item.quantity);
                        quantity.setAttribute('aria-label', `Jumlah ${item.name}`);
                        quantity.addEventListener('change', () => {
                            const next = Number(quantity.value);
                            if (!Number.isInteger(next) || next < 1 || next > item.stock) {
                                quantity.value = String(item.quantity);
                                saleError.textContent = `Jumlah ${item.name} harus antara 1 dan ${item.stock}.`;
                                return;
                            }
                            item.quantity = next;
                            saleError.textContent = '';
                            renderCart();
                        });
                        quantityControls.append(quantity);
                    }
                }
                quantityCell.append(quantityControls);
                const subtotalCell = document.createElement('td');
                subtotalCell.className = 'money';
                subtotalCell.textContent = formatMoney(lineTotal);
                const removeCell = document.createElement('td');
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'pos-remove';
                remove.textContent = 'Hapus';
                remove.setAttribute('aria-label', `Hapus ${item.name}`);
                remove.addEventListener('click', () => { cart.delete(id); renderCart(); });
                removeCell.append(remove);
                row.append(numberCell, nameCell, priceCell, quantityCell, subtotalCell, removeCell);
                for (const [field, value] of [['product_id', id], ['quantity', item.quantity]]) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = `products[${index}][${field}]`;
                    hidden.value = value;
                    row.append(hidden);
                }
                cartBody.append(row);
                index++;
            }
            if (cart.size === 0) {
                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.className = 'pos-empty';
                cell.colSpan = 6;
                cell.textContent = 'Keranjang masih kosong. Cari atau pindai barang untuk mulai.';
                row.append(cell);
                cartBody.append(row);
            }

            const percent = Number(discountPercent.value || 0);
            const fixedDiscount = Number(discountAmount.value || 0);
            const percentDiscount = Math.round(subtotal * percent / 100);
            const totalDiscount = percentDiscount + fixedDiscount;
            const tax = Number(taxAmount.value || 0);
            const fee = Number(additionalFee.value || 0);
            const total = Math.max(0, subtotal - totalDiscount + tax + fee);
            const paid = Number(amountPaid.value || 0);
            document.getElementById('cart-count').textContent = String(itemCount);
            document.getElementById('total-items').textContent = String(itemCount);
            document.getElementById('subtotal-display').textContent = formatMoney(subtotal);
            document.getElementById('grand-total').textContent = formatMoney(total);
            document.getElementById('change-due').textContent = formatMoney(Math.max(0, paid - total));
            checkout.disabled = cart.size === 0;
            checkout.dataset.total = String(total);
            checkout.style.opacity = checkout.disabled ? '.55' : '1';
        }

        function searchAndAddExactBarcode() {
            const term = searchInput.value.trim().toLocaleLowerCase('id-ID');
            const product = products.find((candidate) => candidate.barcode && candidate.barcode.toLocaleLowerCase('id-ID') === term);
            if (!product) return false;
            addProduct(product);
            searchInput.value = '';
            renderProducts();
            return true;
        }

        document.getElementById('search-button').addEventListener('click', () => {
            if (!searchAndAddExactBarcode()) renderProducts();
        });
        searchInput.addEventListener('input', renderProducts);
        searchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                if (searchAndAddExactBarcode()) return;
                const { filtered } = selectedProducts();
                if (filtered.length === 1) {
                    addProduct(filtered[0]);
                    searchInput.value = '';
                    renderProducts();
                } else {
                    renderProducts();
                }
            }
        });

        document.querySelectorAll('[data-method]').forEach((button) => {
            button.classList.toggle('active', button.dataset.method === paymentMethod.value);
            button.addEventListener('click', () => {
                paymentMethod.value = button.dataset.method;
                document.querySelectorAll('[data-method]').forEach((item) => item.classList.toggle('active', item === button));
            });
        });

        for (const input of [discountPercent, discountAmount, taxAmount, additionalFee, amountPaid]) {
            input.addEventListener('input', renderCart);
        }

        function clearCurrentSale() {
            cart.clear();
            document.getElementById('customer-name').value = '';
            document.getElementById('customer-reference').value = '';
            for (const input of [discountPercent, discountAmount, taxAmount, additionalFee, amountPaid]) input.value = '0';
            paymentMethod.value = 'cash';
            document.querySelectorAll('[data-method]').forEach((button) => button.classList.toggle('active', button.dataset.method === 'cash'));
            saleError.textContent = '';
            renderCart();
        }

        document.getElementById('clear-sale').addEventListener('click', () => {
            if (cart.size > 0 && !window.confirm('Batalkan dan kosongkan transaksi ini?')) return;
            clearCurrentSale();
        });

        function readParked() {
            try {
                const saved = JSON.parse(localStorage.getItem(parkedKey) || '[]');
                return Array.isArray(saved) ? saved.filter((item) => item && Array.isArray(item.items)) : [];
            } catch (error) {
                saleError.textContent = 'Data transaksi tertahan tidak dapat dibaca dari perangkat ini.';
                return [];
            }
        }

        function drawParked() {
            const list = document.getElementById('parked-list');
            const saved = readParked();
            document.getElementById('parked-count').textContent = String(saved.length);
            list.replaceChildren();
            for (const [index, parked] of saved.entries()) {
                const row = document.createElement('div');
                row.className = 'pos-parked-item';
                const name = document.createElement('span');
                name.textContent = `${parked.customer || 'Pelanggan'} · ${parked.items.length} produk`;
                const resume = document.createElement('button');
                resume.type = 'button';
                resume.className = 'button secondary small';
                resume.textContent = 'Lanjutkan';
                resume.addEventListener('click', () => {
                    if (cart.size > 0 && !window.confirm('Ganti keranjang saat ini dengan transaksi tertahan?')) return;
                    cart.clear();
                    for (const item of parked.items) {
                        const product = products.find((candidate) => String(candidate.id) === String(item.id));
                        if (product && item.quantity <= product.stock) cart.set(String(product.id), { ...product, quantity: item.quantity });
                    }
                    document.getElementById('customer-name').value = parked.customer || '';
                    document.getElementById('customer-reference').value = parked.reference || '';
                    discountPercent.value = parked.discountPercent || '0';
                    discountAmount.value = parked.discountAmount || '0';
                    taxAmount.value = parked.taxAmount || '0';
                    additionalFee.value = parked.additionalFee || '0';
                    amountPaid.value = parked.amountPaid || '0';
                    paymentMethod.value = parked.paymentMethod || 'cash';
                    document.querySelectorAll('[data-method]').forEach((button) => button.classList.toggle('active', button.dataset.method === paymentMethod.value));
                    const remaining = saved.filter((_, itemIndex) => itemIndex !== index);
                    localStorage.setItem(parkedKey, JSON.stringify(remaining));
                    drawParked();
                    renderCart();
                    if (cart.size !== parked.items.length) {
                        saleError.textContent = 'Sebagian barang pada transaksi tertahan tidak tersedia lagi atau stoknya berubah.';
                    }
                });
                row.append(name, resume);
                list.append(row);
            }
        }

        document.getElementById('park-sale').addEventListener('click', () => {
            if (cart.size === 0) {
                saleError.textContent = 'Tambahkan barang sebelum menahan transaksi.';
                return;
            }
            const saved = readParked();
            saved.push({
                customer: document.getElementById('customer-name').value,
                reference: document.getElementById('customer-reference').value,
                discountPercent: discountPercent.value,
                discountAmount: discountAmount.value,
                taxAmount: taxAmount.value,
                additionalFee: additionalFee.value,
                amountPaid: amountPaid.value,
                paymentMethod: paymentMethod.value,
                items: [...cart.entries()].map(([id, item]) => ({ id, quantity: item.quantity })),
            });
            try {
                localStorage.setItem(parkedKey, JSON.stringify(saved));
                clearCurrentSale();
                drawParked();
            } catch (error) {
                saleError.textContent = 'Transaksi tidak dapat ditahan. Penyimpanan browser penuh atau tidak tersedia.';
            }
        });

        document.getElementById('sale-form').addEventListener('submit', (event) => {
            const subtotal = [...cart.values()].reduce((sum, item) => sum + item.price * item.quantity, 0);
            const discounts = Math.round(subtotal * Number(discountPercent.value || 0) / 100) + Number(discountAmount.value || 0);
            const total = subtotal - discounts + Number(taxAmount.value || 0) + Number(additionalFee.value || 0);
            if (cart.size === 0 || discounts > subtotal || !Number.isSafeInteger(total) || Number(amountPaid.value) < total) {
                event.preventDefault();
                saleError.textContent = cart.size === 0
                    ? 'Keranjang masih kosong.'
                    : discounts > subtotal
                        ? 'Total diskon tidak boleh melebihi subtotal.'
                        : 'Uang dibayar kurang dari total akhir.';
                return;
            }
            checkout.disabled = true;
            checkout.textContent = 'Memproses pembayaran...';
        });

        renderProducts();
        for (const previous of @json(old('products', []))) {
            const product = products.find((candidate) => String(candidate.id) === String(previous.product_id));
            const quantity = Number(previous.quantity);
            if (product && Number.isInteger(quantity) && quantity > 0 && quantity <= product.stock) {
                cart.set(String(product.id), { ...product, quantity });
            }
        }
        renderCart();
        drawParked();
    }
</script>
@endpush
