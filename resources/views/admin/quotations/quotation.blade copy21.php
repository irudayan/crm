<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal for Tally Prime</title>
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
        <h3>Proposal for
            @foreach ($products as $product)
            {{ $product->name }}@if (!$loop->last), @endif
            @endforeach
        </h3>
    </center>

    <p><strong>To,</strong><br>
        {{ $lead->name }}<br>
        {{ $lead->address }}</p>

    <hr>

    <center>
        <h3>About iSaral Business Solutions Pvt Ltd</h3>
    </center>

    <p>We are a premier Enterprise solutions company addressing requirements of customers worldwide, helping
        businesses improve processes by taking advantage of web-based technologies. At iSaral Business Solutions, we
        create Enterprise solutions; a seamless means of changing the way companies do business, by speeding up
        communication and information flow, enhancing productivity, extending their enterprise to their clients, and
        building global brands.</p>

    <p>iSaral Business Solutions is the Certified Partner for Tally Solutions Pvt Ltd, Sag infotech Pvt Ltd, and
        Distributor for Sify Technologies Ltd, eMudhra Ltd, Capricorn & Pantasign (Digital Signature).</p>

    <p>iSaral has a commitment to performance, excellence, and client satisfaction, after-sale support, and software
        development services.</p>

    <p>We provide software that streamlines your business process with exclusive features that increase efficiency,
        improve communications, and enhance performance, allowing you to be more productive, better equipped, and at
        a lower cost.</p>

    <p>We value your attention to the services provided by iSaral. As per our discussion, please find enclosed the
        detailed features and costing for "Tally Prime".</p>

    <hr>

    <h2>Kind Attn: {{ $lead->name }}</h2>

    <p><strong>Ref:</strong> iSaral/2021-22/379 &nbsp;&nbsp;<strong>Date:</strong>
        {{ now()->format('d-m-Y') }}</p>

    <p><em>Dear Sir/Madam,</em></p>

    <p><em>We thank you for the keen interest your organization has shown in our products.</em></p>
    <p><em>As per our discussion and requirement of wall coverings, please find below quotation as requested.</em>
    </p>


    <p><strong>Quotation Reference:</strong> {{ $lead->quotation_reference }}</p>
    <p><strong>Quotation Amount:</strong> ₹{{ number_format($lead->quotation_amount, 2) }}</p>
    <p><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($lead->quotation_expiry_date)->format('d M, Y') }}</p>

    <p>If you have any questions or require any clarification, please don't hesitate to contact us.</p>

    {{-- <p>Best regards,<br>
        iSaral Business Solutions Pvt Ltd<br>
        Phone: +91 9108024198<br>
        Email: rajesh@isaral.in</p> --}}


    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Quotation Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ config('settings.currency_symbol') }} {{ number_format($lead->quotation_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td>
                    <strong>
                        {{ config('settings.currency_symbol') }}
                        {{ $products->sum('quotation_amount') }}
                    </strong>
                </td>
            </tr>
        </tfoot>

    </table>

    <p><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($lead->quotation_expiry_date)->format('d M, Y') }}</p>

    <p class="note"><strong>Note:</strong> 18% GST Extra</p>

    <p><em>Hope that the above is in perfect line with your requirements in anticipation of your early order and
            assuring you of our best services at all times.</em></p>

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

    <h3>
        <h3>Proposal for
            @foreach ($products as $product)
            {{ $product->name }}@if (!$loop->last), @endif
            @endforeach
        </h3>
    </h3>
    <h3>About Us</h3>
    <ol>
        <li>{{ $lead->about_us }}</li>
    </ol>
    <h3>Quotation Notes</h3>
    <ol>
        <li>{{ $lead->quotation_notes }}</li>
    </ol>


    <h3>Support Process:</h3>
    <p><em>The help desk will be available on working days from 10 AM to 7 PM.</em></p>
    <ol>
        <li>Application Support.</li>
        <li>Telephonic and remote support has always been the very strong point of iSaral, so continuing our
            tradition, we provide support.</li>
        <li>Support @ Client End (if needed), in case of Onsite Solution. - charged separately depending on time,
            location & requirements.</li>
    </ol>

    <h3>Terms & Conditions</h3>
    <ol>
        <li>{{ $lead->quotation_terms }}</li>

    </ol>

    <p><em>For any clarification feel free to contact us.</em></p>

    <div class="footer">
        <p>Yours truly,</p>
        <p><strong>Rajesh H B</strong><br>
            M: +91 9108024198<br>
            E: rajesh@isaral.in</p>
        <p><strong>iSaral Business Solutions Pvt Ltd</strong><br>
            #16, GF, 4th Main Road, Dwarakanagar, Nagarabhawi, Bangalore - 560072<br>
            Web - <a href="http://www.isaral.in">www.isaral.in</a></p>
    </div>
</body>

</html>

{{--
<!DOCTYPE html>
<html>

<head>
    <title>Quotation - {{ $lead->quotation_reference }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-info {
            margin-bottom: 30px;
        }

        .client-info {
            margin-bottom: 20px;
        }

        .quotation-details {
            margin-bottom: 30px;
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

        .total-row {
            font-weight: bold;
        }

        .terms {
            margin-top: 30px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>QUOTATION</h2>
        <p>Ref: {{ $lead->quotation_reference ?? 'N/A' }}</p>
        <p>Date: {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="company-info">
        <h3>iSaral</h3>
        <p>Bangalore, India</p>
        <p>Email: info@isaral.com</p>
        <p>Phone: +91 1234567890</p>
    </div>

    <div class="client-info">
        <h3>To:</h3>
        <p>{{ $lead->name }}</p>
        <p>{{ $lead->address }}</p>
        <p>Mobile: {{ $lead->mobile }}</p>
        <p>Email: {{ $lead->email }}</p>
    </div>

    <div class="quotation-details">
        <h3>Quotation Details</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product/Service</th>
                    <th>Price (₹)</th>
                    <th>Tax (%)</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }}</td>
                    <td>{{ $product->pivot->tax }}</td>
                    <td>{{ number_format($product->pivot->price * (1 + $product->pivot->tax / 100), 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"></td>
                    <td>{{ number_format($lead->quotation_amount, 2) }}</td>
                    <td>{{ $lead->quotation_tax }}%</td>
                    <td>{{ number_format($lead->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($lead->about_us)
    <div class="about-us">
        <h3>About Us</h3>
        <p>{!! nl2br(e($lead->about_us)) !!}</p>
    </div>
    @endif

    <div class="terms">
        <h3>Terms & Conditions</h3>
        <ul>
            @if($lead->quotation_terms)
            @foreach(json_decode($lead->quotation_terms) as $term)
            <li>{{ $term }}</li>
            @endforeach
            @endif
        </ul>
        <p>Validity: {{ $lead->quotation_validity }} days (till {{ $lead->quotation_expiry_date ?
            \Carbon\Carbon::parse($lead->quotation_expiry_date)->format('d/m/Y') : 'N/A' }})</p>
    </div>

    @if($lead->quotation_notes)
    <div class="notes">
        <h3>Additional Notes</h3>
        <p>{!! nl2br(e($lead->quotation_notes)) !!}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer generated quotation and does not require a signature.</p>
    </div>
</body>

</html> --}}

{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation for {{ $products[0]['name'] ?? 'Products' }}</title>
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

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="text-center logo">
        <h2>iSaral Business Solutions Pvt Ltd</h2>
        <p>#16, GF, 4th Main Road, Dwarakanagar, Nagarabhawi, Bangalore - 560072</p>
        <p>Phone: +91 9108024198 | Email: rajesh@isaral.in | Web: www.isaral.in</p>
    </div>

    <hr>

    <div class="text-center">
        <h3>QUOTATION</h3>
        <p>Ref: {{ $quotation_reference ?? 'iSaral/'.date('Y').'/'.mt_rand(100, 999) }} | Date: {{ date('d-m-Y') }}</p>
    </div>

    <p><strong>To,</strong><br>
        {{ $lead->name }}<br>
        {{ $lead->address }}<br>
        {{ $lead->mobile }} | {{ $lead->email }}</p>

    <h3>Subject: Quotation for
        @foreach($products as $product)
        {{ $product['name'] }}@if(!$loop->last), @endif
        @endforeach
    </h3>

    <p>Dear Sir/Madam,</p>
    <p>Thank you for your inquiry. We are pleased to submit our quotation as per your requirements.</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Description</th>
                <th class="text-right">Unit Price (₹)</th>
                <th class="text-right">Tax ({{ $tax_rate ?? 18 }}%)</th>
                <th class="text-right">Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $subtotal = 0;
            $totalTax = 0;
            $grandTotal = 0;
            @endphp

            @foreach($products as $product)
            @php
            $productTax = ($product['price'] * ($product['tax_rate'] ?? $tax_rate ?? 18)) / 100;
            $productTotal = $product['price'] + $productTax;
            $subtotal += $product['price'];
            $totalTax += $productTax;
            $grandTotal += $productTotal;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $product['name'] }}</strong><br>
                    {{ $product['description'] ?? 'No description available' }}
                </td>
                <td class="text-right">{{ number_format($product['price'], 2) }}</td>
                <td class="text-right">{{ number_format($productTax, 2) }}</td>
                <td class="text-right">{{ number_format($productTotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Subtotal</strong></td>
                <td class="text-right"><strong>{{ number_format($subtotal, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalTax, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3>Terms & Conditions:</h3>
    <ol>
        @foreach($terms as $term)
        <li>{{ $term }}</li>
        @endforeach
        @if($additional_terms)
        <li>{{ $additional_terms }}</li>
        @endif
        <li>Validity of this quotation: {{ $validity_days ?? 15 }} days from the date of issue.</li>
        <li>Payment Terms: 100% advance payment.</li>
    </ol>

    <h3>Bank Details:</h3>
    <table>
        <tr>
            <th>Bank Name</th>
            <td>ICICI Bank</td>
        </tr>
        <tr>
            <th>Account Name</th>
            <td>iSaral Business Solutions Pvt Ltd</td>
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
            <td>Hebbal Branch, Bangalore</td>
        </tr>
    </table>

    @if($notes)
    <h3>Additional Notes:</h3>
    <p>{!! nl2br(e($notes)) !!}</p>
    @endif

    <div class="footer">
        <p>Thank you for your business. We look forward to serving you.</p>
        <p><strong>For iSaral Business Solutions Pvt Ltd</strong></p>
        <br><br>
        <p><strong>Authorized Signatory</strong></p>
    </div>
</body>

</html> --}}

{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation for {{ $products[0]['name'] ?? 'Products' }}</title>
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

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="text-center logo">
        <h2>iSaral Business Solutions Pvt Ltd</h2>
        <p>#16, GF, 4th Main Road, Dwarakanagar, Nagarabhawi, Bangalore - 560072</p>
        <p>Phone: +91 9108024198 | Email: rajesh@isaral.in | Web: www.isaral.in</p>
    </div>

    <hr>

    <div class="text-center">
        <h3>QUOTATION</h3>
        <p>Ref: {{ $quotation_reference ?? 'iSaral/'.date('Y').'/'.mt_rand(100, 999) }} | Date: {{ date('d-m-Y') }}</p>
    </div>

    <p><strong>To,</strong><br>
        {{ $lead->name }}<br>
        {{ $lead->address }}<br>
        {{ $lead->mobile }} | {{ $lead->email }}</p>

    <h3>Subject: Quotation for
        @foreach($products as $product)
        {{ $product->name }}@if(!$loop->last), @endif
        @endforeach
    </h3>

    <p>Dear Sir/Madam,</p>
    <p>Thank you for your inquiry. We are pleased to submit our quotation as per your requirements.</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Description</th>
                <th class="text-right">Unit Price (₹)</th>
                <th class="text-right">Tax ({{ $tax_rate ?? 18 }}%)</th>
                <th class="text-right">Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $subtotal = 0;
            $totalTax = 0;
            $grandTotal = 0;
            @endphp

            @foreach($products as $product)
            @php
            $productTax = ($product->pivot->price * ($product->pivot->tax ?? $tax_rate ?? 18)) / 100;
            $productTotal = $product->pivot->price + $productTax;
            $subtotal += $product->pivot->price;
            $totalTax += $productTax;
            $grandTotal += $productTotal;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $product->name }}</strong><br>
                    {{ $product->description ?? ' ' }}
                </td>
                <td class="text-right">{{ number_format($product->pivot->price, 2) }}</td>
                <td class="text-right">{{ number_format($productTax, 2) }}</td>
                <td class="text-right">{{ number_format($productTotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Subtotal</strong></td>
                <td class="text-right"><strong>{{ number_format($subtotal, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalTax, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3>Terms & Conditions:</h3>
    <ol>
        @foreach($terms as $term)
        <li>{{ $term }}</li>
        @endforeach
        <li>Validity of this quotation: {{ $validity_days ?? 15 }} days from the date of issue.</li>
        <li>Payment Terms: 100% advance payment.</li>
    </ol>

    <h3>Bank Details:</h3>
    <table>
        <tr>
            <th>Bank Name</th>
            <td>ICICI Bank</td>
        </tr>
        <tr>
            <th>Account Name</th>
            <td>iSaral Business Solutions Pvt Ltd</td>
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
            <td>Hebbal Branch, Bangalore</td>
        </tr>
    </table>

    @if($notes)
    <h3>Additional Notes:</h3>
    <p>{!! nl2br(e($notes)) !!}</p>
    @endif

    <div class="footer">
        <p>Thank you for your business. We look forward to serving you.</p>
        <p><strong>For iSaral Business Solutions Pvt Ltd</strong></p>
        <br><br>
        <p><strong>Authorized Signatory</strong></p>
    </div>
</body>

</html> --}}
