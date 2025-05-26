@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      @if(isset($order) && $order->orderItems->isNotEmpty())
        <h2 class="page-title">Order Received</h2>
        <div class="checkout-steps">
          <a href="javascript:void(0)" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">01</span>
            <span class="checkout-steps__item-title">
              <span>Shopping Bag</span>
              <em>Manage Your Items List</em>
            </span>
          </a>
          <a href="javascript:void(0)" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">02</span>
            <span class="checkout-steps__item-title">
              <span>Shipping and Checkout</span>
              <em>Checkout Your Items List</em>
            </span>
          </a>
          <a href="javascript:void(0)" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">03</span>
            <span class="checkout-steps__item-title">
              <span>Confirmation</span>
              <em>Review And Submit Your Order</em>
            </span>
          </a>
        </div>
        <div class="order-complete">
          <div class="order-complete__message">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="40" cy="40" r="40" fill="#B9A16B" />
              <path
                d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                fill="white" />
            </svg>
            <h3>Your order is completed!</h3>
            <p>Thank you. Your order has been received.</p>
          </div>
          <div class="order-info">
            <div class="order-info__item">
              <label>Order Number</label>
              <span>{{ $order->id }}</span>
            </div>
            <div class="order-info__item">
              <label>Date</label>
              <span>{{ $order->created_at }}</span>
            </div>
            <div class="order-info__item">
              <label>Total</label>
              <span>PKR {{ $order->total }}</span>
            </div>
            <div class="order-info__item">
              <label>Payment Method</label>
              <span>{{ $order->transaction->mode ?? 'N/A' }}</span>
            </div>
          </div>
          <div class="checkout__totals-wrapper">
            <div class="checkout__totals">
              <h3>Order Details</h3>
              <table class="checkout-cart-items">
                <thead>
                  <tr>
                    <th>PRODUCT</th>
                    <th>SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->orderItems as $item)
                    <tr>
                      <td>{{ $item->product->name ?? 'Unknown' }} x {{ $item->quantity }}</td>
                      <td>PKR {{ $item->price }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <table class="checkout-totals">
                <tbody>
                  <tr>
                    <th>SUBTOTAL</th>
                    <td>PKR {{ $order->subtotal }}</td>
                  </tr>
                  <tr>
                    <th>Discount</th>
                    <td>PKR {{ $order->discount }}</td>
                  </tr>
                  <tr>
                    <th>VAT</th>
                    <td>PKR {{ $order->tax }}</td>
                  </tr>
                  <tr>
                    <th>Shipping</th>
                    <td>
                      @if($order->shipping_cost == 0)
                        Free
                      @else
                        PKR {{ $order->shipping_cost }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>TOTAL</th>
                    <td>PKR {{ $order->total }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @else
        <h2 class="page-title">Order Not Found</h2>
        <p>Sorry, we couldn't find your order. Please contact support if you believe this is an error.</p>
      @endif
    </section>
  </main>
  @if(isset($order) && $order->orderItems->isNotEmpty())
  <script>
    // Hardcoded Meta Pixel ID and Access Token
    const pixelId = '678618305092613';
    const accessToken = 'EAAPGeif5o1wBO6umaEGfgonCkNYlxRjTKmftZAXhgsIIjFRn2Y7VJGpZAjGG1S00j6UIlRwbZBSvXAZC6QHJupoqXZBu84yM0DV2tb2YpRKWWumTszW42AY1y6BuCfc1OZB8iIZC1p6AxCr0lIICGPbW2HhuhZCSupHlNh6xkLK1xrj7qtlz6Q1b17yoSVwUUlW6UwZDZD';

    // Initialize Meta Pixel only if not already initialized
    if (!window.fbq) {
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', pixelId);
      fbq('track', 'PageView');
    }

    // Catalog ID mapping for products
    const catalogIdMapping = {
        "7": "lzcxdcwcjq",
        "8": "vvdkpfyo97",
        "9": "r6hbm1fys5",
        "10": "78okh2lki8",
        "11": "kpcuffj8qf",
        "12": "n37sgyamlh",
        "13": "o71vv7yw03",
        "14": "i5hyrhxj5u",
        "15": "cxsgtz0uaa",
        "16": "9svfprctuj",
        "17": "8yior2enng",
        "18": "95gwctlrqb",
        "19": "ok8gk6giow",
        "20": "m265cq9rfy",
        "21": "h5nkmf7z7j",
        "22": "kqgnmnpetl",
        "23": "zuc6dz8spm",
        "24": "htratecte3",
        "25": "3249vkp896",
        "26": "s5sk2qd9t9",
        "27": "btvi71orfs",
        "28": "x641eyppw2",
        "29": "rdeiaok8if",
        "30": "moi7fdic3w",
        "31": "yti5zvhg08",
        "32": "yti5zvhg08",
        "33": "lkdawofeo8",
        "34": "2mo4k3xeit",
        "35": "khdxo55zun",
        "36": "uktf65qy1r",
        "37": "5908gpou8j"
    };

    // Dynamic order data
    const orderValue = parseFloat({{ $order->total }});
    const purchaseCurrency = 'PKR'; // Avoid overwrite
    const eventId = '{{ $order->id }}-{{ time() }}';
    // Fetch email from Orders table, fallback to User table
    const hashedEmail = '{{ hash('sha256', $order->email ?? ($order->user->email ?? '')) }}';

    // Send Meta Pixel and Conversion API Events
    if (typeof fbq === 'function') {
      // Content IDs for both Pixel and API
      const contentIds = [
        @foreach($order->orderItems as $item)
          catalogIdMapping['{{ addslashes($item->product_id) }}'] || '{{ addslashes($item->product_id) }}'@if(!$loop->last),@endif
        @endforeach
      ].filter(id => id); // Remove undefined/null IDs

      // Contents for Pixel (with content_name)
      const pixelContents = [
        @foreach($order->orderItems as $item)
          {
            id: catalogIdMapping['{{ addslashes($item->product_id) }}'] || '{{ addslashes($item->product_id) }}',
            quantity: {{ $item->quantity }},
            item_price: parseFloat({{ $item->quantity > 0 ? ($item->price / $item->quantity) : 0 }}),
            content_name: '{{ addslashes($item->product->name ?? 'Unknown') }}'
          }@if(!$loop->last),@endif
        @endforeach
      ];

      // Contents for Conversion API (without content_name)
      const apiContents = [
        @foreach($order->orderItems as $item)
          {
            id: catalogIdMapping['{{ addslashes($item->product_id) }}'] || '{{ addslashes($item->product_id) }}',
            quantity: {{ $item->quantity }},
            item_price: parseFloat({{ $item->quantity > 0 ? ($item->price / $item->quantity) : 0 }})
          }@if(!$loop->last),@endif
        @endforeach
      ];

      // Send Meta Pixel Purchase Event
      fbq('track', 'Purchase', {
        value: orderValue,
        currency: purchaseCurrency,
        content_type: 'product',
        content_ids: contentIds,
        contents: pixelContents,
        order_id: '{{ addslashes($order->id) }}',
        eventID: eventId,
        num_items: {{ $order->orderItems->sum('quantity') }}
      });

      // Send Meta Conversion API Purchase Event
      fetch(`https://graph.facebook.com/v20.0/${pixelId}/events?access_token=${accessToken}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          data: [{
            event_name: 'Purchase',
            event_time: Math.floor(Date.now() / 1000),
            event_id: eventId,
            action_source: 'website',
            event_source_url: window.location.href,
            user_data: {
              em: [hashedEmail],
              client_ip_address: '{{ request()->ip() }}',
              client_user_agent: navigator.userAgent,
              fbc: document.cookie.match('(^|;)\\s*_fbc\\s*=\\s*([^;]+)')?.pop() || '',
              fbp: document.cookie.match('(^|;)\\s*_fbp\\s*=\\s*([^;]+)')?.pop() || ''
            },
            custom_data: {
              value: orderValue,
              currency: purchaseCurrency,
              content_type: 'product',
              content_ids: contentIds,
              contents: apiContents,
              order_id: '{{ addslashes($order->id) }}',
              num_items: {{ $order->orderItems->sum('quantity') }}
            }
          }]
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log('Meta Conversion API Response:', data);
      })
      .catch(error => {
        console.error('Meta Conversion API Error:', error);
      });
    } else {
      console.warn('Meta Pixel not initialized.');
    }
  </script>
  @else
  <script>
    console.warn('Order data is missing or incomplete. Order ID: {{ $order->id ?? 'N/A' }}');
  </script>
  @endif
@endsection