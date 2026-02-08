<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Thu Chi</title>
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

        .summary-icon.income {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .summary-icon.expense {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }

        .summary-icon.balance {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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

        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 400px;
            margin: 30px auto 30px auto;
        }

        .chart-container h5 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
            text-align: center;
        }

        .chart-container canvas {
            max-height: 300px;
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 0;
        }

        .table {
            margin-bottom: 0;
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

        .badge-income {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-expense {
            background: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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

        .btn-add-transaction {
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

        .btn-add-transaction:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-add-transaction i {
            margin-right: 8px;
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
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

        @media (max-width: 768px) {
            .chart-container {
                max-width: 100%;
            }
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
                    <a href="{{ route('transactions.index') }}" class="nav-link active">
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
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-wallet2"></i> Quản lý Thu Chi
            </h1>
            <button class="btn-add-transaction" onclick="openCreateModal()">
                <i class="bi bi-plus-circle"></i> Tạo giao dịch mới
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-icon income">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Thu</h3>
                    <p id="total-income">0 đ</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon expense">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div class="summary-info">
                    <h3>Tổng Chi</h3>
                    <p id="total-expense">0 đ</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon balance">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="summary-info">
                    <h3>Số Dư</h3>
                    <p id="balance">0 đ</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <h5 class="mb-3">Bộ lọc</h5>
            <div class="filter-row">
                <div class="form-group">
                    <label for="filter_period">Thời gian</label>
                    <select class="form-select" id="filter_period">
                        <option value="all" selected>Tất cả</option>
                        <option value="day">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_from">Từ ngày</label>
                    <input type="date" class="form-control" id="filter_from">
                </div>
                <div class="form-group">
                    <label for="filter_to">Đến ngày</label>
                    <input type="date" class="form-control" id="filter_to">
                </div>
                <div class="form-group">
                    <label for="filter_type">Loại giao dịch</label>
                    <select class="form-select" id="filter_type">
                        <option value="all">Tất cả</option>
                        <option value="income">Thu</option>
                        <option value="expense">Chi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter_content">Nội dung</label>
                    <input type="text" class="form-control" id="filter_content" placeholder="Tìm kiếm nội dung...">
                </div>
                <button class="btn btn-filter" onclick="loadTransactions()">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <h5 class="mb-3">Danh sách giao dịch</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%">STT</th>
                            <th style="width: 15%">Ngày</th>
                            <th style="width: 30%">Nội dung</th>
                            <th style="width: 15%">Số tiền</th>
                            <th style="width: 15%">Loại</th>
                            <th style="width: 20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-tbody">
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Đang tải...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="pagination-container"></div>
        </div>

        <!-- Chart Container -->
        <div class="chart-container">
            <h5>Biểu đồ Thu Chi</h5>
            <canvas id="transactionChart"></canvas>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">
                        <i class="bi bi-plus-circle"></i> Tạo Giao Dịch
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="transaction-form">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Số tiền *</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Nhập số tiền"
                                required oninput="formatNumberInput(this)">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Nội dung giao dịch *</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Nhập nội dung" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Ngày tạo *</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Loại giao dịch *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Chọn loại --</option>
                                <option value="income">Thu</option>
                                <option value="expense">Chi</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="btn-save-transaction">
                                <i class="bi bi-check-circle"></i> Tạo Giao Dịch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Format number input
        function formatNumberInput(input) {
            let value = input.value.toString().replace(/\D/g, '');
            if (value === '') {
                input.value = '';
                return;
            }
            input.value = new Intl.NumberFormat('vi-VN').format(parseInt(value));
        }

        // Clean number for submission
        function cleanNumber(value) {
            if (!value) return 0;
            return value.toString().replace(/\./g, '');
        }

        // Set today's date as default
        document.getElementById('transaction_date').valueAsDate = new Date();

        let chart = null;
        let currentPage = 1;

        // Clear custom dates when selecting period
        document.getElementById('filter_period').addEventListener('change', function () {
            if (this.value !== 'all') {
                document.getElementById('filter_from').value = '';
                document.getElementById('filter_to').value = '';
            }
            loadTransactions();
        });

        // Reset period when entering custom dates
        document.getElementById('filter_from').addEventListener('change', function () {
            if (this.value) {
                document.getElementById('filter_period').value = 'all';
            }
            loadTransactions();
        });

        document.getElementById('filter_to').addEventListener('change', function () {
            if (this.value) {
                document.getElementById('filter_period').value = 'all';
            }
            loadTransactions();
        });

        // Other filter listeners
        document.getElementById('filter_type').addEventListener('change', loadTransactions);
        document.getElementById('filter_content').addEventListener('input', debounce(loadTransactions, 500));

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        // Load transactions
        function loadTransactions(page = 1) {
            const params = new URLSearchParams({
                filter: document.getElementById('filter_period').value,
                from_date: document.getElementById('filter_from').value,
                to_date: document.getElementById('filter_to').value,
                type: document.getElementById('filter_type').value,
                description: document.getElementById('filter_content').value,
                page: page
            });

            fetch(`{{ route('transactions.data') }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    // Update summary
                    document.getElementById('total-income').textContent = formatCurrency(data.totalIncome);
                    document.getElementById('total-expense').textContent = formatCurrency(data.totalExpense);
                    document.getElementById('balance').textContent = formatCurrency(data.totalIncome - data.totalExpense);

                    // Update chart
                    updateChart(data.totalIncome, data.totalExpense);

                    // Update table
                    let html = '';
                    if (data.transactions.data.length === 0) {
                        html = '<tr><td colspan="6" class="empty-state"><div class="empty-state-icon">📭</div>Không có dữ liệu</td></tr>';
                    } else {
                        data.transactions.data.forEach((transaction, index) => {
                            const typeClass = transaction.type === 'income' ? 'badge-income' : 'badge-expense';
                            const typeText = transaction.type === 'income' ? 'Thu' : 'Chi';
                            const typeIcon = transaction.type === 'income' ? 'arrow-down-circle' : 'arrow-up-circle';
                            const rowNum = (data.transactions.current_page - 1) * 10 + index + 1;

                            html += `
                                <tr>
                                    <td>${rowNum}</td>
                                    <td>${formatDate(transaction.transaction_date)}</td>
                                    <td style="text-align: left">${transaction.description}</td>
                                    <td>${formatCurrency(transaction.amount)}</td>
                                    <td>
                                        <span class="${typeClass}">
                                            <i class="bi bi-${typeIcon}"></i> ${typeText}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm text-white" onclick="openEditModal(${transaction.id})">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>
                                        <button class="btn btn-delete btn-sm" onclick="deleteTransaction(${transaction.id})">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    document.getElementById('transactions-tbody').innerHTML = html;

                    // Update pagination
                    updatePagination(data.transactions);
                })
                .catch(err => {
                    console.error('Error loading transactions:', err);
                    document.getElementById('transactions-tbody').innerHTML =
                        '<tr><td colspan="6" class="text-danger">Lỗi tải dữ liệu</td></tr>';
                });
        }

        // Update chart
        function updateChart(income, expense) {
            const ctx = document.getElementById('transactionChart').getContext('2d');

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Thu', 'Chi'],
                    datasets: [{
                        data: [income, expense],
                        backgroundColor: [
                            'rgba(76, 175, 80, 0.8)',
                            'rgba(244, 67, 54, 0.8)'
                        ],
                        borderColor: [
                            'rgba(76, 175, 80, 1)',
                            'rgba(244, 67, 54, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.label + ': ' + formatCurrency(context.parsed);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update pagination
        function updatePagination(paginationData) {
            let html = '<nav><ul class="pagination">';

            // Previous button
            if (paginationData.current_page > 1) {
                html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTransactions(${paginationData.current_page - 1}); return false;">Trước</a></li>`;
            }

            // Page numbers
            for (let i = 1; i <= paginationData.last_page; i++) {
                const active = i === paginationData.current_page ? 'active' : '';
                html += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="loadTransactions(${i}); return false;">${i}</a></li>`;
            }

            // Next button
            if (paginationData.current_page < paginationData.last_page) {
                html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTransactions(${paginationData.current_page + 1}); return false;">Sau</a></li>`;
            }

            html += '</ul></nav>';
            document.getElementById('pagination-container').innerHTML = html;
        }

        // Create/Update transaction
        let editingTransactionId = null;
        const transactionModal = new bootstrap.Modal(document.getElementById('transactionModal'));

        function openCreateModal() {
            editingTransactionId = null;
            document.getElementById('transactionModalLabel').innerHTML = '<i class="bi bi-plus-circle"></i> Tạo Giao Dịch';
            document.getElementById('btn-save-transaction').innerHTML = '<i class="bi bi-check-circle"></i> Tạo Giao Dịch';
            document.getElementById('transaction-form').reset();
            document.getElementById('transaction_date').valueAsDate = new Date();
            transactionModal.show();
        }

        function openEditModal(id) {
            editingTransactionId = id;
            document.getElementById('transactionModalLabel').innerHTML = '<i class="bi bi-pencil"></i> Sửa Giao Dịch';
            document.getElementById('btn-save-transaction').innerHTML = '<i class="bi bi-check-circle"></i> Cập Nhật';

            fetch(`{{ url('/transactions') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    const amountInput = document.getElementById('amount');
                    amountInput.value = Math.floor(parseFloat(data.amount) || 0);
                    formatNumberInput(amountInput);

                    document.getElementById('description').value = data.description;
                    document.getElementById('transaction_date').value = data.transaction_date.substring(0, 10);
                    document.getElementById('type').value = data.type;
                    transactionModal.show();
                })
                .catch(err => {
                    console.error('Error loading transaction details:', err);
                    alert('Không thể tải thông tin giao dịch');
                });
        }

        document.getElementById('transaction-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            // Clean amount
            formData.set('amount', cleanNumber(formData.get('amount')));

            const data = Object.fromEntries(formData.entries());

            const url = editingTransactionId
                ? `{{ url('/transactions') }}/${editingTransactionId}`
                : '{{ route("transactions.store") }}';

            const method = editingTransactionId ? 'PUT' : 'POST';

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
                        // Close modal
                        transactionModal.hide();

                        // Reload transactions
                        loadTransactions(currentPage);

                        // Show success message
                        alert(data.message);
                    } else {
                        alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
                    }
                })
                .catch(err => {
                    console.error('Error saving transaction:', err);
                    alert('Có lỗi xảy ra khi lưu giao dịch');
                });
        });

        // Delete transaction
        function deleteTransaction(id) {
            if (!confirm('Bạn có chắc chắn muốn xóa giao dịch này?')) {
                return;
            }

            fetch(`{{ url('/transactions') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadTransactions();
                        alert(data.message);
                    } else {
                        alert(data.message || 'Có lỗi xảy ra');
                    }
                })
                .catch(err => {
                    console.error('Error deleting transaction:', err);
                    alert('Có lỗi xảy ra khi xóa giao dịch');
                });
        }

        // Load transactions on page load
        loadTransactions();
    </script>
</body>

</html>