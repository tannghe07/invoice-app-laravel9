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

        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .page-title i {
            margin-right: 10px;
            color: #667eea;
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

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

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

        .form-control,
        .form-select {
            height: 40px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
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

        /* Fix Select2 alignment in filters */
        .filters .select2-container--default .select2-selection--single {
            height: 40px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .filters .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }

        .filters .select2-container {
            width: 100% !important;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
        }

        .btn-view {
            background: #6366f1;
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: #4f46e5;
            color: white;
        }

        .btn-warning {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Product Row Styles */
        .product-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            align-items: flex-end;
        }

        .product-row>div {
            margin-bottom: 5px;
        }

        .btn-remove-item {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }

        .btn-remove-item:hover {
            background: #dc2626;
            color: white;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title"><i class="bi bi-arrow-return-left text-primary"></i> Quản lý Trả Hàng</h1>
            <button class="btn btn-add" onclick="openCreateModal()">
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
                <button class="btn btn-primary" style="height: 40px;" onclick="loadReturns()">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tạo Đơn Trả Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="return-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Khách hàng *</label>
                                <select class="form-select select2" id="customer_id" name="customer_id" required>
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ngày trả *</label>
                                <input type="date" class="form-control" id="return_date" name="return_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Danh sách sản phẩm sản phẩm trả lại</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addProductRow()">
                                    <i class="bi bi-plus"></i> Thêm sản phẩm
                                </button>
                            </label>
                            <div id="product-list">
                                <!-- Product Rows -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lý do trả</label>
                            <textarea class="form-control" name="reason" rows="2"
                                placeholder="Nhập lý do khách trả hàng..."></textarea>
                        </div>

                        <div class="mb-3 text-end">
                            <h4>Tổng Tiền Hoàn: <span id="grand-total" class="text-danger">0 đ</span></h4>
                        </div>

                        <input type="hidden" name="status" id="status_input" value="khách trả">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">Lưu đơn trả hàng</button>
                    </form>
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
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden template for product row -->
    <template id="product-row-template">
        <div class="product-row">
            <div style="flex: 1.5">
                <label class="form-label small">Mã hàng</label>
                <select class="form-select sku-select" onchange="syncProductSelects(this, 'sku')" required>
                    <option value="">-- Mã --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->code }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 2.5">
                <label class="form-label small">Tên sản phẩm</label>
                <select class="form-select product-select" onchange="syncProductSelects(this, 'name')" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (Tồn: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1.2">
                <label class="form-label small">Giá hoàn</label>
                <input type="text" class="form-control price-input" value="0"
                    oninput="formatPriceInput(this); calculateRowTotal(this)">
            </div>
            <div style="flex: 0.8">
                <label class="form-label small">SL</label>
                <input type="number" class="form-control qty-input" min="1" value="1" oninput="calculateRowTotal(this)">
            </div>
            <div style="flex: 1.2">
                <label class="form-label small">Thành tiền</label>
                <input type="text" class="form-control total-input fw-bold text-danger" value="0" readonly>
            </div>
            <button type="button" class="btn-remove-item" onclick="removeProductRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </template>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const formatCurrency = (amount) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);

        window.formatPriceInput = function (input, rawValue) {
            let numValue;
            if (rawValue !== undefined) {
                numValue = parseInt(rawValue) || 0;
            } else {
                let value = input.value.toString().replace(/\D/g, '');
                if (value === '') value = '0';
                numValue = parseInt(value);
            }
            input.value = new Intl.NumberFormat('vi-VN').format(numValue);
            $(input).data('raw-value', numValue);
        }

        function addProductRow() {
            const template = document.getElementById('product-row-template');
            const clone = template.content.cloneNode(true);
            const row = $(clone).find('.product-row');
            $('#product-list').append(row);

            // Re-bind select2 or any other init if needed. 
            // Plain selects for now to be simple but compatible.
        }

        function removeProductRow(btn) {
            if ($('#product-list .product-row').length > 1) {
                $(btn).closest('.product-row').remove();
                calculateGrandTotal();
            } else {
                alert('Phải có ít nhất 1 sản phẩm');
            }
        }

        window.syncProductSelects = function (select, type) {
            const row = $(select).closest('.product-row');
            const val = $(select).val();
            if (type === 'sku') {
                row.find('.product-select').val(val);
            } else {
                row.find('.sku-select').val(val);
            }

            // Note: Price is NOT auto-filled as per user request.
            calculateRowTotal(row.find('.qty-input')[0]);
        }

        window.calculateRowTotal = function (input) {
            const row = $(input).closest('.product-row');
            const qty = parseInt(row.find('.qty-input').val()) || 0;
            const price = parseFloat(row.find('.price-input').data('raw-value')) || 0;
            const total = qty * price;
            row.find('.total-input').val(new Intl.NumberFormat('vi-VN').format(total));
            row.find('.total-input').data('raw-total', total);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            $('.total-input').each(function () {
                total += parseFloat($(this).data('raw-total')) || 0;
            });
            $('#grand-total').text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total));
        }

        let returnModal;
        let detailModal;
        let editingId = null;

        $(document).ready(function () {
            returnModal = new bootstrap.Modal(document.getElementById('returnModal'));
            detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            $('.select2').select2();

            $('#returnModal').on('shown.bs.modal', function () {
                $('#customer_id').select2({ dropdownParent: $('#returnModal') });
            });

            document.getElementById('return_date').valueAsDate = new Date();
            loadReturns();

            // Handle Enter key to add product row
            $(document).on('keydown', function (e) {
                if ($('#returnModal').hasClass('show')) {
                    if (e.key === 'Enter' && !$(e.target).is('button, a, textarea')) {
                        e.preventDefault();
                        addProductRow();
                        // Focus the SKU select of the newly added row
                        setTimeout(() => {
                            $('#product-list .product-row:last .sku-select').focus();
                        }, 50);
                    }
                }
            });
        });

        function openCreateModal() {
            editingId = null;
            $('#return-form')[0].reset();
            $('#product-list').empty();
            $('#customer_id').val('').trigger('change');
            document.getElementById('return_date').valueAsDate = new Date();
            document.getElementById('grand-total').textContent = '0 đ';
            $('.modal-title').text('Tạo Đơn Trả Hàng');
            addProductRow();
            returnModal.show();
        }

        function openEditModal(id) {
            editingId = id;
            $('.modal-title').text('Sửa Đơn Trả Hàng');
            $('#product-list').empty();

            fetch(`{{ url('/returns') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#customer_id').val(data.customer_id).trigger('change');
                    $('#return_date').val(data.return_date);
                    $('textarea[name="reason"]').val(data.reason || '');
                    $('#status_input').val(data.status);

                    data.details.forEach(detail => {
                        const template = document.getElementById('product-row-template');
                        const clone = template.content.cloneNode(true);
                        const row = $(clone).find('.product-row');
                        
                        row.find('.sku-select').val(detail.product_id);
                        row.find('.product-select').val(detail.product_id);
                        row.find('.qty-input').val(detail.quantity);
                        
                        const priceInput = row.find('.price-input')[0];
                        // Convert DB string (e.g. "100000.00") to clean integer
                        const rawPrice = Math.round(parseFloat(detail.refund_price) || 0);
                        formatPriceInput(priceInput, rawPrice);

                        $('#product-list').append(row);
                        calculateRowTotal(row.find('.qty-input')[0]);
                    });

                    returnModal.show();
                });
        }

        function viewReturn(id) {
            $('#detail-content').html('Loading...');
            detailModal.show();

            fetch(`{{ url('/returns') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <div class="mb-3">
                            <strong>Khách hàng:</strong> ${data.customer ? data.customer.name : 'Nhà cung cấp'}
                        </div>
                        <div class="mb-3">
                            <strong>Ngày trả:</strong> ${new Date(data.return_date).toLocaleDateString('vi-VN')}
                        </div>
                        <div class="mb-3">
                            <strong>Trạng thái:</strong> ${data.status}
                        </div>
                        <div class="mb-3">
                            <strong>Lý do:</strong> ${data.reason || 'Không có'}
                        </div>
                        <hr>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>SL</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    data.details.forEach(d => {
                        html += `
                            <tr>
                                <td>${d.product_name}</td>
                                <td>${d.quantity}</td>
                                <td class="text-end">${formatCurrency(d.refund_price)}</td>
                                <td class="text-end">${formatCurrency(d.quantity * d.refund_price)}</td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th class="text-end text-danger">${formatCurrency(data.total_refund_amount)}</th>
                                </tr>
                            </tfoot>
                        </table>
                    `;

                    $('#detail-content').html(html);
                });
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
                                        <button class="btn btn-warning btn-sm text-white" title="Sửa" onclick="openEditModal(${r.id})">
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