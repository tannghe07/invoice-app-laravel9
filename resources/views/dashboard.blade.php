<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 15px;
            color: white;
            position: fixed;
            right: -550px;
            width: 500px;
            top: 0;
            z-index: 1000;
            transition: right 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
        }

        .sidebar.active {
            right: 0;
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

        .nav-item {
            position: relative;
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

        .container-main {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        .container-main.sidebar-open {
            margin-left: -500px;
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

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            color: white;
        }

        .btn-add-invoice {
            position: fixed;
            right: 30px;
            bottom: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 30px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .btn-add-invoice:hover {
            transform: scale(1.1);
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #ddd;
        }

        .table th {
            font-weight: 600;
            color: #333;
            padding: 15px;
            text-align: center;
        }

        .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-view {
            background: #17a2b8;
            border: none;
            color: white;
        }

        .btn-view:hover {
            background: #138496;
            color: white;
        }

        .btn-edit {
            background: #ffc107;
            border: none;
            color: white;
        }

        .btn-edit:hover {
            background: #e0a800;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-right: 30px;
            flex-shrink: 0;
        }

        #invoice-form {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        #invoice-form::-webkit-scrollbar {
            width: 6px;
        }

        #invoice-form::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        #invoice-form::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        #invoice-form::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .form-group-sidebar {
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .form-group-sidebar label {
            color: white;
            font-weight: 600;
            margin-bottom: 4px;
            display: block;
            font-size: 13px;
        }

        .form-group-sidebar input,
        .form-group-sidebar select {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 13px;
            height: 35px;
        }

        .form-group-sidebar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group-sidebar input:focus,
        .form-group-sidebar select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
        }

        .btn-submit-invoice {
            width: 100%;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            position: static;
            flex-shrink: 0;
            margin-bottom: 15px;
        }

        .btn-submit-invoice:hover {
            background: #45a049;
        }

        .btn-close-sidebar {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        .modal-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-popup.active {
            display: block;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .invoice-info {
            margin-bottom: 15px;
        }

        .invoice-info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .invoice-info-label {
            font-weight: 600;
            color: #666;
        }

        .invoice-info-value {
            color: #333;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }

        .btn-pdf,
        .btn-print {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-pdf {
            background: #e74c3c;
            color: white;
        }

        .btn-pdf:hover {
            background: #c0392b;
        }

        .btn-print {
            background: #3498db;
            color: white;
        }

        .btn-print:hover {
            background: #2980b9;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #999;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .navbar-logout {
            margin-left: auto;
        }

        .customer-list {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 15px;
        }

        .customer-option {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: background 0.2s ease;
        }

        .customer-option:hover {
            background: rgba(255, 255, 255, 0.2);
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

    <div class="container-fluid container-main">
        <div class="px-4">
            <!-- Filters -->
            <div class="filters">
                <h5 class="mb-20" style="margin-bottom: 20px;">Bộ lọc</h5>
                <div class="filter-row">
                    <div class="form-group">
                        <label for="filter_customer">Tên khách hàng</label>
                        <input type="text" class="form-control" id="filter_customer" placeholder="Nhập tên khách">
                    </div>
                    <div class="form-group">
                        <label for="filter_from_date">Từ ngày</label>
                        <input type="date" class="form-control" id="filter_from_date">
                    </div>
                    <div class="form-group">
                        <label for="filter_to_date">Đến ngày</label>
                        <input type="date" class="form-control" id="filter_to_date">
                    </div>
                    <div class="form-group">
                        <label for="filter_status">Trạng thái</label>
                        <select class="form-select" id="filter_status">
                            <option value="">Tất cả</option>
                            <option value="pending">Còn nợ</option>
                            <option value="paid">Đã xong</option>
                        </select>
                    </div>
                    <button class="btn btn-filter" onclick="loadInvoices()">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div id="invoices-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th style="width: 15%">Tên khách hàng</th>
                                <th style="width: 20%">Tên mặt hàng</th>
                                <th style="width: 12%">Sdt khách</th>
                                <th style="width: 10%">Trạng thái</th>
                                <th style="width: 38%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="invoices-tbody">
                            <tr>
                                <td colspan="6" class="loading">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Đang tải...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar (Side Tab) -->
    <div class="overlay" id="overlay"></div>
    <div class="sidebar" id="sidebar">
        <button class="btn-close-sidebar" onclick="closeSidebar()">×</button>
        <div class="sidebar-title">
            <i class="bi bi-plus-circle"></i> Tạo Hóa Đơn
        </div>

        <form id="invoice-form">
            @csrf

            <!-- Customer Selection -->
            <div class="form-group-sidebar">
                <label>Khách hàng</label>
                <select id="customer_select" onchange="selectCustomer()">
                    <option value="">-- Tạo khách mới --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-phone="{{ $customer->phone }}">
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" id="customer_id" name="customer_id">
            </div>

            <div class="form-group-sidebar">
                <label for="customer_name">Tên khách hàng *</label>
                <input type="text" id="customer_name" name="customer_name" placeholder="Nhập tên khách hàng" required>
            </div>

            <div class="form-group-sidebar">
                <label for="customer_phone">Số điện thoại khách *</label>
                <input type="tel" id="customer_phone" name="customer_phone" placeholder="Nhập số điện thoại" required>
                <div id="phone-error"
                    style="color: #ff6b6b; font-size: 12px; margin-top: 3px; display: none; line-height: 1.2;"></div>
            </div>

            <div class="form-group-sidebar">
                <label for="customer_address">Địa chỉ</label>
                <input type="text" id="customer_address" name="customer_address" placeholder="Nhập địa chỉ (tùy chọn)">
            </div>

            <div class="form-group-sidebar">
                <label for="invoice_date">Ngày lập hóa đơn *</label>
                <input type="date" id="invoice_date" name="invoice_date" required>
            </div>

            <div class="form-group-sidebar">
                <label for="product_name">Tên sản phẩm *</label>
                <input type="text" id="product_name" name="product_name" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="form-group-sidebar">
                <label for="price">Số tiền sản phẩm *</label>
                <input type="number" id="price" name="price" placeholder="0" step="0.01" min="0" required>
            </div>

            <div class="form-group-sidebar">
                <label for="paid_amount">Số tiền khách trả *</label>
                <input type="number" id="paid_amount" name="paid_amount" placeholder="0" step="0.01" min="0" required>
            </div>

            <div class="form-group-sidebar">
                <label for="change_amount">Số tiền trả khách</label>
                <input type="number" id="change_amount" name="change_amount" readonly placeholder="Tự tính">
            </div>

            <div class="form-group-sidebar">
                <label for="debt_amount">Số tiền khách nợ</label>
                <input type="number" id="debt_amount" name="debt_amount" readonly placeholder="Tự tính">
            </div>

            <button type="submit" class="btn-submit-invoice">
                <i class="bi bi-check-circle"></i> Tạo Hóa Đơn
            </button>
        </form>
    </div>

    <!-- Invoice Details Popup -->
    <div class="modal-popup" id="invoiceModal">
        <div class="modal-header">
            <h3>Chi tiết Hóa Đơn</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div id="invoice-details">
            <!-- Invoice details will be loaded here -->
        </div>
        <div class="modal-actions">
            <button class="btn-pdf" onclick="exportPdf()">
                <i class="bi bi-filetype-pdf"></i> Xuất PDF
            </button>
            <button class="btn-print" onclick="printInvoice()">
                <i class="bi bi-printer"></i> In
            </button>
        </div>
    </div>

    <!-- Add Invoice Button -->
    <button class="btn-add-invoice" onclick="openSidebar()" title="Tạo hóa đơn">
        <i class="bi bi-plus"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        // Set today's date as default
        document.getElementById('invoice_date').valueAsDate = new Date();

        function openSidebar() {
            document.getElementById('sidebar').classList.add('active');
            document.getElementById('overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('invoice-form').reset();
            document.getElementById('invoice_date').valueAsDate = new Date();
            document.getElementById('phone-error').style.display = 'none';
            document.querySelector('.btn-submit-invoice').disabled = false;
        }

        document.getElementById('overlay').addEventListener('click', closeSidebar);

        // Calculate change and debt amounts
        document.getElementById('price').addEventListener('input', calculateAmounts);
        document.getElementById('paid_amount').addEventListener('input', calculateAmounts);

        // Check phone number availability
        document.getElementById('customer_phone').addEventListener('blur', checkPhoneAvailability);

        function checkPhoneAvailability() {
            const phone = document.getElementById('customer_phone').value.trim();
            const customerId = document.getElementById('customer_id').value;
            const phoneErrorDiv = document.getElementById('phone-error');
            const submitBtn = document.querySelector('.btn-submit-invoice');

            if (!phone) {
                phoneErrorDiv.style.display = 'none';
                submitBtn.disabled = false;
                return;
            }

            // Check if phone exists
            const params = new URLSearchParams({
                phone: phone,
                customer_id: customerId || ''
            });

            fetch(`{{ route('customers.check-phone') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        phoneErrorDiv.textContent = data.message;
                        phoneErrorDiv.style.display = 'block';
                        submitBtn.disabled = true;
                    } else {
                        phoneErrorDiv.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Error checking phone:', err);
                    phoneErrorDiv.style.display = 'none';
                    submitBtn.disabled = false;
                });
        }

        function calculateAmounts() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
            const debtAmount = Math.max(0, price - paidAmount);
            const changeAmount = Math.max(0, paidAmount - price);

            document.getElementById('debt_amount').value = debtAmount.toFixed(2);
            document.getElementById('change_amount').value = changeAmount.toFixed(2);
        }

        // Select customer
        function selectCustomer() {
            const select = document.getElementById('customer_select');
            const option = select.options[select.selectedIndex];
            const customerId = option.value;

            if (customerId) {
                const customerName = option.text;
                const customerPhone = option.getAttribute('data-phone');

                document.getElementById('customer_id').value = customerId;
                document.getElementById('customer_name').value = customerName;
                document.getElementById('customer_phone').value = customerPhone;
            } else {
                document.getElementById('customer_id').value = '';
                document.getElementById('customer_name').value = '';
                document.getElementById('customer_phone').value = '';
            }

            // Clear phone error when selecting from dropdown
            document.getElementById('phone-error').style.display = 'none';
            document.querySelector('.btn-submit-invoice').disabled = false;
        }

        // Load invoices
        function loadInvoices() {
            const params = new URLSearchParams({
                customer_name: document.getElementById('filter_customer').value,
                from_date: document.getElementById('filter_from_date').value,
                to_date: document.getElementById('filter_to_date').value,
                status: document.getElementById('filter_status').value,
            });

            fetch(`{{ route('invoices.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.length === 0) {
                        html = '<tr><td colspan="6" class="empty-state"><div class="empty-state-icon">📭</div>Không có dữ liệu</td></tr>';
                    } else {
                        data.forEach((invoice, index) => {
                            const statusClass = invoice.status === 'paid' ? 'status-paid' : 'status-pending';
                            const statusText = invoice.status === 'paid' ? 'Đã xong' : 'Còn nợ';
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${invoice.customer_name}</td>
                                    <td>${invoice.product_name}</td>
                                    <td>${invoice.customer_phone}</td>
                                    <td><span class="${statusClass}">${statusText}</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-view" onclick="viewInvoice(${invoice.id})">
                                                <i class="bi bi-eye"></i> Xem
                                            </button>
                                            <button class="btn btn-sm btn-edit" onclick="editInvoice(${invoice.id})">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <button class="btn btn-sm btn-delete" onclick="deleteInvoice(${invoice.id})">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    document.getElementById('invoices-tbody').innerHTML = html;
                })
                .catch(err => {
                    console.error('Error loading invoices:', err);
                    document.getElementById('invoices-tbody').innerHTML = '<tr><td colspan="6" class="text-danger">Lỗi tải dữ liệu</td></tr>';
                });
        }

        // Create invoice
        document.getElementById('invoice-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(`{{ route('invoices.store') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Tạo hóa đơn thành công!');
                        closeSidebar();
                        loadInvoices();
                        showInvoiceModal(data.invoice);
                    } else {
                        alert('Có lỗi xảy ra');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Lỗi: ' + err.message);
                });
        });

        // View invoice
        function viewInvoice(id) {
            fetch(`{{ route('invoices.show', ':id') }}`.replace(':id', id))
                .then(res => res.json())
                .then(invoice => {
                    showInvoiceModal(invoice);
                })
                .catch(err => console.error('Error:', err));
        }

        function showInvoiceModal(invoice) {
            // Handle both flat and nested invoice objects
            const customerName = invoice.customer?.name || invoice.customer_name || '';
            const customerPhone = invoice.customer?.phone || invoice.customer_phone || '';
            const productName = invoice.details ? invoice.details.map(d => d.product_name).join(', ') : invoice.product_name || '';
            const invoiceDate = invoice.invoice_date || '';
            const totalAmount = parseFloat(invoice.total_amount || 0);
            const paidAmount = parseFloat(invoice.paid_amount || 0);
            const changeAmount = parseFloat(invoice.change_amount || 0);
            const debtAmount = parseFloat(invoice.debt_amount || 0);

            const detailsHtml = `
                <div class="invoice-info">
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Mã hóa đơn:</span>
                        <span class="invoice-info-value">#${invoice.id}</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Tên khách hàng:</span>
                        <span class="invoice-info-value">${customerName}</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Số điện thoại:</span>
                        <span class="invoice-info-value">${customerPhone}</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Ngày lập:</span>
                        <span class="invoice-info-value">${invoiceDate}</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Mặt hàng:</span>
                        <span class="invoice-info-value">${productName}</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Tổng tiền:</span>
                        <span class="invoice-info-value" style="color: #e74c3c; font-weight: bold;">${totalAmount.toLocaleString('vi-VN')} đ</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Khách đã trả:</span>
                        <span class="invoice-info-value">${paidAmount.toLocaleString('vi-VN')} đ</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Tiền trả khách:</span>
                        <span class="invoice-info-value">${changeAmount.toLocaleString('vi-VN')} đ</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Khách còn nợ:</span>
                        <span class="invoice-info-value" style="color: #f39c12; font-weight: bold;">${debtAmount.toLocaleString('vi-VN')} đ</span>
                    </div>
                    <div class="invoice-info-row">
                        <span class="invoice-info-label">Trạng thái:</span>
                        <span class="invoice-info-value">
                            ${invoice.status === 'paid'
                    ? '<span class="status-paid">Đã xong</span>'
                    : '<span class="status-pending">Còn nợ</span>'}
                        </span>
                    </div>
                </div>
            `;
            document.getElementById('invoice-details').innerHTML = detailsHtml;
            window.currentInvoice = invoice;
            document.getElementById('invoiceModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('invoiceModal').classList.remove('active');
        }

        // Edit invoice
        function editInvoice(id) {
            const newStatus = confirm('Đánh dấu hóa đơn đã xong?') ? 'paid' : 'pending';
            fetch(`{{ route('invoices.update', ':id') }}`.replace(':id', id), {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Cập nhật thành công');
                        loadInvoices();
                        closeModal();
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        // Delete invoice
        function deleteInvoice(id) {
            if (confirm('Bạn chắc chắn muốn xóa hóa đơn này?')) {
                fetch(`{{ route('invoices.destroy', ':id') }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Xóa thành công');
                            loadInvoices();
                            closeModal();
                        }
                    })
                    .catch(err => console.error('Error:', err));
            }
        }

        // Export PDF
        function exportPdf() {
            if (!window.currentInvoice) return;
            const invoice = window.currentInvoice;
            const element = document.getElementById('invoice-details');
            const opt = {
                margin: 10,
                filename: `hoa_don_${invoice.id}.pdf`,
                image: { type: 'png', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            html2pdf().set(opt).from(element).save();
        }

        // Print invoice
        function printInvoice() {
            if (!window.currentInvoice) return;
            const invoice = window.currentInvoice;
            const element = document.getElementById('invoice-details');
            const printWindow = window.open('', '', 'height=500,width=800');
            printWindow.document.write(element.innerHTML);
            printWindow.document.close();
            printWindow.print();
        }

        // Load invoices on page load
        loadInvoices();
    </script>
</body>

</html>