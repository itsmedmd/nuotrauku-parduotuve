<div class="action-confirmation-form-overlay">
    <div class="action-confirmation-form-overlay-content">
        <p class="action-confirmation-form-text">
            {{ $message }}
        </p>
        <div class="action-confirmation-form-buttons">
            <button class="button action-confirmation-form-confirm">
                <a
                    href="{{ route('confirmAction', ['action' => $action, 'id' => $itemID]) }}"
                    class="action-confirmation-form-link"
                >
                    Confirm
                </a> 
            </button>
            <button
                class="button action-confirmation-form-cancel"
            >
                <a
                    href="{{ route('cancelAction', ['action' => $origin]) }}"
                    class="action-confirmation-form-link"
                >
                    Cancel
                </a> 
            </button>
        </div>
    </div>
</div>