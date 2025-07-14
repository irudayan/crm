<!DOCTYPE html>
<html>

<head>
    <title>Quotation Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Quotation Details</h2>
    <p><strong>Name:</strong> {{ $lead->name }}</p>
    <p><strong>Email:</strong> {{ $lead->email }}</p>
    <p><strong>Mobile:</strong> {{ $lead->mobile }}</p>
    <p><strong>Quotation Amount:</strong> ₹{{ number_format($lead->quotation_amount, 2) }}</p>
    <p><strong>Tax:</strong> {{ $lead->quotation_tax }}%</p>
    <p><strong>Total Amount:</strong> ₹{{ number_format($lead->quotation_amount * (1 + $lead->quotation_tax/100), 2) }}
    </p>

    <h3>Products</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Tax Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lead->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>₹{{ number_format($product->pivot->price, 2) }}</td>
                <td>{{ $product->pivot->tax }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Please find the attached quotation for your reference.</p>

    <p>Best regards,<br>
        {{ $senderName }}<br>
        {{ $senderEmail }}</p>
</body>

</html>
