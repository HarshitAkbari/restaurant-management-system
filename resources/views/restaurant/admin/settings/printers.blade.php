@extends('restaurant.admin.layouts.app')

@section('title', 'Printers')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Printers</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.printers.update') }}">
            @csrf
            @method('PUT')
            @php $printers = old('printer_names') ? null : ($setting->printers ?? []); @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>IP / Address</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < max(3, count($printers ?? [])); $i++)
                    <tr>
                        <td>
                            <input type="text" name="printer_names[]" class="form-control"
                                value="{{ old('printer_names.'.$i, $printers[$i]['name'] ?? '') }}">
                        </td>
                        <td>
                            <input type="text" name="printer_ips[]" class="form-control"
                                value="{{ old('printer_ips.'.$i, $printers[$i]['ip'] ?? '') }}">
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Printers</button>
        </form>
    </div>
</div>
@endsection
