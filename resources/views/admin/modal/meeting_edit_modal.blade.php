<form method="post" id="formEdit">
    @csrf
    <div class="modal fade" id="editMeeting" tabindex="-1" role="dialog" aria-labelledby="editMeetingLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMeetingLabel">Edit Rapat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Nama Rapat</label>
            @error('name')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
            @enderror
            <input type="text" class="form-control"  id="name" name="name" value="{{  old('name') }}"
                aria-describedby="emailHelp"
                placeholder="Masukkan nama rapat">
        </div>
        <div class="form-group date mt-3">
            <label for="datepicker">Tanggal Rapat</label>
            @error('tanggal')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
            @enderror
            <input type="date" class="form-control data full datedropper picker-input" name="tanggal"
             id="date-input" placeholder="Tanggal Rapat" value="{{ old('tanggal') }}">
             
        </div>
        <div class="jam row">
            <div class="form-group date mt-3 col-sm">
                <label for="timepicker">Dari Jam</label>
                @error('dari_jam')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <input type="text" class="form-control time" value="{{  old('dari_jam') }}"
                    name="dari_jam" id="timepicker1" placeholder="Tanggal Rapat">
            </div>
            <div class="form-group date mt-3 col-sm">
                <label for="timepicker">Hingga Jam</label>
                @error('sampai_jam')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <input type="text" class="form-control time" value="{{  old('sampai_jam') }}"
                    name="sampai_jam" id="timepicker2" placeholder="Tanggal Rapat">
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </div>
    </div>
</div>
</form>

<script>
    $(document).ready(function () {
      $("#timepicker1").clockTimePicker({
          autosize: false,
      
      });
      $("#timepicker2").clockTimePicker({
          autosize: false,
      });
    });
  
    function modalEditMeeting(name, tanggal, id, dari, sampai) {
      $(document).ready(function () {
        $("#name").val(name);
        $("#date-input").val(tanggal);
        $("#timepicker1").val(dari.slice(0, -3));
        $("#timepicker2").val(sampai.slice(0, -3));
        $("#formEdit").attr("action", `/admin/rapat/edit/store/${id}`);
      });
    } 
</script>