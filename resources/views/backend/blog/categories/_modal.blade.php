<!-- Modal -->
<div class="modal fade" id="categoryModal" area-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" class="form-horizontal">
                    <input type="hidden" name="id" id="category_id">

                    <div class="row">
                        <div class="col-lg-8">
                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                                @foreach($sortedLanguages as $language)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $language->code }}"
                                            data-bs-toggle="tab" data-bs-target="#lang-{{ $language->code }}" type="button"
                                            role="tab" aria-controls="lang-{{ $language->code }}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            <i class="{{ $language->icon }}"></i> {{ $language->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content" id="languageTabContent">
                                @foreach($sortedLanguages as $language)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="lang-{{ $language->code }}" role="tabpanel" aria-labelledby="tab-{{ $language->code }}">

                                        <div class="mb-3">
                                            <label for="name_{{ $language->code }}" class="form-label">Category Name
                                                ({{ $language->code }}) 
                                                @if($loop->first) <span class="text-danger">*</span> @endif
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                id="name_{{ $language->code }}" name="translations[{{ $language->code }}][name]"
                                                @if($loop->first) required @endif>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="slug_{{ $language->code }}" class="form-label">Slug
                                                ({{ $language->code }})
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                id="slug_{{ $language->code }}" name="translations[{{ $language->code }}][slug]">
                                            <small class="form-text text-muted">Leave empty to auto-generate from the name.</small>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="badge_color" class="form-label">Badge Color</label>
                                <input type="text" name="badge_color" id="badge_color" class="form-control" placeholder="e.g., industry, #ff0000">
                                <small class="form-text text-muted">CSS class or HEX.</small>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
