<div class="modal fade" id="addReview" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewLabel">Review</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submitReview" class="mb-4">
                    <div class="mb-2">
                        <label for="rating" class="form-label">Nota:</label>
                        <select wire:model="rating" id="rating" class="form-select w-25">
                            @foreach(range(1,5) as $star)
                                <option value="{{ $star }}">{{ $star }} ⭐</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="mb-2">
                        <label for="review" class="form-label">Seu Review:</label>
                        <textarea wire:model="review" id="review" class="form-control" rows="3" required></textarea>
                    </div>
                
                    <button type="submit" class="btn btn-custom">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>