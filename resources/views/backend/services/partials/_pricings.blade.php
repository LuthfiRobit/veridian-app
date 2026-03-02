<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service Pricing Packages</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btnAddPricing">
            <i class="ti ti-plus"></i> Add Package
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="pricingsTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sort</th>
                        <th>Name (EN)</th>
                        <th>Price Label (EN)</th>
                        <th>Featured</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pricing Modal -->
<div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pricingModalLabel">Add Pricing Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="pricingForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 mb-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i> The
                        <strong>{{ $sortedLanguages->first()->name }}</strong> (Default) fields are mandatory. Other
                        languages are optional.
                    </div>
                    <input type="hidden" id="pricing_id" name="pricing_id">

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="pricing_sort_order" name="sort_order"
                                value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Featured (Popular)</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="pricing_is_featured"
                                    name="is_featured" value="1">
                                <label class="form-check-label" for="pricing_is_featured">Set as Popular</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Active</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="pricing_is_active" name="is_active"
                                    value="1" checked>
                            </div>
                        </div>
                    </div>

                    <!-- Translatable Tabs -->
                    <ul class="nav nav-tabs" id="pricingLangTabs" role="tablist">
                        @foreach($sortedLanguages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="pricing-tab-{{ $language->code }}" data-bs-toggle="tab"
                                    data-bs-target="#pricing-content-{{ $language->code }}" type="button" role="tab">
                                    <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="pricingLangContent">
                        @foreach($sortedLanguages as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="pricing-content-{{ $language->code }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Package Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                name="translations[{{ $language->code }}][name]"
                                                placeholder="e.g. Standard">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Price Label</label>
                                            <input type="text" class="form-control"
                                                name="translations[{{ $language->code }}][price_label]"
                                                placeholder="e.g. $0.12">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Unit Label</label>
                                            <input type="text" class="form-control"
                                                name="translations[{{ $language->code }}][unit_label]"
                                                placeholder="e.g. /word">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features List (One feature per line)</label>
                                    <textarea class="form-control features-input"
                                        name="translations[{{ $language->code }}][features_raw]" rows="5"
                                        placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                                    <small class="text-muted">Enter each feature on a new line.</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSavePricing">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>