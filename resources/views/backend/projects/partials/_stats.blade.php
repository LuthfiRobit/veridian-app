<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Project Stats</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btnAddStat">
            <i class="ti ti-plus"></i> Add Stat
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="statsTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sort</th>
                        <th>Icon</th>
                        <th>Value</th>
                        <th>Label (EN)</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Stat Modal -->
<div class="modal fade" id="statModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statModalLabel">Add Stat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statForm">
                <div class="modal-body">
                    <input type="hidden" id="stat_id" name="stat_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <select class="form-select" id="stat_icon" name="icon_class"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Value (e.g. 150+, 5 Stars)</label>
                            <input type="text" class="form-control" id="stat_value" name="value" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="stat_sort_order" name="sort_order" value="0">
                        </div>
                    </div>

                    <!-- Translatable Tabs -->
                    <ul class="nav nav-tabs" id="statLangTabs" role="tablist">
                        @foreach($sortedLanguages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="stat-tab-{{ $language->code }}" data-bs-toggle="tab"
                                    data-bs-target="#stat-content-{{ $language->code }}" type="button" role="tab">
                                    <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="statLangContent">
                        @foreach($sortedLanguages as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="stat-content-{{ $language->code }}" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Label</label>
                                    <input type="text" class="form-control"
                                        name="translations[{{ $language->code }}][label]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveStat">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>