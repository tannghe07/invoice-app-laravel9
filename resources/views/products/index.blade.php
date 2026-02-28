<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Kho Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Reusing styles from Transactions page for consistency */
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

        .navbar-logout {
            margin-left: auto;
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

        .summary-icon.qty {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .summary-icon.value {
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

        .btn-add {
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

        .btn-add:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
            color: white;
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

        .table-action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            border: none;
            margin-right: 5px;
            color: white;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #3b82f6;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: #ef4444;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-return {
            background: #f59e0b;
        }

        .btn-return:hover {
            background: #d97706;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .pagination {
            margin-top: 20px;
            justify-content: center;
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

        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            .navbar {
                margin-bottom: 20px;
                padding: 10px 0;
            }

            .nav-menu {
                flex-direction: column;
                align-items: stretch;
                margin: 15px 0;
                width: 100%;
                gap: 5px;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                display: block;
                padding: 12px 15px;
                border-radius: 8px;
            }

            .navbar-logout {
                margin: 10px 0 0 0;
                width: 100%;
                text-align: center;
            }

            .navbar-logout button {
                width: 100%;
                padding: 10px;
            }
        }

        @media (max-width: 767.98px) {
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .btn-add {
                width: 100%;
                padding: 12px;
            }

            .summary-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .summary-card {
                padding: 15px;
            }

            .summary-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .summary-info p {
                font-size: 20px;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .btn-filter {
                width: 100%;
                margin-top: 10px;
            }

            .table-container {
                padding: 15px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 13px;
            }

            .table-action-btn {
                width: 38px;
                height: 38px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-receipt"></i> Invoices App
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
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
                        <a href="{{ route('products.index') }}" class="nav-link active">
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
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-box-seam"></i> Quản lý Kho Hàng
            </h1>
            <button class="btn-add" onclick="openCreateModal()">
                <i class="bi bi-plus-circle"></i> Nhập hàng mới
            </button>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-icon qty">
                    <i class="bi bi-layers"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Số Lượng Tồn</h3>
                    <p id="total-qty">0</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon value">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Giá Trị Tồn Kho</h3>
                    <p id="total-value">0 đ</p>
                </div>
            </div>
        </div>
        <!-- Filters -->
        <div class="filters">
            <h5 class="mb-3">Bộ lọc</h5>
            <div class="filter-row">
                <div class="form-group">
                    <label for="filter_code">Mã sản phẩm</label>
                    <input type="text" class="form-control" id="filter_code" placeholder="Nhập mã SP...">
                </div>
                <div class="form-group">
                    <label for="filter_name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="filter_name" placeholder="Nhập tên SP...">
                </div>
                <button class="btn btn-filter" onclick="loadProducts()">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </div>

        <div class="table-container">
            <h5 class="mb-3">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Ngày nhập</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="products-tbody">
                        <tr>
                            <td colspan="6" class="text-center">Đang tải...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="pagination-container"></div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nhập Hàng Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="product-form">
                        <input type="hidden" id="product_id" name="product_id">
                        <div class="mb-3">
                            <label class="form-label">Mã sản phẩm *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="code" name="code" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="generateCode()">
                                    <i class="bi bi-arrow-repeat"></i> Auto
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số lượng *</label>
                                <input type="text" class="form-control" id="quantity" name="quantity" min="1" value="1"
                                    required oninput="formatNumberInput(this); calcTotal()">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Đơn giá (VNĐ) *</label>
                                <input type="text" class="form-control" id="price" name="price" min="0" required
                                    oninput="formatNumberInput(this); calcTotal()">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày nhập *</label>
                            <input type="date" class="form-control" id="import_date" name="import_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tổng giá trị: <span id="calc-total" class="text-primary">0
                                    đ</span></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="btn-save">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark">Trả Hàng (NCC)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="return-form">
                        <input type="hidden" id="return_product_id">
                        <div class="mb-3">
                            <label class="form-label">Sản phẩm</label>
                            <input type="text" class="form-control" id="return_product_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số lượng hiện có</label>
                            <input type="text" class="form-control" id="return_current_qty" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số lượng trả *</label>
                            <input type="text" class="form-control" id="return_quantity" required min="1"
                                oninput="formatNumberInput(this)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày trả *</label>
                            <input type="date" class="form-control" id="return_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Loại trả hàng</label>
                            <select class="form-select" disabled>
                                <option selected>Trả cho nhà cung cấp</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Xác nhận trả hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Utils
        const formatCurrency = (amount) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        const formatDate = (dateStr) => {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('vi-VN');
        }

        // Format number input
        function formatNumberInput(input) {
            let value = input.value.replace(/\D/g, '');
            if (value === '') {
                input.value = '';
                return;
            }
            input.value = new Intl.NumberFormat('vi-VN').format(value);
        }

        // Clean number for submission/calculation
        function cleanNumber(value) {
            if (!value) return 0;
            return parseInt(value.toString().replace(/\./g, '')) || 0;
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            loadProducts();
            document.getElementById('import_date').valueAsDate = new Date();
            document.getElementById('return_date').valueAsDate = new Date();
        });

        // Load Products
        function loadProducts(page = 1) {
            const params = new URLSearchParams({
                page: page,
                code: document.getElementById('filter_code').value,
                name: document.getElementById('filter_name').value,
            });

            fetch(`{{ route('products.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    // Update Summary
                    document.getElementById('total-qty').textContent = data.totalQuantity;
                    document.getElementById('total-value').textContent = formatCurrency(data.totalValue);

                    // Update Table
                    const tbody = document.getElementById('products-tbody');
                    if (data.products.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" class="empty-state"><div class="empty-state-icon">📭</div>Chưa có dữ liệu</td></tr>`;
                    } else {
                        tbody.innerHTML = data.products.data.map(p => `
                            <tr>
                                <td><span class="badge bg-secondary">${p.code}</span></td>
                                <td class="fw-bold">${p.name}</td>
                                <td>${p.quantity}</td>
                                <td>${formatCurrency(p.price)}</td>
                                <td>${formatDate(p.import_date)}</td>
                                <td class="text-center">
                                    <button class="table-action-btn btn-edit" title="Sửa" onclick='openEditModal(${JSON.stringify(p)})'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="table-action-btn btn-return" title="Trả hàng" onclick='openReturnModal(${JSON.stringify(p)})'>
                                        <i class="bi bi-arrow-return-left"></i>
                                    </button>
                                    <button class="table-action-btn btn-delete" title="Xóa" onclick="deleteProduct(${p.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('');
                        updatePagination(data.products);
                    }
                });
        }

        function updatePagination(data) {
            let html = '<nav><ul class="pagination">';
            if (data.prev_page_url) html += `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts(${data.current_page - 1}); return false;">Trước</a></li>`;
            for (let i = 1; i <= data.last_page; i++) {
                html += `<li class="page-item ${i === data.current_page ? 'active' : ''}"><a class="page-link" href="#" onclick="loadProducts(${i}); return false;">${i}</a></li>`;
            }
            if (data.next_page_url) html += `<li class="page-item"><a class="page-link" href="#" onclick="loadProducts(${data.current_page + 1}); return false;">Sau</a></li>`;
            html += '</ul></nav>';
            document.getElementById('pagination-container').innerHTML = html;
        }

        // Generate Code
        function generateCode() {
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            const date = new Date().toISOString().slice(2, 10).replace(/-/g, '');
            document.getElementById('code').value = `SP${date}${random}`;
        }

        // Calc Total Price in Form
        function calcTotal() {
            const qty = cleanNumber(document.getElementById('quantity').value);
            const price = cleanNumber(document.getElementById('price').value);
            document.getElementById('calc-total').textContent = formatCurrency(qty * price);
        }

        // Modals
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        const returnModal = new bootstrap.Modal(document.getElementById('returnModal'));

        function openCreateModal() {
            document.getElementById('product-form').reset();
            document.getElementById('product_id').value = '';
            document.getElementById('modalTitle').textContent = 'Nhập Hàng Mới';
            document.getElementById('import_date').valueAsDate = new Date();
            generateCode();
            calcTotal();
            productModal.show();
        }

        function openEditModal(product) {
            document.getElementById('product_id').value = product.id;
            document.getElementById('code').value = product.code;
            document.getElementById('name').value = product.name;

            // Format existing value (round price/qty to avoid decimal issues in UI)
            const qtyInput = document.getElementById('quantity');
            qtyInput.value = Math.round(product.quantity);
            formatNumberInput(qtyInput);

            const priceInput = document.getElementById('price');
            priceInput.value = Math.round(product.price);
            formatNumberInput(priceInput);

            document.getElementById('import_date').value = product.import_date;
            document.getElementById('modalTitle').textContent = 'Cập Nhật Sản Phẩm';
            calcTotal();
            productModal.show();
        }

        // Form Submit (Create/Update)
        document.getElementById('product-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('product_id').value;
            const url = id ? `{{ url('/products') }}/${id}` : `{{ route('products.store') }}`;
            const method = id ? 'PUT' : 'POST';

            const formData = new FormData(this);
            // Clean numbers
            formData.set('quantity', cleanNumber(formData.get('quantity')));
            formData.set('price', cleanNumber(formData.get('price')));

            const data = Object.fromEntries(formData.entries());

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
                        productModal.hide();
                        loadProducts();
                        alert(data.message);
                    } else {
                        alert('Lỗi: ' + JSON.stringify(data.errors || data.message));
                    }
                })
                .catch(err => console.error(err));
        });

        // Return Logic
        function openReturnModal(product) {
            document.getElementById('return_product_id').value = product.id;
            document.getElementById('return_product_name').value = product.name;
            document.getElementById('return_current_qty').value = Math.round(product.quantity);

            const returnQtyInput = document.getElementById('return_quantity');
            returnQtyInput.value = '';

            document.getElementById('return_date').valueAsDate = new Date();
            returnModal.show();
        }

        document.getElementById('return-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('return_product_id').value;
            const qty = cleanNumber(document.getElementById('return_quantity').value);

            fetch(`{{ url('/products') }}/${id}/return`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    quantity: qty,
                    return_date: document.getElementById('return_date').value
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        returnModal.hide();
                        loadProducts();
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                });
        });

        // Delete Logic
        function deleteProduct(id) {
            if (!confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) return;
            fetch(`{{ url('/products') }}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadProducts();
                        alert(data.message);
                    }
                });
        }
    </script>
</body>

</html>