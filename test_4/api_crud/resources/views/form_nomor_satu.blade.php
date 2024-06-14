<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomor 1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<style>
    .width-content {
        width: 50%
    }

    .padding-content {
        padding: 10px 10px 0 10px;
    }
</style>
<body>
    <div class="container">
        <div class="row padding-content">
            <div class="width-content padding-content">
                <p>Input</p>
                <form id="formInput">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <select name="txtTipe" id="txtTipe" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="1">Tipe 1</option>
                            <option value="2">Tipe 2</option>
                            <option value="3">Tipe 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="txtAngka" name="txtAngka" placeholder="Masukan dalam bentuk angka lalu tekan submit">
                    </div>
                    <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
                </form>
            </div>
            <div class="width-content padding-content">
                <p>Output</p>
                <div id="content-output">
                </div>

            </div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script>
    $('#txtTipe').val('');
    $('#txtAngka').val('');

    $('#btnSubmit').click(function(){
        var urlInput  = '{{ env('URL_API').'/api/v1/nomor_satu' }}';
        var dataInput = {
            kode_tipe       : $('#txtTipe').val(),
            jumlah_baris    : $('#txtAngka').val(),
        };

        $.ajax({
            type: 'POST',
            url: urlInput,
            async: false,
            data: dataInput,
            success: function(data) {
                if(data.responseCode){
                    errorMessage(data.responseDesc);
                    $('#content-output').html('');
                }else{
                    $('#content-output').html(data);
                }
            },error: function(){
                errorMessage('Gagal load data');
            }
        });
        
    });

    function errorMessage(message){
        alert(message);
    }
</script>
</body>
</html>