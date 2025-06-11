@extends('layouts.app')

@section('content')

<style>
    .cart-total th, .cart-total td {
        color: green;
        font-weight: bold;
        font-size: 21px !important;
    }
    /* Ensure error messages are visible */
    .invalid-feedback {
        display: none;
    }
    .is-invalid ~ .invalid-feedback {
        display: block;
    }
    .phone-group {
        display: flex;
        align-items: center;
        border: 1px solid #ced4da; /* Match Bootstrap form-control border */
        border-radius: 0.25rem; /* Match Bootstrap form-control border-radius */
        overflow: hidden; /* Ensure no gaps between elements */
        background-color: #fff; /* Match input background */
    }
    .phone-group select {
        width: 30%; /* Smaller width for country code */
        border: none; /* Remove inner border */
        border-right: 1px solid #ced4da; /* Separator between country code and phone */
        border-radius: 0; /* No border-radius on select */
        padding: 0 0.5rem; /* Adjust padding for smaller appearance */
        font-size: 0.875rem; /* Smaller font for country code */
        background-color: #f8f9fa; /* Light background to distinguish */
        height: 100%; /* Match height of input */
        appearance: none; /* Remove default dropdown arrow */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' viewBox='0 0 16 16'%3E%3Cpath d='M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z'/%3E%3C/svg%3E"); /* Custom dropdown arrow */
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 12px;
    }
    .phone-group input {
        border: none; /* Remove inner border */
        border-radius: 0; /* No border-radius on input */
        flex: 1; /* Take remaining space */
        padding-left: 0.75rem; /* Match Bootstrap padding */
        height: 58px; /* Match form-floating height */
    }
    .phone-group input:focus, .phone-group select:focus {
        outline: none; /* Remove default focus outline */
        box-shadow: none; /* Remove Bootstrap focus shadow */
    }
    .form-floating .phone-group {
        height: 58px; /* Ensure consistent height with other inputs */
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<main class="pt-90">
    <section class="shop-checkout container">
        <form name="checkout-form" action="{{ route('cart.placeOrder') }}" method="POST">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-6">
                            <h4>SHIPPING DETAILS</h4>
                        </div>
                        <div class="col-6">
                            @if($address)
                                <a href="#" class="btn btn-info btn-sm float-right">Change Address</a>
                                <a href="#" class="btn btn-warning btn-sm float-right mr-3">Edit Address</a>
                            @endif
                        </div>
                    </div>

                    @if($address)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-account__address-list">
                                    <div class="my-account__address-item">
                                        <div class="my-account__address-item__detail">
                                            <p>{{ $address->email }}</p>
                                            <p>{{ $address->name }}</p>
                                            <p>{{ $address->address }}</p>
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            <p>{{ $address->zip }}</p>
                                            <p>Phone: {{ $address->phone }}</p>
                                            <p>Locality: {{ $address->locality }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    <label for="email">Email *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    <label for="name">Full Name *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}">
                                    <label for="country">Country *</label>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <div class="phone-group">
                                        <select name="country_code" id="country_code" class="@error('country_code') is-invalid @enderror">
                                            <option value="+92" {{ old('country_code') == '+92' ? 'selected' : '' }}>+92</option>
                                            <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                            <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                            <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="3XX XXXXXXX">
                                    </div>
                                    <label for="phone" style="top: -1.1rem;background-color: #fff;">Phone Number *</label>
                                    @error('country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="phone-feedback" class="text-muted"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}">
                                    <label for="zip">Postal Code *</label>
                                    @error('zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}">
                                    <label for="state">State *</label>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                                    <label for="city">Town / City *</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                                    <label for="address">House no, Building Name *</label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('locality') is-invalid @enderror" id="locality" name="locality" value="{{ old('locality') }}">
                                    <label for="locality">Road Name, Area, Colony *</label>
                                    @error('locality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @php
                    $cartSubtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
                    $shippingCost = ($cartSubtotal > 5999) ? 0 : 250;
                @endphp

                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">
                        <div class="checkout__totals">
                            <h3>Your Order</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th class="text-right">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::instance('cart')->content() as $item)
                                        <tr>
                                            <td>{{ $item->name }} x {{ $item->qty }}</td>
                                            <td class="text-right">PKR {{ $item->subtotal }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if(session()->has('discounts'))
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-right">PKR {{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount {{ session()->get("coupon")["code"] }}</th>
                                            <td class="text-right">-PKR {{ session()->get("discounts")["discount"] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal After Discount</th>
                                            <td class="text-right">PKR {{ session()->get("discounts")["subtotal"] }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-right">
                                                @if($shippingCost == 0)
                                                    Free
                                                @else
                                                    PKR {{ number_format($shippingCost, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td class="text-right">PKR {{ session()->get("discounts")["tax"] }}</td>
                                        </tr>
                                        <tr class="cart-total">
                                            <th>Total</th>
                                            <td class="text-right">
                                                PKR {{ number_format((float) str_replace(',', '', session()->get("discounts")["total"]) + $shippingCost, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td class="text-right">PKR {{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td class="text-right">
                                                @if($shippingCost == 0)
                                                    Free
                                                @else
                                                    PKR {{ number_format($shippingCost, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td class="text-right">PKR {{ Cart::instance('cart')->tax() }}</td>
                                        </tr>
                                        <tr class="cart-total">
                                            <th>TOTAL</th>
                                            <td class="text-right">
                                                PKR {{ number_format((float) str_replace(',', '', Cart::instance('cart')->total()) + $shippingCost, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="checkout__payment-methods">
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill @error('mode') is-invalid @enderror" type="radio" name="mode" value="card" id="mode_1">
                                <label class="form-check-label" for="mode_1">Debit or Credit Card (Coming Soon)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill @error('mode') is-invalid @enderror" type="radio" name="mode" value="cod" checked id="mode_3">
                                <label class="form-check-label" for="mode_3">Cash on delivery</label>
                            </div>
                            @error('mode')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @endif
                            <div class="policy-text">
                                Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="{{ route('privacy.policy') }}" target="_blank">privacy policy</a>.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">PLACE ORDER</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<script>
    document.getElementById('phone').addEventListener('input', function(e) {
        let input = e.target;
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-digits
        input.value = value; // Update input with cleaned value

        let feedback = document.getElementById('phone-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.id = 'phone-feedback';
            feedback.className = 'text-muted';
            input.parentNode.appendChild(feedback);
        }

        // Validation rules
        if (value.length === 0) {
            feedback.textContent = 'Enter a 10-digit phone number starting with 3 (e.g., 3XX XXXXXXX).';
            feedback.style.color = 'gray';
            input.classList.remove('is-invalid');
        } else if (value.length !== 10 || !value.startsWith('3')) {
            feedback.textContent = 'Phone number must be exactly 10 digits and start with 3 (e.g., 3XX XXXXXXX).';
            feedback.style.color = 'red';
            input.classList.add('is-invalid');
        } else {
            feedback.textContent = 'Valid phone number.';
            feedback.style.color = 'green';
            input.classList.remove('is-invalid');
        }
    });
</script>

@endsection