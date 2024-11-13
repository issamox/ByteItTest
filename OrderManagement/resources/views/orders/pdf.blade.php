<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        h1, h2 {
            color: #333;
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 14pt;
            margin-top: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24pt;
            color: #4CAF50;
        }

        .order-info, .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-info th, .order-info td, .product-table th, .product-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .order-info th, .product-table th {
            background-color: #f4f4f4;
        }

        .order-info td {
            background-color: #fafafa;
        }

        .order-info tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16pt;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10pt;
            color: #999;
        }

        /* Footer with page number (if applicable) */
        @page {
            margin-bottom: 20px;
        }

        .footer p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('images/companyLogo.jpg') }}" alt="Company Logo"> <!-- Your company logo -->
    <h1>Order #{{ $order->id }}</h1>
    <p>{{ now()->format('d F, Y') }}</p>
</div>

<div class="order-info">
    <table>
        <tr>
            <th>Client Name</th>
            <td>{{ $order->client->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $order->client->email }}</td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $order->status }}</td>
        </tr>
    </table>
</div>

<h2>Products</h2>
<table class="product-table">
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>${{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total">
    <h3>Total: ${{ number_format($total, 2) }}</h3>
</div>

<div class="footer">
    <p>Thank you for your business!</p>
    <p>For support, contact us at support@byeit.com</p>
</div>
</body>
</html>
