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
            <div class="order-info__item">
              <label>Country</label>
              <span>{{ $order->country ?? 'N/A' }}</span>
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

    // Skip Meta Pixel initialization on localhost
    if (!isLocalhost) {
      // Initialize Meta Pixel only if not already initialized
      if (!window.fbq) {
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.bq=function(){n.callMethod?
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
        "37": "5908gpou8j",
        "57": "cq0sk4qxvy",
        "58": "kmmlkjyql2",
        "63": "p1zdzc9mzv",
        "64": "g8iw9431v2",
        "65": "vd1fjj1l0k",
        "66": "6v3cdj53hv",
        "67": "1wrwcm3s75",
        "68": "wvuhanxezn",


    };

    // Dynamic order data
    const orderValue = parseFloat({{ $order->total }});
    const purchaseCurrency = 'PKR';
    const eventId = '{{ $order->id }}-{{ time() }}';

    const hashedEmail = '{{ hash('sha256', $order->email ?? '') }}';
    const hashedPhone = '{{ hash('sha256', $order->phone ?? '') }}'; // Phone already includes country code
    const hashedName = '{{ hash('sha256', $order->name ?? '') }}';
    const hashedCity = '{{ hash('sha256', strtolower($order->city ?? '')) }}';
    const hashedState = '{{ hash('sha256', strtolower($order->state ?? '')) }}';
    const hashedPostalCode = '{{ hash('sha256', $order->zip ?? '') }}';
    const hashedCountry = '{{ hash('sha256', strtolower($order->country ?? '')) }}'; // Hash country
    const externalId = '{{ addslashes($order->id) }}'; // Use order_id as external ID

    // Extract fbclid from URL and construct fbc with cookie storage
    const urlParams = new URLSearchParams(window.location.search);
    const fbclid = urlParams.get('fbclid') || '';
    const fbcFromCookie = document.cookie.match('(^|;)\\s*_fbc\\s*=\\s*([^;]*)')?.[2] || '';
    const fbc = fbclid ? `fb.1.${Math.floor(Date.now() / 1000)}.${fbclid}` : fbcFromCookie;

    // Store fbc in cookie if fbclid is present and no existing _fbc
    if (fbclid && !fbcFromCookie) {
        document.cookie = `_fbc=${fbc}; max-age=7776000; path=/;`; // 90 days in seconds
    }

    if (!fbc) {
        console.warn('No fbc found, attribution may be incomplete.');
    } else {
        console.log('fbc:', fbc);
    }

    // Get the client IP (prefer IPv6 if available)
    const clientIp = '<?php
      $ip = request()->ip();
      if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        echo $ip;
      } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $forwarded = request()->header('X-Forwarded-For');
        if ($forwarded) {
          $ips = explode(',', $forwarded);
          foreach ($ips as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
              echo $ip;
              break;
            }
          }
        }
        echo $ip;
      } else {
        echo '';
      }
    ?>';

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
        num_items: {{ $order->orderItems->sum('quantity') }},
        fbc: fbc
      }, { eventID: eventId });

      // Send Meta Conversion API Purchase Event only if not on localhost
      if (!isLocalhost) {
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
                ph: [hashedPhone],
                fn: [hashedName],
                ct: [hashedCity],
                st: [hashedState],
                zp: [hashedPostalCode],
                cn: [hashedCountry],
                external_id: [externalId],
                client_ip_address: clientIp,
                client_user_agent: navigator.userAgent,
                fbc: fbc,
                fbp: document.cookie.match('(^|;)\\s*_fbp\\s*=\\s*([^;]*)')?.[2] || ''
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
        console.warn('Conversion API call blocked on localhost');
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