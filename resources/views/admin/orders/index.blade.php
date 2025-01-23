@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Zamówienia</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Klient</th>
                <th>Status</th>
                <th>Kwota</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->total_price }} zł</td>
                <td>
                    <form method="POST" action="/admin/orders/{{ $order->id }}/status">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control">
                            <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Nowe</option>
                            <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>W trakcie</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Zakończone</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Anulowane</option>
                        </select>
                        <button type="submit" class="btn btn-success">Zaktualizuj</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
