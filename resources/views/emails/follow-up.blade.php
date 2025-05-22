<!DOCTYPE html>
<html>
<head>
    <title>Follow Up Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .footer { margin-top: 20px; font-size: 0.9em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Follow Up Reminder</h2>
        </div>

        <p>Hello {{ $lead->name }},</p>

        <p>This is a reminder for our scheduled follow-up:</p>

        <p><strong>Date:</strong> {{ $followDateTime->format('F j, Y') }}</p>
        <p><strong>Time:</strong> {{ $followDateTime->format('h:i A') }}</p>

        @if($products->count() > 0)
            <p><strong>Products Discussed:</strong></p>
            <ul>
                @foreach($products as $product)
                    <li>{{ $product->name }}</li>
                @endforeach
            </ul>
        @endif

        <p>Please let us know if you need to reschedule.</p>

        <div class="footer">
            <p>Best regards,<br>
            {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
