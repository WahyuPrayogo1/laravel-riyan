@extends('layouts.backend.dashboard')
@section('content')
    <div class="row justify-content-between mt-4 mb-3">
        <div class="col-md-12">
            <h3 class="card-title"> Penjualan</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table-barang" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Keranjang Belanja</h4>
                    <table id="table-keranjang" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data keranjang belanja akan ditampilkan di sini -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align:right"><b>Total:</b></td>
                                <td id="total-keranjang" colspan="2">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <button class="btn btn-primary" onclick="checkout()">Checkout</button>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
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
                        render: function(data) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<button class="btn btn-success" onclick="addToCart(${row.id})">Add to Cart</button>`;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            loadCart();
        });

        function addToCart(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('keranjang') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    barang_id: id,
                    jumlah: 1 // Default jumlah adalah 1, sesuaikan jika diperlukan
                },
                success: function(response) {
                    Swal.fire('Added!', response.success, 'success');
                    refreshKeranjangTable();
                },
                error: function(xhr) {
                    Swal.fire('Failed!', xhr.responseJSON ? xhr.responseJSON.error :
                        'There was a problem adding to cart.', 'error');
                }
            });
        }

        function loadCart() {
            $('#table-keranjang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('keranjang.index') }}",
                columns: [{
                        data: 'barang.kode_barang',
                        name: 'barang.kode_barang'
                    },
                    {
                        data: 'barang.nama_barang',
                        name: 'barang.nama_barang'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'harga_satuan',
                        name: 'harga_satuan',
                        render: function(data) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga',
                        render: function(data) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<button class="btn btn-danger" onclick="removeFromCart(${row.id})">Remove</button>`;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ? i.replace(/[\Rp,]/g, '') * 1 : typeof i ===
                            'number' ? i : 0;
                    };

                    var total = api.column(4).data().reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    $(api.column(4).footer()).html('Rp ' + new Intl.NumberFormat('id-ID').format(total));
                }
            });
        }

        function refreshKeranjangTable() {
            var oTable = $('#table-keranjang').DataTable();
            oTable.ajax.reload(null, false);
        }

        function removeFromCart(id) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('keranjang') }}/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Removed!', response.success, 'success');
                    refreshKeranjangTable();
                },
                error: function(xhr) {
                    Swal.fire('Failed!', xhr.responseJSON ? xhr.responseJSON.error :
                        'There was a problem removing the item from cart.', 'error');
                }
            });
        }

        function checkout() {


            $.ajax({
                type: "POST",
                url: "{{ route('penjualan.store') }}",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Success!', response.success, 'success');
                    refreshKeranjangTable();
                    $('#table-barang').DataTable().ajax.reload(); // Refresh barang table to update stock
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    Swal.fire('Failed!', errorMessage, 'error');
                }
            });
        }
    </script>
@endpush
