<div
    class="modal fade"
    id="paymentModal"
    tabindex="-1"
    aria-labelledby="paymentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">
                <i class="fas fa-meh me-2"></i>
                Record Payment for Bill #{{ $bill->bill_number }}
            </h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>

        <form
            method="POST"
            action="{{ route('receptionist.bill.payment', $bill) }}"
        >
            @csrf

            <div class="modal-body">
                <div class="row g-3">

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Amount <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="amount"
                            class="form-control"
                            value="{{ old('amount') }}"
                            required
                        >

                        @error('amount')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Method -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Payment Method <span class="text-danger">*</span>
                        </label>

                        <select name="method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>
                                Cash
                            </option>
                            <option value="card" {{ old('method') == 'card' ? 'selected' : '' }}>
                                Card
                            </option>
                            <option value="other" {{ old('method') == 'other' ? 'selected' : '' }}>
                                Other
                            </option>
                        </select>

                        @error('method')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="alert alert-info mt-3">
                    <strong>Remaining Amount:</strong> ${{ number_format($bill->remaining_amount, 2) }}
                </div>

            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-meh me-1"></i>
                    Record Payment
                </button>
            </div>

        </form>
    </div>
</div>
</div>