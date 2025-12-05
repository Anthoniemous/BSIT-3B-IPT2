<x-app-layout>

<link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">

<div class="container">
    <h1 class="page-title"> Customer Orders  </h1>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Check if user has any orders --}}
    @if($orders->isEmpty())
        <p class="no-orders">You have no orders yet.</p>
    @else
        <div class="order-table">
            <table>
                <thead>
            <tr>
              <th>Order ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Contact</th>
              <th>Date</th>
              <th>Products (Merged)</th>
              <th>Total</th>  
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
          @foreach($orders as $order)

              @php
                  // Group items by PRODUCT + SIZE + PRICE
                  $grouped = $order->items->groupBy(function($item) {
                      return $item->product_id . '-' . ($item->size ?? 'N/A') . '-' . $item->product->price;
                  });

                  // Compute Total
                  $finalTotal = $grouped->sum(function($items) {
                      return $items->first()->product->price * $items->sum('quantity');
                  });
              @endphp

              <tr>
                  <td>{{ $order->order_id }}</td>
                  <td>{{ $order->name }}</td>
                  <td>{{ $order->address }}</td>
                  <td>{{ $order->contact_number }}</td>
                  <td>{{ $order->created_at->format('M d, Y') }}</td>

                  <td class="text-start">
                      <ul class="mb-0 ps-3">
                          @foreach($grouped as $items)
                              @php
                                  $item = $items->first();
                                  $qty = $items->sum('quantity');
                              @endphp

                              <li>
                                  {{ $item->product->product_name }}
                                  ({{ $item->size ?? 'N/A' }})
                                  - {{ $qty }} × ₱{{ number_format($item->product->price, 2) }}
                              </li>
                          @endforeach
                      </ul>
                  </td>

                  <td>
                      ₱{{ number_format($finalTotal, 2) }}
                  </td>

                  <td>
                      <span class="status {{ strtolower($order->status) }}">
                          {{ ucfirst($order->status) }}
                      </span>
                  </td>
              </tr>

          @endforeach
          </tbody>

        </table>
      </div>
    @endif

    <div class="text-center">
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

</div>
</x-app-layout>
