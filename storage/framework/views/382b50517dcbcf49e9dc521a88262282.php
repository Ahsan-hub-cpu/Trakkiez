<?php $__env->startSection('content'); ?>
<style>
  /* Product Details Color Scheme */
  .product-details-header {
      background: var(--bg-gradient-dark);
      color: white;
      padding: 40px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
  }

  .product-details-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="detailsGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="%23ff6b6b" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23detailsGrid)"/></svg>');
      opacity: 0.1;
      z-index: 1;
  }

  .product-details-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      position: relative;
      z-index: 2;
  }

  .product-details-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      position: relative;
      z-index: 2;
  }

  .product-gallery {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      overflow: hidden;
      margin-bottom: 30px;
  }

  .main-image {
      width: 100%;
      height: 500px;
      object-fit: cover;
      transition: var(--transition);
  }

  .thumbnail {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: var(--border-radius-sm);
      cursor: pointer;
      transition: var(--transition);
      border: 2px solid transparent;
  }

  .thumbnail:hover,
  .thumbnail.active {
      border-color: var(--primary-color);
      transform: scale(1.05);
  }

  .product-info {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      padding: 30px;
      margin-bottom: 30px;
  }

  .product-title {
      color: var(--text-primary);
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 15px;
  }

  .product-price {
      color: var(--primary-color);
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 20px;
  }

  .product-description {
      color: var(--text-secondary);
      line-height: 1.6;
      margin-bottom: 25px;
  }

  .variation-section {
      margin-bottom: 25px;
  }

  .variation-title {
      color: var(--text-primary);
      font-weight: 600;
      margin-bottom: 15px;
      font-size: 1.1rem;
  }

  .variation-options {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
  }

  .size-btn {
      min-width: 60px;
      position: relative;
      transition: var(--transition);
      border-radius: var(--border-radius-sm);
      padding: 10px 15px;
      border: 2px solid #e9ecef;
      background: white;
      color: var(--text-primary);
      font-weight: 600;
  }

  .size-btn:hover {
      border-color: var(--primary-color);
      color: var(--primary-color);
      transform: translateY(-2px);
  }

  .size-btn.active {
      background: var(--bg-gradient);
      color: white;
      border-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: var(--shadow-light);
  }

  .color-btn {
      min-width: 80px;
      position: relative;
      transition: var(--transition);
      border-radius: var(--border-radius-sm);
      padding: 10px 15px;
      border: 2px solid #e9ecef;
      background: white;
      color: var(--text-primary);
      font-weight: 600;
  }

  .color-btn:hover {
      border-color: var(--primary-color);
      color: var(--primary-color);
      transform: translateY(-2px);
  }

  .color-btn.active {
      border-color: var(--primary-color);
      border-width: 3px;
      transform: scale(1.05);
      box-shadow: var(--shadow-light);
  }

  .color-btn.sold-out {
      opacity: 0.6;
      cursor: not-allowed;
      position: relative;
  }

  .color-btn.sold-out::after {
      content: "______";
      position: absolute;
      top: 30%;
      left: 30%;
      transform: translate(-50%, -50%);
      font-size: 1.2em;
      color: var(--danger-color);
  }

  .quantity-section {
      margin-bottom: 25px;
  }

  .quantity-controls {
      display: flex;
      align-items: center;
      gap: 15px;
  }

  .quantity-btn {
      background: var(--bg-gradient);
      border: none;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      transition: var(--transition);
  }

  .quantity-btn:hover {
      transform: scale(1.1);
      box-shadow: var(--shadow-light);
  }

  .quantity-input {
      width: 60px;
      text-align: center;
      border: 2px solid #e9ecef;
      border-radius: var(--border-radius-sm);
      padding: 8px;
      font-weight: 600;
      color: var(--text-primary);
  }

  .quantity-input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
      outline: none;
  }

  .action-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
  }

  .add-to-cart-btn {
      background: var(--bg-gradient);
      border: none;
      color: white;
      padding: 15px 30px;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      font-size: 1.1rem;
      transition: var(--transition);
      flex: 1;
  }

  .add-to-cart-btn:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .wishlist-btn {
      background: transparent;
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      padding: 15px 20px;
      border-radius: var(--border-radius-sm);
      font-weight: 600;
      transition: var(--transition);
      min-width: 60px;
  }

  .wishlist-btn:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
  }

  .filled-heart {
      color: var(--primary-color);
  }

  .product-tabs {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      margin-bottom: 30px;
  }

  .tab-nav {
      display: flex;
      border-bottom: 2px solid #e9ecef;
  }

  .tab-link {
      padding: 15px 25px;
      color: var(--text-secondary);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border-bottom: 3px solid transparent;
  }

  .tab-link:hover,
  .tab-link.active {
      color: var(--primary-color);
      border-bottom-color: var(--primary-color);
  }

  .tab-content {
      padding: 30px;
  }

  .reviews-section {
      margin-top: 30px;
  }

  .review-item {
      background: #f8f9fa;
      border-radius: var(--border-radius-sm);
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid var(--primary-color);
  }

  .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
  }

  .reviewer-name {
      font-weight: 600;
      color: var(--text-primary);
  }

  .review-rating {
      color: var(--warning-color);
  }

  .review-text {
      color: var(--text-secondary);
      line-height: 1.6;
  }

  .related-products {
      margin-top: 50px;
  }

  .related-title {
      color: var(--text-primary);
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
  }

  .related-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
  }

  .related-card {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-light);
      transition: var(--transition);
      overflow: hidden;
  }

  .related-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
  }

  .related-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
  }

  .related-info {
      padding: 20px;
  }

  .related-name {
      color: var(--text-primary);
      font-weight: 600;
      margin-bottom: 10px;
  }

  .related-price {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.1rem;
  }

  /* Mobile Responsive */
  @media (max-width: 768px) {
      .product-details-header {
          padding: 30px 0;
      }
      
      .product-details-title {
          font-size: 2rem;
      }
      
      .product-info {
          padding: 20px;
          margin-bottom: 20px;
      }
      
      .product-title {
          font-size: 1.5rem;
          margin-bottom: 15px;
      }
      
      .product-price {
          font-size: 1.5rem;
          margin-bottom: 20px;
      }
      
      .action-buttons {
          flex-direction: column;
          gap: 15px;
      }
      
      .related-grid {
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
          gap: 20px;
      }

      /* Mobile-specific improvements */
      .product-single__media {
          margin-bottom: 25px;
      }

      .product-single__name {
          font-size: 1.8rem;
          margin-bottom: 15px;
          line-height: 1.3;
      }

      .product-single__price {
          margin-bottom: 20px;
      }

      .price-display {
          padding: 15px;
          border-radius: 10px;
      }

      .current-price, .sale-price {
          font-size: 1.8rem;
      }

      .original-price {
          font-size: 1.2rem;
      }

      .discount-badge {
          font-size: 0.8rem;
          padding: 6px 12px;
      }

      .product-single__short-desc {
          margin-bottom: 25px;
          font-size: 0.95rem;
          line-height: 1.5;
      }

      .product-single__options {
          margin-bottom: 25px;
      }

      .product-single__addtocart {
          margin-bottom: 25px;
      }

      .color-selector {
          justify-content: flex-start;
          margin-top: 15px;
      }

      .product-single__options .row {
          margin: 0;
      }

      .product-single__options .col-md-6 {
          padding: 0 10px;
      }

      .color-btn {
          width: 45px;
          height: 45px;
          min-width: 45px;
          min-height: 45px;
          max-width: 45px;
          max-height: 45px;
          margin: 8px;
          padding: 0;
          box-sizing: border-box;
          flex-shrink: 0;
          line-height: 1;
      }

      .qty-control {
          margin-bottom: 0;
          justify-content: center;
          padding: 15px;
          gap: 15px;
          flex-wrap: nowrap;
          align-items: center;
          max-width: 250px;
          border-radius: 10px;
          box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
          height: 70px;
      }

      .qty-control__number {
          width: 70px;
          height: 40px;
          font-size: 16px;
          padding: 10px;
          text-align: center;
          line-height: 1;
          font-weight: 600;
      }

      .qty-control__reduce, .qty-control__increase {
          width: 40px;
          height: 40px;
          min-width: 40px;
          min-height: 40px;
          max-width: 40px;
          max-height: 40px;
          font-size: 16px;
          flex-shrink: 0;
          line-height: 1;
          padding: 0;
          box-sizing: border-box;
          font-weight: 600;
      }

      .btn-addtocart, .btn-buynow {
          width: 100%;
          margin-bottom: 15px;
          padding: 15px 20px;
          font-size: 16px;
      }

      .size-chart-btn {
          width: 100%;
          margin-left: 0;
          margin-top: 15px;
      }

      .product-single__addtolinks {
          margin-bottom: 25px;
      }

      .product-single__details-tab {
          margin-top: 25px;
      }

      .reviews-section {
          margin-top: 25px;
          padding-top: 25px;
      }

      .review-summary {
          margin-bottom: 20px;
          flex-direction: column;
          align-items: center;
          text-align: center;
      }

      .write-review-btn {
          width: 100%;
          margin-top: 15px;
      }

      .review-item {
          padding: 15px 0;
          margin-bottom: 15px;
      }

      .products-carousel {
          margin-top: 35px;
      }
  }

  @media (max-width: 576px) {
      .variation-options {
          justify-content: center;
      }
      
      .quantity-controls {
          justify-content: center;
      }
      
      .tab-nav {
          flex-direction: column;
      }
      
      .tab-link {
          text-align: center;
          border-bottom: none;
          border-right: 3px solid transparent;
      }
      
      .tab-link.active {
          border-bottom-color: transparent;
          border-right-color: var(--primary-color);
      }

      /* Extra small screens improvements */
      .product-single__name {
          font-size: 1.6rem;
          margin-bottom: 12px;
      }

      .product-single__price {
          margin-bottom: 18px;
      }

      .price-display {
          padding: 12px;
          border-radius: 8px;
      }

      .current-price, .sale-price {
          font-size: 1.6rem;
      }

      .original-price {
          font-size: 1.1rem;
      }

      .discount-badge {
          font-size: 0.75rem;
          padding: 5px 10px;
      }

      .price-row {
          gap: 10px;
          margin-bottom: 8px;
      }

      .product-single__short-desc {
          font-size: 0.9rem;
          margin-bottom: 20px;
      }

      .color-btn {
          width: 40px;
          height: 40px;
          min-width: 40px;
          min-height: 40px;
          max-width: 40px;
          max-height: 40px;
          margin: 6px;
          padding: 0;
          box-sizing: border-box;
          flex-shrink: 0;
          line-height: 1;
      }

      .btn-addtocart, .btn-buynow {
          padding: 12px 18px;
          font-size: 15px;
      }

      .product-single__media {
          margin-bottom: 20px;
      }

      .product-single__addtocart {
          margin-bottom: 20px;
      }

      .product-single__addtolinks {
          margin-bottom: 20px;
      }

      .product-single__details-tab {
          margin-top: 20px;
      }

      .reviews-section {
          margin-top: 20px;
          padding-top: 20px;
      }

      .review-item {
          padding: 12px 0;
          margin-bottom: 12px;
      }

      .products-carousel {
          margin-top: 30px;
      }

      .lightbox-content {
          max-width: 95%;
          max-height: 85%;
          padding: 15px;
      }

      .lightbox-images {
          flex-direction: column;
          align-items: center;
          max-height: 70vh;
      }

      .lightbox-image {
          max-height: 35vh;
          width: 100%;
      }

      .average-rating {
          font-size: 1.5rem;
      }

      .review-summary {
          flex-direction: column;
          align-items: flex-start;
          gap: 10px;
      }

      .write-review-btn {
          width: 100%;
          text-align: center;
      }
  }

  .size-btn {
    min-width: 60px;
    position: relative;
    transition: all 0.3s ease;
    border-radius: 4px;
    padding: 8px 12px;
  }

  .size-btn.active {
    background:black;
    color: white;
    border-color:black;
  }

  .color-btn {
    width: 50px;
    height: 50px;
    min-width: 50px;
    min-height: 50px;
    max-width: 50px;
    max-height: 50px;
    position: relative;
    transition: all 0.3s ease;
    border-radius: 50%;
    border: 3px solid #ddd;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0;
    cursor: pointer;
    margin: 5px;
    padding: 0;
    box-sizing: border-box;
    flex-shrink: 0;
    line-height: 1;
    overflow: hidden;
  }

  .color-btn.active {
    border-color: #000;
    border-width: 4px;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .color-btn:hover {
    transform: scale(1.05);
    border-color: #666;
  }

  .color-btn.sold-out {
    opacity: 0.4;
    cursor: not-allowed;
    position: relative;
  }

  .color-btn.sold-out::after {
    content: "✕";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 20px;
    color: #dc3545;
    font-weight: bold;
  }

  .size-btn.sold-out {
    opacity: 0.6;
    cursor: not-allowed;
    position: relative;
  }

  .size-btn.sold-out::after {
    content: "______";
    position: absolute;
    top: 30%;
    left: 30%;
    transform: translate(-50%, -50%);
    font-size: 1.2em;
  }

  .sold-out-text {
    font-size: 0.7em;
    margin-left: 4px;
    color: #dc3545;
  }

  .sold-out-label {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #ff9800;
    color: #fff;
    font-size: 0.9rem;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 5px;
    z-index: 10;
  }

  .pc__sold-out {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    padding: 5px 10px;
    font-weight: bold;
    border-radius: 3px;
    z-index: 10;
  }

  .qty-error {
    color: red;
    font-size: 0.8rem;
    margin-top: 4px;
  }

  .size-chart-btn {
    display: inline-block;
    margin-left: 10px;
    padding: 12px 24px;
    background-color: #000000;
    color: white;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 30%;
    height: 4rem;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .size-chart-btn:hover {
    background-color: #333333;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  .lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    justify-content: center;
    align-items: center;
  }

  .lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 80%;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .lightbox-images {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    max-height: 60vh;
    overflow-y: auto;
  }

  .lightbox-image {
    max-width: 100%;
    max-height: 30vh;
    object-fit: contain;
    border-radius: 4px;
  }

  .close {
    position: absolute;
    top: -15px;
    right: -15px;
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    cursor: pointer;
    background: #000;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .close:hover {
    color: #ccc;
  }

  /* Reviews Section Styles */
  .reviews-section { padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px; }
  .review-summary { display: flex; align-items: center; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
  .average-rating { font-size: 2rem; font-weight: bold; }
  .star-rating .fa-star { color: #ccc; }
  .star-rating .fa-star.checked { color: #f39c12; }
  .rating-breakdown { flex: 1; }
  .rating-bar { background: #ddd; height: 5px; border-radius: 5px; overflow: hidden; margin: 5px 0; }
  .rating-bar-fill { background: #dc3545; height: 100%; }
  .write-review-btn { 
    background: #000000; 
    color: white; 
    border: none; 
    padding: 12px 24px; 
    border-radius: 6px; 
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .write-review-btn:hover {
    background: #333333;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }
  /* .write-review-btn:hover { background: #e68900; } */
  .review-item { border-bottom: 1px solid #ddd; padding: 15px 0; }
  .review-meta { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
  .pagination { justify-content: center; margin-top: 20px; }
  .pagination .page-link { color: #ff9800; }
  .pagination .page-item.active .page-link { background-color: #ff9800; border-color: #ff9800; color: white; }

  /* Modal Styles */
  .review-modal .modal-content { border-radius: 8px; }
  .review-modal .modal-header { background: #ff9800; color: white; }
  .review-modal .modal-footer { border-top: none; }
  .star-rating-input { display: flex; gap: 5px; }
  .star-rating-input .fa-star { font-size: 1.5rem; cursor: pointer; }
  .star-rating-input .fa-star.checked { color: #f39c12; }
  .review-form .error-message { color: #dc3545; font-size: 0.8rem; margin-top: 5px; display: none; }
  #rating-error { color: #dc3545; }

  /* Buy It Now Button Styles */
  .btn-buynow {
    background-color: #000000;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    width: 17.5rem;
    margin-top: 10px;
    height: 4rem;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .btn-buynow:hover {
    background-color: #333333;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  

  .btn-buynow.loading {
    opacity: 0.7;
    cursor: not-allowed;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    .size-chart-btn, .btn-buynow, .btn-addtocart {
      padding: 6px 12px;
      font-size: 0.8rem;
      margin-bottom: 1rem;
    }
    .lightbox-content { max-width: 95%; max-height: 85%; padding: 15px; }
    .lightbox-images { flex-direction: column; align-items: center; max-height: 70vh; }
    .lightbox-image { max-height: 35vh; width: 100%; }
    .gap-2 { gap: 0.5rem !important; margin-bottom: 1rem; }
    .average-rating { font-size: 1.5rem; }
    .review-summary { flex-direction: column; align-items: flex-start; gap: 10px; }
    .write-review-btn { width: 100%; text-align: center; }
  }

  @media (max-width: 480px) {
    .size-chart-btn, .btn-buynow, .btn-addtocart {
      padding: 5px 10px;
      font-size: 0.75rem;
    }
    .lightbox-content { max-width: 98%; max-height: 90%; padding: 10px; }
    .lightbox-image { max-height: 30vh; }
    .review-meta { flex-direction: column; align-items: flex-start; }
    .star-rating-input .fa-star { font-size: 1.2rem; }
    
    .qty-control {
        padding: 8px;
        gap: 8px;
        flex-wrap: nowrap;
        align-items: center;
        max-width: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        height: 50px;
    }

    .qty-control__number {
        width: 50px;
        height: 30px;
        font-size: 14px;
        padding: 5px;
        text-align: center;
        line-height: 1;
        font-weight: 600;
        background: white;
        border: 1px solid #ced4da;
    }

    .qty-control__reduce, .qty-control__increase {
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
        max-width: 30px;
        max-height: 30px;
        font-size: 14px;
        flex-shrink: 0;
        line-height: 1;
        padding: 0;
        box-sizing: border-box;
        font-weight: 600;
        background: #6c757d;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .qty-control__reduce:hover, .qty-control__increase:hover {
        background: #495057;
        transform: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }
  }

  /* Extra small mobile devices */
  @media (max-width: 360px) {
    .qty-control {
        padding: 6px;
        gap: 6px;
        max-width: 180px;
        border-radius: 6px;
        height: 45px;
    }

    .qty-control__number {
        width: 45px;
        height: 28px;
        font-size: 12px;
        padding: 4px;
    }

    .qty-control__reduce, .qty-control__increase {
        width: 28px;
        height: 28px;
        min-width: 28px;
        min-height: 28px;
        max-width: 28px;
        max-height: 28px;
        font-size: 12px;
    }
  }

  .text-success { color: black !important; }
  .gap-2 { gap: 0.5rem !important; margin-bottom: 0.5rem; margin-top: 0.5rem; }
  .btn-addtocart.loading { opacity: 0.7; cursor: not-allowed; }

  /* Force Button Alignment and Equal Width */
  .action-buttons .btn-addtocart,
  .action-buttons .btn-buynow {
      flex: 1 1 0% !important;
      min-width: 0 !important;
      max-width: none !important;
      width: auto !important;
      margin: 0 !important;
      padding: 15px 20px !important;
      font-size: 1rem !important;
      line-height: 1.2 !important;
      text-align: center !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
  }

  /* Additional Beauty Improvements */
  .product-single {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      margin-bottom: 30px;
      width: 100%;
      max-width: 100%;
      overflow: hidden;
  }

  /* Responsive Product Single Container */
  @media (max-width: 1200px) {
    .product-single {
        padding: 25px;
        margin-bottom: 25px;
    }
  }

  @media (max-width: 768px) {
    .product-single {
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
  }

  @media (max-width: 480px) {
    .product-single {
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 6px;
    }
  }

  /* Global Responsive Improvements */
  .container {
      max-width: 100%;
      padding-left: 15px;
      padding-right: 15px;
  }

  .row {
      margin-left: -15px;
      margin-right: -15px;
  }

  .col-md-6 {
      padding-left: 15px;
      padding-right: 15px;
  }

  /* Responsive Product Images */
  .product-single__media {
      width: 100%;
      margin-bottom: 20px;
  }

  .product-single__image-item img {
      width: 100%;
      height: auto;
      border-radius: 8px;
  }

  /* Responsive Product Info */
  .product-single__name {
      font-size: 1.8rem;
      margin-bottom: 15px;
      word-wrap: break-word;
  }

  /* Responsive Color and Quantity Section */
  .product-single__options .row {
      margin: 0;
  }

  .product-single__options .col-md-6 {
      padding: 0 10px;
      margin-bottom: 20px;
  }

  /* Action Buttons Container */
  .action-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
      width: 100%;
      align-items: stretch;
  }

  /* Responsive Buttons */
  .btn-addtocart, .btn-buynow {
      flex: 1 !important;
      margin-bottom: 0 !important;
      padding: 15px 20px !important;
      font-size: 1rem !important;
      font-weight: 600 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      border-radius: 8px !important;
      transition: all 0.3s ease !important;
      min-height: 50px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      width: 100% !important;
      box-sizing: border-box !important;
      border: none !important;
      text-decoration: none !important;
  }

  /* Responsive Description */
  .description-preview {
      margin-bottom: 20px;
  }

  /* Responsive Reviews Section */
  .reviews-section {
      margin-top: 20px;
      padding: 20px;
  }

  /* Mobile First Responsive Breakpoints */
  @media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }

    .btn-addtocart, .btn-buynow {
        width: 100%;
        flex: none;
    }
  }

  @media (max-width: 576px) {
    .container {
        padding-left: 10px;
        padding-right: 10px;
    }

    .product-single__name {
        font-size: 1.5rem;
        margin-bottom: 12px;
    }

    .product-single__options .col-md-6 {
        padding: 0 5px;
        margin-bottom: 15px;
    }

    .btn-addtocart, .btn-buynow {
        padding: 12px 15px;
        font-size: 0.9rem;
        min-height: 45px;
    }

    .reviews-section {
        padding: 15px;
    }
  }

  @media (max-width: 360px) {
    .product-single__name {
        font-size: 1.3rem;
    }

    .btn-addtocart, .btn-buynow {
        padding: 10px 12px;
        font-size: 0.85rem;
        min-height: 40px;
    }
  }

  .product-single__media {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .product-single__image img {
      border-radius: 12px;
      transition: transform 0.3s ease;
  }

  .product-single__image img:hover {
      transform: scale(1.02);
  }

  .product-single__thumbnail {
      margin-top: 15px;
  }

  .product-single__thumbnail img {
      border-radius: 8px;
      transition: all 0.3s ease;
      border: 2px solid transparent;
  }

  .product-single__thumbnail img:hover {
      border-color: #000000;
      transform: scale(1.05);
  }

  .product-single__name {
      color: #212529;
      font-weight: 700;
      margin-bottom: 15px;
      line-height: 1.3;
  }

  .product-single__price {
      margin-bottom: 25px;
  }

  .price-display {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
      position: relative;
      overflow: hidden;
  }

  .price-display::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #000000 0%, #333333 100%);
  }

  .price-row {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 10px;
  }

  .current-price {
      color: #000000;
      font-weight: 800;
      font-size: 2.2rem;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .original-price {
      color: #6c757d;
      font-weight: 500;
      font-size: 1.4rem;
      text-decoration: line-through;
      opacity: 0.7;
  }

  .sale-price {
      color: #dc3545;
      font-weight: 800;
      font-size: 2.2rem;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
  }

  .discount-badge {
      display: inline-block;
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
      animation: pulse 2s infinite;
  }

  @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
  }

  .product-single__short-desc {
      margin-bottom: 25px;
  }

  .description-preview {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
      position: relative;
      overflow: hidden;
  }

  .description-preview::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #000000 0%, #333333 100%);
  }

  .description-preview p {
      color: #495057;
      line-height: 1.7;
      font-size: 1rem;
      margin-bottom: 15px;
      font-weight: 400;
  }

  .btn-read-more {
      background: linear-gradient(135deg, #000000 0%, #333333 100%);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 8px;
  }

  .btn-read-more:hover {
      background: linear-gradient(135deg, #333333 0%, #000000 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
  }

  .read-more-icon {
      transition: transform 0.3s ease;
      font-size: 0.8rem;
  }

  .btn-read-more.expanded .read-more-icon {
      transform: rotate(180deg);
  }

  .btn-read-more.expanded .read-more-text {
      content: "Read Less";
  }

  .description-content {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
      margin-top: 20px;
  }

  .description-text {
      color: #495057;
      line-height: 1.8;
      font-size: 1.1rem;
      font-weight: 400;
  }

  .description-text h1, .description-text h2, .description-text h3, 
  .description-text h4, .description-text h5, .description-text h6 {
      color: #000000;
      font-weight: 700;
      margin: 20px 0 15px 0;
  }

  .description-text p {
      margin-bottom: 15px;
  }

  .description-text ul, .description-text ol {
      margin: 15px 0;
      padding-left: 25px;
  }

  .description-text li {
      margin-bottom: 8px;
  }

  .product-single__options {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 25px;
  }

  .product-single__addtocart {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 25px;
  }

  .qty-control {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      margin-bottom: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      flex-wrap: nowrap;
      border: 1px solid #e9ecef;
      width: 100%;
      position: relative;
      max-width: 300px;
      margin: 0 auto;
      height: 90px;
  }

  /* Laptop view responsiveness */
  @media (min-width: 1200px) {
    .qty-control {
        max-width: 350px;
        height: 100px;
        padding: 25px;
        gap: 25px;
    }
  }

  @media (min-width: 1400px) {
    .qty-control {
        max-width: 400px;
        height: 110px;
        padding: 30px;
        gap: 30px;
    }
  }

  .qty-control__number {
      border: 2px solid #e9ecef;
      border-radius: 8px;
      padding: 15px;
      font-weight: 700;
      text-align: center;
      width: 90px;
      height: 50px;
      transition: all 0.3s ease;
      font-size: 18px;
      background: #fafafa;
      color: #333;
      line-height: 1;
      box-sizing: border-box;
  }

  /* Laptop view input sizing */
  @media (min-width: 1200px) {
    .qty-control__number {
        width: 100px;
        height: 55px;
        font-size: 20px;
        padding: 18px;
    }
  }

  @media (min-width: 1400px) {
    .qty-control__number {
        width: 110px;
        height: 60px;
        font-size: 22px;
        padding: 20px;
    }
  }

  .qty-control__number:focus {
      border-color: #000000;
      box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
      outline: none;
      background: white;
  }

  .qty-control__reduce, .qty-control__increase {
      background: rgba(255, 255, 255, 0.9);
      color: #666;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      min-width: 50px;
      min-height: 50px;
      max-width: 50px;
      max-height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      font-size: 18px;
      cursor: pointer;
      flex-shrink: 0;
      line-height: 1;
      padding: 0;
      box-sizing: border-box;
      position: relative;
      margin: 0;
      backdrop-filter: blur(10px);
      z-index: 2;
  }

  .qty-control__reduce i, .qty-control__increase i {
      font-size: 16px;
      font-weight: 600;
  }

  /* Laptop view button sizing */
  @media (min-width: 1200px) {
    .qty-control__reduce, .qty-control__increase {
        width: 55px;
        height: 55px;
        min-width: 55px;
        min-height: 55px;
        max-width: 55px;
        max-height: 55px;
        font-size: 20px;
    }

    .qty-control__reduce i, .qty-control__increase i {
        font-size: 18px;
    }
  }

  @media (min-width: 1400px) {
    .qty-control__reduce, .qty-control__increase {
        width: 60px;
        height: 60px;
        min-width: 60px;
        min-height: 60px;
        max-width: 60px;
        max-height: 60px;
        font-size: 22px;
    }

    .qty-control__reduce i, .qty-control__increase i {
        font-size: 20px;
    }
  }

  .qty-control__reduce:hover, .qty-control__increase:hover {
      background: rgba(0, 0, 0, 0.8);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(15px);
  }

  .qty-control__reduce:disabled, .qty-control__increase:disabled {
      background: #e9ecef;
      color: #6c757d;
      cursor: not-allowed;
      transform: none;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }

  .product-single__addtolinks {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 25px;
  }

  .product-single__details-tab {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-top: 30px;
      overflow: hidden;
  }

  .nav-tabs {
      background: #f8f9fa;
      border-bottom: none;
      padding: 0 20px;
  }

  .nav-link {
      border: none;
      border-radius: 0;
      padding: 15px 20px;
      font-weight: 600;
      color: #6c757d;
      transition: all 0.3s ease;
  }

  .nav-link.active {
      background: white;
      color: #000000;
      border-bottom: 3px solid #000000;
  }

  .tab-content {
      padding: 30px;
  }

  .reviews-section {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-top: 30px;
      padding: 30px;
  }

  .review-item {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid #000000;
  }

  .products-carousel {
      margin-top: 40px;
  }

  .product-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      overflow: hidden;
  }

  .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  .pc__img-wrapper {
      border-radius: 12px 12px 0 0;
      overflow: hidden;
  }

  .pc__img {
      transition: transform 0.3s ease;
  }

  .product-card:hover .pc__img {
      transform: scale(1.05);
  }

  .pc__info {
      padding: 20px;
  }

  .pc__title a {
      color: #212529;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
  }

  .pc__title a:hover {
      color: #000000;
  }

  .price {
      color: #000000;
      font-weight: 700;
      font-size: 1.1rem;
  }
  
  /* Improved spacing for mobile case details page */
  .product-single { 
      padding: 20px 0; 
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 30px;
  }
  
  .product-single__media { 
      margin-bottom: 20px; 
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  .product-single__name { 
      margin-bottom: 15px; 
      font-size: 1.8rem; 
      color: #212529;
      font-weight: 700;
      line-height: 1.3;
  }
  
  .product-single__price { 
      margin-bottom: 15px; 
      color: #000000;
      font-weight: 700;
      font-size: 1.6rem;
  }
  
  .product-single__short-desc { 
      margin-bottom: 20px; 
      color: #6c757d;
      line-height: 1.6;
  }
  
  .product-single__options { 
      margin-bottom: 20px; 
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
  }
  
  .product-single__addtocart { 
      margin-bottom: 20px; 
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
  }
  
  .product-single__addtolinks { 
      margin-bottom: 20px; 
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
  }
  
  .product-single__details-tab { 
      margin-top: 20px; 
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
  }
  
  .reviews-section { 
      margin-top: 30px; 
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      border: 1px solid #e9ecef;
  }

  .reviews-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 2px solid #f8f9fa;
      flex-wrap: wrap;
      gap: 15px;
  }

  .reviews-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #000000;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
      min-width: 200px;
  }

  .reviews-title i {
      color: #f39c12;
      font-size: 1.5rem;
  }

  .reviews-stats {
      background: linear-gradient(135deg, #000000 0%, #333333 100%);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      white-space: nowrap;
      flex-shrink: 0;
  }

  /* Responsive Reviews Header */
  @media (max-width: 768px) {
    .reviews-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .reviews-title {
        font-size: 1.5rem;
        min-width: auto;
    }

    .reviews-stats {
        align-self: flex-end;
    }
  }

  @media (max-width: 480px) {
    .reviews-title {
        font-size: 1.3rem;
    }

    .reviews-stats {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
  }

  .review-item {
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 20px;
      border: 1px solid #e9ecef;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
  }

  .review-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(135deg, #000000 0%, #333333 100%);
  }

  .review-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      flex-wrap: wrap;
      gap: 10px;
  }

  .reviewer-info {
      display: flex;
      align-items: center;
      gap: 15px;
      flex: 1;
      min-width: 200px;
  }

  .reviewer-avatar {
      width: 45px;
      height: 45px;
      background: linear-gradient(135deg, #000000 0%, #333333 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
      flex-shrink: 0;
  }

  .reviewer-details {
      display: flex;
      flex-direction: column;
      gap: 3px;
      min-width: 0;
  }

  .reviewer-name {
      font-weight: 700;
      color: #000000;
      font-size: 1rem;
      word-wrap: break-word;
  }

  .review-date {
      color: #6c757d;
      font-size: 0.85rem;
  }

  .star-rating {
      display: flex;
      gap: 3px;
      flex-shrink: 0;
  }

  .star-rating .fa-star {
      color: #ddd;
      font-size: 1.1rem;
      transition: color 0.3s ease;
  }

  .star-rating .fa-star.checked {
      color: #f39c12;
  }

  .review-content {
      margin-top: 15px;
  }

  .review-text {
      color: #495057;
      line-height: 1.7;
      font-size: 1rem;
      margin: 0;
      word-wrap: break-word;
  }

  /* Responsive Review Items */
  @media (max-width: 768px) {
    .review-item {
        padding: 20px;
        margin-bottom: 15px;
    }

    .review-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .reviewer-info {
        min-width: auto;
        width: 100%;
    }

    .star-rating {
        align-self: flex-end;
    }
  }

  @media (max-width: 480px) {
    .review-item {
        padding: 15px;
        margin-bottom: 12px;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .reviewer-name {
        font-size: 0.9rem;
    }

    .review-date {
        font-size: 0.8rem;
    }

    .star-rating .fa-star {
        font-size: 1rem;
    }

    .review-text {
        font-size: 0.9rem;
        line-height: 1.6;
    }
  }
  
  .review-summary { 
      margin-bottom: 15px; 
  }
  
  .review-item { 
      padding: 10px 0; 
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid #000000;
  }
  
  .products-carousel { 
      margin-top: 30px; 
  }
  
  .qty-control { 
      margin-bottom: 10px; 
      background: white;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }
  
  .mb-3 { margin-bottom: 15px !important; }
  .mb-4 { margin-bottom: 20px !important; }
  .mb-5 { margin-bottom: 25px !important; }
  .py-5 { padding-top: 25px !important; padding-bottom: 25px !important; }
  
  /* Global Image Quality Improvements */
  img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
  }
</style>

<main class="pt-60">
  <div class="mb-md-1 pb-md-2"></div>
  <section class="product-single container">
    <div class="row">
      <div class="col-lg-7">
        <div class="product-single__media" data-media-type="vertical-thumbnail">
          <div class="product-single__image">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto" src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" width="674" height="674" alt="<?php echo e($product->name); ?>" 
                       style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);" />
                  <a data-fancybox="gallery" href="<?php echo e(asset('uploads/products/thumbnails/' . $product->main_image)); ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_zoom" />
                    </svg>
                  </a>
                </div>
                <?php if($product->gallery_images): ?>
                  <?php
                    $galleryImages = is_array($product->gallery_images) 
                        ? $product->gallery_images 
                        : json_decode($product->gallery_images, true) ?? [];
                  ?>
                  <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="<?php echo e(asset('uploads/products/' . $gimg)); ?>" width="674" height="674" alt="<?php echo e($product->name); ?>" 
                         style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);" />
                    <a data-fancybox="gallery" href="<?php echo e(asset('uploads/products/thumbnails/' . $gimg)); ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </div>
              <div class="swiper-button-prev">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_sm" />
                </svg>
              </div>
              <div class="swiper-button-next">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_sm" />
                </svg>
              </div>
            </div>
          </div>
          <div class="product-single__thumbnail">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto" src="<?php echo e(asset('uploads/products/thumbnails/' . $product->main_image)); ?>" width="104" height="104" alt="<?php echo e($product->name); ?>" 
                       style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);" />
                </div>
                <?php if($product->gallery_images): ?>
                  <?php
                    $galleryImages = is_array($product->gallery_images) 
                      ? $product->gallery_images 
                      : json_decode($product->gallery_images, true) ?? [];
                    // Debug: Log gallery images for troubleshooting
                    \Illuminate\Support\Facades\Log::info('Gallery Images Debug', [
                      'product_id' => $product->id,
                      'gallery_images_raw' => $product->gallery_images,
                      'gallery_images_parsed' => $galleryImages,
                      'count' => count($galleryImages)
                    ]);
                  ?>
                  <?php if(!empty($galleryImages)): ?>
                    <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="swiper-slide product-single__image-item">
                        <img loading="lazy" class="h-auto" src="<?php echo e(asset('uploads/products/thumbnails/' . $gimg)); ?>" width="104" height="104" alt="<?php echo e($product->name); ?>" 
                             style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);" />
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="d-flex justify-content-between mb-3 pb-md-1">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>
          <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
          </div>
        </div>
        <h1 class="product-single__name"><?php echo e($product->name); ?></h1>
        <div class="product-single__rating">
          <!-- Rating will be displayed in the reviews section below -->
        </div>
        <div class="product-single__price">
          <div class="price-display">
            <?php if($product->sale_price): ?>
              <div class="price-row">
                <span class="original-price">PKR <?php echo e($product->regular_price); ?></span>
                <span class="sale-price">PKR <?php echo e($product->sale_price); ?></span>
              </div>
              <div class="discount-badge">
                Save PKR <?php echo e($product->regular_price - $product->sale_price); ?>

              </div>
            <?php else: ?>
              <div class="price-row">
                <span class="current-price">PKR <?php echo e($product->regular_price); ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="product-single__short-desc">
          <div class="description-preview">
            <p><?php echo e(\Illuminate\Support\Str::limit($product->description, 150)); ?></p>
            <button type="button" class="btn-read-more" onclick="toggleDescription()">
              <span class="read-more-text">Read More</span>
              <i class="fas fa-chevron-down read-more-icon"></i>
            </button>
          </div>
        </div>
        <?php if($product->stock_status === 'out_of_stock'): ?>
          <span class="btn btn-secondary mb-3">Sold Out</span>
        <?php else: ?>
          <form id="add-to-cart-form" method="POST" action="<?php echo e(route('cart.add')); ?>">
            <?php echo csrf_field(); ?>
            <div class="product-single__options">
              <div class="row">
                <!-- Color Selection - Left Side -->
                <?php if($product->productVariations && $product->productVariations->where('colour_id', '!=', null)->count() > 0): ?>
                  <div class="col-md-6 mb-3">
                    <label class="mb-2">Color:</label>
                    <div class="color-selector d-flex flex-wrap gap-2">
                      <?php
                        $availableColors = $product->productVariations->where('colour_id', '!=', null)->groupBy('colour_id');
                    ?>
                      <?php $__currentLoopData = $availableColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colorId => $variations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                          $color = $variations->first()->colour;
                          $totalStock = $variations->sum('quantity');
                        ?>
                      <button type="button" 
                          class="color-btn <?php echo e($totalStock <= 0 ? 'sold-out' : ''); ?>"
                          data-color-id="<?php echo e($color->id); ?>"
                          data-color-name="<?php echo e($color->name); ?>"
                          data-color-code="<?php echo e($color->code); ?>"
                          data-total-stock="<?php echo e($totalStock); ?>"
                          <?php echo e($totalStock <= 0 ? 'disabled' : ''); ?>

                          style="<?php echo e($color->code ? 'background-color: ' . $color->code . ';' : ''); ?>"
                          title="<?php echo e($color->name); ?><?php echo e($totalStock <= 0 ? ' (Sold Out)' : ''); ?>">
                      </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <input type="hidden" name="colour_id" id="selected_color" value="">
                  </div>
                  <?php endif; ?>

                <!-- Quantity Selection - Right Side -->
                <div class="col-md-6 mb-3">
                  <label class="mb-2">Quantity:</label>
              <div class="qty-control position-relative">
                <button type="button" class="qty-control__reduce">
                  <i class="fas fa-minus"></i>
                </button>
                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                <button type="button" class="qty-control__increase">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
                </div>
              </div>
              
              <!-- Hidden inputs -->
              <input type="hidden" name="size_id" id="selected_size" value="1">
            </div>

            <div class="product-single__addtocart d-flex flex-column align-items-start gap-2">
              <div class="qty-error">
                <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <input type="hidden" name="id" value="<?php echo e($product->id); ?>" />
              <input type="hidden" name="name" value="<?php echo e($product->name); ?>" />
              <input type="hidden" name="price" value="<?php echo e($product->sale_price ?: $product->regular_price); ?>" />
              <div class="action-buttons d-flex gap-3">
                <button type="submit" class="btn btn-primary btn-addtocart flex-fill">Add to Cart</button>
                <button type="button" class="btn btn-buynow flex-fill" onclick="buyNow()">Buy It Now</button>
              </div>
              <span class="cart-status text-success ms-2" aria-live="polite"></span>
            </div>
          </form>
        <?php endif; ?>
        <div class="product-single__addtolinks">
          <?php if(Cart::instance("wishlist")->content()->where('id', $product->id)->count() > 0): ?>
            <form method="POST" action="<?php echo e(route('wishlist.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId])); ?>" id="wishlist-remove-form">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart" onclick="document.getElementById('wishlist-remove-form').submit();">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg>
                <span>Remove from Wishlist</span>
              </a>
            </form>
          <?php else: ?>
            <form method="POST" action="<?php echo e(route('wishlist.add')); ?>" id="wishlist-add-form">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="id" value="<?php echo e($product->id); ?>" />
              <input type="hidden" name="name" value="<?php echo e($product->name); ?>" />
              <input type="hidden" name="quantity" value="1"/>
              <input type="hidden" name="price" value="<?php echo e($product->sale_price ?: $product->regular_price); ?>" />
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist" onclick="document.getElementById('wishlist-add-form').submit()">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg>
                <span>Add to Wishlist</span>
              </a>
            </form>
          <?php endif; ?>
          <share-button class="share-button"></share-button>
          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>SKU:</label>
              <span><?php echo e($product->SKU); ?></span>
            </div>
            <div class="meta-item">
              <label>Categories:</label>
              <span><?php echo e($product->category->name); ?></span>
            </div>
            <div class="meta-item">
              <label>Tags:</label>
              <span>N/A</span>
            </div>
          </div>
        </div>
        <div class="product-single__details-tab">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
              <div class="product-single__description">
                <div class="description-content">
                  <div class="description-text">
                    <?php echo e($product->description); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Reviews Section -->
          <div class="reviews-section">
            <div class="reviews-header">
              <h2 class="reviews-title">
                <i class="fas fa-star"></i>
                Customer <strong>Reviews</strong>
              </h2>
              <div class="reviews-stats">
                <span class="total-reviews"><?php echo e($reviews->count()); ?> Reviews</span>
              </div>
            </div>
            <?php if(session('success')): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <div class="review-summary">
              <div class="rating-overview">
                <span class="average-rating"><?php echo e(number_format($averageRating, 1)); ?></span>
                <div class="star-rating d-inline-block">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star <?php echo e($i <= round($averageRating) ? 'checked' : ''); ?>"></i>
                  <?php endfor; ?>
                </div>
                <p class="review-count">(<?php echo e($reviewCount); ?> reviews)</p>
              </div>
              <button class="write-review-btn" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
            </div>
            <div class="reviews-list">
              <?php if($reviews->count() > 0): ?>
                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="review-item">
                    <div class="review-header">
                      <div class="reviewer-info">
                        <div class="reviewer-avatar">
                          <i class="fas fa-user"></i>
                        </div>
                        <div class="reviewer-details">
                          <span class="reviewer-name"><?php echo e($review->reviewer_name ?? 'Anonymous'); ?></span>
                          <span class="review-date"><?php echo e($review->created_at->format('M d, Y')); ?></span>
                        </div>
                      </div>
                      <div class="star-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                          <i class="fas fa-star <?php echo e($i <= $review->rating ? 'checked' : ''); ?>"></i>
                        <?php endfor; ?>
                      </div>
                    </div>
                    <div class="review-content">
                      <p class="review-text"><?php echo e($review->review); ?></p>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <nav aria-label="Reviews pagination">
                  <?php echo e($reviews->links('pagination::bootstrap-5')); ?>

                </nav>
              <?php else: ?>
                <p>No reviews yet. Be the first to write a review!</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- End Reviews Section -->
        </div>
      </div>

      <!-- Size chart lightbox removed as not in database schema -->
  </section>
  <section class="products-carousel container">
    <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>
    <div id="related_products" class="position-relative">
      <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
        <div class="swiper-wrapper">
          <?php $__currentLoopData = $rproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rproduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide product-card" style="position: relative;">
              <div class="pc__img-wrapper">
                <a href="<?php echo e(route('shop.product.details', ['product_slug' => $rproduct->slug])); ?>">
                  <img loading="lazy" src="<?php echo e(asset('uploads/products/thumbnails/' . $rproduct->main_image)); ?>" width="330" height="400" alt="<?php echo e($rproduct->name); ?>" class="pc__img"
                       style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-transform: translateZ(0); transform: translateZ(0);">
                </a>
                <?php if($rproduct->stock_status === 'out_of_stock'): ?>
                  <div class="sold-out-label">Sold Out</div>
                <?php endif; ?>
              </div>
              <div class="pc__info position-relative">
                <p class="pc__category"><?php echo e($rproduct->category->name); ?></p>
                <h6 class="pc__title">
                  <a href="<?php echo e(route('shop.product.details', ['product_slug' => $rproduct->slug])); ?>"><?php echo e($rproduct->name); ?></a>
                </h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    <?php if($rproduct->sale_price): ?>
                      <s>PKR <?php echo e($rproduct->regular_price); ?></s> PKR <?php echo e($rproduct->sale_price); ?>

                    <?php else: ?>
                      PKR <?php echo e($rproduct->regular_price); ?>

                    <?php endif; ?>
                  </span>
                </div>
                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_prev_md" />
        </svg>
      </div>
      <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_next_md" />
        </svg>
      </div>
      <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
    </div>
  </section>

  <!-- Review Modal -->
  <div class="modal fade review-modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="review-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <div class="mb-3">
              <label for="rating" class="form-label">Your Rating</label>
              <div class="star-rating-input" id="rating-input">
                <?php for($i = 1; $i <= 5; $i++): ?>
                  <i class="fas fa-star" data-value="<?php echo e($i); ?>"></i>
                <?php endfor; ?>
              </div>
              <input type="hidden" name="rating" id="rating" value="0">
              <div class="error-message" id="rating-error"></div>
            </div>
            <div class="mb-3">
              <label for="reviewer_name" class="form-label">Your Name</label>
              <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" maxlength="255">
            </div>
            <div class="mb-3">
              <label for="review" class="form-label">Your Review</label>
              <textarea class="form-control" id="review" name="review" rows="4" maxlength="1000" required></textarea>
              <div class="error-message" id="review-error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Description toggle functionality
function toggleDescription() {
    const btn = document.querySelector('.btn-read-more');
    const preview = document.querySelector('.description-preview p');
    const fullDescription = `<?php echo e($product->description); ?>`;
    
    if (btn.classList.contains('expanded')) {
        // Collapse
        preview.textContent = `<?php echo e(\Illuminate\Support\Str::limit($product->description, 150)); ?>`;
        btn.querySelector('.read-more-text').textContent = 'Read More';
        btn.classList.remove('expanded');
    } else {
        // Expand
        preview.textContent = fullDescription;
        btn.querySelector('.read-more-text').textContent = 'Read Less';
        btn.classList.add('expanded');
    }
}
</script>
<script>
$(document).ready(function() {
    const $quantityInput = $('input.qty-control__number');
    const $qtyError = $('.qty-error');
    const $cartStatus = $('.cart-status');
    const $addToCartBtn = $('.btn-addtocart');
    const $buyNowBtn = $('.btn-buynow');
    let selectedSize = null;
    let selectedColor = null;
    let cartItems = [];

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

    // Fetch initial cart items on page load
    $.ajax({
        url: '<?php echo e(route('cart.partial')); ?>',
        method: 'GET',
        success: function(response) {
            const $cartContent = $(response);
            cartItems = $cartContent.find('.cart-item').map(function() {
                return {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    price: $(this).data('price'),
                    quantity: $(this).data('quantity')
                };
            }).get();

            if (cartItems.length > 0 && typeof fbq !== 'undefined') {
                const totalValue = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
                fbq('track', 'AddToCart', {
                    content_ids: cartItems.map(item => catalogIdMapping[item.id] || item.id),
                    content_type: 'product',
                    value: totalValue,
                    currency: 'PKR',
                    contents: cartItems.map(item => ({
                        id: catalogIdMapping[item.id] || item.id,
                        quantity: item.quantity,
                        content_name: item.name
                    }))
                });
            }
        },
        error: function(xhr) {
            console.error('Failed to load initial cart:', xhr.responseText);
        }
    });

    // Color selection handler
    $('.color-btn').on('click', function() {
        const $btn = $(this);
        if ($btn.hasClass('sold-out') || $btn.prop('disabled')) return;
        $('.color-btn').removeClass('active');
        $btn.addClass('active');
        selectedColor = {
            id: $btn.data('color-id'),
            name: $btn.data('color-name'),
            code: $btn.data('color-code'),
            totalStock: $btn.data('total-stock')
        };
        $('#selected_color').val(selectedColor.id);
        
        // Update available sizes based on selected color
        updateAvailableSizes();
    });

    // Size selection removed - using colors only
    // Default size is set to 1 (Medium)
    selectedSize = { id: 1, quantity: 999 };

    // Function to update available sizes based on selected color
    function updateAvailableSizes() {
        if (!selectedColor) return;
        // Since we're only using colors, we don't need to update sizes
        // Just ensure we have a valid size selected
        selectedSize = { id: 1, quantity: 999 };
    }

    $('.qty-control__increase').on('click', function() {
        const hasColors = $('.color-btn').length > 0;
        if (hasColors && !selectedColor) {
            $qtyError.text('Please select a color first');
            return;
        }
        if (!selectedSize) {
            $qtyError.text('Please select a size first');
            return;
        }
        const currentVal = parseInt($quantityInput.val()) || 1;
        if (currentVal < selectedSize.quantity) {
            $quantityInput.val(currentVal);
            $qtyError.text('');
        } else {
            $qtyError.text(`Only ${selectedSize.quantity} items available`);
        }
    });

    $('.qty-control__reduce').on('click', function() {
        const currentVal = parseInt($quantityInput.val()) || 1;
        if (currentVal > 1) {
            $quantityInput.val(currentVal);
            $qtyError.text('');
        }
    });

    $quantityInput.on('input', function() {
        const hasColors = $('.color-btn').length > 0;
        if (hasColors && !selectedColor) {
            $qtyError.text('Please select a color first');
            $quantityInput.val(1);
            return;
        }
        if (!selectedSize) {
            $qtyError.text('Please select a size first');
            $quantityInput.val(1);
            return;
        }
        const currentVal = parseInt($quantityInput.val());
        const maxVal = selectedSize.quantity;
        if (currentVal > maxVal) {
            $qtyError.text(`Only ${maxVal} items available`);
            $quantityInput.val(maxVal);
        } else if (currentVal < 1 || isNaN(currentVal)) {
            $quantityInput.val(1);
            $qtyError.text('');
        } else {
            $qtyError.text('');
        }
    });

    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        
        // Check if colors are available and selected
        const hasColors = $('.color-btn').length > 0;
        if (hasColors && !selectedColor) {
            $qtyError.text('Please select a color');
            return;
        }
        
        if (!selectedSize) {
            $qtyError.text('Please select a size');
            return;
        }
        const $form = $(this);
        $addToCartBtn.addClass('loading').prop('disabled', true).text('Adding...');
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $addToCartBtn.removeClass('loading').prop('disabled', false).text('Add to Cart');
                if (response.success) {
                    $cartStatus.text('Added to cart').show().fadeOut(3000);
                    $qtyError.text('');
                    $quantityInput.val(1);
                    $('.size-btn').removeClass('active');
                    $('#selected_size').val('');
                    selectedSize = null;
                    $('.cart-count-overlay').text(response.count).attr('aria-label', `Cart contains ${response.count} items`);
                    $('#cart-modal-content').html(response.content);
                    $('#cartModal').modal('show');

                    cartItems = response.cartItems || cartItems;
                    if (cartItems.length > 0 && typeof fbq !== 'undefined') {
                        const productId = '<?php echo e($product->id); ?>';
                        const catalogId = catalogIdMapping[productId] || productId;
                        const productName = '<?php echo e(addslashes($product->name)); ?>';
                        const productPrice = parseFloat('<?php echo e($product->sale_price ?: $product->regular_price); ?>');
                        const quantity = parseInt($quantityInput.val()) || 1;

                        fbq('track', 'AddToCart', {
                            content_ids: [catalogId],
                            content_type: 'product',
                            value: productPrice * quantity,
                            currency: 'PKR',
                            contents: [{
                                id: catalogId,
                                quantity: quantity,
                                content_name: productName
                            }]
                        });
                    }
                } else {
                    $qtyError.text(response.message || 'Failed to add to cart');
                }
            },
            error: function(xhr) {
                console.error('Add to cart error:', xhr.responseJSON || xhr.responseText);
                $addToCartBtn.removeClass('loading').prop('disabled', false).text('Add to Cart');
                $qtyError.text(xhr.responseJSON?.message || 'An error occurred while adding to cart');
                $.ajax({
                    url: '<?php echo e(route('cart.partial')); ?>',
                    method: 'GET',
                    success: function(cartContent) {
                        $('#cart-modal-content').html(cartContent);
                        $('#cartModal').modal('show');
                    },
                    error: function(cartXhr) {
                        console.error('Cart content load error:', cartXhr.responseText);
                        $qtyError.text('Failed to load cart content');
                    }
                });
            }
        });
    });

    // Buy It Now handler
    window.buyNow = function() {
        if (!selectedSize) {
            $qtyError.text('Please select a size');
            return;
        }
        const $form = $('#add-to-cart-form');
        $buyNowBtn.addClass('loading').prop('disabled', true).text('Processing...');
        $.ajax({
            url: '<?php echo e(route('cart.add')); ?>',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $buyNowBtn.removeClass('loading').prop('disabled', false).text('Buy It Now');
                if (response.success) {
                    $qtyError.text('');
                    $quantityInput.val(1);
                    $('.size-btn').removeClass('active');
                    $('#selected_size').val('');
                    selectedSize = null;
                    window.location.href = '<?php echo e(route('cart.checkout')); ?>';
                } else {
                    $qtyError.text(response.message || 'Failed to add to cart');
                }
            },
            error: function(xhr) {
                console.error('Buy now error:', xhr.responseJSON || xhr.responseText);
                $buyNowBtn.removeClass('loading').prop('disabled', false).text('Buy It Now');
                $qtyError.text(xhr.responseJSON?.message || 'An error occurred while processing your request');
            }
        });
    };

    // Size chart lightbox handlers
    window.openLightbox = function() {
        const $lightbox = $('#size-chart-lightbox');
        if ($lightbox.length === 0) {
            console.error('Size chart lightbox not found in DOM');
            return;
        }
        $lightbox.css('display', 'flex');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function() {
        const $lightbox = $('#size-chart-lightbox');
        if ($lightbox.length === 0) {
            console.error('Size chart lightbox not found in DOM');
            return;
        }
        $lightbox.css('display', 'none');
        document.body.style.overflow = 'auto';
    };

    $(document).on('click', '#size-chart-lightbox', function(event) {
        if ($(event.target).is('#size-chart-lightbox')) {
            closeLightbox();
        }
    });

    // Review submission via AJAX
    $('#review-form').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $ratingError = $('#rating-error');
        const $reviewError = $('#review-error');
        $ratingError.hide();
        $reviewError.hide();
        $submitBtn.prop('disabled', true).text('Submitting...');

        const rating = parseInt($('#rating').val());
        const reviewText = $('#review').val().trim();

        // Client-side validation
        let hasError = false;
        if (rating === 0) {
            $ratingError.text('Please select a rating').show();
            hasError = true;
        }
        if (!reviewText) {
            $reviewError.text('Please write your review').show();
            hasError = true;
        }
        if (hasError) {
            $submitBtn.prop('disabled', false).text('Submit Review');
            return;
        }

        $.ajax({
            url: '<?php echo e(route('reviews.store', $product->id)); ?>',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $submitBtn.prop('disabled', false).text('Submit Review');
                if (response.success) {
                    $('#reviewModal').modal('hide');
                    $form[0].reset();
                    $('#rating-input .fa-star').removeClass('checked');
                    $('#rating').val(0);
                    const $alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        'Review submitted successfully' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('.reviews-section').prepend($alert);
                } else {
                    $reviewError.text(response.message || 'Failed to submit review').show();
                }
            },
            error: function(xhr) {
                $submitBtn.prop('disabled', false).text('Submit Review');
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while submitting your review';
                $reviewError.text(errorMessage).show();
            }
        });
    });

    // Star rating input handler
    $('#rating-input .fa-star').on('click', function() {
        const value = $(this).data('value');
        $('#rating-input .fa-star').removeClass('checked');
        $('#rating-input .fa-star').each(function() {
            if ($(this).data('value') <= value) {
                $(this).addClass('checked');
            }
        });
        $('#rating').val(value);
        $('#rating-error').hide();
    });

    // Handle pagination via AJAX
    $(document).on('click', 'nav.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('.reviews-list').html(data);
                // Re-bind the event handler to new pagination links
                $(document).off('click', 'nav.pagination a').on('click', 'nav.pagination a', function(e) {
                    e.preventDefault();
                    const newUrl = $(this).attr('href');
                    $.ajax({
                        url: newUrl,
                        method: 'GET',
                        dataType: 'html',
                        success: function(newData) {
                            $('.reviews-list').html(newData);
                        },
                        error: function(xhr) {
                            console.error('Pagination error:', xhr.responseText);
                        }
                    });
                });
                history.pushState({}, '', url);
            },
            error: function(xhr) {
                console.error('Pagination error:', xhr.responseText);
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\trakkiez\resources\views/details.blade.php ENDPATH**/ ?>