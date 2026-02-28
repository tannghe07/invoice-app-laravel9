<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khách Hàng</title>
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
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
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

        .btn-delete:hover {
            background: #c82333;
            color: white;
        }

        .btn-restore {
            background: #198754;
            border: none;
            color: white;
        }

        .btn-restore:hover {
            background: #157347;
            color: white;
        }

        .btn-trash-toggle {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-trash-toggle.active {
            background: #dc3545;
        }

        .trash-header {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .btn-close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .form-group-modal {
            margin-bottom: 15px;
        }

        .form-group-modal label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group-modal input,
        .form-group-modal textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group-modal input:focus,
        .form-group-modal textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-save {
            background: #4CAF50;
            color: white;
        }

        .btn-save:hover {
            background: #45a049;
        }

        .btn-cancel {
            background: #ccc;
            color: #333;
        }

        .btn-cancel:hover {
            background: #bbb;
        }

        .required::after {
            content: " *";
            color: #dc3545;
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

            .page-header .d-flex {
                width: 100%;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .page-header .btn-trash-toggle,
            .page-header .btn-add {
                width: 100%;
                padding: 10px 5px;
                font-size: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
                margin: 0;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .btn-filter {
                width: 100%;
                margin-top: 10px;
            }

            .table-responsive {
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 13px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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
                        <a href="{{ route('customers.index') }}" class="nav-link active">
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
        </div>
    </nav>

    <div class="container-fluid">
        <div class="px-4">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-people" id="page-icon"></i> <span id="page-title-text">Quản lý Khách Hàng</span>
                </h1>
                <div class="d-flex gap-2">
                    <button class="btn-trash-toggle" id="btn-trash-toggle" onclick="toggleTrash()">
                        <i class="bi bi-trash"></i> Thùng rác
                    </button>
                    <button class="btn-add" id="btn-add-main" onclick="openAddModal()">
                        <i class="bi bi-plus-circle"></i> Thêm khách hàng
                    </button>
                </div>
            </div>

            <!-- Trash Header Info -->
            <div class="trash-header" id="trash-info">
                <div>
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Đang xem Thùng rác.</strong> Các khách hàng ở đây đã được xóa tạm thời.
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <h5 style="margin-bottom: 20px;">Tìm kiếm</h5>
                <div class="filter-row">
                    <div class="form-group">
                        <label for="filter-name">Tên khách hàng</label>
                        <input type="text" class="form-control" id="filter-name" placeholder="Nhập tên">
                    </div>
                    <div class="form-group">
                        <label for="filter-phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="filter-phone" placeholder="Nhập số điện thoại">
                    </div>
                    <button class="btn btn-filter" onclick="loadCustomers()">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%">STT</th>
                            <th style="width: 20%">Tên khách hàng</th>
                            <th style="width: 15%">Số điện thoại</th>
                            <th style="width: 30%">Địa chỉ</th>
                            <th style="width: 10%">Số hóa đơn</th>
                            <th style="width: 20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="customers-table">
                        <tr>
                            <td colspan="6" class="empty-state">
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

    <!-- Modal Add/Edit Customer -->
    <div class="modal-overlay" id="customerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm khách hàng</h3>
                <button class="btn-close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="customerForm">
                @csrf
                <input type="hidden" id="customerId">

                <div class="form-group-modal">
                    <label for="customerName" class="required">Tên khách hàng</label>
                    <input type="text" id="customerName" name="name" required placeholder="Nhập tên khách hàng">
                </div>

                <div class="form-group-modal">
                    <label for="customerPhone">Số điện thoại</label>
                    <input type="tel" id="customerPhone" name="phone" placeholder="Nhập số điện thoại (tùy chọn)">
                </div>

                <div class="form-group-modal">
                    <label for="customerAddress">Địa chỉ</label>
                    <textarea id="customerAddress" name="address" rows="3"
                        placeholder="Nhập địa chỉ (tùy chọn)"></textarea>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-modal btn-cancel" onclick="closeModal()">Hủy</button>
                    <button type="submit" class="btn-modal btn-save">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let isEditMode = false;
        let showTrashed = false;

        // Open add modal
        function openAddModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Thêm khách hàng';
            document.getElementById('customerId').value = '';
            document.getElementById('customerForm').reset();
            document.querySelector('.btn-save').disabled = false;
            document.getElementById('customerModal').classList.add('active');
        }

        // Close modal
        function closeModal() {
            document.getElementById('customerModal').classList.remove('active');
            document.querySelector('.btn-save').disabled = false;
        }

        // Close modal when clicking outside
        document.getElementById('customerModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Load customers
        function loadCustomers() {
            const name = document.getElementById('filter-name').value;
            const phone = document.getElementById('filter-phone').value;
            const params = new URLSearchParams({
                name,
                phone,
                show_trashed: showTrashed
            });

            fetch(`{{ route('customers.data') }}?${params}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.length === 0) {
                        html = `<tr><td colspan="6" class="empty-state"><div style="font-size: 40px; margin-bottom: 10px;">${showTrashed ? '🗑️' : '👥'}</div>Không có dữ liệu ${showTrashed ? 'trong thùng rác' : ''}</td></tr>`;
                    } else {
                        data.forEach((customer, index) => {
                            let actions = '';
                            if (customer.is_trashed) {
                                actions = `
                                    <button class="btn btn-sm btn-restore" title="Khôi phục" onclick="restoreCustomer(${customer.id})">
                                        <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                                    </button>
                                `;
                            } else {
                                actions = `
                                    <button class="btn btn-sm btn-edit" title="Sửa" onclick="editCustomer(${customer.id})">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </button>
                                    <button class="btn btn-sm btn-delete" title="Xóa" onclick="deleteCustomer(${customer.id})">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                `;
                            }

                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td class="${customer.is_trashed ? 'text-decoration-line-through text-muted' : ''}">${customer.name}</td>
                                    <td>${customer.phone || '-'}</td>
                                    <td>${customer.address || '-'}</td>
                                    <td>${customer.invoices_count}</td>
                                    <td>
                                        <div class="action-buttons">
                                            ${actions}
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    document.getElementById('customers-table').innerHTML = html;
                })
                .catch(err => {
                    console.error('Error:', err);
                    document.getElementById('customers-table').innerHTML = '<tr><td colspan="6" class="text-danger text-center">Lỗi tải dữ liệu</td></tr>';
                });
        }

        // Edit customer
        function editCustomer(id) {
            fetch(`{{ route('customers.show', ':id') }}`.replace(':id', id), {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(customer => {
                    isEditMode = true;
                    document.getElementById('modalTitle').textContent = 'Chỉnh sửa khách hàng';
                    document.getElementById('customerId').value = customer.id;
                    document.getElementById('customerName').value = customer.name;
                    document.getElementById('customerPhone').value = customer.phone;
                    document.getElementById('customerAddress').value = customer.address || '';
                    document.getElementById('customerModal').classList.add('active');
                })
                .catch(err => console.error('Error:', err));
        }

        // Delete customer
        function deleteCustomer(id) {
            if (confirm('Bạn chắc chắn muốn đưa khách hàng này vào thùng rác?')) {
                fetch(`{{ url('/customers') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            loadCustomers();
                        } else {
                            alert('Lỗi: ' + (data.message || 'Không thể xóa'));
                        }
                    })
                    .catch(err => console.error('Error:', err));
            }
        }

        function restoreCustomer(id) {
            fetch(`{{ url('/customers') }}/${id}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadCustomers();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                });
        }

        function toggleTrash() {
            showTrashed = !showTrashed;
            const btn = document.getElementById('btn-trash-toggle');
            const trashInfo = document.getElementById('trash-info');
            const pageIcon = document.getElementById('page-icon');
            const pageTitleText = document.getElementById('page-title-text');
            const btnAdd = document.getElementById('btn-add-main');

            if (showTrashed) {
                btn.innerHTML = '<i class="bi bi-arrow-left"></i> Quay lại';
                btn.classList.add('active');
                trashInfo.style.display = 'flex';
                pageIcon.className = 'bi bi-trash text-danger';
                pageTitleText.textContent = 'Thùng rác Khách Hàng';
                btnAdd.style.display = 'none';
            } else {
                btn.innerHTML = '<i class="bi bi-trash"></i> Thùng rác';
                btn.classList.remove('active');
                trashInfo.style.display = 'none';
                pageIcon.className = 'bi bi-people text-primary';
                pageTitleText.textContent = 'Quản lý Khách Hàng';
                btnAdd.style.display = 'block';
            }
            loadCustomers();
        }

        // Submit form
        document.getElementById('customerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const customerId = document.getElementById('customerId').value;
            const formData = new FormData(this);

            const url = isEditMode && customerId
                ? `{{ route('customers.update', ':id') }}`.replace(':id', customerId)
                : '{{ route("customers.store") }}';

            const method = isEditMode && customerId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(isEditMode ? 'Cập nhật thành công' : 'Thêm khách hàng thành công');
                        closeModal();
                        loadCustomers();
                    } else {
                        alert('Lỗi: ' + (data.message || 'Có lỗi xảy ra'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Lỗi: ' + err.message);
                });
        });

        // Load customers on page load
        loadCustomers();
    </script>
</body>

</html>