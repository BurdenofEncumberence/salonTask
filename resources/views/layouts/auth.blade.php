<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black: #0a0a0a;
            --gray-700: #333333;
            --gray-500: #666666;
            --gray-300: #cccccc;
            --gray-100: #f0f0f0;
            --gray-50: #f8f8f8;
            --white: #ffffff;
            --border: #e0e0e0;
            --danger: #a01a1a;
            --danger-bg: #f5e8e8;
        }

        body {
            font-family: 'Geist', system-ui, sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--black);
        }

        .auth-card {
            width: 100%;
            max-width: 380px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 40px;
        }

        .auth-heading {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--black);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .auth-subheading {
            font-size: 0.82rem;
            color: var(--gray-500);
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-family: 'Geist', sans-serif;
            font-size: 0.85rem;
            color: var(--black);
            background: var(--white);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--black);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.06);
        }

        .form-error {
            font-size: 0.75rem;
            color: var(--danger);
            margin-top: 4px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            color: var(--gray-500);
        }
        .remember-row input[type="checkbox"] {
            accent-color: var(--black);
            width: 14px; height: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background: var(--black);
            color: var(--white);
            border: none;
            border-radius: 7px;
            font-family: 'Geist', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.15s;
            letter-spacing: -0.01em;
        }
        .btn-login:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="auth-card">
        @yield('content')
    </div>
</body>
</html>