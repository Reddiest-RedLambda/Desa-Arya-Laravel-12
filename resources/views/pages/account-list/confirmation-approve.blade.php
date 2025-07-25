<!-- Modal -->
<div class="modal fade" id="confirmationApprove-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationApproveLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/account-request/approval/{{ $item->id }}" method="post">
        @csrf
        @method('POST')
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="confirmationApproveLabel">Konfirmasi Aktif</h4>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="for" value="activate">
        <span>Apakah anda yakin ingin mengaktifkan data ini?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-outline-success">Activate</button>
      </div>
    </div>
    </form>
  </div>
</div>
