<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Sistem Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Background Off-White Elegan */
        body {
            background-color: #f4f7f9; 
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Card Minimalis dengan Bayangan Super Halus */
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 45px 40px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid rgba(0, 0, 0, 0.03);
            margin: 20px;
        }

        /* Tipografi Elegan */
        .login-title {
            font-weight: 700;
            color: #2b3440; /* Warna teks gelap yang lebih soft dari hitam pekat */
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }
        .login-subtitle {
            color: #8392a5;
            font-size: 0.95rem;
            margin-bottom: 35px;
        }

        /* Styling Form Input */
        .form-floating > .form-control {
            border: 1px solid #e1e5eb;
            border-radius: 10px;
            background-color: #fcfdfd;
            font-size: 0.95rem;
        }
        .form-floating > .form-control:focus {
            box-shadow: 0 0 0 4px rgba(43, 52, 64, 0.08); /* Glow abu-abu elegan */
            border-color: #b0b8c4;
            background-color: #ffffff;
        }
        .form-floating > label {
            color: #8392a5;
        }

        /* Tombol Dark Elegan */
        .btn-login {
            background-color: #2b3440;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-login:hover {
            background-color: #1a202c;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            color: #ffffff;
        }
        .btn-login:disabled {
            background-color: #8392a5;
            transform: none;
            box-shadow: none;
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <h3 class="login-title">Klinik App</h3>
    <p class="login-subtitle">Silakan masuk ke akun Anda</p>

    <form id="formLogin">
        <div class="form-floating mb-3 text-start">
            <input type="text" name="username" class="form-control" id="floatingUsername" placeholder="Username" required autocomplete="off">
            <label for="floatingUsername">Username</label>
            <div class="form-text mt-2" style="font-size: 0.8rem; color: #a0aec0;">
                *Demo: admin / admisi / perawat
            </div>
        </div>

        <div class="form-floating mb-4 text-start">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-login w-100" id="btnSubmit">
            Masuk
        </button>
    </form>
</div>

<script>
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        
        let btn = $('#btnSubmit');
        let originalText = btn.html();

        // Status loading elegan
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...').prop('disabled', true);
        
        $.ajax({
            url: "<?= base_url('auth/login') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.status == 'success') {
                    // Alert SweetAlert disesuaikan warnanya agar matching
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        showConfirmButton: false,
                        timer: 1500,
                        iconColor: '#2b3440'
                    }).then(() => {
                        window.location.href = "<?= base_url('/') ?>"; 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.msg || 'Username atau Password salah!',
                        confirmButtonColor: '#2b3440'
                    });
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: 'Terjadi kesalahan pada server.',
                    confirmButtonColor: '#2b3440'
                });
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
</script>

</body>
</html>