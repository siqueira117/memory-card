@props(['rating' => 0, 'maxStars' => 5, 'size' => 'md', 'interactive' => false, 'name' => 'rating'])

@php
    $sizeClasses = [
        'sm' => 'star-sm',
        'md' => 'star-md',
        'lg' => 'star-lg',
        'xl' => 'star-xl',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $rating = max(0, min($maxStars, (float) $rating));
@endphp

<div class="star-rating {{ $sizeClass }} {{ $interactive ? 'star-rating-interactive' : '' }}" {{ $interactive ? 'data-name=' . $name : '' }}>
    @for ($i = 1; $i <= $maxStars; $i++)
        @php
            $isFilled = $i <= $rating;
            $isHalf = !$isFilled && ($i - 0.5) <= $rating;
        @endphp
        
        @if($interactive)
            <span class="star {{ $isFilled ? 'star-filled' : ($isHalf ? 'star-half' : 'star-empty') }}" 
                  data-value="{{ $i }}"
                  onclick="setRating(this, {{ $i }})">
                @if($isFilled)
                    <i class="fas fa-star"></i>
                @elseif($isHalf)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            </span>
        @else
            <span class="star {{ $isFilled ? 'star-filled' : ($isHalf ? 'star-half' : 'star-empty') }}">
                @if($isFilled)
                    <i class="fas fa-star"></i>
                @elseif($isHalf)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            </span>
        @endif
    @endfor
    
    @if($interactive)
        <input type="hidden" name="{{ $name }}" value="{{ $rating }}" id="{{ $name }}_input">
    @endif
</div>

@if($interactive)
    <script>
        function setRating(element, rating) {
            const container = element.closest('.star-rating-interactive');
            const stars = container.querySelectorAll('.star');
            const input = container.nextElementSibling?.querySelector('input[type="hidden"]') || 
                         document.getElementById(container.dataset.name + '_input');
            
            // Atualizar visual das estrelas
            stars.forEach((star, index) => {
                const starValue = index + 1;
                const icon = star.querySelector('i');
                
                if (starValue <= rating) {
                    star.className = 'star star-filled';
                    icon.className = 'fas fa-star';
                } else {
                    star.className = 'star star-empty';
                    icon.className = 'far fa-star';
                }
                
                star.dataset.value = starValue;
            });
            
            // Atualizar valor do input
            if (input) {
                input.value = rating;
                
                // Disparar evento customizado
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            console.log('⭐ Rating selecionado:', rating);
        }
        
        // Hover effect
        document.querySelectorAll('.star-rating-interactive .star').forEach(star => {
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.value);
                const container = this.closest('.star-rating-interactive');
                const stars = container.querySelectorAll('.star');
                
                stars.forEach((s, index) => {
                    const icon = s.querySelector('i');
                    if (index < rating) {
                        icon.className = 'fas fa-star';
                        s.style.color = '#ffc107';
                    } else {
                        icon.className = 'far fa-star';
                        s.style.color = '';
                    }
                });
            });
            
            star.closest('.star-rating-interactive').addEventListener('mouseleave', function() {
                const input = document.getElementById(this.dataset.name + '_input');
                const currentRating = input ? parseInt(input.value) : 0;
                const stars = this.querySelectorAll('.star');
                
                stars.forEach((s, index) => {
                    const icon = s.querySelector('i');
                    if (index < currentRating) {
                        icon.className = 'fas fa-star';
                        s.className = 'star star-filled';
                    } else {
                        icon.className = 'far fa-star';
                        s.className = 'star star-empty';
                    }
                    s.style.color = '';
                });
            });
        });
    </script>
@endif

