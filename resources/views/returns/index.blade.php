<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Trả Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .navbar-brand {
            color: #667eea !important;
            font-weight: bold;
            font-size: 20px;
            margin-right: 40px;
        }

        .nav-menu {
            display: flex;
            gap: 5px;
            align-items: center;
            margin-left: auto;
            margin-right: auto;
        }

        .nav-link {
            display: inline-block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-radius: 5px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: #f0f0f0;
            color: #667eea;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .nav-link i {
            margin-right: 8px;
        }

        .navbar-logout {
            margin-left: auto;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .page-title i {
            margin-right: 10px;
            color: #667eea;
        }

        .btn-create {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            font-size: 15px;
        }

        .btn-create:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .summary-icon.count {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .summary-icon.refund {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }

        .summary-info h3 {
            font-size: 14px;
            color: #666;
            margin: 0;
            font-weight: 500;
        }

        .summary-info p {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0 0 0;
            color: #333;
        }

        /* Filters */
        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: flex-end;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 40px;
        }

        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            height: 40px;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-filter:hover {
            color: white;
        }

        /* Table */
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #ddd;
        }

        .table th {
            font-weight: 600;
            color: #333;
            padding: 15px;
            text-align: left;
        }

        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .btn-view {
            background: #17a2b8;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .btn-edit {
            background: #ffc107;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        /* Modal */
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .product-row {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid #eee;
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .product-row>div {
            margin-bottom: 5px;
        }

        .btn-remove-item {
            color: #dc3545;
            border: 1px solid #dc3545;
            background: white;
            width: 38px;
            height: 38px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-remove-item:hover {
            background: #dc3545;
            color: white;
        }

        /* Select2 override */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }

        .badge-khach {
            background: #e3f2fd;
            color: #1976d2;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-ncc {
            background: #fff3e0;
            color: #e65100;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="bi bi-receipt"></i> Invoices App
            </span>

            <!-- Menu Top -->
            <div class="nav-menu">
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i> Quản lý hóa đơn
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link">
                        <i class="bi bi-people"></i> Quản lý khách hàng
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('transactions.index') }}" class="nav-link">
                        <i class="bi bi-wallet2"></i> Quản lý thu chi
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="bi bi-box-seam"></i> Quản lý kho hàng
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('returns.index') }}" class="nav-link active">
                        <i class="bi bi-arrow-return-left"></i> Quản lý trả hàng
                    </a>
                </div>
            </div>

            <div class="navbar-logout">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-arrow-return-left"></i> Quản lý Trả Hàng
            </h1>
            <button class="btn-create" onclick="openCreateModal()">
                <i class="bi bi-plus-circle"></i> Tạo đơn trả hàng
            </button>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-icon count"><i class="bi bi-list-check"></i></div>
                <div class="summary-info">
                    <h3>Tổng số đơn trả</h3>
                    <p id="total-count">0</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon refund"><i class="bi bi-cash-stack"></i></div>
                <div class="summary-info">
                    <h3>Tổng tiền hoàn khách</h3>
                    <p id="total-refund">0 đ</p>
                </div>
            </div>
        </div>

        <div class="filters">
            <div class="filter-row">
                <div class="form-group">
                    <label class="mb-2 fw-bold">Khách hàng</label>
                    <select class="form-select select2" id="filter_customer">
                        <option value="">Tất cả khách hàng</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="mb-2 fw-bold">Từ ngày</label>
                    <input type="date" class="form-control" id="filter_from_date">
                </div>
                <div class="form-group">
                    <label class="mb-2 fw-bold">Đến ngày</label>
                    <input type="date" class="form-control" id="filter_to_date">
                </div>
                <div class="form-group">
                    <label class="mb-2 fw-bold">Trạng thái</label>
                    <select class="form-select" id="filter_status">
                        <option value="khách trả" selected>Khách trả</option>
                        <option value="trả cho nhà cung cấp">Trả cho NCC</option>
                        <option value="">Tất cả</option>
                    </select>
                </div>
                <button class="btn btn-filter" onclick="loadReturns()">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Ngày trả</th>
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Lý do</th>
                        <th>Tiền hoàn</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody id="returns-tbody">
                    <tr>
                        <td colspan="7" class="text-center py-4">Đang tải dữ liệu...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Đơn Trả Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="return-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Chọn Khách Hàng *</label>
                                <select class="form-select select2" id="customer_id" name="customer_id" required
                                    style="width: 100%">
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c->id }}" data-phone="{{ $c->phone ?? '' }}">{{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="customer_phone" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày trả *</label>
                            <input type="date" class="form-control" id="return_date" name="return_date" required>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6>Thêm sản phẩm trả lại</h6>
                                <div class="product-row" id="search-section">
                                    <div style="flex: 1.5">
                                        <label class="form-label small">Mã hàng</label>
                                        <select class="form-select sku-select" id="search_sku"
                                            onchange="syncSearchSelects(this, 'sku')">
                                            <option value="">-- Mã --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-code="{{ $product->code }}"
                                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                                    {{ $product->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 2.5">
                                        <label class="form-label small">Tên sản phẩm</label>
                                        <select class="form-select product-select" id="search_name"
                                            onchange="syncSearchSelects(this, 'name')">
                                            <option value="">-- Chọn sản phẩm --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-code="{{ $product->code }}"
                                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }} (Tồn: {{ $product->quantity }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 0.8">
                                        <label class="form-label small">SL</label>
                                        <input type="number" class="form-control" id="search_qty" value="1" min="1">
                                    </div>
                                    <div style="flex: 1.2">
                                        <label class="form-label small">Giá hoàn</label>
                                        <input type="text" class="form-control" id="search_price" value="0"
                                            oninput="formatPriceInput(this)">
                                    </div>
                                    <div style="flex: 0.5">
                                        <label class="form-label small">&nbsp;</label>
                                        <button type="button" class="btn btn-primary w-100" onclick="addItemToReturn()">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">STT</th>
                                        <th style="width: 120px;">Mã SP</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th class="text-center" style="width: 80px;">SL</th>
                                        <th class="text-end" style="width: 130px;">Giá hoàn</th>
                                        <th class="text-end" style="width: 150px;">Thành tiền</th>
                                        <th class="text-center" style="width: 50px;">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="selected-items-tbody">
                                    <!-- Rows added dynamically -->
                                </tbody>
                                <tfoot class="table-light fw-bold" id="selected-items-tfoot">
                                    <tr>
                                        <td colspan="3" class="text-end">Tổng số lượng:</td>
                                        <td class="text-center" id="footer-total-qty">0</td>
                                        <td class="text-end">TỔNG TIỀN:</td>
                                        <td class="text-end text-primary" id="footer-grand-total">0 đ</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lý do trả</label>
                            <textarea class="form-control" name="reason" id="return_reason" rows="2"
                                placeholder="Nhập lý do khách trả hàng..."></textarea>
                        </div>

                        <input type="hidden" name="status" id="status_input" value="khách trả">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="submitReturn()">Lưu đơn trả hàng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Chi Tiết Đơn Trả Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detail-content">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info text-white" onclick="printReturn()">
                        <i class="bi bi-printer"></i> In Phiếu
                    </button>
                    <button class="btn btn-danger" onclick="downloadReturnPDF()">
                        <i class="bi bi-file-pdf"></i> Xuất PDF
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        const formatCurrency = (amount) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);

        let returnModal;
        let detailModal;
        let editingId = null;
        let selectedItems = [];

        $(document).ready(function () {
            returnModal = new bootstrap.Modal(document.getElementById('returnModal'));
            detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

            $('.select2').each(function () {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') : null
                });
            });

            // Update phone when select customer
            $('#customer_id').on('change', function () {
                const phone = $(this).find(':selected').data('phone');
                $('#customer_phone').val(phone || '');
            });

            window.openCreateModal = function () {
                editingId = null;
                selectedItems = [];
                $('#return-form')[0].reset();
                $('#customer_id').val('').trigger('change');
                $('#return_date')[0].valueAsDate = new Date();
                resetSearchSection();
                renderSelectedItems();
                $('.modal-title').text('Tạo Đơn Trả Hàng');
                returnModal.show();
            }

            window.openEditModal = function (id) {
                editingId = id;
                selectedItems = [];
                $('.modal-title').text('Sửa Đơn Trả Hàng');

                fetch(`{{ url('/returns') }}/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        $('#customer_id').val(data.customer_id).trigger('change');
                        $('#return_date').val(data.return_date);
                        $('#return_reason').val(data.reason || '');
                        $('#status_input').val(data.status);

                        selectedItems = data.details.map(d => ({
                            product_id: d.product_id,
                            product_code: d.product ? d.product.code : (d.product_name.split(' ')[0] || '-'), // Fallback
                            product_name: d.product_name,
                            quantity: parseInt(d.quantity),
                            price: parseFloat(d.refund_price)
                        }));

                        resetSearchSection();
                        renderSelectedItems();
                        returnModal.show();
                    });
            }

            window.resetSearchSection = function () {
                $('#search_sku').val('').trigger('change');
                $('#search_name').val('').trigger('change');
                $('#search_qty').val(1);
                $('#search_price').val(0).data('raw-value', 0);
            }

            window.syncSearchSelects = function (select, type) {
                const val = $(select).val();
                if (type === 'sku') {
                    $('#search_name').val(val);
                } else {
                    $('#search_sku').val(val);
                }
            }

            window.formatPriceInput = function (input) {
                let value = input.value.toString().replace(/\D/g, '');
                if (value === '') value = '0';
                const numValue = parseInt(value);
                input.value = new Intl.NumberFormat('vi-VN').format(numValue);
                $(input).data('raw-value', numValue);
            }

            window.addItemToReturn = function () {
                const productId = $('#search_name').val();
                const qty = parseInt($('#search_qty').val());
                const price = parseFloat($('#search_price').data('raw-value')) || 0;

                if (!productId) {
                    alert('Vui lòng chọn sản phẩm');
                    return;
                }

                if (isNaN(qty) || qty <= 0) {
                    alert('Số lượng không hợp lệ');
                    return;
                }

                const option = $('#search_name').find(':selected');
                const product = {
                    product_id: productId,
                    product_code: option.data('code'),
                    product_name: option.data('name'),
                    quantity: qty,
                    price: price
                };

                selectedItems.push(product);
                renderSelectedItems();
                resetSearchSection();

                setTimeout(() => $('#search_sku').focus(), 50);
            }

            window.removeSelectedItem = function (index) {
                selectedItems.splice(index, 1);
                renderSelectedItems();
            }

            $('#return_date')[0].valueAsDate = new Date();
            loadReturns();

            // Handle keydown in search section
            $(document).on('keydown', '#search-section input, #search-section select', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addItemToReturn();
                }

                const focusables = $('#search-section').find('.sku-select, .product-select, #search_qty, #search_price');
                const index = focusables.index(this);

                if (e.key === 'ArrowRight') {
                    if (index < focusables.length - 1) {
                        e.preventDefault();
                        focusables.eq(index + 1).focus();
                    }
                } else if (e.key === 'ArrowLeft') {
                    if (index > 0) {
                        e.preventDefault();
                        focusables.eq(index - 1).focus();
                    }
                }
            });
        });

        // ... (existing functions)

        function updateItem(index, field, element) {
            let value = element.value;

            if (field === 'quantity') {
                value = parseInt(value);
                if (isNaN(value) || value <= 0) {
                    alert('Số lượng không hợp lệ');
                    element.value = selectedItems[index].quantity;
                    return;
                }
                selectedItems[index].quantity = value;
            } else if (field === 'price') {
                // Ensure formatPriceInput is called first or handles the formatting
                // For simplified inline edit, we might rely on the raw value or re-parse
                let rawValue = parseInt(value.replace(/\D/g, '')) || 0;
                selectedItems[index].price = rawValue;
                // Re-format the input to show pretty currency
                element.value = new Intl.NumberFormat('vi-VN').format(rawValue);
            }

            renderSelectedItems(false); // Pass false to avoid re-rendering inputs (losing focus)
        }

        // Modified render function to accept a flag to prevent full re-render if we want to keep focus
        // But simpler: just re-render and don't worry about focus for now, or use onchange which is naturally fine.
        // Actually, for "price" oninput, re-rendering the whole table is bad.
        // Let's keep renderSelectedItems simple and just update totals in a separate function?
        // Or better: update the DOM directly in updateItem and only re-render totals.
        // For now, let's just re-render but maybe we need a way to not kill the input we are typing in.

        function updateTableTotals() {
            let totalQty = 0;
            let grandTotal = 0;

            selectedItems.forEach((item, index) => {
                const total = item.quantity * item.price;
                totalQty += item.quantity;
                grandTotal += total;

                // Update row total cell
                $(`#item-total-${index}`).text(formatCurrency(total));
            });

            $('#footer-total-qty').text(totalQty);
            $('#footer-grand-total').text(formatCurrency(grandTotal));
        }

        function renderSelectedItems() {
            const tbody = $('#selected-items-tbody');
            // If we are calling this from updateItem, we shouldn't wipe everything if we want to keep focus?
            // But requirement allows "edit number and price".
            // Let's just render inputs.

            // Check if we already have rows and if we are just updating? 
            // The simplest sustainable way is to re-render. 
            // If user types in input, 'onchange' triggers. 'oninput' for price?

            tbody.empty();

            let totalQty = 0;
            let grandTotal = 0;

            selectedItems.forEach((item, index) => {
                const total = item.quantity * item.price;
                totalQty += item.quantity;
                grandTotal += total;

                tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.product_code || '-'}</td>
                        <td>${item.product_name}</td>
                        <td class="text-center" style="width: 100px;">
                            <input type="number" class="form-control form-control-sm text-center" 
                                value="${item.quantity}" min="1" 
                                onchange="updateItem(${index}, 'quantity', this)">
                        </td>
                        <td class="text-end" style="width: 150px;">
                            <input type="text" class="form-control form-control-sm text-end" 
                                value="${new Intl.NumberFormat('vi-VN').format(item.price)}"
                                onfocus="this.select()"
                                onchange="updateItem(${index}, 'price', this)"> 
                        </td>
                        <td class="text-end fw-bold text-danger" id="item-total-${index}">${formatCurrency(total)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeSelectedItem(${index})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });

            if (selectedItems.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center py-3 text-muted">Chưa có sản phẩm nào</td></tr>');
            }

            $('#footer-total-qty').text(totalQty);
            $('#footer-grand-total').text(formatCurrency(grandTotal));
        }

        function submitReturn() {
            const customerId = $('#customer_id').val();
            const returnDate = $('#return_date').val();

            if (!returnDate) { alert('Vui lòng chọn ngày trả'); return; }
            if (selectedItems.length === 0) {
                alert('Vui lòng thêm ít nhất 1 sản phẩm');
                return;
            }

            const data = {
                customer_id: customerId,
                return_date: returnDate,
                reason: $('#return_reason').val(),
                status: $('#status_input').val(),
                details: selectedItems.map(item => ({
                    product_id: item.product_id,
                    quantity: item.quantity,
                    refund_price: item.price
                }))
            };

            const url = editingId ? `{{ url('/returns') }}/${editingId}` : '{{ route("returns.store") }}';
            const method = editingId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        returnModal.hide();
                        loadReturns();
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Có lỗi xảy ra');
                });
        }

        let currentReturnId = null;

        function viewReturn(id) {
            currentReturnId = id;
            $('#detail-content').html('Loading...');
            detailModal.show();

            fetch(`{{ url('/returns') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    let totalQty = 0;
                    let html = `
                        <div id="return-receipt" style="padding: 10px; font-family: Arial, sans-serif;">
                            <div class="text-center mb-4">
                                <h3 style="margin-bottom: 5px; font-weight: bold;">PHIẾU TRẢ HÀNG</h3>
                                <p style="font-size: 14px; color: #555;">Số: TH-${data.id}</p>
                            </div>
                            
                            <hr>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <p style="margin-bottom: 5px;"><strong>Khách hàng:</strong> ${data.customer ? data.customer.name : 'Nhà cung cấp'}</p>
                                    <p style="margin-bottom: 5px;"><strong>Ngày trả:</strong> ${new Date(data.return_date).toLocaleDateString('vi-VN')}</p>
                                    <p style="margin-bottom: 5px;"><strong>Lý do:</strong> ${data.reason || 'Không có'}</p>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">SL</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    data.details.forEach((d, idx) => {
                        totalQty += parseInt(d.quantity);
                        html += `
                            <tr>
                                <td class="text-center">${idx + 1}</td>
                                <td>${d.product_name}</td>
                                <td class="text-center">${d.quantity}</td>
                                <td class="text-end">${formatCurrency(d.refund_price)}</td>
                                <td class="text-end">${formatCurrency(d.quantity * d.refund_price)}</td>
                            </tr>
                        `;
                    });

                    html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-end">TỔNG CỘNG:</th>
                                        <th class="text-center">${totalQty}</th>
                                        <th class="text-end" colspan="2" style="font-size: 18px; color: #667eea;">${formatCurrency(data.total_refund_amount)}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="mt-5 row">
                                <div class="col-6 text-center">
                                    <p><strong>Người trả hàng</strong></p>
                                    <p style="margin-top: 60px;">(Ký, ghi rõ họ tên)</p>
                                </div>
                                <div class="col-6 text-center">
                                    <p><strong>Người nhận hàng</strong></p>
                                    <p style="margin-top: 60px;">(Ký, ghi rõ họ tên)</p>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#detail-content').html(html);
                });
        }

        function printReturn() {
            const content = document.getElementById('return-receipt').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>In Phiếu Trả</title>');
            printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
            printWindow.document.write('<style>body { padding: 20px; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        }

        function downloadReturnPDF() {
            const element = document.getElementById('return-receipt');
            const opt = {
                margin: 0.5,
                filename: `phieu_tra_hang_th${currentReturnId}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }

        function loadReturns() {
            const params = new URLSearchParams({
                customer_id: $('#filter_customer').val(),
                from_date: $('#filter_from_date').val(),
                to_date: $('#filter_to_date').val(),
                status: $('#filter_status').val()
            });

            fetch(`{{ route('returns.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    $('#total-count').text(data.totalCount);
                    $('#total-refund').text(formatCurrency(data.totalRefund));

                    const tbody = $('#returns-tbody');
                    tbody.empty();

                    if (data.returns.length === 0) {
                        tbody.append('<tr><td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu</td></tr>');
                    } else {
                        data.returns.forEach(r => {
                            const badge = r.status === 'khách trả' ? 'badge-khach' : 'badge-ncc';
                            const productsList = r.details.map(d => `${d.product_name} (x${d.quantity})`).join('<br>');

                            tbody.append(`
                                <tr>
                                    <td>${new Date(r.return_date).toLocaleDateString('vi-VN')}</td>
                                    <td class="fw-bold">${r.customer ? r.customer.name : 'Nhà cung cấp'}</td>
                                    <td>${productsList}</td>
                                    <td class="text-muted small">${r.reason || '-'}</td>
                                    <td class="fw-bold text-danger">${formatCurrency(r.total_refund_amount)}</td>
                                    <td><span class="${badge}">${r.status}</span></td>
                                    <td class="text-center">
                                        <button class="btn-view" title="Xem" onclick="viewReturn(${r.id})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn-edit" title="Sửa" onclick="openEditModal(${r.id})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn-delete" title="Xóa" onclick="deleteReturn(${r.id})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
        }

        function deleteReturn(id) {
            if (!confirm('Bạn có chắc chắn muốn xóa đơn trả hàng này không? Số lượng kho sẽ được trừ lại tương ứng.')) return;

            fetch(`{{ url('/returns') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        loadReturns();
                        alert(res.message);
                    } else {
                        alert('Lỗi: ' + res.message);
                    }
                });
        }

        $('#return-form').on('submit', function (e) {
            e.preventDefault();

            const products = [];
            let isValid = true;
            $('#product-list .product-row').each(function () {
                const productId = $(this).find('.product-select').val();
                if (!productId) { isValid = false; return; }

                products.push({
                    product_id: productId,
                    quantity: $(this).find('.qty-input').val(),
                    refund_price: $(this).find('.price-input').data('raw-value') || 0
                });
            });

            if (!isValid) { alert('Vui lòng chọn sản phẩm'); return; }

            const data = {
                customer_id: $('#customer_id').val(),
                return_date: $('#return_date').val(),
                reason: $('textarea[name="reason"]').val(),
                status: $('#status_input').val(),
                details: products
            };

            const url = editingId ? `{{ url('/returns') }}/${editingId}` : '{{ route("returns.store") }}';
            const method = editingId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        returnModal.hide();
                        loadReturns();
                        alert(res.message);
                    } else {
                        alert('Lỗi: ' + (res.message || 'Vui lòng kiểm tra lại dữ liệu'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Có lỗi xảy ra khi lưu đơn trả hàng');
                });
        });
    </script>
</body>

</html>