@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penjualan / Data Penjualan /</span> Edit Data Penjualan
        </h5>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data Gagal Diperbarui, periksa kembali!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-xxl">
            <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                @method('PUT')
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
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $customer->id == $sale->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="spk">SPK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('spk') is-invalid @enderror" name="spk"
                                    id="spk" value="{{ old('spk', $sale->spk) }}" placeholder="SPK01" required />
                                @error('spk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (!$errors->has('spk'))
                                    <div id="defaultFormControlHelp" class="form-text">
                                        Jika anda mengubahnya, pastikan tidak sama dengan SPK yang telah ada dalam data
                                        penjualan, periksa dengan teliti.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="sent_date">Tanggal Kirim</label>
                            <div class="col-sm-10">
                                <input required class="form-control @error('sent_date') is-invalid @enderror" type="date"
                                    value="{{ old('sent_date', $sale->sent_date) }}" id="sent_date" name="sent_date" />
                                @error('sent_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="received_date">Tanggal Diterima</label>
                            <div class="col-sm-10">
                                <input required class="form-control @error('received_date') is-invalid @enderror"
                                    type="date" value="{{ old('received_date', $sale->received_date) }}"
                                    id="received_date" name="received_date" />
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
                                    @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}"
                                            {{ $sale->user_id == $technician->id ? 'selected' : '' }}>
                                            {{ $technician->no_staff }} | {{ $technician->name }}</option>
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
                    @foreach ($sale->saleDetail as $index => $detail)
                        <div class="product card-body" data-index="{{ $index }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="product_id_{{ $index }}">Produk</label>
                                <div class="col-sm-10">
                                    <select name="products[{{ $index }}][product_id]"
                                        id="product_id_{{ $index }}"
                                        class="product-select form-control @error('products.' . $index . '.product_id') is-invalid @enderror">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $product->id == $detail->product_id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('products.' . $index . '.product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="serial_number_{{ $index }}">No Seri
                                    Produk</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('products.' . $index . '.serial_number') is-invalid @enderror"
                                        name="products[{{ $index }}][serial_number]"
                                        id="serial_number_{{ $index }}"
                                        value="{{ old('products.' . $index . '.serial_number', $detail->serial_number) }}"
                                        placeholder="LBS001" required />
                                    @error('products.' . $index . '.serial_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (!$errors->has('products.' . $index . '.serial_number'))
                                        <div id="defaultFormControlHelp" class="form-text">
                                            Jika anda mengubahnya, pastikan tidak sama dengan No Seri Produk yang telah ada
                                            dalam data penjualan, periksa dengan teliti.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"
                                    for="commissioning_date_{{ $index }}">Tanggal
                                    Komisioning / Penyerahan Produk</label>
                                <div class="col-sm-10">
                                    <input required
                                        class="form-control @error('products.' . $index . '.commissioning_date') is-invalid @enderror"
                                        type="date" id="commissioning_date_{{ $index }}"
                                        name="products[{{ $index }}][commissioning_date]"
                                        value="{{ old('products.' . $index . '.commissioning_date', $detail->commissioning_date) }}" />
                                    @error('products.' . $index . '.commissioning_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="location_{{ $index }}">Lokasi</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('products.' . $index . '.location') is-invalid @enderror"
                                        id="location_{{ $index }}" name="products[{{ $index }}][location]"
                                        value="{{ old('products.' . $index . '.location', $detail->location) }}"
                                        placeholder="Lokasi A" required />
                                    @error('products.' . $index . '.location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="divider text-start mb-3">
                                <div class="divider-text">Garansi Produk</div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="start_date_{{ $index }}">Tanggal
                                    Mulai</label>
                                <div class="col-sm-10">
                                    <input required
                                        class="form-control @error('products.' . $index . '.warranty.start_date') is-invalid @enderror"
                                        type="date" id="start_date_{{ $index }}"
                                        name="products[{{ $index }}][warranty][start_date]"
                                        value="{{ old('products.' . $index . '.warranty.start_date', $detail->warranty->start_date) }}" />
                                    @error('products.' . $index . '.warranty.start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="end_date_{{ $index }}">Tanggal
                                    Berakhir</label>
                                <div class="col-sm-10">
                                    <input required
                                        class="form-control @error('products.' . $index . '.warranty.end_date') is-invalid @enderror"
                                        type="date" id="end_date_{{ $index }}"
                                        name="products[{{ $index }}][warranty][end_date]"
                                        value="{{ old('products.' . $index . '.warranty.end_date', $detail->warranty->end_date) }}" />
                                    @error('products.' . $index . '.warranty.end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm mt-1 text-end">
                                    <button type="button" class="btn btn-success add-product">
                                        Tambah Produk
                                    </button>
                                    <button type="button" class="remove-product btn btn-danger ms-1">Hapus</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- / Data Detail Penjualan --}}

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">
                            Simpan Data Penjualan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('sales_edit_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = @json($sale->saleDetail->count());

            function addProductForm(index) {
                const productsContainer = document.getElementById('products');
                const newProductForm = document.createElement('div');
                newProductForm.classList.add('product', 'card-body');
                newProductForm.setAttribute('data-index', index);
                newProductForm.innerHTML = `
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="product_id_${index}">Produk</label>
                    <div class="col-sm-10">
                        <select name="products[${index}][product_id]" id="product_id_${index}"
                            class="product-select form-control">
                            <!-- Data akan dimuat melalui AJAX -->
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="serial_number_${index}">No Seri Produk</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="products[${index}][serial_number]" id="serial_number_${index}" placeholder="LBS001" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="commissioning_date_${index}">Tanggal Komisioning</label>
                    <div class="col-sm-10">
                        <input required class="form-control" type="date" id="commissioning_date_${index}" name="products[${index}][commissioning_date]" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="location_${index}">Lokasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="location_${index}" name="products[${index}][location]" placeholder="Lokasi A" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="start_date_${index}">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <input required class="form-control" type="date" id="start_date_${index}" name="products[${index}][warranty][start_date]" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="end_date_${index}">Tanggal Berakhir</label>
                    <div class="col-sm-10">
                        <input required class="form-control" type="date" id="end_date_${index}" name="products[${index}][warranty][end_date]" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm mt-1 text-end">
                        <button type="button" class="add-product btn btn-success">Tambah Produk</button>
                        <button type="button" class="remove-product btn btn-danger ms-1">Hapus</button>
                    </div>
                </div>
            `;
                productsContainer.appendChild(newProductForm);
                initializeSelect2();
            }

            function initializeSelect2() {
                $('.product-select').select2({
                    placeholder: 'Pilih atau cari produk',
                    ajax: {
                        url: "{{ route('product-search') }}",
                        processResults: function(data) {
                            return {
                                results: data.data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        }
                    }
                });
            }

            // Inisialisasi Select2 saat halaman dimuat
            initializeSelect2();

            // Event delegation untuk tombol tambah produk
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-product')) {
                    addProductForm(++productIndex); // Tambah produk dan naikkan index
                }
            });

            // Event delegation untuk tombol hapus produk
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    e.target.closest('.product').remove(); // Hapus produk
                }
            });

            // Jika ada produk yang sudah diisi sebelumnya, sembunyikan tombol hapus pada produk pertama
            document.querySelectorAll('.product').forEach((product, index) => {
                if (index === 0) {
                    product.querySelector('.remove-product').classList.add('d-none');
                }
            });
        });
    </script>
@endpush
