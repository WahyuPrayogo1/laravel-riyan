@extends('dashboard')
@section('content')
    <div class="row justify-content-between mt-5 mb-3">
        <div class="col-6">
            <h3 class="card-title"> History Penjualan</h3>
        </div>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table-barang" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>

                                <th>Tgl_Faktur</th>
                                <th>Nama Pembeli</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#table-barang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('history-penjualan') }}",
                columns: [{
                        data: 'tgl_faktur',
                        name: 'tgl_faktur'
                    },
                    {
                        data: 'nama_konsumen',
                        name: 'nama_konsumen'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang',
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                    },
                    {
                        data: 'harga_satuan',
                        name: 'harga_satuan',
                        render: function(data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data ? parseFloat(
                                data) : 0);
                        }
                    },
                    {
                        data: 'harga_total',
                        name: 'harga_total',
                        render: function(data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data ? parseFloat(
                                data) : 0);
                        }
                    },
                ],
                order: [
                    [0, 'desc']
                ],
            });
        });

        function editFunc(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('barang') }}/" + id + "/edit",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#ajax-crud-datatable').modal('show');
                    $('#id').val(res.id);
                    $('#kode_barang').val(res.kode_barang);
                    $('#nama_barang').val(res.nama_barang);
                    $('#harga_jual').val(res.harga_jual);
                    $('#harga_beli').val(res.harga_beli);
                    $('#satuan').val(res.satuan);
                    $('#stok').val(res.stok);
                    $('#kategori').val(res.kategori);
                }
            });
        }

        function deleteFunc(id) {
            Swal.fire({
                title: 'Kamu yakin ?',
                text: "Data ini akan ke hapus permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('barang') }}/" + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Deleted!', res.success, 'success');
                            var oTable = $('#table-barang').DataTable();
                            oTable.ajax.reload(null, false); // Refresh DataTables without reset page
                        },
                        error: function(xhr) {
                            Swal.fire('Failed!', xhr.responseJSON ? xhr.responseJSON.error :
                                'There was a problem deleting the record.', 'error');
                        }
                    });
                }
            });
        }

        function add() {
            $('#barangForm')[0].reset();
            $('#id').val(''); // Add this line to reset the hidden input field
            $('#ajax-crud-datatable').modal('show'); // Open the modal
        }

        $('#barangForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('barang.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#ajax-crud-datatable").modal('hide');
                    var oTable = $('#table-barang').dataTable();
                    oTable.fnDraw(false);

                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil ditambahkan!",
                        icon: "success"
                    });
                },
                error: function(data) {
                    let response = data.responseJSON;
                    let errorString = '<ul>';
                    $.each(response.errors, function(key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    errorString += '</ul>';
                    Swal.fire({
                        title: "Error!",
                        html: errorString,
                        icon: "error"
                    });
                }
            });
        });
    </script>
@endpush
