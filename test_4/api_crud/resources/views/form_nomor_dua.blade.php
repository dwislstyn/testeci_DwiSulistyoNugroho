<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomor 2</title>
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
                        <input type="text" class="form-control" id="txtAngka" name="txtAngka" placeholder="Masukan angka lalu tekan submit, contoh:9834201">
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
        var urlInput  = '{{ env('URL_API').'/api/v1/nomor_dua' }}';
        var dataInput = {
            angka    : $('#txtAngka').val()
        };

        $.ajax({
            type: 'POST',
            url: urlInput,
            async: false,
            data: dataInput,
            success: function(data) {
                if(data.responseCode === '00'){
                    var responseData = data.responseData;
                    var html = '';
                    html += responseData.nilai + '<br/> Terbilang: <h3>' + responseData.nilai_terbilang + '</h3>';
                    $('#content-output').html(html);
                }else{
                    errorMessage(data.responseDesc);
                    $('#content-output').html('');
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