<form method="post" action="{{ route('user_meeting_store', $id)  }}" id="absenForm">
    @csrf
    <div class="modal fade" id="absenceMeeting" tabindex="-1" role="dialog" aria-labelledby="absenceMeetingLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absenceMeetingLabel">Izin Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p class="alert alert-warning">Harap isi alasan untuk tidak mengikuti rapat!</p>
                    <hr>
                    <div class="absen">
                        {{-- <div class="form d-flex justify-content-around">
                            <div class="form-group form-check">
                                <label class="form-check-label" for="izin">Hadir</label>
                                <input class="form-check-input" type="radio" name="status" value="1" id="izin">
                            </div>
                            <div class="form-group form-check">
                                <label class="form-check-label" for="izin">Izin</label>
                                <input class="form-check-input" type="radio" name="status" value="0" id="izin">
                            </div>
                        </div> --}}
                        <div class="form-group text-box">
                            <label class="font-weight-bold" for="alasan">Alasan</label>
                            <input class="form-control" name="alasan" type="text" id="alasan_form">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submit" type="button" class="btn btn-primary w-100">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <input type="hidden" name="status" id="status2"> --}}

</form>

<script>
    $(document).ready(function () {
        // $("#presence_form").submit();
        $("#submit").prop("disabled", true);
        $("#alasan_form").keyup(function (e) { 
            if ($(this).val().length != 0) {
                $("#submit").prop("disabled", false);
            } else {
                 $("#submit").prop("disabled", true);
            }
        });
        
        $('#submit').click(function (e) { 
            e.preventDefault();

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $.ajax({
                type: "post",
                url: "{{ route('user_meeting_store', $id) }}",
                data: {
                    status: "0",
                    alasan: $("#alasan_form").val(),
                },
                dataType: "json",
                success: function (response) {
                }
            });
            $("#status").val("0");
            $("#alasan").val($("#alasan_form").val());
            $("#presence_form").submit();
        });
    });
</script>

{{-- @if (session('status') == 400)
    <script>
        $(document).ready(function () {
            $('#absenceMeeting').modal('show');
            // $(".absen").html("");
            //     $("#judul_rapat").html(`Judul Rapat: ${name}`);
            //     $("#waktu").html(`Tanggal/Jam: ${date} (${start} - ${end})`);
            //     $("#pembuat").html(`Pembuat: ${creator}`);
            //     $(".absen").append(
            //         `<div class="alert alert-warning">
            //             <div class="row">
            //                 <div class="col-md-12">
            //                     <p>Anda tidak mengikuti rapat dengan keterangan: </p>
            //                 </div>
            //                 <div class="col-md-12">
            //                     <p class="text-warning">${alasan}</p>
            //                 </div>
            //             </div>
            //         </div>`
            //     );
        });
    </script>
@endif --}}

{{-- <script>
    function absenceMeeting(name, date, id, start, end, creator, data, alasan, telat) {
        $(document).ready(function () {
            if (data == 1) {
                $(".absen").html("");
                $(".modal-footer").addClass("d-none");
                $("#judul_rapat").html(`Judul Rapat: ${name}`);
                $("#waktu").html(`Tanggal/Jam: ${date} (${start} - ${end})`);
                $("#pembuat").html(`Pembuat: ${creator}`);
                $(".absen").append(
                    `<h5 class='alert alert-success'>Anda sudah melakukan absen<h5>`
                );
            } else if (data == 0) {
                console.log(data);
                $(".absen").html("");
                $("#judul_rapat").html(`Judul Rapat: ${name}`);
                $(".modal-footer").addClass("d-none");
                $("#waktu").html(`Tanggal/Jam: ${date} (${start} - ${end})`);
                $("#pembuat").html(`Pembuat: ${creator}`);
                $(".absen").append(
                    `<div class="alert alert-warning">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Anda tidak mengikuti rapat dengan keterangan: </p>
                            </div>
                            <div class="col-md-12">
                                <p class="text-warning">${alasan}</p>
                            </div>
                        </div>
                    </div>`
                );
            } else {
                $("#id").val(id);
                $("#judul_rapat").html(`Judul Rapat: ${name}`);
                $("#waktu").html(`Tanggal/Jam: ${date} (${start} - ${end})`);
                $("#pembuat").html(`Pembuat: ${creator}`);
                $(".absen").html("");
                if (!telat) {
                    $(".absen").append(`
                    <div class="form d-flex justify-content-around">
                                <div class="form-group form-check">
                                    <label class="form-check-label" for="masuk">Hadir</label>
                                    <input class="form-check-input" type="radio" name="status" value="1" id="masuk">
                                </div>
                                <div class="form-group form-check">
                                    <label class="form-check-label" for="izin">Izin</label>
                                    <input class="form-check-input" type="radio" name="status" value="0" id="izin">
                                </div>
                            </div>
                            <div class="form-group text-box">
                                <label class="font-weight-bold" for="alasan">Alasan</label>
                                <input class="form-control" name="alasan" type="text" id="alasan">
                    </div>
                    `);

                    var status;
                    $("#submit").prop("disabled", true);
                    $("input[type='radio']").change(function (e) { 
                        e.preventDefault();
                            $("#submit").attr("disabled", false); 
                    });



                    console.log(status);
                    
                } else {
                    $(".absen").append(`
                    <div class="form d-flex justify-content-around">
                                <div class="form-group form-check">
                                    <label class="form-check-label" for="masuk">Hadir</label>
                                    <input class="form-check-input" disabled type="radio" name="status" value="1" id="masuk">
                                </div>
                                <div class="form-group form-check">
                                    <label class="form-check-label" for="izin">Izin</label>
                                    <input class="form-check-input" checked disabled type="radio" name="status" value="0" id="izin">
                                </div>
                            </div>
                            <div class="form-group text-box">
                                <label class="font-weight-bold" for="alasan">Alasan</label>
                                <input class="form-control" name="alasan" type="text" id="alasan">
                    </div>

                    <input id="status" name="status" value="0" type="hidden">

                    `);

                    $("#submit").attr("disabled", true);
                    $("#alasan").keyup(function (e) { 
                        if ($(this).val().length != 0) {
                            $("#submit").attr("disabled", false); 
                        } else {
                            $("#submit").attr("disabled", true);
                        }
                    });

                }
                
            }
        });
    }

</script> --}}
