@extends('admin.layouts.master')

@section('content')
    <section class="content-main p-4">
        <div class="content-header">
            <h4 class="content-title">POS</h4>
        </div>
        <div class="row">
            <div class="col-xxl-6">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-12 col-sm-12 mt-2">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="make" class="pb-1 ps-1 fw-bold text-primary">Make</label>
                                            <select class="form-select p-2" multiple name="make[]" id="make" style="height: 20rem; overflow-y: auto;">
                                                <option selected disabled>Select Make</option>
                                                @foreach ($makers as $make)
                                                    <option value="{{ $make->make_id }}">{{ $make->make_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="model" class="pb-1 ps-1 fw-bold text-primary">Model</label>
                                            <select class="form-select p-2" multiple name="model[]" id="model" style="height: 20rem; overflow-y: scroll;">
                                                <option selected disabled>Select Model</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="part" class="pb-1 ps-1 fw-bold text-primary">Part Name</label>
                                            <select class="form-select p-2" multiple name="part[]" id="part" style="height: 20rem; overflow-y: scroll;">
                                                <option selected disabled>Select Part</option>
                                                @foreach ($partCategories as $partCategory)
                                                    <option value="{{ $partCategory->id }}">{{ $partCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    {{ $dataTable->table() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Checkout Part 2 -->
            <div class="col-xxl-6">
                <div class="card" style="background-color: rgb(255, 255, 255);">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-sm-12">
                                <header>
                                    <input type="text">
                                    <h4 class="d-flex align-items-center justify-content-center">
                                        <span><i class="fas fa-shopping-cart"></i></span>
                                        <span class="ms-2">Your cart has <span id="cartItemTotal">{{ $cartContent->count() }}</span> item(s)</span>
                                    </h4>
                                </header>
                                <!-- Cart Content -->
                                <div class="table-responsive pt-3">
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr class="border-bottom text-center">
                                                <th scope="col">S/N</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Item</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartItemsTable" class="text-center">
                                            @foreach ($cartContent as $cartItem)
                                                <tr class="border-bottom">
                                                    <td scope="row">
                                                        <a href="#" class="fw-bold text-black">#{{ $loop->index + 1 }}</a>
                                                    </td>
                                                    <td>
                                                        <img style="height:2.5rem; width:2.5rem; object-fit: contain;" src="{{ asset('/assets/imgs/car-parts/placeholder.jpg') }}" alt="{{ $cartItem->name }}" class="img-fluid">
                                                    </td>
                                                    <td class="text-start">
                                                        <p>{{ $cartItem->name }}</p>
                                                        <p>${{ $cartItem->price }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="input-group d-flex justify-content-center">
                                                            <button title="Decrease item quantity" class="btn btn-light btn-sm fw-bold cart-item-qty-minus" data-rowid="{{ $cartItem->rowId }}">-</button>
                                                            <input type="number"
                                                                class="form-control text-center cart-item-qty-input"
                                                                value="{{ $cartItem->qty }}"
                                                                data-rowid="{{ $cartItem->rowId }}" style="width: 1rem;">
                                                            <button title="Increase item quantity"
                                                                class="btn btn-light btn-sm fw-bold cart-item-qty-plus"
                                                                data-rowid="{{ $cartItem->rowId }}"
                                                                data-qty="{{ $cartItem->options['max'] }}">+
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <p class="item-total-price" data-id="{{ $cartItem->rowId }}">
                                                            ${{ $cartItem->price * $cartItem->qty }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <button title="Remove item from cart"
                                                            value="{{ $cartItem->rowId }}"
                                                            class="btn btn-instagram rounded font-sm delete-cart-item">
                                                            <i style="pointer-events: none" class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Lower Part Of checkout -->
                                <div class="row px-3 d-flex justify-content-end">
                                    <div class="col-lg-6 m-0 p-0">
                                        <div class="row">
                                            <h6 class="col-sm-9 col-8">Subtotal:</h6>
                                            <p id="cartSubTotalValue" class="col-sm-3 col-4 text-end">${{ $totalPrice }}</p>
                                        </div>
                                        <hr class="my-2 bg-black" style="height: 2px;">
                                        <div class="row">
                                            <h6 class="col-sm-9 col-8">Total:</h6>
                                            <h5 id="cartTotalValue" class="col-sm-3 col-4 text-end text-black text-nowrap">${{ $totalPrice }}</h5>
                                        </div>
                                        <div class="row p-2">
                                            <a href="{{ route('admin.cart.checkout') }}"
                                                class="btn btn-md rounded font-sm text-center d-flex align-items-center justify-content-center fw-bold">
                                                <i class="fas fa-shopping-cart"></i>
                                                <span class="ms-2">CHECKOUT</span>
                                            </a>
                                            <button
                                                class="btn btn-instagram rounded font-sm text-center d-flex align-items-center justify-content-center fw-bold mt-2">
                                                <i class="fas fa-sync-alt"></i>
                                                <span class="ms-2">RESET ALL</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @component('admin.components.parts-modal', [
        'id' => 'partsModal',
        'title' => 'Parts List',
        'size' => 'modal-lg',
    ])
        <div class="modal-body">
            <table class="table" id="partsTable">
                <thead>
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Part Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="partsTableBody">

                </tbody>
            </table>
        </div>
    @endcomponent
@endsection

@push('scripts')
    <script>
        const cartStoreUrl = '{{ route('admin.cart.store') }}';
        const csrfToken = '{{ csrf_token() }}';
    </script>

    <script defer src="{{ asset('assets/js/part-modal-cart.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('#partsModal').on('show.bs.modal', handleModalShow);
            setupDataTable();
        });

        function populatePartsTable(response) {

            console.table(response.data)

            const convertCartContentIntoArray = Object.values(response.data.cartContent);
            const cartIds = convertCartContentIntoArray.map((cartContent) => cartContent.id);

            response.data.data.forEach(item => {
                $('#partsTableBody').append(`
                    <tr>
                        <td>${item.make_title}</td>
                        <td>${item.model_title}</td>
                        <td>${item.part_category_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price}</td>
                        <td>
                            <a href="#" title="Add item to cart" class="add-to-cart ${cartIds.includes(item.part_id.toString()) ? 'disabled text-secondary' : 'text-success'}"
                               data-id="${item.part_id}"
                               data-name="${item.part_category_name}"
                               data-quantity="${item.quantity}"
                               data-price="${item.price}"> ${cartIds.includes(item.part_id.toString()) ? '<del>Add to cart</del>' : 'Add to cart'}</a>
                        </td>
                    </tr>
                `);
            });
        }

        function fetchPartsData(makeId, modelId, partCategory) {
            $.ajax({
                url: "{{ route('admin.part.group') }}",
                method: 'GET',
                data: {
                    make_id: makeId,
                    model_id: modelId,
                    part_category_id: partCategory
                },
                success: populatePartsTable,
                error: function(xhr) {
                    console.error("Error fetching parts data:", xhr.responseJSON?.message || "Unknown error");
                }
            });
        }

        function handleModalShow(event) {
            const button = $(event.relatedTarget);
            const makeId = button.data('make_id');
            const modelId = button.data('model_id');
            const partCategory = button.data('part_category_id');

            $('#partsTableBody').empty();
            fetchPartsData(makeId, modelId, partCategory);
        }
    </script>

    <!-- DataTable Initialization and Filters -->
    <script>
        function setupDataTable() {
            const table = $('#part-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.cart.create') }}',
                    data: fetchDataFilters
                },
                columns: [{
                        data: 'serial_number',
                        searchable: false
                    },
                    {
                        data: 'part_category_name'
                    },
                    {
                        data: 'make'
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: 'total_quantity',
                        searchable: false
                    },
                    {
                        data: 'unit_avg_price',
                        searchable: false
                    },
                    {
                        data: 'action',
                        searchable: false
                    }
                ]
            });

            $('#make, #model, #part').on('change', () => table.ajax.reload());
            $('#make').on('change', updateModelOptions);
        }

        function fetchDataFilters(d) {
            d.make = $('#make').val();
            d.model = $('#model').val();
            d.part = $('#part').val();
        }

        function updateModelOptions() {
            const selectedMakes = $('#make').val();
            fetchModels(selectedMakes);
        }

        function fetchModels(makes) {
            $.ajax({
                url: '{{ route('admin.vehicle.models') }}',
                method: 'GET',
                data: {
                    makes: makes
                },
                success: populateModelOptions,
                error: function(xhr) {
                    console.error('Error fetching models:', xhr);
                }
            });
        }

        function populateModelOptions(data) {
            const modelDropdown = $('#model');
            modelDropdown.empty();
            modelDropdown.append(new Option('Select Model', '', false, false));
            data.models.forEach(model => {
                modelDropdown.append(new Option(model.model_title, model.model_id));
            });
        }
    </script>
@endpush
