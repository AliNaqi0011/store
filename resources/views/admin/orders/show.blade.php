@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details - {{ $order->order_number }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Order Number:</strong></td>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $order->status === 'confirmed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>{{ strtoupper($order->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $order->billing_address['first_name'] }} {{ $order->billing_address['last_name'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $order->billing_address['email'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $order->billing_address['phone'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Billing Address</h5>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-1"><strong>{{ $order->billing_address['first_name'] }} {{ $order->billing_address['last_name'] }}</strong></p>
                                <p class="mb-1">{{ $order->billing_address['address_line_1'] }}</p>
                                @if($order->billing_address['address_line_2'])
                                    <p class="mb-1">{{ $order->billing_address['address_line_2'] }}</p>
                                @endif
                                <p class="mb-1">{{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}</p>
                                <p class="mb-1">{{ $order->billing_address['country'] }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ $order->billing_address['phone'] }}</p>
                                <p class="mb-0"><strong>Email:</strong> {{ $order->billing_address['email'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Shipping Address</h5>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-1"><strong>{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address['address_line_1'] }}</p>
                                @if($order->shipping_address['address_line_2'])
                                    <p class="mb-1">{{ $order->shipping_address['address_line_2'] }}</p>
                                @endif
                                <p class="mb-1">{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}</p>
                                <p class="mb-1">{{ $order->shipping_address['country'] }}</p>
                                <p class="mb-0"><strong>Phone:</strong> {{ $order->shipping_address['phone'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Order Items</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product_sku }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Subtotal</th>
                                        <th>${{ number_format($order->subtotal, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Tax</th>
                                        <th>${{ number_format($order->tax_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Shipping</th>
                                        <th>${{ number_format($order->shipping_amount, 2) }}</th>
                                    </tr>
                                    @if($order->discount_amount > 0)
                                    <tr>
                                        <th colspan="4">Discount</th>
                                        <th>-${{ number_format($order->discount_amount, 2) }}</th>
                                    </tr>
                                    @endif
                                    <tr class="table-success">
                                        <th colspan="4">Total</th>
                                        <th>${{ number_format($order->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection