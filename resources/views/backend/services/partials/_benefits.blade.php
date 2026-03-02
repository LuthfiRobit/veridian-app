<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service Benefits (Why Choose Us)</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btnAddBenefit">
            <i class="ti ti-plus"></i> Add Benefit
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="benefitsTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sort</th>
                        <th width="10%">Icon</th>
                        <th>Title (EN)</th>
                        <th>Description (EN)</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Benefit Modal -->
<div class="modal fade" id="benefitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="benefitModalLabel">Add Benefit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="benefitForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 mb-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i> The
                        <strong>{{ $sortedLanguages->first()->name }}</strong> (Default) fields are mandatory. Other
                        languages are optional.
                    </div>
                    <input type="hidden" id="benefit_id" name="benefit_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <select class="form-select" id="benefit_icon" name="icon_class"></select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="benefit_sort_order" name="sort_order"
                                value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Active</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="benefit_is_active" name="is_active"
                                    value="1" checked>
                            </div>
                        </div>
                    </div>

                    <!-- Translatable Tabs -->
                    <ul class="nav nav-tabs" id="benefitLangTabs" role="tablist">
                        @foreach($sortedLanguages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="benefit-tab-{{ $language->code }}" data-bs-toggle="tab"
                                    data-bs-target="#benefit-content-{{ $language->code }}" type="button" role="tab">
                                    <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="benefitLangContent">
                        @foreach($sortedLanguages as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="benefit-content-{{ $language->code }}" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        name="translations[{{ $language->code }}][title]">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="translations[{{ $language->code }}][description]"
                                        rows="3"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveBenefit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>