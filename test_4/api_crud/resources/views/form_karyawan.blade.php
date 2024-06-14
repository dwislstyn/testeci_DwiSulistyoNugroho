<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data List Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container">

        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalHeader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUpdate">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="txtNikKaryawan">NIK Karyawan</label>
                            <input name="nik_karyawan" type="text" class="form-control" id="txtNikKaryawan">
                        </div>
                        <div class="form-group">
                            <label for="txtNamaKaryawan">Nama Karyawan</label>
                            <input name="nama_karyawan" type="text" class="form-control" id="txtNamaKaryawan">
                        </div>
                        <div class="form-group">
                            <label for="txtTanggalLahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="txtTanggalLahir">
                        </div>
                        <div class="form-group">
                            <label for="txtAlamat">Alamat</label>
                            <textarea name="alamat" id="txtAlamat" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="txtJabatan">Jabatan</label>
                            <select name="id_jabatan" id="txtJabatan" class="form-control">
                                <option value="">-- Pilih --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtDepartment">Department</label>
                            <select name="id_dept" id="txtDepartment" class="form-control">
                                <option value="">-- Pilih --</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnModalInput">Simpan</button>
                        <button type="button" class="btn btn-primary" id="btnModalEdit">Update</button>
                        <button type="button" class="btn btn-danger" id="btnModalCancel" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
          


        <div class="card" style="border: none;">
            <div style="margin: 40px 0 10px 0; padding: 20px 5px 5px 10px" class="border border-light">
                <button type="button" class="btn btn-primary" id="btnInsertData">Input Data Baru</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">NIK</th>
                        <th style="text-align: center">Nama Karyawan</th>
                        <th style="text-align: center">Tanggal Lahir</th>
                        <th style="text-align: center">Alamat</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="show_data">

                </tbody>
            </table>
        </div>
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script>
    var url = '{{ env('URL_API') }}';
    var token = $('meta[name="csrf-token"]').attr('content');

    tampilData();

    function tampilData(){
        $.ajax({
            type: 'POST',
            url: url+'/api/v1/inquiryListKaryawan',
            headers: {
                'X-CSRF-TOKEN': token
            },
            async: false,
            dataType: 'json',
            data:{},
            success: function(data) {
                if(data.responseCode == '00'){
                    var dataKaryawan = data.responseData;
                    var html = '';
                    var i;
                    for (i = 0; i < dataKaryawan.length; i++) {
                        html += '<tr>' +
                            '<td style="text-align: center">' + (i+1) + '</td>' +
                            '<td style="text-align: center">' + dataKaryawan[i].nik + '</td>' +
                            '<td style="text-align: center">' + dataKaryawan[i].nama + '</td>' +
                            '<td style="text-align: center">' + dataKaryawan[i].tgl_lahir + '</td>' +
                            '<td style="text-align: center">' + dataKaryawan[i].alamat + '</td>' +
                            
                            '<td style="text-align: center">' +
    
                            '<button class="btn btn-warning btnUpdate" data-dept="'+ dataKaryawan[i].id_dept +'" data-jabatan="'+ dataKaryawan[i].id_jabatan +'" data="'+dataKaryawan[i].id_karyawan+'"" style="margin-right:5px;">Update</button>'+
                            '<button class="btn btn-danger btnDelete" data="'+dataKaryawan[i].id_karyawan+'"">Delete</button>'+
    
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }else{
                    errorMessage(data.responseDesc);
                }
            },error: function(){
                errorMessage("Gagal mereload data");
            }
        });
    }

    $('#btnInsertData').click(function(){
        $('#txtNikKaryawan').val('');
        $('#txtNamaKaryawan').val('');
        $('#txtTanggalLahir').val('');
        $('#txtAlamat').val('');
        $('#txtJabatan').val('');
        $('#txtDepartment').val('');

        $('#btnModalInput').removeAttr('style');
        $('#btnModalEdit').attr('style', 'display:none;');

        getListInputJabatan();
        getListInputDept();

        $('#myModal').modal('show');
        $('#myModal').find('#myModalHeader').text('Input Data Karyawan');
    });

    $('#btnModalInput').click(function(){
        var dataInput = new FormData($('#formUpdate')[0]);

        $.ajax({
            type: 'POST',
            url: url+'/api/v1/insertDataKaryawan',
            async: false,
            dataType: 'json',
            data: dataInput,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.responseCode === '00'){
                    alert(data.responseDesc);
                    $('#btnModalCancel').click();
                    tampilData();
                }else{
                    errorMessage(data.responseDesc);
                }
            },error: function(){
                errorMessage('Gagal input data');
            }
        });
    });

    $('#btnModalEdit').click(function(){
        var dataUpdate = new FormData($('#formUpdate')[0]);

        dataUpdate.append('id_karyawan', $('#btnModalEdit').attr('data-id'));

        $.ajax({
            type: 'POST',
            url: url+'/api/v1/updateDataKaryawan',
            async: false,
            dataType: 'json',
            data: dataUpdate,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.responseCode === '00'){
                    alert(data.responseDesc);
                    $('#btnModalCancel').click();
                    tampilData();
                }else{
                    error();
                }
            },error: function(){
                alert("Gagal update data");
            }
        });
    });

    $('#show_data').on('click', '.btnDelete', function(){
        var idKaryawan = $(this).attr('data');

        $.ajax({
            type: 'POST',
            url: url+'/api/v1/deleteDataKaryawan',
            async: false,
            dataType: 'json',
            headers:{'X-CSRF-TOKEN': token},
            data: {                
                id_karyawan: idKaryawan
            },
            success: function(data) {
                if(data.responseCode === '00'){
                    alert(data.responseDesc);
                    tampilData();
                }else{
                    errorMessage(data.responseDesc);
                }
            },error: function(){
                errorMessage('Gagal mendapatkan response');
            }
        });
    });

    $('#show_data').on('click', '.btnUpdate', function(){
        var row = $(this).closest('tr');

        var idJabatan = $(this).attr('data-jabatan');
        var idDept = $(this).attr('data-dept');
        
        $('#btnModalEdit').attr('data-id', $(this).attr('data'));

        $('#txtNikKaryawan').val(row.find('td').eq(1).text());
        $('#txtNamaKaryawan').val(row.find('td').eq(2).text());
        $('#txtTanggalLahir').val(row.find('td').eq(3).text());
        $('#txtAlamat').val(row.find('td').eq(4).text());
        
        getListInputDept();
        getListInputJabatan();
        
        $('#txtJabatan').val(idJabatan);
        $('#txtDepartment').val(idDept);

        $('#btnModalEdit').removeAttr('style')
        $('#btnModalInput').attr('style', 'display:none;');

        $('#myModal').modal('show');
        $('#myModal').find('#myModalHeader').text('Edit Data Karyawan');
    })

    function getListInputJabatan(){
        $.ajax({
            type: 'POST',
            url: url+'/api/v1/inquiryListJabatan',
            headers: {
                'X-CSRF-TOKEN': token
            },
            async: false,
            dataType: 'json',
            data:{},
            success: function(data) {
                if(data.responseCode == '00'){
                    var responseJabatan = data.responseData;
                    var selectInputJabatan = $('#txtJabatan');

                    $.each(responseJabatan, function(indexJabatan, valueJabatan) {
                        selectInputJabatan.append('<option value="' + valueJabatan.id_jabatan + '">' + valueJabatan.nama_jabatan + '</option>');
                    });
                }else{
                    errorMessage(data.responseDesc);
                }
            },error: function(){
                errorMessage("Gagal mereload data");
            }
        });
    }
    
    function getListInputDept(){
        $.ajax({
            type: 'POST',
            url: url+'/api/v1/inquiryListDepartment',
            headers: {
                'X-CSRF-TOKEN': token
            },
            async: false,
            dataType: 'json',
            data:{},
            success: function(data) {
                if(data.responseCode == '00'){
                    var responseDept = data.responseData;
                    var selectInputDept = $('#txtDepartment');

                    $.each(responseDept, function(indexDept, valueDept) {
                        selectInputDept.append('<option value="' + valueDept.id_dept + '">' + valueDept.nama_dept + '</option>');
                    });
                }else{
                    errorMessage(data.responseDesc);
                }
            },error: function(){
                errorMessage("Gagal mereload data");
            }
        });
    }

    function errorMessage(message){
        alert(message);
    }
</script>
</body>
</html>