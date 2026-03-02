<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Project Features</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btnAddFeature">
            <i class="ti ti-plus"></i> Add Feature
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="featuresTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sort</th>
                        <th>Icon</th>
                        <th>Title (EN)</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Feature Modal -->
<div class="modal fade" id="featureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="featureModalLabel">Add Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="featureForm">
                <div class="modal-body">
                    <input type="hidden" id="feature_id" name="feature_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <select class="form-select" id="feature_icon" name="icon_class"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="feature_sort_order" name="sort_order"
                                value="0">
                        </div>
                    </div>

                    <!-- Translatable Tabs -->
                    <ul class="nav nav-tabs" id="featureLangTabs" role="tablist">
                        @foreach($sortedLanguages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="feature-tab-{{ $language->code }}" data-bs-toggle="tab"
                                    data-bs-target="#feature-content-{{ $language->code }}" type="button" role="tab">
                                    <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="featureLangContent">
                        @foreach($sortedLanguages as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="feature-content-{{ $language->code }}" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control"
                                        name="translations[{{ $language->code }}][title]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveFeature">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>