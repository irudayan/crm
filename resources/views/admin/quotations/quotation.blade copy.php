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
            color: #777;
        }

        img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
    </style>

</head>

<body>
    <div class="logo">
        <img src="{{ public_path('backend/images/logo/pdflink.png') }}" alt="iSaral Business Solutions">
    </div>

    <center>
        <h3>Proposal for Tally Prime</h3>
    </center>

    <p><strong>To,</strong><br>
        {{ $lead->name }}<br>
        {{ $lead->address }}</p>

    <hr>

    <center>
        <h3>About iSaral Business Solutions Pvt Ltd</h3>
    </center>
    <p>We are a premier Enterprise solutions company addressing requirements of customers worldwide, helping
        businesses
        improve processes by taking advantage of web-based technologies. At iSaral Business Solutions, we create
        Enterprise solutions; a seamless means of changing the way companies do business, by speeding up
        communication
        and information flow, enhancing productivity, extending their enterprise to their clients, and building
        global
        brands.</p>

    <p>iSaral Business Solutions is the Certified Partner for Tally Solutions Pvt Ltd, Sag infotech Pvt Ltd, and
        Distributor for Sify Technologies Ltd, eMudhra Ltd, Capricorn & Pantasign (Digital Signature).</p>

    <p>iSaral has a commitment to performance, excellence, and client satisfaction, after-sale support, and software
        development services.</p>

    <p>We provide software that streamlines your business process with exclusive features that increase efficiency,
        improve communications, and enhance performance, allowing you to be more productive, better equipped, and at
        a
        lower cost.</p>

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

    <table class="table">
        <tr>
            <th>SL No</th>
            <th>Prodduct</th>
            <th>Total</th>
        </tr>

        <tr>
            <td> 1 .</td>
            <td>
                $lead->products->pluck('name')->implode('
            <td></td> ')
            @dd($lead->product->name)
            @if ($lead->products->isNotEmpty())
                @foreach ($lead->products as $product)
                    <span class="badge badge-info">{{ $product->name }}</span>
                @endforeach
            @else
                <span class="text-muted">No Products</span>
            @endif
            </td>
            <td>
                @if ($lead->products->isNotEmpty())
                    <strong>₹. {{ number_format($lead->products->sum('price'), 2) }}</strong>
                @else
                    <span class="text-muted">No Price</span>
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="3">Free Addons: Auto Backup, WhatsApp Module</td>
        </tr>
    </table>

    <p class="note"><strong>Note:</strong>
        {{ number_format($product->price, 2) }} 18% GST Extra</p>
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

    <h3>Tally Software Installation</h3>
    <ol>
        <li>Installation by online / Offline, depending on client requirement. Visiting Client Place only @
            Bangalore,
            Rest of Bangalore only online.</li>
        <li>Add-on will be provided @ Free of cost (According to the Plan).</li>
        <li>Existing Customized Tools will be given @ 50% Discount.</li>
        <li>Any other customizations will be charged extra based on your requirements.</li>
        <li>No back-end data entry support.</li>
    </ol>

    <h3>Support Process:</h3>
    <p><em>The help desk will be available on working days from 10 AM to 7 PM.</em></p>
    <ol>
        <li>Application Support.</li>
        <li>Telephonic and remote support has always been the very strong point of iSaral, so continuing our
            tradition,
            we provide support.</li>
        <li>Support @ Client End (if needed), in case of Onsite Solution. - charged separately depending on time,
            location & requirements.</li>
    </ol>


    <h3>Pre-Requisites</h3>
    <ol>
        <li>Tally Prime Supports only Windows 64 Bit OS.</li>
        <li>Internet connectivity for installation and support.</li>
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
