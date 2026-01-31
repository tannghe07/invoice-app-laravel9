<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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

        .btn-create-invoice {
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

        .btn-create-invoice:hover {
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

        .summary-icon.revenue {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .summary-icon.count {
            background: linear-gradient(135deg, #FFC107 0%, #FF9800 100%);
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
            height: 38px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="bi bi-receipt"></i> Invoices App
            </span>

            <div class="nav-menu">
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
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
                    <a href="{{ route('returns.index') }}" class="nav-link">
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
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-file-earmark-text"></i> Quản lý Hóa Đơn
            </h1>
            <button class="btn-create-invoice" onclick="openCreateModal()">
                <i class="bi bi-plus-circle"></i> Tạo Hóa Đơn Mới
            </button>
        </div>

        <!-- Summary -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-icon revenue">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Doanh Thu</h3>
                    <p id="total-revenue">0 đ</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon count">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Số Hóa Đơn</h3>
                    <p id="total-count">0</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <h5 class="mb-3">Bộ lọc</h5>
            <div class="filter-row">
                <div class="form-group">
                    <label>Khách hàng</label>
                    <select class="form-select" id="filter_customer">
                        <option value="">-- Tất cả khách hàng --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Từ ngày</label>
                    <input type="date" class="form-control" id="filter_from_date">
                </div>
                <div class="form-group">
                    <label>Đến ngày</label>
                    <input type="date" class="form-control" id="filter_to_date">
                </div>
                <button class="btn btn-filter" onclick="loadInvoices()">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày lập</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="invoices-tbody">
                        <tr>
                            <td colspan="7" class="text-center">Đang tải...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Invoice Modal -->
    <div class="modal fade" id="createInvoiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo Hóa Đơn Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="create-invoice-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Chọn Khách Hàng *</label>
                                <select class="form-select select2" id="customer_id" name="customer_id" required
                                    style="width: 100%">
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" data-phone="{{ $customer->phone ?? '' }}">
                                            {{ $customer->name }}
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
                            <label class="form-label">Ngày lập hóa đơn</label>
                            <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-flex justify-content-between align-items-center">
                                <span>Danh sách sản phẩm</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addProductRow()">
                                    <i class="bi bi-plus"></i> Thêm sản phẩm
                                </button>
                            </label>
                            <div id="product-list">
                                <!-- Product Rows -->
                            </div>
                        </div>

                        <div class="mb-3 text-end">
                            <h4>Tổng Tiền: <span id="grand-total" class="text-primary">0 đ</span></h4>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-invoice" onclick="submitInvoice()">Tạo
                        Hóa Đơn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi Tiết Hóa Đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detail-content">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info text-white" onclick="printInvoice()">
                        <i class="bi bi-printer"></i> In Hóa Đơn
                    </button>
                    <button class="btn btn-danger" onclick="downloadPDF()">
                        <i class="bi bi-file-pdf"></i> Xuất PDF
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden template for product row -->
    <template id="product-row-template">
        <div class="product-row">
            <div style="flex: 2">
                <label class="form-label small">Sản phẩm</label>
                <select class="form-select product-select" onchange="updateProductPrice(this)" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            {{ $product->name }}
                            ({{ $product->quantity > 0 ? 'Tồn: ' . $product->quantity : 'Hết hàng' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1">
                <label class="form-label small">Đơn giá</label>
                <input type="text" class="form-control price-input" readonly value="0">
            </div>
            <div style="flex: 1">
                <label class="form-label small">Số lượng</label>
                <input type="number" class="form-control qty-input" min="1" value="1" oninput="calculateRowTotal(this)">
            </div>
            <div style="flex: 1">
                <label class="form-label small">Thành tiền</label>
                <input type="text" class="form-control total-input" readonly value="0">
            </div>
            <button type="button" class="btn-remove-item" onclick="removeProductRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </template>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        // Utils
        const formatCurrency = (amount) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        const formatDate = (dateStr) => {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('vi-VN');
        }

        let createModal;
        let detailModal;

        $(document).ready(function () {
            createModal = new bootstrap.Modal(document.getElementById('createInvoiceModal'));
            detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

            // Init Select2
            $('.select2').select2({
                dropdownParent: $('#createInvoiceModal')
            });

            // Customer change listener
            $('#customer_id').on('change', function () {
                const phone = $(this).find(':selected').data('phone');
                $('#customer_phone').val(phone || '');
            });

            loadInvoices();
        });

        // Load Invoices
        function loadInvoices() {
            const params = new URLSearchParams({
                customer_id: $('#filter_customer').val(),
                from_date: $('#filter_from_date').val(),
                to_date: $('#filter_to_date').val()
            });

            fetch(`{{ route('invoices.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    // Update Summary
                    $('#total-revenue').text(formatCurrency(data.totalRevenue));
                    $('#total-count').text(data.totalCount);

                    // Update Table
                    const tbody = $('#invoices-tbody');
                    tbody.empty();

                    if (data.invoices.length === 0) {
                        tbody.append('<tr><td colspan="7" class="text-center py-5 text-muted">Không có dữ liệu</td></tr>');
                    } else {
                        data.invoices.forEach((inv, index) => {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${formatDate(inv.invoice_date)}</td>
                                    <td>${inv.customer_name}</td>
                                    <td>${inv.customer_phone || '-'}</td>
                                    <td>${inv.product_name}</td>
                                    <td class="fw-bold">${formatCurrency(inv.total_amount)}</td>
                                    <td>
                                        <button class="btn btn-view btn-sm" onclick="viewInvoice(${inv.id})">
                                            <i class="bi bi-eye"></i> Xem
                                        </button>
                                        <button class="btn btn-warning btn-sm text-white" onclick="openEditModal(${inv.id})">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                })
                .catch(err => console.error(err));
        }

        // --- Invoice Creation Logic ---

        // Create/Update Logic
        let editingInvoiceId = null;

        function openCreateModal() {
            editingInvoiceId = null;
            $('#create-invoice-form')[0].reset();
            $('#customer_id').val('').trigger('change');
            $('#invoice_date')[0].valueAsDate = new Date();
            $('#product-list').empty();
            $('#grand-total').text('0 đ');
            $('.modal-title').text('Tạo Hóa Đơn Mới');
            $('#btn-submit-invoice').text('Tạo Hóa Đơn');
            addProductRow();
            createModal.show();
        }

        function openEditModal(id) {
            editingInvoiceId = id;
            $('.modal-title').text('Cập Nhật Hóa Đơn');
            $('#btn-submit-invoice').text('Lưu Cập Nhật');

            fetch(`{{ url('/invoices') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#customer_id').val(data.customer_id).trigger('change');
                    $('#invoice_date').val(data.invoice_date.substring(0, 10)); // YYYY-MM-DD

                    $('#product-list').empty();

                    if (data.details && data.details.length > 0) {
                        data.details.forEach(d => {
                            addProductRow(d);
                        });
                    } else {
                        addProductRow();
                    }
                    createModal.show();
                });
        }

        function addProductRow(data = null) {
            const template = document.getElementById('product-row-template');
            const clone = template.content.cloneNode(true);
            const row = $(clone).find('.product-row');

            $('#product-list').append(row);

            if (data) {
                const select = row.find('.product-select');

                // Check if product exists in dropdown
                if (data.product_id && select.find(`option[value="${data.product_id}"]`).length === 0) {
                    // Good Solution: Product was deleted from DB but exists in Invoice
                    // We add a temporary disabled option so the UI isn't broken
                    select.append(`<option value="${data.product_id}" data-price="${data.price}" disabled selected>${data.product_name} (Đã ngưng kinh doanh)</option>`);
                } else if (data.product_id) {
                    // Product exists but might be disabled due to 0 stock
                    // We must enable it for THIS row so it can be shown
                    select.find(`option[value="${data.product_id}"]`).prop('disabled', false);
                }

                select.val(data.product_id || '').trigger('change');

                row.find('.qty-input').val(data.quantity);
                calculateRowTotal(row.find('.qty-input')[0]);
            }
            updateAvailableProducts();
        }

        function updateAvailableProducts() {
            const selectedProducts = [];
            $('.product-select').each(function () {
                const val = $(this).val();
                if (val) selectedProducts.push(val);
            });

            $('.product-select').each(function () {
                const currentVal = $(this).val();
                $(this).find('option').each(function () {
                    const optVal = $(this).val();
                    if (!optVal) return;

                    // If it's the current selected value, always keep it enabled so it's visible
                    if (optVal === currentVal) {
                        $(this).prop('disabled', false);
                        $(this).css('color', '');
                        return;
                    }

                    // If it's selected in another row, disable it
                    if (selectedProducts.includes(optVal)) {
                        $(this).prop('disabled', true);
                        $(this).css('color', '#ccc');
                    } else {
                        // Otherwise, follow the data's original state (out of stock = disabled)
                        // Note: info is static in HTML, but we can check the text or use a data attribute
                        // For simplicity, we can check if it has the "Hết hàng" indicator in text
                        const isOutOfStock = $(this).text().includes('(Hết hàng)');
                        const isMissing = $(this).text().includes('(Đã ngưng kinh doanh)');

                        if (isOutOfStock || isMissing) {
                            $(this).prop('disabled', true);
                            $(this).css('color', '#ccc');
                        } else {
                            $(this).prop('disabled', false);
                            $(this).css('color', '');
                        }
                    }
                });
            });
        }

        function removeProductRow(btn) {
            if ($('#product-list .product-row').length > 1) {
                $(btn).closest('.product-row').remove();
                calculateGrandTotal();
                updateAvailableProducts();
            } else {
                alert('Phải có ít nhất 1 sản phẩm');
            }
        }

        window.updateProductPrice = function (select) {
            const price = $(select).find(':selected').data('price') || 0;
            const row = $(select).closest('.product-row');
            row.find('.price-input').val(formatCurrency(price)); // Display formatted
            row.find('.price-input').data('raw-price', price); // Store raw
            calculateRowTotal(row.find('.qty-input')[0]);
            updateAvailableProducts();
        }

        window.calculateRowTotal = function (input) {
            const row = $(input).closest('.product-row');
            const qty = parseInt($(input).val()) || 0;
            const price = parseFloat(row.find('.price-input').data('raw-price')) || 0;

            const total = qty * price;
            row.find('.total-input').val(formatCurrency(total));
            row.find('.total-input').data('raw-total', total);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            $('.total-input').each(function () {
                total += parseFloat($(this).data('raw-total')) || 0;
            });
            $('#grand-total').text(formatCurrency(total));
        }

        function submitInvoice() {
            const customerId = $('#customer_id').val();
            if (!customerId) { alert('Vui lòng chọn khách hàng'); return; }

            const products = [];
            let isValid = true;
            $('#product-list .product-row').each(function () {
                const productId = $(this).find('.product-select').val();
                if (!productId) { isValid = false; return; }

                products.push({
                    product_id: productId,
                    quantity: $(this).find('.qty-input').val(),
                    price: $(this).find('.price-input').data('raw-price')
                });
            });

            if (!isValid) { alert('Vui lòng chọn sản phẩm'); return; }

            const data = {
                customer_id: customerId,
                invoice_date: $('#invoice_date').val(),
                details: products
            };

            const url = editingInvoiceId ? `{{ url('/invoices') }}/${editingInvoiceId}` : '{{ route("invoices.store") }}';
            const method = editingInvoiceId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        createModal.hide();
                        loadInvoices();
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Có lỗi xảy ra');
                });
        }

        // --- View ---

        let currentInvoiceId = null;

        function viewInvoice(id) {
            currentInvoiceId = id;
            fetch(`{{ url('/invoices') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <div id="invoice-receipt" style="padding: 10px; font-family: Arial, sans-serif;">
                            <div class="text-center mb-4">
                                <h3 style="margin-bottom: 5px; font-weight: bold;">HÓA ĐƠN BÁN HÀNG</h3>
                                <p style="font-size: 14px; color: #555;">Số: HD-${data.id}</p>
                            </div>
                            
                            <hr>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <p style="margin-bottom: 5px;"><strong>Khách hàng:</strong> ${data.customer.name}</p>
                                    <p style="margin-bottom: 5px;"><strong>Điện thoại:</strong> ${data.customer.phone || '-'}</p>
                                    <p style="margin-bottom: 5px;"><strong>Ngày lập:</strong> ${formatDate(data.invoice_date)}</p>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">SL</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    data.details.forEach(d => {
                        html += `
                            <tr>
                                <td>${d.product_name}</td>
                                <td class="text-center">${d.quantity}</td>
                                <td class="text-end">${formatCurrency(d.price)}</td>
                                <td class="text-end">${formatCurrency(d.total)}</td>
                            </tr>
                        `;
                    });

                    html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">TỔNG CỘNG:</th>
                                        <th class="text-end text-primary" style="font-size: 18px;">${formatCurrency(data.total_amount)}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="mt-5 row">
                                <div class="col-6 text-center">
                                    <p><strong>Người mua hàng</strong></p>
                                    <p style="margin-top: 60px;">(Ký, ghi rõ họ tên)</p>
                                </div>
                                <div class="col-6 text-center">
                                    <p><strong>Người bán hàng</strong></p>
                                    <p style="margin-top: 60px;">(Ký, ghi rõ họ tên)</p>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#detail-content').html(html);
                    detailModal.show();
                });
        }

        function printInvoice() {
            const content = document.getElementById('invoice-receipt').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>In Hóa Đơn</title>');
            printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
            printWindow.document.write('<style>body { padding: 20px; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Wait for styles to load
            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        }

        function downloadPDF() {
            const element = document.getElementById('invoice-receipt');
            const opt = {
                margin: 0.5,
                filename: `hoa_don_hd${currentInvoiceId}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }



    </script>
</body>

</html>