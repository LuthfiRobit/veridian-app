<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="languageForm" name="languageForm" class="form-horizontal">
                    <input type="hidden" name="id_language" id="id_language">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value=""
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <select id="code" name="code" class="form-control" placeholder="Select Language Code" required>
                            <option value="">Select Code...</option>
                            <option value="en">EN - English</option>
                            <option value="id">ID - Indonesian</option>
                            <option value="es">ES - Spanish</option>
                            <option value="fr">FR - French</option>
                            <option value="de">DE - German</option>
                            <option value="ja">JA - Japanese</option>
                            <option value="ko">KO - Korean</option>
                            <option value="zh">ZH - Chinese</option>
                            <option value="ar">AR - Arabic</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon Class</label>
                        <select id="icon" name="icon" class="form-control" placeholder="Select Flag Icon">
                            <option value="">Select Icon...</option>
                            <option value="flag-icon flag-icon-us">🇺🇸 USA (flag-icon-us)</option>
                            <option value="flag-icon flag-icon-gb">🇬🇧 UK (flag-icon-gb)</option>
                            <option value="flag-icon flag-icon-id">🇮🇩 Indonesia (flag-icon-id)</option>
                            <option value="flag-icon flag-icon-es">🇪🇸 Spain (flag-icon-es)</option>
                            <option value="flag-icon flag-icon-fr">🇫🇷 France (flag-icon-fr)</option>
                            <option value="flag-icon flag-icon-de">🇩🇪 Germany (flag-icon-de)</option>
                            <option value="flag-icon flag-icon-jp">🇯🇵 Japan (flag-icon-jp)</option>
                            <option value="flag-icon flag-icon-kr">🇰🇷 Korea (flag-icon-kr)</option>
                            <option value="flag-icon flag-icon-cn">🇨🇳 China (flag-icon-cn)</option>
                            <option value="flag-icon flag-icon-sa">🇸🇦 Saudi Arabia (flag-icon-sa)</option>
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="hidden" name="is_default" value="0">
                        <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1">
                        <label class="form-check-label" for="is_default">Is Default?</label>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                            checked>
                        <label class="form-check-label" for="is_active">Active?</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>