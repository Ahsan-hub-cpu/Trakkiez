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
            <h3>Your order is completed!</h3>
            <!-- Alternative SVG with corrected path for testing -->
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
              <circle cx="40" cy="40" r="40" fill="#B9A16B" />
              <path d="M53 36 C53 35.5 52.8 35 52.5 34.6 L50.2 32.3 C49.9 32 49.5 31.9 49.1 31.9 C48.7 31.9 48.3 32.3 L37 43.3 L32 38.4 C31.7 38.1 31.3 37.9 30.9 37.9 C30.5 37.9 30.1 38.1 29.8 38.4 L27.5 40.7 C27.2 41 27 41.4 27 41.8 C27 42.2 27.2 42.7 27.5 43 L33.6 49 L35.8 51.3 C36.1 51.6 36.5 51.8 37 51.8 C37.4 51.8 37.8 51.6 38.1 51.3 L40.4 49 L52.5 36.9 C52.8 36.6 53 36.2 53 36 Z" fill="white" />
            </svg>
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
    // Block all Meta tracking on localhost
    const blockedHosts = ['localhost', '127.0.0.1'];
    const isLocalhost = blockedHosts.includes(window.location.hostname);
    if (isLocalhost) {
      window.fbq = function() {
        console.log('Meta Pixel blocked on localhost:', arguments);
      };
    }

    // Hardcoded Meta Pixel ID and Access Token
    const pixelId = '678618305092613';
    const accessToken = 'EAAPGeif5o1wBO6umaEGfgonCkNYlxRjTKmftZAXhgsIIjFRn2Y7VJGpZAjGG1S00j6UIlRwbZBSvXAZC6QHJupoqXZBu84yM0DV2tb2YpRKWWumTszW42AY1y6BuCfc1OZB8iIZC1p6AxCr0lIICGPbW2HhuhZCSupHlNh6xkLK1xrj7qtlz6Q1b17yoSVwUUlW6UwZDZD';

    // Function to get URL parameter
    function getUrlParameter(name) {
      const regex = new RegExp('[?&]' + name + '=([^&#]*)');
      const results = regex.exec(window.location.href);
      return results ? decodeURIComponent(results[1].replace(/\+/g, ' ')) : '';
    }

    // Check for fbclid in the URL and set _fbc cookie if not present
    const fbclid = getUrlParameter('fbclid');
    if (fbclid && !document.cookie.match('(^|;)\\s*_fbc\\s*=\\s*([^;]+)')) {
      const timestamp = Math.floor(Date.now() / 1000);
      const fbcValue = `fb.1.${timestamp}.${fbclid}`;
      document.cookie = `_fbc=${fbcValue}; path=/; max-age=${60 * 60 * 24 * 90}; SameSite=Lax`; // 90-day expiry
    }

    // Skip Meta Pixel initialization on localhost
    if (!isLocalhost) {
      // Initialize Meta Pixel only if not already initialized
      if (!window.fbq) {
        !function(f,b,e,v,n,t,s)
        {if(f lucreturn;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', pixelId);
        fbq('track', 'PageView');
      }
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

      // Send Meta Conversion API Purchase Event only if not on localhost
      if (!isLocalhost) {
        if (isLocalhost) {
          console.warn('Conversion API call blocked on localhost');
        } else {
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
                  external_id: '{{ hash('sha256', $order->id) }}', // Use hashed order ID as external_id
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
        }
      }
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