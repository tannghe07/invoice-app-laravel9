<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê Doanh Thu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .page-title i {
            margin-right: 10px;
            color: #667eea;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
        .stat-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .stat-icon {
            font-size: 32px;
            color: #667eea;
            opacity: 0.2;
            float: right;
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            align-items: flex-end;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 40px;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
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
            padding: 0 30px;
        }
        .btn-filter:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            color: white;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            height: 400px;
        }
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
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
            border: none;
        }
        .table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
        .filter-hidden {
            display: none;
        }
        .currency {
            color: #28a745;
            font-weight: 600;
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
                    <a href="{{ route('customers.index') }}" class="nav-link">
                        <i class="bi bi-people"></i> Quản lý khách hàng
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('revenue.dashboard') }}" class="nav-link active">
                        <i class="bi bi-bar-chart"></i> Thống kê doanh thu
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
            <h1 class="page-title">
                <i class="bi bi-bar-chart"></i> Thống kê Doanh Thu
            </h1>

            <!-- Summary Cards -->
            <div class="row" id="summary-cards">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                        <div class="stat-label">Tổng doanh thu</div>
                        <div class="stat-value currency" id="total-revenue">0 đ</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                        <div class="stat-label">Doanh thu hôm nay</div>
                        <div class="stat-value currency" id="today-revenue">0 đ</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
                        <div class="stat-label">Doanh thu tháng này</div>
                        <div class="stat-value currency" id="month-revenue">0 đ</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-file-earmark-check"></i></div>
                        <div class="stat-label">Tổng hóa đơn</div>
                        <div class="stat-value" id="total-invoices">0</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <h5 style="margin-bottom: 20px;">Tùy chọn xem báo cáo</h5>
                <div class="filter-row">
                    <div class="form-group">
                        <label for="filter-type">Loại báo cáo</label>
                        <select class="form-select" id="filter-type" onchange="handleTypeChange()">
                            <option value="day">Theo ngày</option>
                            <option value="date_range">Theo khoảng ngày</option>
                            <option value="week">Theo tuần</option>
                            <option value="month">Theo tháng</option>
                            <option value="customer">Theo khách hàng</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="form-group" id="date-filter">
                        <label for="filter-date">Chọn ngày</label>
                        <input type="date" class="form-control" id="filter-date">
                    </div>

                    <!-- Date Range Filter -->
                    <div class="form-group filter-hidden" id="start-date-filter">
                        <label for="filter-start-date">Từ ngày</label>
                        <input type="date" class="form-control" id="filter-start-date">
                    </div>
                    <div class="form-group filter-hidden" id="end-date-filter">
                        <label for="filter-end-date">Đến ngày</label>
                        <input type="date" class="form-control" id="filter-end-date">
                    </div>

                    <!-- Week Filter -->
                    <div class="form-group filter-hidden" id="week-filter">
                        <label for="filter-week">Chọn tuần</label>
                        <input type="number" class="form-control" id="filter-week" min="1" max="53" placeholder="1-53">
                    </div>

                    <!-- Month Filter -->
                    <div class="form-group filter-hidden" id="month-filter">
                        <label for="filter-month">Chọn tháng</label>
                        <input type="month" class="form-control" id="filter-month">
                    </div>

                    <!-- Customer Filter -->
                    <div class="form-group filter-hidden" id="customer-filter">
                        <label for="filter-customer">Chọn khách hàng</label>
                        <select class="form-select" id="filter-customer">
                            <option value="">-- Tất cả --</option>
                        </select>
                    </div>

                    <button class="btn btn-filter" onclick="loadRevenue()">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>

            <!-- Chart -->
            <div class="chart-container">
                <div class="chart-title">Biểu đồ doanh thu</div>
                <canvas id="revenueChart"></canvas>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">STT</th>
                            <th style="width: 30%">Mô tả</th>
                            <th style="width: 25%">Doanh thu</th>
                            <th style="width: 20%">Số hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody id="revenue-table">
                        <tr>
                            <td colspan="4" class="empty-state">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let revenueChart = null;

        // Load customers for filter
        function loadCustomers() {
            fetch('{{ route("invoices.data") }}')
                .then(res => res.json())
                .then(data => {
                    const customers = [...new Set(data.map(inv => ({
                        id: inv.customer_id,
                        name: inv.customer_name
                    })))];
                    
                    let html = '<option value="">-- Tất cả --</option>';
                    customers.forEach(customer => {
                        if (customer.id && customer.name) {
                            html += `<option value="${customer.id}">${customer.name}</option>`;
                        }
                    });
                    document.getElementById('filter-customer').innerHTML = html;
                })
                .catch(err => console.error('Error:', err));
        }

        // Handle type change
        function handleTypeChange() {
            const type = document.getElementById('filter-type').value;
            
            // Hide all filters
            document.getElementById('date-filter').classList.remove('filter-hidden');
            document.getElementById('start-date-filter').classList.add('filter-hidden');
            document.getElementById('end-date-filter').classList.add('filter-hidden');
            document.getElementById('week-filter').classList.add('filter-hidden');
            document.getElementById('month-filter').classList.add('filter-hidden');
            document.getElementById('customer-filter').classList.add('filter-hidden');

            // Show relevant filter
            switch(type) {
                case 'day':
                    document.getElementById('date-filter').classList.remove('filter-hidden');
                    break;
                case 'date_range':
                    document.getElementById('date-filter').classList.add('filter-hidden');
                    document.getElementById('start-date-filter').classList.remove('filter-hidden');
                    document.getElementById('end-date-filter').classList.remove('filter-hidden');
                    break;
                case 'week':
                    document.getElementById('date-filter').classList.add('filter-hidden');
                    document.getElementById('week-filter').classList.remove('filter-hidden');
                    break;
                case 'month':
                    document.getElementById('date-filter').classList.add('filter-hidden');
                    document.getElementById('month-filter').classList.remove('filter-hidden');
                    break;
                case 'customer':
                    document.getElementById('date-filter').classList.add('filter-hidden');
                    document.getElementById('customer-filter').classList.remove('filter-hidden');
                    break;
            }
        }

        // Load summary
        function loadSummary() {
            fetch('{{ route("revenue.summary") }}')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('total-revenue').textContent = formatCurrency(data.total_revenue);
                    document.getElementById('today-revenue').textContent = formatCurrency(data.today_revenue);
                    document.getElementById('month-revenue').textContent = formatCurrency(data.month_revenue);
                    document.getElementById('total-invoices').textContent = data.total_invoices;
                })
                .catch(err => console.error('Error:', err));
        }

        // Load revenue data
        function loadRevenue() {
            const type = document.getElementById('filter-type').value;
            let params = `type=${type}`;

            switch(type) {
                case 'day':
                    const date = document.getElementById('filter-date').value;
                    if (date) params += `&date=${date}`;
                    break;
                case 'date_range':
                    const startDate = document.getElementById('filter-start-date').value;
                    const endDate = document.getElementById('filter-end-date').value;
                    if (startDate && endDate) {
                        params += `&start_date=${startDate}&end_date=${endDate}`;
                    }
                    break;
                case 'week':
                    const week = document.getElementById('filter-week').value;
                    const year = new Date().getFullYear();
                    if (week) params += `&week=${week}&year=${year}`;
                    break;
                case 'month':
                    const month = document.getElementById('filter-month').value;
                    if (month) {
                        const [y, m] = month.split('-');
                        params += `&month=${m}&year=${y}`;
                    }
                    break;
                case 'customer':
                    const customerId = document.getElementById('filter-customer').value;
                    params += `&customer_id=${customerId}`;
                    break;
            }

            fetch(`{{ route("revenue.data") }}?${params}`)
                .then(res => res.json())
                .then(data => {
                    renderChart(data);
                    renderTable(data);
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Lỗi khi tải dữ liệu');
                });
        }

        // Render chart
        function renderChart(data) {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            let labels = [];
            let revenues = [];

            if (data.type === 'day' && data.invoices) {
                data.invoices.forEach(inv => {
                    labels.push(inv.customer_name);
                    revenues.push(inv.amount);
                });
            } else if (['date_range', 'week', 'month'].includes(data.type) && data.daily_data) {
                Object.entries(data.daily_data).forEach(([key, value]) => {
                    labels.push(key);
                    revenues.push(value.total);
                });
            } else if (data.type === 'customer' && data.customers) {
                if (Array.isArray(data.customers)) {
                    data.customers.forEach((cust, idx) => {
                        labels.push(cust.customer?.name || `Khách hàng ${idx + 1}`);
                        revenues.push(cust.total_revenue);
                    });
                }
            }

            if (revenueChart) {
                revenueChart.destroy();
            }

            revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu (đ)',
                        data: revenues,
                        backgroundColor: '#667eea',
                        borderColor: '#667eea',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatCurrencyShort(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Render table
        function renderTable(data) {
            let html = '';
            let index = 1;

            if (data.type === 'day' && data.invoices) {
                data.invoices.forEach(inv => {
                    html += `
                        <tr>
                            <td>${index++}</td>
                            <td>${inv.customer_name}</td>
                            <td class="currency">${formatCurrency(inv.amount)}</td>
                            <td>1</td>
                        </tr>
                    `;
                });
                if (!data.invoices.length) {
                    html = '<tr><td colspan="4" class="empty-state">Không có dữ liệu</td></tr>';
                }
            } else if (['date_range', 'week', 'month'].includes(data.type) && data.daily_data) {
                Object.entries(data.daily_data).forEach(([key, value]) => {
                    html += `
                        <tr>
                            <td>${index++}</td>
                            <td>${key}</td>
                            <td class="currency">${formatCurrency(value.total)}</td>
                            <td>${value.count}</td>
                        </tr>
                    `;
                });
            } else if (data.type === 'customer') {
                if (data.customers && Array.isArray(data.customers)) {
                    data.customers.forEach(cust => {
                        html += `
                            <tr>
                                <td>${index++}</td>
                                <td>${cust.customer?.name || 'N/A'}</td>
                                <td class="currency">${formatCurrency(cust.total_revenue)}</td>
                                <td>${cust.invoice_count || 0}</td>
                            </tr>
                        `;
                    });
                } else if (data.invoices) {
                    data.invoices.forEach(inv => {
                        html += `
                            <tr>
                                <td>${index++}</td>
                                <td>${data.customer?.name || 'N/A'}</td>
                                <td class="currency">${formatCurrency(inv.amount)}</td>
                                <td>1</td>
                            </tr>
                        `;
                    });
                }
            }

            document.getElementById('revenue-table').innerHTML = html || '<tr><td colspan="4" class="empty-state">Không có dữ liệu</td></tr>';
        }

        // Format currency
        function formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                maximumFractionDigits: 0
            }).format(value || 0);
        }

        // Format currency short
        function formatCurrencyShort(value) {
            if (value >= 1000000) {
                return (value / 1000000).toFixed(1) + 'M';
            } else if (value >= 1000) {
                return (value / 1000).toFixed(0) + 'K';
            }
            return value;
        }

        // Initialize
        document.getElementById('filter-date').valueAsDate = new Date();
        document.getElementById('filter-month').valueAsDate = new Date();
        
        loadSummary();
        loadCustomers();
        loadRevenue();
    </script>
</body>
</html>
