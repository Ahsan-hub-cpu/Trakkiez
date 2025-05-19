<div class="reviews-list">
  @if($reviews->count() > 0)
    @foreach($reviews as $review)
      <div class="review-item">
        <div class="review-meta">
          <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
              <i class="fas fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></i>
            @endfor
          </div>
          <span class="reviewer-name">{{ $review->reviewer_name ?? 'Anonymous' }}</span>
          <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
        </div>
        <p class="review-text">{{ $review->review }}</p>
      </div>
    @endforeach
    <nav aria-label="Reviews pagination">
      {{ $reviews->links('pagination::bootstrap-5') }}
    </nav>
  @else
    <p>No reviews yet. Be the first to write a review!</p>
  @endif
</div>