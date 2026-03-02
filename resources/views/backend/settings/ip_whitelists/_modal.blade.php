<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ipForm" name="ipForm" class="form-horizontal">
                    <input type="hidden" name="id_ip_whitelist" id="id_ip_whitelist">

                    <div class="mb-3">
                        <label for="ip_address" class="form-label">IP Address</label>
                        <input type="text" class="form-control" id="ip_address" name="ip_address"
                            placeholder="e.g 192.168.1.1" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" placeholder="e.g Office Network"
                            value="">
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