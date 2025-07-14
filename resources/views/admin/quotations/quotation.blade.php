{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal for {{ implode(', ', $products->pluck('name')->toArray()) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .note {
            font-style: italic;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #131516;
        }

        img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
        }
    </style>
</head>

<body>
    <center>
        <div class="logo">
            <img src="{{ public_path('backend/images/logo/logo.png') }}" alt="iSaral Business Solutions">
        </div>
    </center>

    <center>
        <h3>Proposal for {{ implode(', ', $products->pluck('name')->toArray()) }}</h3>
    </center>

    <p><strong>To,</strong><br>
        {{ $lead->name }}<br>
        {{ $lead->address }}</p>

    <hr>

    <center>
        <h3>About iSaral Business Solutions Pvt Ltd</h3>
    </center>

    <p>{{ $lead->about_us }}</p>

    <hr>

    <h2>Kind Attn: {{ $lead->name }}</h2>

    <p><strong>Ref:</strong> {{ $lead->quotation_reference }} &nbsp;&nbsp;<strong>Date:</strong> {{
        now()->format('d-m-Y') }}</p>

    <p><em>Dear Sir/Madam,</em></p>
    <p><em>We thank you for the keen interest your organization has shown in our products.</em></p>
    <p><em>As per our discussion and requirement, please find below quotation as requested.</em></p>

    <p><strong>Quotation Reference:</strong> {{ $lead->quotation_reference }}</p>
    <p><strong>Quotation Amount:</strong> ₹{{ number_format($lead->quotation_amount, 2) }}</p>
    <p><strong>Tax:</strong> {{ $lead->quotation_tax }}%</p>
    <p><strong>Total Amount:</strong> ₹{{ number_format($lead->quotation_amount * (1 + $lead->quotation_tax/100), 2) }}
    </p>
    <p><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($lead->quotation_expiry_date)->format('d M, Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Tax Rate</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>₹{{ number_format($product->pivot->price, 2) }}</td>
                <td>{{ $product->pivot->tax }}%</td>
                <td>₹{{ number_format($product->pivot->price * (1 + $product->pivot->tax/100), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Subtotal</strong></td>
                <td><strong>₹{{ number_format($lead->quotation_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Tax ({{ $lead->quotation_tax }}%)</strong></td>
                <td><strong>₹{{ number_format($lead->quotation_amount * $lead->quotation_tax/100, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total Amount</strong></td>
                <td><strong>₹{{ number_format($lead->quotation_amount * (1 + $lead->quotation_tax/100), 2) }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <h3>Terms & Conditions</h3>
    <ol>
        @foreach($terms as $term)
        <li>{{ $term }}</li>
        @endforeach
    </ol>

    <h3>Notes</h3>
    <p>{{ $lead->quotation_notes }}</p>

    <div class="footer">
        <p>Yours truly,</p>
        <p><strong>iSaral Business Solutions Pvt Ltd</strong><br>
            Web - <a href="http://www.isaral.in">www.isaral.in</a></p>
    </div>
</body>

</html> --}}

<!DOCTYPE html>
<html>

<head>
    <title>Quotation #{{ $lead->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .company-info {
            float: right;
            text-align: right;
        }

        .customer-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .text-right {
            text-align: right;
        }

        .terms {
            margin-top: 30px;
        }

        .signature {
            margin-top: 50px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <center>
        <div class="logo">
            <img src="http://127.0.0.1:8000/backend/images/logo/logo.png" alt="iSaral Business Solutions">
        </div>
    </center>

    <div class="header">
        <h1>QUOTATION</h1>
        <p>Date: {{ $date }} | Valid Until: {{ $expiry_date }} | Ref: {{ $lead->quotation_reference }}</p>
    </div>



    <div class="customer-info">
        <h3>To:</h3>
        <p><strong>{{ $lead->name }}</strong></p>
        <p>{{ $lead->address }}</p>
        <p>Phone: {{ $lead->mobile }}</p>
        <p>Email: {{ $lead->email }}</p>
    </div>


    <hr>

    <center>
        <h3>About iSaral Business Solutions Pvt Ltd</h3>
    </center>

    <p>{{ $lead->about_us }}</p>

    <hr>

    <h2>Kind Attn: {{ $lead->name }}</h2>

    <p><strong>Ref:</strong> {{ $lead->quotation_reference }} &nbsp;&nbsp;<strong>Date:</strong> {{
        now()->format('d-m-Y') }}</p>

    <p><em>Dear Sir/Madam,</em></p>
    <p><em>We thank you for the keen interest your organization has shown in our products.</em></p>
    <p><em>As per our discussion and requirement, please find below quotation as requested.</em></p>

    <p><strong>Quotation Reference:</strong> {{ $lead->quotation_reference }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td class="text-right">Rs.{{ number_format($product->pivot->price, 2) }}</td>
                <td class="text-right">Rs.{{ number_format($product->pivot->discount, 2) }}</td>
                <td class="text-right">Rs.{{ number_format($product->pivot->tax_amount, 2) }}</td>
                <td class="text-right">Rs.{{ number_format($product->pivot->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">Rs.{{ number_format($lead->quotation_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Total Discount:</strong></td>
                <td class="text-right">Rs.{{ number_format($lead->quotation_discount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Total Tax:</strong></td>
                <td class="text-right">Rs.{{ number_format($lead->quotation_tax, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right">Rs.{{ number_format($lead->quotation_total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <h3>Payment Conditions:</h3>
    <table>
        <tr>
            <th>Validity of Quotation</th>
            <td>15 Days</td>
        </tr>
        <tr>
            <th>Payment Terms</th>
            <td>100% Advance in the Name of “iSaral Business Solutions Pvt Ltd”</td>
        </tr>
        <tr>
            <th>Bank Name</th>
            <td>ICICI Bank</td>
        </tr>
        <tr>
            <th>Account Number</th>
            <td>318005000404</td>
        </tr>
        <tr>
            <th>IFSC Code</th>
            <td>ICIC0003180</td>
        </tr>
        <tr>
            <th>Branch</th>
            <td>Hebbal Branch</td>
        </tr>
    </table>


    <div class="terms">
        <h3>Terms & Conditions:</h3>
        <ul>
            @foreach($terms as $term)
            <li>{{ $term }}</li>
            @endforeach
        </ul>
        @if($lead->quotation_notes)
        <p><strong>Notes:</strong> {{ $lead->quotation_notes }}</p>
        @endif
    </div>

    <div class="footer">
        <p>Yours truly,</p>
        <p><strong>iSaral Business Solutions Pvt Ltd</strong><br>
            Web - <a href="http://www.isaral.in">www.isaral.in</a></p>
    </div>
</body>

</html>
