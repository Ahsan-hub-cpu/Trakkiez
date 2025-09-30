@extends('layouts.app')
@section('content')
<style>
    /* Contact Page Color Scheme */
    .contact-header {
        background: var(--bg-gradient-dark);
        color: white;
        padding: 60px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .contact-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="contactGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="%23ff6b6b" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23contactGrid)"/></svg>');
        opacity: 0.1;
        z-index: 1;
    }

    .contact-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
        text-transform: uppercase;
    }

    .contact-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .contact-form-section {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: 40px;
        margin: 40px 0;
    }

    .form-title {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-floating {
        margin-bottom: 25px;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        padding: 15px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        outline: none;
    }

    .form-control_gray {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        padding: 15px;
        font-size: 1rem;
        transition: var(--transition);
        resize: vertical;
        min-height: 120px;
    }

    .form-control_gray:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        outline: none;
    }

    .form-label {
        color: var(--text-secondary);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .text-danger {
        color: var(--danger-color) !important;
        font-size: 0.9rem;
        margin-top: 5px;
        display: block;
    }

    .alert-success {
        background: rgba(78, 205, 196, 0.1);
        border: 2px solid var(--success-color);
        color: var(--success-color);
        padding: 15px 20px;
        border-radius: var(--border-radius-sm);
        margin-bottom: 25px;
        font-weight: 600;
    }

    .contact-info {
        background: var(--bg-gradient);
        color: white;
        border-radius: var(--border-radius);
        padding: 40px;
        margin: 40px 0;
        text-align: center;
    }

    .contact-info h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contact-info p {
        font-size: 1.1rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .contact-info a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .contact-info a:hover {
        color: var(--warning-color);
        text-decoration: underline;
    }

    .contact-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin: 40px 0;
    }

    .contact-method {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        padding: 30px;
        text-align: center;
        transition: var(--transition);
    }

    .contact-method:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }

    .contact-method i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .contact-method h4 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 15px;
    }

    .contact-method p {
        color: var(--text-secondary);
        margin-bottom: 10px;
    }

    .contact-method a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .contact-method a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .contact-header {
            padding: 40px 0;
        }
        
        .contact-title {
            font-size: 2.5rem;
        }
        
        .contact-form-section {
            padding: 25px;
            margin: 20px 0;
        }
        
        .form-title {
            font-size: 1.5rem;
        }
        
        .contact-info {
            padding: 25px;
            margin: 20px 0;
        }
        
        .contact-methods {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .contact-title {
            font-size: 2rem;
        }
        
        .contact-form-section {
            padding: 20px;
        }
        
        .contact-info {
            padding: 20px;
        }
        
        .contact-method {
            padding: 20px;
        }
    }
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">CONTACT US</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if(session()->has('success'))
            <div class= "alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{route('home.contact.store')}}" method="POST">
            @csrf
            <h3 class="mb-5">Get In Touch</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Name *" value="{{old('name')}}" required="">
              <label for="contact_us_name">Name *</label>
              @error('name')<span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Phone *" value="{{old('phone')}}" required="">
              <label for="contact_us_name">Phone *</label>
              @error('phone')<span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Email address *"  value="{{old('email')}}" required="">
              <label for="contact_us_name">Email address *</label>
              @error('email')<span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" name="comment" placeholder="Your Message"  cols="30"
                rows="8" required="">{{old('comment')}}</textarea>
                @error('comment')<span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
@endsection