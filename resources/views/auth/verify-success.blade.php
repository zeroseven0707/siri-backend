<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #F3F4F6; }
        .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; max-width: 400px; width: 90%; }
        .icon { font-size: 64px; color: #2ECC71; margin-bottom: 20px; }
        h1 { color: #1F2937; margin-bottom: 10px; }
        p { color: #6B7280; line-height: 1.6; margin-bottom: 30px; }
        .btn { display: inline-block; background-color: #2ECC71; color: white; padding: 12px 30px; border-radius: 12px; text-decoration: none; font-weight: bold; transition: background 0.3s; }
        .btn:hover { background-color: #27AE60; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✓</div>
        <h1>Verifikasi Berhasil!</h1>
        <p>Email Anda telah berhasil diverifikasi. Silakan kembali ke aplikasi Push untuk melanjutkan.</p>
        <a href="pushapp://verify-success" class="btn">Buka Aplikasi</a>
    </div>

    <script>
        // Mencoba membuka aplikasi secara otomatis
        setTimeout(function() {
            window.location.href = "pushapp://verify-success";
        }, 2000);
    </script>
</body>
</html>
