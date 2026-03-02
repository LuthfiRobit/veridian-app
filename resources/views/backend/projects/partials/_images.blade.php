<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Project Gallery</h5>
        <button type="button" class="btn btn-primary btn-sm" id="btnAddImage">
            <i class="ti ti-plus"></i> Add Image
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="imagesTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sort</th>
                        <th width="15%">Image</th>
                        <th>Caption (EN)</th>
                        <th>Hero?</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Add Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="imageForm" enctype="multipart/form-data">
                {{-- No @csrf here, handled by ajaxSetup --}}
                <div class="modal-body">
                    <input type="hidden" id="image_id" name="image_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image File</label>
                            <input type="file" class="form-control" id="image_path" name="image_path">
                            <div id="current_image_preview" class="mt-2 d-none">
                                <img src="" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="image_sort_order" name="sort_order" value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Is Hero?</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="image_is_hero" name="is_hero"
                                    value="1">
                            </div>
                        </div>
                    </div>

                    <!-- Translatable Tabs -->
                    <ul class="nav nav-tabs" id="imageLangTabs" role="tablist">
                        @foreach($sortedLanguages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="image-tab-{{ $language->code }}" data-bs-toggle="tab"
                                    data-bs-target="#image-content-{{ $language->code }}" type="button" role="tab">
                                    <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="imageLangContent">
                        @foreach($sortedLanguages as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="image-content-{{ $language->code }}" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Caption</label>
                                    <input type="text" class="form-control"
                                        name="translations[{{ $language->code }}][caption]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveImage">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>