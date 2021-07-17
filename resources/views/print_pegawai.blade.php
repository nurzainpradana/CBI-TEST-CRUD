<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CRUD Pegawai</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
</head>
  <style>
  .alert-message {
    color: red;
  }
</style>
<body>

<div class="container">
    <h2 style="margin-top: 12px;" class="">
        <br>
        Data Pegawai
     </h2><br>
     <div class="row" style="clear: both;margin-top: 18px; margin-bottom: 18px">
       <div class="col-12 text-right">
         <!-- <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPegawai()">Tambah Pegawai Baru</a> -->
       </div>
    </div>
    <div class="row">
        <div class="col-12">
          <table id="pegawai_table" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawai as $p)
                <tr id="row_{{$p->id}}">
                   <td>{{ $p->id  }}</td>
                   <td>{{ $p->nip }}</td>
                   <td>{{ $p->nama }}</td>
                   <td>{{ $p->alamat }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
          <br>
          <h5>Created by Nur Zain Pradana</h5>
       </div>
    </div>
</div>
<div class="modal fade" id="pegawai-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
              <form name="userForm" class="form-horizontal">
                 <input type="hidden" name="pegawai_id" id="pegawai_id">
                 <div class="form-group">
                    <label for="name" class="col-sm-2">NIP</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP">
                        <span id="nipError" class="alert-message"></span>
                    </div>
                </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-2">Nama</label>
                      <div class="col-sm-12">
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                          <span id="namaError" class="alert-message"></span>
                      </div>
                  </div>
  
                  <div class="form-group">
                      <label class="col-sm-2">Alamat</label>
                      <div class="col-sm-12">
                          <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat">
                          </textarea>
                          <span id="alamatError" class="alert-message"></span>
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="createPegawai()">Save</button>
          </div>
      </div>
    </div>
  </div>

</body>


<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/jquery.print.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    $('pegawai_table').DataTable();

    function addPegawai() {
        $("#pegawai_id").val('');
        $("#alamat").val('');
        $("#pegawai-modal").modal("show");
    }

    function editPegawai(event){
        var id = $(event).data("id");
        let _url = `{{route('pegawai.show', ":id")}}`;
        _url = _url.replace(':id', id );
        
        $('#nipError').text('');
        $('#namaError').text('');
        $('#alamatError').text('');

        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#pegawai_id").val(response.id);
                    $("#nip").val(response.nip);
                    $("#nama").val(response.nama);
                    $("#alamat").val(response.alamat);
                    $("#pegawai-modal").modal("show");
                }
            }
        });
    }

    function createPegawai(){
        var nip = $("#nip").val();
        var nama = $("#nama").val();
        var alamat = $("#alamat").val();
        var id = $("#pegawai_id").val();

        let _url = "{{ route('pegawai.store') }}";
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nip: nip,
                nama: nama,
                alamat: alamat,
                _token: _token
            },
            success: function(response) {
                if (response.code == 200) {
                    if (id != "") {
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nip);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.nama);
                        $("#row_"+id+" td:nth-child(4)").html(response.data.alamat);
                    } else {
                        $('table tbody').prepend('<tr id="row_'+response.data.id+'">"<td>'
                        +response.data.id+'</td><td>'+response.data.nip+'</td><td>'
                        +response.data.nama+'</td><td>'+response.data.alamat+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editPegawai(event.target)" class="btn btn-info">Edit</a></td><td><a href="javascript(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deletePegawai(event.target)">Delete</a></td></tr>');
                    }
                    $('#nip').val('');
                    $('#nama').val('');
                    $('#alamat').val('');

                    $('#pegawai-modal').modal('hide');
                }
            }, 
            error: function(response) {
                $('#nipError').text(response.responseJSON.errors.nip);
                $('#namaError').text(response.responseJSON.errors.nama);
                $('#alamatError').text(response.responseJSON.errors.alamat);
            }
        });
    }

    function deletePegawai(event){
        var id = $(event).data("id");
        let _url = `{{route('pegawai.destroy', ":id")}}`;
        _url = _url.replace(':id', id );
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "DELETE",
            data: {
                _token: _token
            },
            success: function(response) {
                $("#row_"+id).remove();
            }
        });
    }
</script>
</html>