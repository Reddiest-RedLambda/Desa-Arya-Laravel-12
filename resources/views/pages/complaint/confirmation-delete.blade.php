<!-- Modal -->
<div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/complaint/{{ $item->id }}" method="post">
        @csrf
        @method('DELETE')
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="confirmationDeleteLabel">Konfirmasi Hapus</h4>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <span>Apakah anda yakin ingin menghapus laporan ini?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
    </div>
    </form>
  </div>
</div>