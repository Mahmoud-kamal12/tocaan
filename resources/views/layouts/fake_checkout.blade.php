<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fake PayPal Checkout</title>
</head>
<body>
<h2>🔒 Simulated Payment Gateway</h2>
<p>You are simulating a payment for a test order.</p>
<a href="{{ route('payment.callback', ['paymentId' => $token]) }}?status=success">✅ Simulate Success</a><br><br>
<a href="{{ route('payment.callback', ['paymentId' => $token]) }}?status=failure">❌ Simulate Failure</a>
</body>
</html>
