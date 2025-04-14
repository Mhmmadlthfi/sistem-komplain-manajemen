@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penjualan / Data Penjualan /</span> Tambah Data Penjualan
        </h5>

        <div class="col-xxl">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                {{-- Data Penjualan --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Data Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="customer_id">Customer</label>
                            <div class="col-sm-10">
                                <select name="customer_id" id="customer_id" class="customer-select form-control">
                                    @if (old('customer_id'))
                                        <option value="{{ old('customer_id') }}" selected>
                                            {{ App\Models\Customer::find(old('customer_id'))->name }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="spk">SPK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('spk') is-invalid @enderror" name="spk"
                                    id="spk" value="{{ old('spk') }}" placeholder="SPK01" required />
                                @error('spk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (!$errors->has('spk'))
                                    <div id="defaultFormControlHelp" class="form-text">
                                        Pastikan tidak sama dengan SPK yang telah ada dalam data penjualan, periksa dengan
                                        teliti.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="sent_date">Tanggal Kirim</label>
                            <div class="col-sm-10">
                                <input required class="form-control @error('sent_date') is-invalid @enderror" type="date"
                                    value="{{ old('sent_date') }}" id="sent_date" name="sent_date" />
                                @error('sent_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="received_date">Tanggal Diterima</label>
                            <div class="col-sm-10">
                                <input required class="form-control @error('received_date') is-invalid @enderror"
                                    type="date" value="{{ old('received_date') }}" id="received_date"
                                    name="received_date" />
                                @error('received_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="user_id">PIC</label>
                            <div class="col-sm-10">
                                <select required class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" aria-label="Default select example">
                                    <option selected disabled value="">Pilih Teknisi</option>
                                    @if (old('user_id'))
                                        <option value="{{ old('user_id') }}" selected>
                                            {{ App\Models\User::find(old('user_id'))->no_staff }} |
                                            {{ App\Models\User::find(old('user_id'))->name }}
                                        </option>
                                    @endif
                                    @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}">
                                            {{ $technician->no_staff }} |
                                            {{ $technician->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- / Data Penjualan --}}

                {{-- Data Detail Penjualan --}}
                <div class="card mb-4" id="products">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Data Detail Penjualan</h5>
                    </div>
                    <div class="product card-body" data-index="0">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="product_id_0">Produk</label>
                            <div class="col-sm-10">
                                <select name="products[0][product_id]" id="product_id_0"
                                    class="product-select form-control @error('products.0.product_id') is-invalid @enderror">
                                    @if (old('products.0.product_id'))
                                        <option value="{{ old('products.0.product_id') }}" selected>
                                            {{ App\Models\Product::find(old('products.0.product_id'))->name }}
                                        </option>
                                    @endif
                                </select>
                                @error('products.0.product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="serial_number_0">No Seri Produk</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('products.0.serial_number') is-invalid @enderror"
                                    name="products[0][serial_number]" id="serial_number_0"
                                    value="{{ old('products.0.serial_number') }}" placeholder="LBS001" required />
                                @error('products.0.serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (!$errors->has('products.0.serial_number'))
                                    <div id="defaultFormControlHelp" class="form-text">
                                        Pastikan tidak sama dengan No Seri Produk yang telah ada dalam data penjualan,
                                        periksa dengan teliti.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="commissioning_date_0">Tanggal Komisioning /
                                Penyerahan Produk</label>
                            <div class="col-sm-10">
                                <input required
                                    class="form-control @error('products.0.commissioning_date') is-invalid @enderror"
                                    type="date" value="{{ old('products.0.commissioning_date') }}"
                                    id="commissioning_date_0" name="products[0][commissioning_date]" />
                                @error('products.0.commissioning_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="location_0">Lokasi</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('products.0.location') is-invalid @enderror"
                                    name="products[0][location]" id="location_0"
                                    value="{{ old('products.0.location') }}" placeholder="Lokasi A" required />
                                @error('products.0.location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="divider text-start mb-3">
                            <div class="divider-text">Garansi Produk</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="start_date_0">Tanggal Mulai</label>
                            <div class="col-sm-10">
                                <input required
                                    class="form-control @error('products.0.warranty.start_date') is-invalid @enderror"
                                    type="date" id="start_date_0" value="{{ old('products.0.warranty.start_date') }}"
                                    name="products[0][warranty][start_date]" />
                                @error('products.0.warranty.start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="end_date_0">Tanggal Berakhir</label>
                            <div class="col-sm-10">
                                <input required
                                    class="form-control @error('products.0.warranty.end_date') is-invalid @enderror"
                                    type="date" id="end_date_0" value="{{ old('products.0.warranty.end_date') }}"
                                    name="products[0][warranty][end_date]" />
                                @error('products.0.warranty.end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm mt-1 text-end">
                                <button type="button" onclick="addProduct()" class="btn btn-success">Tambah
                                    Produk</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- / Data Detail Penjualan --}}

                <div class="text-start mt-3">
                    <button type="submit" class="btn btn-primary px-5">Simpan Data</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('sales_create_scripts')
    <script>
        let productIndex = 1;

        function addProduct() {
            const productsDiv = document.getElementById('products');
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('product', 'card-body');
            newProductDiv.setAttribute('data-index', productIndex);

            newProductDiv.innerHTML = `
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="product_id_${productIndex}">Produk</label>
                    <div class="col-sm-10">
                        <select name="products[${productIndex}][product_id]" id="product_id_${productIndex}"
                            class="product-select form-control @error('products.${productIndex}.product_id') is-invalid @enderror">
                            <!-- Data akan dimuat melalui AJAX -->
                        </select>
                        @error('products.${productIndex}.product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="serial_number_${productIndex}">No Seri Produk</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('products.${productIndex}.serial_number') is-invalid @enderror"
                            name="products[${productIndex}][serial_number]" id="serial_number_${productIndex}" placeholder="LBS001"
                            required />
                        @error('products.${productIndex}.serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (!$errors->has('products.${productIndex}.serial_number'))
                            <div id="defaultFormControlHelp" class="form-text">
                                Pastikan tidak sama dengan No Seri Produk yang telah ada dalam data penjualan, periksa dengan teliti.
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="commissioning_date_${productIndex}">Tanggal Komisioning / Penyerahan Produk</label>
                    <div class="col-sm-10">
                        <input required class="form-control @error('products.${productIndex}.commissioning_date') is-invalid @enderror"
                            type="date" id="commissioning_date_${productIndex}"
                            name="products[${productIndex}][commissioning_date]" />
                        @error('products.${productIndex}.commissioning_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="location_${productIndex}">Lokasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('products.${productIndex}.location') is-invalid @enderror"
                            id="location_${productIndex}" name="products[${productIndex}][location]" placeholder="Lokasi A" required />
                        @error('products.${productIndex}.location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="divider text-start mb-3">
                    <div class="divider-text">Garansi Produk</div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="start_date_${productIndex}">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <input required class="form-control @error('products.${productIndex}.warranty.start_date') is-invalid @enderror"
                            type="date" id="start_date_${productIndex}" name="products[${productIndex}][warranty][start_date]" />
                        @error('products.${productIndex}.warranty.start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="end_date_${productIndex}">Tanggal Berakhir</label>
                    <div class="col-sm-10">
                        <input required class="form-control @error('products.${productIndex}.warranty.end_date') is-invalid @enderror"
                            type="date" id="end_date_${productIndex}" name="products[${productIndex}][warranty][end_date]" />
                        @error('products.${productIndex}.warranty.end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm mt-1 text-end">
                        <button type="button" onclick="addProduct()" class="btn btn-success">Tambah Produk</button>
                        <button type="button" class="remove-product btn btn-danger ms-1">Hapus</button>
                    </div>
                </div>  
            `;

            productsDiv.appendChild(newProductDiv);

            $(newProductDiv).find('.product-select').select2({
                placeholder: 'Pilih atau cari produk',
                ajax: {
                    url: "{{ route('product-search') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            productIndex++;
        }

        // Fungsi untuk menghapus produk
        document.getElementById('products').addEventListener('click', function(e) {
            if (e.target && e.target.matches('button.remove-product')) {
                e.target.closest('.product').remove();
            }
        });

        $(document).ready(function() {
            $('.customer-select').select2({
                placeholder: 'Pilih atau cari customer',
                ajax: {
                    url: "{{ route('customer-search') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                },
            });

            $('.product-select').select2({
                placeholder: 'Pilih atau cari product',
                ajax: {
                    url: "{{ route('product-search') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
        });
    </script>
@endpush
