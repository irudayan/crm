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

    {{-- <h3>Products:</h3> --}}
    {{-- <table>
        <thead>
            <tr>
                <th>Product Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}

</body>

</html>
