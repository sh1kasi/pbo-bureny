<form method="post" id="absenForm">
    @csrf
    <div class="modal fade" id="absenceMeeting" tabindex="-1" role="dialog" aria-labelledby="absenceMeetingLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absenceMeetingLabel">Absen Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p id="judul_rapat"></p>
                    <p id="waktu"></p>
                    <p id="pembuat"></p>
                    <hr>
                    <div class="absen">
                        <div class="form d-flex justify-content-around">
                            <div class="form-group form-check">
                                <label class="form-check-label" for="izin">Hadir</label>
                                <input class="form-check-input" type="radio" name="status" value="1" id="izin">
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary w-100">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" id="id">

</form>

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

<script>
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

    $(document).ready(function () {
        $("#absenForm").attr("action", "{{ route('user_meeting_store') }}");
    });

</script>
