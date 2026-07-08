@extends('restaurant.pos.layouts.app')

@section('body_class', 'pos-body--billing')

@section('title', 'Order ' . $order->order_number)

@push('styles')
<style>
.pos-billing-page { margin: -1rem; height: calc(100vh - 52px); display: flex; flex-direction: column; overflow: hidden; }
.pos-billing-header { flex-shrink: 0; padding: .75rem 1rem; background: #fff; border-bottom: 1px solid #e2e8f0; }
.pos-billing-body { flex: 1; display: flex; min-height: 0; overflow: hidden; }

.pos-menu-sidebar { width: 180px; flex-shrink: 0; background: #1e293b; overflow-y: auto; padding: .5rem; display: flex; flex-direction: column; gap: .35rem; }
.pos-menu-sidebar__title { color: #94a3b8; font-size: .7rem; text-transform: uppercase; letter-spacing: .05em; padding: .5rem .75rem .25rem; }
.pos-category-btn { border: none; background: #334155; color: #e2e8f0; text-align: left; padding: .75rem 1rem; border-radius: .375rem; font-weight: 600; font-size: .875rem; cursor: pointer; transition: background .15s; min-height: 44px; }
.pos-category-btn:hover { background: #475569; color: #fff; }
.pos-category-btn.active { background: #0ea5e9; color: #fff; }

.pos-item-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; background: #f1f5f9; border-right: 1px solid #e2e8f0; }
.pos-item-panel__toolbar { padding: .75rem 1rem; background: #fff; border-bottom: 1px solid #e2e8f0; }
.pos-item-grid { flex: 1; overflow-y: auto; padding: 1rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: .75rem; align-content: start; }
.pos-item-card { position: relative; border: 1px solid #e2e8f0; background: #fff; border-radius: .5rem; padding: .75rem .75rem .75rem 1rem; text-align: left; cursor: pointer; min-height: 80px; display: flex; flex-direction: column; justify-content: space-between; transition: box-shadow .15s, transform .1s; }
.pos-item-card:hover:not(:disabled) { box-shadow: 0 4px 12px rgba(0,0,0,.1); transform: translateY(-1px); }
.pos-item-card:disabled { opacity: .6; cursor: not-allowed; }
.pos-item-card.loading { opacity: .5; pointer-events: none; }
.pos-item-card--veg { border-left: 4px solid #22c55e; }
.pos-item-card--nonveg { border-left: 4px solid #ef4444; }
.pos-item-card--egg { border-left: 4px solid #d97706; }
.pos-item-card__food-type { position: absolute; top: .45rem; right: .45rem; line-height: 0; }
.pos-item-card__name { font-weight: 600; font-size: .875rem; line-height: 1.3; padding-right: 1rem; }
.pos-item-card__price { font-size: .8rem; color: #64748b; margin-top: .25rem; }
.pos-item-card.hidden { display: none; }
.pos-item-grid__empty { grid-column: 1 / -1; text-align: center; padding: 2rem; }

.pos-cart-panel { width: min(46vw, 560px); min-width: 480px; flex-shrink: 0; display: flex; flex-direction: column; overflow: hidden; border-left: 1px solid #e2e8f0 !important; box-shadow: -8px 0 30px rgba(15,23,42,.06); background: #fff; }
.pos-cart-panel__header { background: linear-gradient(180deg, #fff 0%, #f8fafc 100%); border-bottom: 1px solid #e2e8f0 !important; flex-shrink: 0; }
.pos-cart-panel__icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(var(--primary-rgb, 255, 97, 117), .12); color: var(--primary, #ff6175); display: flex; align-items: center; justify-content: center; font-size: .85rem; }
.pos-cart-panel__count { font-size: .7rem; padding: .3em .55em; }
.fs-14 { font-size: .875rem; }

.pos-cart-items { background: #eef1f6; padding: .35rem !important; flex: 1 1 auto; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
.pos-cart-items::-webkit-scrollbar { width: 6px; }
.pos-cart-items::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
.pos-cart-item-wrap { background: transparent !important; }
.pos-cart-item { background: #fff; border-radius: 6px; padding: .35rem .45rem; border: 1px solid #e8ecf1; transition: box-shadow .15s, border-color .15s; }
.pos-cart-item:hover { box-shadow: 0 2px 10px rgba(15,23,42,.06); border-color: #d8dee8; }
.pos-cart-item--kot { border-left: 3px solid #22c55e; }

.pos-cart-row { display: grid; grid-template-columns: 24px 1fr 100px 58px; gap: .3rem; align-items: center; }
.pos-cart-row--head { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: #94a3b8; padding: 0 .55rem; }
.pos-cart-row--head span:nth-child(3) { text-align: center; }
.pos-cart-row--head span:last-child { text-align: right; }
.pos-cart-table-head { background: transparent !important; padding-bottom: 0 !important; }

.pos-cart-row__remove { width: 22px; height: 22px; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .65rem; }
.pos-cart-row__remove--spacer { display: block; }

.pos-cart-row__item { display: flex; align-items: center; gap: .35rem; min-width: 0; }
.pos-cart-item__name { color: var(--primary, #ff6175); font-weight: 700; font-size: .82rem; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.pos-cart-row__qty { display: flex; justify-content: center; }
.pos-qty-group { width: 100%; max-width: 100px; border-radius: 5px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
.pos-qty-group .form-control { max-width: 30px; min-width: 30px; border-color: #e2e8f0; background: #fafbfc; font-size: .75rem; padding: .15rem; }
.pos-qty-group .btn { padding: .1rem .35rem; font-size: .75rem; }
.pos-qty-group .btn-primary { background: var(--primary, #ff6175); border-color: var(--primary, #ff6175); }

.pos-cart-row__price { line-height: 1.15; }
.pos-cart-item__total { font-weight: 800; font-size: .85rem; color: #1e293b; }
.pos-cart-row__price small { font-size: .65rem; }

.pos-cart-row__meta { font-size: .65rem; padding: .15rem .55rem .35rem 2.1rem; line-height: 1.2; }

.pos-food-type-icon { flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; line-height: 0; }
.pos-food-type-icon__svg { display: block; }

.badge-xs { font-size: .6rem; padding: .15rem .35rem; }
.btn-xs { padding: .15rem .4rem; font-size: .7rem; line-height: 1.2; }
.min-w-0 { min-width: 0; }

.pos-cart-empty { list-style: none; background: transparent !important; }
.pos-cart-empty__circle { width: 48px; height: 48px; border-radius: 50%; background: #fff; border: 2px dashed #cbd5e1; display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #94a3b8; margin-bottom: .5rem; }

.pos-cart-footer { background: #fff; border-top: 1px solid #e2e8f0; }
.pos-summary-bar { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); }
.pos-summary-bar__total { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #1e293b; font-size: .95rem; font-weight: 800; padding: .1rem .55rem; border-radius: 6px; min-width: 58px; text-align: center; display: inline-block; }
.pos-tax-toggle { font-size: .65rem; text-decoration: none !important; vertical-align: middle; }
.pos-tax-drawer { background: #f8fafc; border-bottom: 1px solid #e2e8f0; }

.pos-cart-footer__block { padding: .35rem .5rem; border-bottom: 1px solid #f1f5f9; }
.pos-pay-compact .form-control,
.pos-pay-compact .btn { height: 28px; font-size: .75rem; }
.pos-pay-methods { display: flex; flex-wrap: wrap; gap: .25rem; }
.pos-pay-pill { margin: 0; cursor: pointer; }
.pos-pay-pill input { position: absolute; opacity: 0; pointer-events: none; }
.pos-pay-pill span { display: inline-block; padding: .15rem .5rem; font-size: .65rem; font-weight: 600; border: 1px solid #e2e8f0; border-radius: 999px; background: #f8fafc; color: #64748b; transition: all .12s; }
.pos-pay-pill input:checked + span { background: var(--primary, #ff6175); border-color: var(--primary, #ff6175); color: #fff; }

.pos-action-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: .25rem; }
.pos-action-grid form { margin: 0; min-width: 0; }
.pos-action-btn { width: 100%; height: 28px; border: none; border-radius: 4px; font-weight: 700; font-size: .62rem; cursor: pointer; text-transform: uppercase; letter-spacing: .02em; padding: 0 .15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pos-action-btn--save { background: #dc2626; color: #fff; }
.pos-action-btn--save:hover { background: #b91c1c; }
.pos-action-btn--kot { background: var(--primary, #ff6175); color: #fff; }
.pos-action-btn--kot:hover { filter: brightness(.92); }
.pos-action-btn--hold { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
.pos-cart-footer__actions { border-bottom: none; padding-bottom: .25rem; }

.pos-void-details summary { list-style: none; }
.pos-void-details summary::-webkit-details-marker { display: none; }

.pos-cart-panel .card-body { min-height: 0; flex: 1; }

.pos-toast { position: fixed; bottom: 1rem; right: 1rem; z-index: 9999; padding: .75rem 1.25rem; border-radius: .5rem; color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,.15); animation: posToastIn .2s ease; }
.pos-toast--success { background: #16a34a; }
.pos-toast--error { background: #dc2626; }
@keyframes posToastIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 992px) {
    .pos-billing-body { flex-direction: column; overflow-y: auto; }
    .pos-menu-sidebar { width: 100%; flex-direction: row; flex-wrap: wrap; max-height: 120px; }
    .pos-cart-panel { width: 100%; min-width: 0; max-height: 50vh; }
}
</style>
@endpush

@section('content')
<div class="pos-billing-page" id="pos-billing"
    data-order-id="{{ $order->id }}"
    data-items-store-url="{{ route('pos.orders.items.store', $order->id) }}"
    data-items-update-url="{{ url('/pos/orders/'.$order->id.'/items') }}"
    data-items-destroy-url="{{ url('/pos/orders/'.$order->id.'/items') }}"
    data-order-active="{{ $order->status->isActive() ? '1' : '0' }}">

    <div class="pos-billing-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-0">{{ $order->order_number }}</h5>
            <small class="text-muted">{{ $order->type->label() }} · {{ $order->status->label() }} · Table: {{ $order->table?->name ?? '—' }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pos.orders.index') }}" class="btn btn-outline-dark btn-sm">Back</a>
        </div>
    </div>

    <div class="pos-billing-body">
        @include('restaurant.pos.orders.partials.menu-sidebar', ['menuCategories' => $menuCategories])
        @include('restaurant.pos.orders.partials.item-grid', ['menuCategories' => $menuCategories, 'order' => $order])
        @include('restaurant.pos.orders.partials.cart-panel', ['order' => $order, 'paymentMethods' => $paymentMethods])
    </div>
</div>

@if($order->status->isActive())
<div class="modal fade" id="pos-delete-modal" tabindex="-1" aria-labelledby="pos-delete-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pos-delete-modal-title">Remove Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-2">Please provide a reason for removing this item.</p>
                <div class="d-flex flex-wrap gap-1 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm pos-delete-preset" data-reason="Wrong item ordered">Wrong item</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm pos-delete-preset" data-reason="Customer cancelled">Customer cancelled</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm pos-delete-preset" data-reason="Duplicate entry">Duplicate</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm pos-delete-preset" data-reason="Item not available">Not available</button>
                </div>
                <textarea id="pos-delete-reason" class="form-control" rows="3" placeholder="Delete reason (required)" minlength="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal" id="pos-delete-cancel">Cancel</button>
                <button type="button" class="btn btn-primary" id="pos-delete-confirm">Remove Item</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
(function () {
    const root = document.getElementById('pos-billing');
    if (!root) return;

    const orderId = root.dataset.orderId;
    const isActive = root.dataset.orderActive === '1';
    const storeUrl = root.dataset.itemsStoreUrl;
    const updateBaseUrl = root.dataset.itemsUpdateUrl;
    const destroyBaseUrl = root.dataset.itemsDestroyUrl;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    let activeCategory = 'all';

    function showToast(message, type) {
        const el = document.createElement('div');
        el.className = 'pos-toast pos-toast--' + (type || 'success');
        el.textContent = message;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 2500);
    }

    function formatMoney(n) {
        return '₹' + Number(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function formatMoneyCompact(n) {
        return '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 0 });
    }

    function formatTotal(n) {
        return Number(n).toLocaleString('en-IN', { maximumFractionDigits: 0 });
    }

    function foodTypeIconHtml(foodType, size = 16) {
        const type = foodType || 'veg';
        const labels = { veg: 'Veg', non_veg: 'Non-Veg', egg: 'Eggetarian' };
        const title = labels[type] || 'Veg';
        if (type === 'veg') {
            return `<span class="pos-food-type-icon" title="${title}" aria-label="${title}"><svg viewBox="0 0 20 20" width="${size}" height="${size}" class="pos-food-type-icon__svg" aria-hidden="true"><rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#22c55e" stroke-width="2"/><circle cx="10" cy="10" r="4.5" fill="#22c55e"/></svg></span>`;
        }
        if (type === 'egg') {
            return `<span class="pos-food-type-icon" title="${title}" aria-label="${title}"><svg viewBox="0 0 20 20" width="${size}" height="${size}" class="pos-food-type-icon__svg" aria-hidden="true"><rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#d97706" stroke-width="2"/><ellipse cx="10" cy="11" rx="3.5" ry="4.5" fill="#92400e"/></svg></span>`;
        }
        return `<span class="pos-food-type-icon" title="${title}" aria-label="${title}"><svg viewBox="0 0 20 20" width="${size}" height="${size}" class="pos-food-type-icon__svg" aria-hidden="true"><rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#dc2626" stroke-width="2"/><polygon points="10,5 15,15 5,15" fill="#dc2626"/></svg></span>`;
    }

    function buildCartItemHtml(item) {
        const foodType = item.food_type || (item.is_veg === false ? 'non_veg' : 'veg');
        const kotClass = item.kot_sent ? ' pos-cart-item--kot' : '';
        const addons = Array.isArray(item.addons) && item.addons.length
            ? item.addons.map(a => a.name || a).filter(Boolean).join(', ')
            : '';
        const metaParts = [item.notes, addons ? '+ ' + addons : ''].filter(Boolean);
        const metaHtml = metaParts.length
            ? `<div class="pos-cart-row__meta text-muted">${escapeHtml(metaParts.join(' '))}</div>`
            : '';
        const kotBadge = item.kot_sent ? '<span class="badge badge-success light badge-xs flex-shrink-0">KOT</span>' : '';

        const removeBtn = isActive ? `
            <button type="button" class="btn btn-danger light btn-xs sharp pos-cart-row__remove" data-action="remove" data-item-id="${item.id}" title="Remove" aria-label="Remove item">
                <i class="fa fa-times"></i>
            </button>` : `<span class="pos-cart-row__remove pos-cart-row__remove--spacer"></span>`;

        const qtyHtml = isActive ? `
            <div class="input-group input-group-sm pos-qty-group">
                <button type="button" class="btn btn-outline-secondary" data-action="decrease" data-item-id="${item.id}" data-qty="${item.quantity}" aria-label="Decrease quantity">−</button>
                <input type="text" class="form-control text-center px-1 fw-bold" value="${item.quantity}" readonly tabindex="-1" aria-label="Quantity">
                <button type="button" class="btn btn-primary" data-action="increase" data-item-id="${item.id}" data-qty="${item.quantity}" aria-label="Increase quantity">+</button>
            </div>` : `<span class="badge badge-primary light">${item.quantity}</span>`;

        return `
            <li class="list-group-item border-0 py-1 px-2 pos-cart-item-wrap" data-item-id="${item.id}">
                <div class="pos-cart-item pos-cart-row${kotClass}">
                    ${removeBtn}
                    <div class="pos-cart-row__item min-w-0">
                        ${foodTypeIconHtml(foodType)}
                        <span class="pos-cart-item__name text-truncate">${escapeHtml(item.name)}</span>
                        ${kotBadge}
                    </div>
                    <div class="pos-cart-row__qty">${qtyHtml}</div>
                    <div class="pos-cart-row__price text-end">
                        <span class="pos-cart-item__total">${formatTotal(item.line_total)}</span>
                        <small class="text-muted d-block lh-1">${formatTotal(item.unit_price)}</small>
                    </div>
                </div>
                ${metaHtml}
            </li>`;
    }

    function renderCart(order) {
        const container = document.getElementById('pos-cart-items');
        const countEl = document.getElementById('pos-cart-count');
        const subtitleEl = document.getElementById('pos-cart-subtitle');
        const tableHead = document.getElementById('pos-cart-table-head');
        if (!container) return;

        const totalQty = order.items.reduce((sum, i) => sum + i.quantity, 0);

        if (!order.items.length) {
            tableHead?.remove();
            container.innerHTML = `
                <li class="list-group-item text-center py-4 text-muted border-0 pos-cart-empty" id="pos-cart-empty">
                    <span class="pos-cart-empty__circle"><i class="fa fa-shopping-basket"></i></span>
                    <p class="mb-1 fw-semibold text-dark">No items yet</p>
                    <small>Tap menu items to add them to this order</small>
                </li>`;
        } else {
            if (!tableHead) {
                container.insertAdjacentHTML('afterbegin', `
                    <li class="pos-cart-table-head list-group-item border-0 py-1 px-2" id="pos-cart-table-head">
                        <div class="pos-cart-row pos-cart-row--head">
                            <span></span><span>Items</span><span>Qty.</span><span>Price</span>
                        </div>
                    </li>`);
            }
            const head = document.getElementById('pos-cart-table-head');
            const itemsHtml = order.items.map(item => buildCartItemHtml(item)).join('');
            container.innerHTML = (head ? head.outerHTML : '') + itemsHtml;
            bindCartActions();
        }

        if (countEl) countEl.textContent = order.items.length;
        if (subtitleEl) subtitleEl.textContent = `${totalQty} qty · ${order.items.length} items`;
        document.getElementById('pos-subtotal').textContent = formatMoneyCompact(order.subtotal);
        document.getElementById('pos-tax').textContent = formatMoney(order.tax_amount);
        document.getElementById('pos-service').textContent = formatMoney(order.service_charge);
        document.getElementById('pos-total').textContent = formatTotal(order.total_amount);

        const payAmount = document.getElementById('pos-pay-amount');
        if (payAmount) payAmount.value = order.balance_due.toFixed(2);
    }

    function applyFilters() {
        const query = (document.getElementById('pos-item-search')?.value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.pos-item-card');
        let visible = 0;

        cards.forEach(card => {
            const catMatch = activeCategory === 'all' || card.dataset.categoryId === activeCategory;
            const searchMatch = !query || (card.dataset.search || '').includes(query);
            const show = catMatch && searchMatch;
            card.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        document.getElementById('pos-item-empty')?.classList.toggle('d-none', visible > 0);
    }

    document.querySelectorAll('.pos-category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.pos-category-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.dataset.categoryId;
            applyFilters();
        });
    });

    document.getElementById('pos-item-search')?.addEventListener('input', applyFilters);

    function escapeHtml(text) {
        const d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }

    async function apiRequest(url, method, body) {
        const opts = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
            },
        };
        if (body) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(body);
        }
        const res = await fetch(url, opts);
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            let message = data.message || 'Request failed';
            if (data.errors) {
                message = Object.values(data.errors).flat().join(', ');
            }
            throw new Error(message);
        }
        return data;
    }

    async function addItem(card) {
        if (!isActive) return;
        card.classList.add('loading');
        try {
            const data = await apiRequest(storeUrl, 'POST', {
                menu_item_id: parseInt(card.dataset.itemId, 10),
                name: card.dataset.name,
                quantity: 1,
                unit_price: parseFloat(card.dataset.price),
            });
            renderCart(data.order);
            showToast(data.message || 'Item added');
        } catch (e) {
            showToast(e.message, 'error');
        } finally {
            card.classList.remove('loading');
        }
    }

    async function updateQty(itemId, qty) {
        if (!isActive || qty < 1) return;
        try {
            const data = await apiRequest(`${updateBaseUrl}/${itemId}`, 'PUT', { quantity: qty });
            renderCart(data.order);
        } catch (e) {
            showToast(e.message, 'error');
        }
    }

    const deleteModalEl = document.getElementById('pos-delete-modal');
    const deleteReasonInput = document.getElementById('pos-delete-reason');
    const deleteModal = deleteModalEl && typeof bootstrap !== 'undefined'
        ? new bootstrap.Modal(deleteModalEl)
        : null;
    let pendingRemoveItemId = null;

    function openDeleteModal(itemId) {
        pendingRemoveItemId = itemId;
        if (deleteReasonInput) deleteReasonInput.value = '';
        deleteModal?.show();
        setTimeout(() => deleteReasonInput?.focus(), 200);
    }

    function closeDeleteModal() {
        pendingRemoveItemId = null;
        deleteModal?.hide();
    }

    document.getElementById('pos-delete-confirm')?.addEventListener('click', () => {
        const reason = (deleteReasonInput?.value || '').trim();
        if (reason.length < 3) {
            showToast('Please enter a delete reason (min 3 characters).', 'error');
            return;
        }
        if (pendingRemoveItemId) {
            confirmRemoveItem(pendingRemoveItemId, reason);
        }
    });
    document.querySelectorAll('.pos-delete-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            if (deleteReasonInput) deleteReasonInput.value = btn.dataset.reason || '';
        });
    });

    async function confirmRemoveItem(itemId, reason) {
        if (!isActive) return;
        try {
            const data = await apiRequest(`${destroyBaseUrl}/${itemId}`, 'DELETE', { delete_reason: reason });
            renderCart(data.order);
            showToast(data.message || 'Item removed');
            closeDeleteModal();
        } catch (e) {
            showToast(e.message, 'error');
        }
    }

    function promptRemoveItem(itemId) {
        if (!isActive) return;
        if (deleteModal) {
            openDeleteModal(itemId);
        } else {
            const reason = window.prompt('Reason for removing this item:');
            if (reason && reason.trim().length >= 3) {
                confirmRemoveItem(itemId, reason.trim());
            }
        }
    }

    function bindCartActions() {
        document.querySelectorAll('[data-action="increase"]').forEach(btn => {
            btn.onclick = () => updateQty(btn.dataset.itemId, parseInt(btn.dataset.qty, 10) + 1);
        });
        document.querySelectorAll('[data-action="decrease"]').forEach(btn => {
            btn.onclick = () => {
                const qty = parseInt(btn.dataset.qty, 10);
                if (qty <= 1) promptRemoveItem(btn.dataset.itemId);
                else updateQty(btn.dataset.itemId, qty - 1);
            };
        });
        document.querySelectorAll('[data-action="remove"]').forEach(btn => {
            btn.onclick = () => promptRemoveItem(btn.dataset.itemId);
        });
    }

    document.querySelectorAll('.pos-item-card').forEach(card => {
        card.addEventListener('click', () => addItem(card));
    });

    bindCartActions();
    applyFilters();
})();
</script>
@endpush
