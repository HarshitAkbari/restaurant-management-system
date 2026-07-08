@php $paid = $order->payments->sum('amount'); @endphp

<aside class="pos-cart-panel card h-100 mb-0 rounded-0 border-0" id="pos-cart-panel">
    <div class="card-header pos-cart-panel__header border-0 py-2 px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="pos-cart-panel__icon"><i class="fa fa-receipt"></i></span>
            <div>
                <h6 class="mb-0 fw-bold fs-14">Order Items</h6>
                <small class="text-muted" id="pos-cart-subtitle">{{ $order->items->sum('quantity') }} qty · {{ $order->items->count() }} items</small>
            </div>
        </div>
        <span class="badge badge-primary badge-pill pos-cart-panel__count" id="pos-cart-count">{{ $order->items->count() }}</span>
    </div>

    <div class="card-body p-0 d-flex flex-column flex-grow-1 overflow-hidden min-h-0">
        <ul class="list-group list-group-flush flex-grow-1 overflow-auto mb-0 pos-cart-items min-h-0" id="pos-cart-items">
            @if($order->items->isNotEmpty())
            <li class="pos-cart-table-head list-group-item border-0 py-0 px-2" id="pos-cart-table-head">
                <div class="pos-cart-row pos-cart-row--head">
                    <span></span>
                    <span>Items</span>
                    <span>Qty.</span>
                    <span>Price</span>
                </div>
            </li>
            @endif
            @forelse($order->items as $item)
                @include('restaurant.pos.orders.partials.cart-item', ['item' => $item, 'order' => $order])
            @empty
            <li class="list-group-item text-center py-4 text-muted border-0 pos-cart-empty" id="pos-cart-empty">
                <span class="pos-cart-empty__circle"><i class="fa fa-shopping-basket"></i></span>
                <p class="mb-1 fw-semibold text-dark small">No items yet</p>
                <small>Tap menu items to add</small>
            </li>
            @endforelse
        </ul>

        <div class="pos-cart-footer flex-shrink-0" id="pos-cart-footer">
            <div class="pos-summary-bar d-flex justify-content-between align-items-center px-2 py-1">
                <div class="text-white small">
                    Sub <strong id="pos-subtotal">₹{{ number_format($order->subtotal, 0) }}</strong>
                    <button class="btn btn-link btn-sm text-white-50 p-0 ms-1 align-baseline pos-tax-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#posTotalsBody" aria-expanded="false">
                        <i class="fa fa-chevron-down fa-xs"></i>
                    </button>
                </div>
                <div class="text-white d-flex align-items-center gap-1 small">
                    Total <span class="pos-summary-bar__total" id="pos-total">{{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>

            <div class="collapse" id="posTotalsBody">
                <div class="pos-tax-drawer px-2 py-1" id="pos-cart-totals">
                    <div class="d-flex justify-content-between small"><span class="text-muted">Tax</span><span id="pos-tax">₹{{ number_format($order->tax_amount, 2) }}</span></div>
                    <div class="d-flex justify-content-between small"><span class="text-muted">Service</span><span id="pos-service">₹{{ number_format($order->service_charge, 2) }}</span></div>
                    @if($paid > 0)
                    <div class="d-flex justify-content-between small text-success"><span>Paid</span><span id="pos-paid">₹{{ number_format($paid, 2) }}</span></div>
                    @endif
                </div>
            </div>

            @if($order->status->isActive())
            <div class="pos-cart-footer__block">
                <form method="POST" action="{{ route('pos.orders.pay', $order->id) }}" id="pos-pay-form" class="pos-pay-compact">
                    @csrf
                    <div class="pos-pay-methods mb-1">
                        @foreach($paymentMethods as $i => $method)
                        <label class="pos-pay-pill">
                            <input type="radio" name="method" id="pay-method-{{ $method }}" value="{{ $method }}" {{ $i === 0 ? 'checked' : '' }}>
                            <span>{{ ucfirst($method) }}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="input-group input-group-sm">
                        <input type="number" step="0.01" name="amount" id="pos-pay-amount" class="form-control"
                            value="{{ max($order->total_amount - $paid, 0) }}" required placeholder="Amt">
                        <input type="text" name="reference" class="form-control" placeholder="Ref">
                        <button type="submit" class="btn btn-success btn-sm px-3">Pay</button>
                    </div>
                </form>
            </div>

            <div class="pos-cart-footer__block pos-cart-footer__actions">
                <div class="pos-action-grid">
                    <form method="POST" action="{{ route('pos.orders.save', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--save" title="Save">Save</button></form>
                    <form method="POST" action="{{ route('pos.orders.save-print', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--save" title="Save &amp; Print">S&amp;P</button></form>
                    <form method="POST" action="{{ route('pos.orders.save-ebill', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--save" title="Save &amp; eBill">eBill</button></form>
                    <form method="POST" action="{{ route('pos.orders.send-kot', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--kot" title="Send KOT">KOT</button></form>
                    <form method="POST" action="{{ route('pos.orders.kot-print', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--kot" title="KOT &amp; Print">K&amp;P</button></form>
                    <form method="POST" action="{{ route('pos.orders.hold', $order->id) }}">@csrf<button type="submit" class="pos-action-btn pos-action-btn--hold" title="Hold order">Hold</button></form>
                </div>
            </div>

            <details class="pos-void-details px-2 pb-1">
                <summary class="text-danger" style="font-size:.65rem;cursor:pointer;">Void order</summary>
                <form method="POST" action="{{ route('pos.orders.void', $order->id) }}" class="mt-1">
                    @csrf
                    <textarea name="void_reason" class="form-control form-control-sm mb-1" rows="1" placeholder="Reason" required></textarea>
                    <button type="submit" class="btn btn-danger light btn-xs w-100" onclick="return confirm('Void order?')">Void</button>
                </form>
            </details>
            @endif
        </div>
    </div>
</aside>
