<div class="bg-dark-custom p-3 mb-3 rounded">
    <strong>{{ $review->user->name }}</strong> — <span class="text-warning">{{ str_repeat('⭐', $review->rating) }}</span>
    <p>{{ $review->review }}</p>
    <small class="text-light">{{ $review->created_at->diffForHumans() }}</small>
</div>