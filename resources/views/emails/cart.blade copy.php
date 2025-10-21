<!DOCTYPE html>
<html>
<head>
    <title>Cart Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        thead {
            background-color: #d9b382;
            color: #fff;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        p {
            font-size: 16px;
            color: #555;
            text-align: right;
            margin: 20px 0;
        }
        .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #d9b382;
        }
    </style>
</head>
<body>

    <h1>New Cart Order Details</h1>
    <table>
        <thead>
            <tr>
                <th>Country</th>
                <th>street</th>
                <th>address</th>
                <th>zip code</th>
                <th>location</th>
                <th>phone</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $location_data['country'] }}</td>
                <td>{{ $location_data['street'] }}</td>
                <td>{{ $location_data['address'] }}</td>
                <td>{{ $location_data['zipcode'] }}</td>
                <td>{{ $location_data['location'] }}</td>
                <td>{{ $location_data['phone'] }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Price: <span class="total-price">${{ $total_data['subtotal'] }}</span></p>
    <p>Vat 19%: <span class="total-price">${{ $total_data['vat'] }}</span></p>
    <p>Total with vat: <span class="total-price">${{ $total_data['totalWithVat'] }}</span></p>
</body>
</html>
