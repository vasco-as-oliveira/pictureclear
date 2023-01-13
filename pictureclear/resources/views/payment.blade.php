<link rel="stylesheet" href="{{ asset('/css/payment.css') }}" />
<script src="https://js.stripe.com/v3/"
integrity="sha384-Af044HDnlFb8FD1DzMtPCnFXTGCgQxkn+0GLaVHa3pm3GKV4BUpDfrXuWNifEq3u"
crossorigin="anonymous"></script>
<form action="{{ url('charge') }}" method="post" id="payment-form">
    <div class="form-row">
        <p><input type="text" name="amount" placeholder="Enter Amount" /></p>
        <p><input type="email" name="email" placeholder="Enter Email" /></p>
        <label for="card-element">
            or debit card
        </label>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <button>Submit Payment</button>
    {{ csrf_field() }}
</form>
<script>
    var publishable_key = '{{ env('STRIPE_PUBLISHABLE_KEY') }}';
</script>
<script src="{{ asset('/js/card.js') }}"></script>
