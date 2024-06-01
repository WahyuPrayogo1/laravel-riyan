@extends('dashboard')
@section('content')
    <div class="row justify-content-between mt-5 mb-3">
        <div class="col-6">
            <h3 class="card-title"> Data Barang</h3>
        </div>

        <div class="col-auto text-right">
            <button type="button" onClick="add()" class="btn btn-outline-success btn-sm text-right" data-bs-toggle="modal"
                data-bs-target="#ajax-crud-datatable"><i class="ri-add-fill"></i>Tambah Data</button>
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

    <div class="modal fade" id="ajax-crud-datatable" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Barang</h4>
                    <button type="button" id="buttonForm" class="btn-close" data-bs-dismiss="modal"
                        aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="barangForm" name="barangForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_barang" class="form-label">Kode Barang</label>
                                    <input type="text" id="kode_barang" class="form-control" name="kode_barang">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="text" id="harga_beli" name="harga_beli" class="form-control"
                                        data-toggle="input-mask" data-mask-format="000.000.000.000.000.000"
                                        data-reverse="true">
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <input type="text" id="kategori" class="form-control" name="kategori">
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" id="nama_barang" class="form-control" name="nama_barang">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="text" id="harga_jual" name="harga_jual" class="form-control"
                                        data-toggle="input-mask" data-mask-format="000.000.000.000.000.000"
                                        data-reverse="true">
                                </div>
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" id="satuan" class="form-control" name="satuan">
                                </div>




                            </div>
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="text" id="stok" class="form-control" name="stok">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10"><br />
                            <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table-barang" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>

                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Jual</th>
                                <th>Beli</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align:right">Total:</th>
                                <th></th>
                                <th></th>
                                <th colspan="4"></th>
                            </tr>
                        </tfoot>

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
                ajax: "{{ route('barang.index') }}",
                columns: [{
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual',
                        render: function(data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data ? parseFloat(
                                data) : 0);
                        }
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli',
                        render: function(data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data ? parseFloat(
                                data) : 0);
                        }
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ? i.replace(/[\Rp,]/g, '') * 1 : typeof i ===
                            'number' ? i : 0;
                    };

                    // Total over all pages for 'Jual'
                    var totalJual = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page for 'Jual'
                    var pageTotalJual = api
                        .column(2, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over all pages for 'Beli'
                    var totalBeli = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page for 'Beli'
                    var pageTotalBeli = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(2).footer()).html(
                        'Rp ' + new Intl.NumberFormat('id-ID').format(pageTotalJual)
                    );
                    $(api.column(3).footer()).html(
                        'Rp ' + new Intl.NumberFormat('id-ID').format(pageTotalBeli)
                    );
                }
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
