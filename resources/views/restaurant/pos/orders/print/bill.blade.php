<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bill {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 8px; color: #000; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .qty { width: 24px; text-align: center; }
        .amt { text-align: right; white-space: nowrap; }
        @media print { body { width: 80mm; } @page { margin: 4mm; } }
    </style>
</head>
<body>
    <div class="center bold" style="font-size:14px;margin-bottom:4px;">{{ config('restaurant.name') }}</div>
    <div class="center" style="margin-bottom:6px;">TAX INVOICE</div>

    <div>Order: {{ $order->order_number }}</div>
    <div>Date: {{ now()->format('d/m/Y H:i') }}</div>
    <div>Type: {{ $order->type->label() }}</div>
    @if($order->table)
    <div>Table: {{ $order->table->name }}</div>
    @endif
    @if($order->customer)
    <div>Customer: {{ $order->customer->name }}</div>
    @endif

    <div class="line"></div>

    <table>
        <thead>
            <tr class="bold">
                <td>Item</td>
                <td class="qty">Qty</td>
                <td class="amt">Amt</td>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="qty">{{ $item->quantity }}</td>
                <td class="amt">{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table>
        <tr><td>Subtotal</td><td class="amt">{{ number_format($order->subtotal, 2) }}</td></tr>
        <tr><td>Tax</td><td class="amt">{{ number_format($order->tax_amount, 2) }}</td></tr>
        <tr><td>Service</td><td class="amt">{{ number_format($order->service_charge, 2) }}</td></tr>
        <tr class="bold"><td>Total</td><td class="amt">{{ number_format($order->total_amount, 2) }}</td></tr>
        @php $paid = $order->payments->sum('amount'); @endphp
        @if($paid > 0)
        <tr><td>Paid</td><td class="amt">{{ number_format($paid, 2) }}</td></tr>
        <tr><td>Balance</td><td class="amt">{{ number_format(max($order->total_amount - $paid, 0), 2) }}</td></tr>
        @endif
    </table>

    <div class="line"></div>
    <div class="center" style="margin-top:6px;">Thank you!</div>

    <script>window.onload = function () { window.print(); };</script>
</body>
</html>
