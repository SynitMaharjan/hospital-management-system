<div
    class="modal fade"
    id="addItemModal"
    tabindex="-1"
    aria-labelledby="addItemModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="addItemModalLabel">
                <i class="fas fa-plus me-2"></i>
                Add Item to Bill #{{ $bill->bill_number }}
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
            action="{{ route('receptionist.bill.item.store', $bill) }}"
        >
            @csrf

            <div class="modal-body">
                <div class="row g-3">

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Description <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="description"
                            class="form-control"
                            value="{{ old('description') }}"
                            required
                        >

                        @error('description')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Quantity <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="quantity"
                            class="form-control"
                            value="{{ old('quantity') }}"
                            required
                        >

                        @error('quantity')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Unit Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Unit Price <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="unit_price"
                            class="form-control"
                            value="{{ old('unit_price') }}"
                            required
                        >

                        @error('unit_price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Add Item
                </button>
            </div>

        </form>
    </div>
</div>
</div>