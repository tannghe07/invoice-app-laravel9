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

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
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
    </style>
</head>

<body>
    <!-- Navbar -->
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
                    <a href="{{ route('customers.index') }}" class="nav-link active">
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

    <div class="container-fluid">
        <div class="px-4">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-people"></i> Quản lý Khách Hàng
                </h1>
                <button class="btn-add" onclick="openAddModal()">
                    <i class="bi bi-plus-circle"></i> Thêm khách hàng
                </button>
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
                    <label for="customerPhone" class="required">Số điện thoại</label>
                    <input type="tel" id="customerPhone" name="phone" required placeholder="Nhập số điện thoại">
                    <div id="phoneError"
                        style="color: #dc3545; font-size: 12px; margin-top: 3px; display: none; line-height: 1.2;">
                    </div>
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

        // Check phone number availability
        function checkPhoneAvailability() {
            const phone = document.getElementById('customerPhone').value.trim();
            const customerId = document.getElementById('customerId').value;
            const phoneErrorDiv = document.getElementById('phoneError');
            const submitBtn = document.querySelector('.btn-save');

            if (!phone) {
                phoneErrorDiv.style.display = 'none';
                submitBtn.disabled = false;
                return;
            }

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

        // Add event listener for phone input
        document.getElementById('customerPhone').addEventListener('blur', checkPhoneAvailability);

        // Open add modal
        function openAddModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Thêm khách hàng';
            document.getElementById('customerId').value = '';
            document.getElementById('customerForm').reset();
            document.getElementById('phoneError').style.display = 'none';
            document.querySelector('.btn-save').disabled = false;
            document.getElementById('customerModal').classList.add('active');
        }

        // Close modal
        function closeModal() {
            document.getElementById('customerModal').classList.remove('active');
            document.getElementById('phoneError').style.display = 'none';
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
            const params = new URLSearchParams({ name, phone });

            fetch(`{{ route('customers.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.length === 0) {
                        html = '<tr><td colspan="6" class="empty-state"><div style="font-size: 40px; margin-bottom: 10px;">👥</div>Không có dữ liệu</td></tr>';
                    } else {
                        data.forEach((customer, index) => {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${customer.name}</td>
                                    <td>${customer.phone}</td>
                                    <td>${customer.address || '-'}</td>
                                    <td>${customer.invoices_count}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-edit" onclick="editCustomer(${customer.id})">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <button class="btn btn-sm btn-delete" onclick="deleteCustomer(${customer.id})">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
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
            fetch(`{{ route('customers.show', ':id') }}`.replace(':id', id))
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
            if (confirm('Bạn chắc chắn muốn xóa khách hàng này?')) {
                fetch(`{{ route('customers.destroy', ':id') }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Xóa thành công');
                            loadCustomers();
                        } else {
                            alert('Lỗi: ' + (data.message || 'Không thể xóa'));
                        }
                    })
                    .catch(err => console.error('Error:', err));
            }
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