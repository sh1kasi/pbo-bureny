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
            <input type="text" class="form-control data full datedropper picker-input" name="tanggal"
             id="date-input" placeholder="Tanggal Rapat" value="{{ old('tanggal') }}">
             
        </div>
        <div class="form-group w-50 mt-3">
          <label for="token_rapat">Token Rapat</label>
          @error('token')
          <div class="text-danger mt-1">
              {{ $message }}
          </div>
          @enderror
          <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="token" value="{{  old('token') }}"
              id="token" aria-describedby="emailHelp"
              placeholder="Masukkan token rapat">
        </div>
        <div class="jam row">
            <div class="form-group date mt-3 col-sm">
                <label for="timepicker">Dari Jam</label>
                @error('dari_jam')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <input type="time" class="form-control time" value="{{  old('dari_jam') }}"
                    name="dari_jam" id="timepicker1" placeholder="Tanggal Rapat">
            </div>
            <div class="form-group date mt-3 col-sm">
                <label for="timepicker">Hingga Jam</label>
                @error('sampai_jam')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror
                <input type="time" class="form-control time" value="{{  old('sampai_jam') }}"
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

@if (session()->has('failed-edit'))
    <script>
      $(document).ready(function () {
        toastr.error("{!! session('failed-edit') !!}")
        $("#editMeeting").modal('show');
        $("#formEdit").attr("action", "{{ session('failed_url_form') }}");
      });
    </script>
@endif

<script>
    $(document).ready(function () {
        $("#date-input").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: parseInt(moment().format('YYYY')),
            minDate: moment().format('L'),
        });
    });
  
    function modalEditMeeting(name, tanggal, token, id, dari, sampai, url) {
      $(document).ready(function () {
        $("#name").val(name);
        $("#date-input").val(moment(tanggal).format("L"));
        $("#token").val(token);
        $("#timepicker1").val(dari.slice(0, -3));
        $("#timepicker2").val(sampai.slice(0, -3));
        $("#formEdit").attr("action", url);
      });
    } 
</script>