<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arsip Desa Galang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Menempatkan form di tengah layar secara vertikal & horizontal */
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px; /* Membatasi lebar agar tidak full selayar */
            padding: 15px;
        }

        .login-card {
            border-radius: 20px; /* Sudut kartu lebih halus */
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .brand-logo {
            font-size: 3rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            border-color: #4f46e5;
        }

        .input-group-text {
            border: 1px solid #e0e0e0;
            color: #9ca3af;
        }

        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            z-index: 10;
        }

        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background-color: #4f46e5;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="brand-logo">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h4 class="fw-bold">Selamat Datang</h4>
                <p class="text-muted small">Silakan login ke sistem arsip</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger small py-2 border-0 shadow-sm">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Nama Pengguna</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="nama_pengguna" class="form-control border-start-0" 
                               placeholder="Username" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Kata Sandi</label>
                    <div class="password-group">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="kata_sandi" id="passwordInput" 
                                   class="form-control border-start-0 pass-input" 
                                   placeholder="•••••" required style="border-radius: 0 10px 10px 0;">
                        </div>
                        <i class="fas fa-eye password-toggle" id="toggleIcon"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 shadow-sm mb-4">
                    Masuk <i class="fas fa-sign-in-alt ms-1"></i>
                </button>
            </form>

            <div class="text-center mt-2">
                <p class="small text-muted mb-0">&copy; {{ date('Y') }} Desa Galang</p>
            </div>
        </div>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script