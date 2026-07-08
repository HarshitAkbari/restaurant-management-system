<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KOT {{ $kot->kot_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; font-size: 13px; width: 80mm; margin: 0 auto; padding: 8px; color: #000; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 2px solid #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; vertical-align: top; }
        .qty { width: 28px; text-align: center; font-weight: bold; font-size: 15px; }
        @media print { body { width: 80mm; } @page { margin: 4mm; } }
    </style>
</head>
<body>
    <div class="center bold" style="font-size:16px;margin-bottom:4px;">KOT</div>
    <div class="center bold" style="font-size:14px;margin-bottom:6px;">{{ $kot->kot_number }}</div>

    <div>Order: {{ $order->order_number }}</div>
    <div>Time: {{ $kot->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</div>
    @if($order->table)
    <div class="bold">Table: {{ $order->table->name }}</div>
    @endif
    @if($kot->station)
    <div>Station: {{ $kot->station }}</div>
    @endif

    <div class="line"></div>

    <table>
        @foreach($kot->items as $item)
        <tr>
            <td class="qty">{{ $item->quantity }}</td>
            <td>
                <span class="bold">{{ $item->name }}</span>
                @if($item->notes)
                <div style="font-size:11px;">{{ $item->notes }}</div>
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>
    <div class="center" style="margin-top:4px;">{{ config('restaurant.name') }}</div>

    <script>window.onload = function () { window.print(); };</script>
</body>
</html>
