<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        .login-header p {
            color: #999;
        }
        .form-control {
            height: 45px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            height: 45px;
            border-radius: 5px;
            color: white;
            font-weight: 600;
            margin-top: 10px;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f94 100%);
            color: white;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .demo-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #2196F3;
        }
        .demo-info strong {
            display: block;
            margin-bottom: 5px;
            color: #0066cc;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🧾 Invoices App</h1>
            <p>Quản lý hóa đơn</p>
        </div>

        <div class="demo-info">
            <strong>Thông tin đăng nhập demo:</strong>
            Email: admin@example.com<br>
            Mật khẩu: password
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 login-btn">
                Đăng nhập
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
