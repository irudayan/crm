<!DOCTYPE html>
<html>

<head>
    <title>Demo Details</title>
</head>

<style>
    .contact-info {
        margin-top: 20px;
        font-size: 16px;
    }

    .contact-info a {
        color: #007BFF;
        text-decoration: none;
    }

    .contact-info a:hover {
        text-decoration: underline;
    }
</style>

<body>
    {{-- <h1>Demo Details</h1> --}}
    <p>Dear {{ $lead->name }},</p>
    <p>Thank you for your interest. Below are the details of your quotation:</p>

    <h2>Lead Demo Information</h2>

    <ul>
        <li><strong>Date:</strong> {{ $lead->demo_date }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($lead->demo_time)->format('h:i A') }}</li>
    </ul>

    <h2>Products</h2>
    <ul>
        @if ($lead->products->isNotEmpty())
            @foreach ($lead->products as $product)
                <span class="badge badge-info">{{ $product->name }} &nbsp; - <strong>₹.
                        {{ $product->price }}</strong></span>
            @endforeach
        @else
            <span class="text-muted">No Products</span>
        @endif

        {{-- @foreach ($products as $product)
            <li>{{ $product->name }} - ${{ $product->price }}</li>
        @endforeach --}}
    </ul>

    <p>Best regards,</p>
    <div class="contact-info">
        <p>For any clarification, feel free to contact us.</p>
        <p>Yours truly,<br>
            {{ $lead->name }}<br>
            M: <a href="tel:+919108024198">+91 9108024198</a><br>
            E: <a href="mailto:rajesh@isaral.in">rajesh@isaral.in</a></p>
        <p><strong>iSaral Business Solutions Pvt Ltd</strong><br>
            #16, GF, 4th Main Road, Dwarakanagar, Nagarabhavi, Bangalore - 560072<br>
            Web: <a href="http://www.isaral.in">www.isaral.in</a></p>
    </div>
</body>

</html>
