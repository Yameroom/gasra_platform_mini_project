<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASRA | Welcome Back</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            /* Base Blue Color dari widget dashboard */
            --gasra-blue-base: #001d3d; 
            --gasra-blue-hover: #003566;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f2; 
            height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden; 
        }
        
        .login-card {
            background: white;
            width: 100%;
            max-width: 850px; 
            height: 480px;    
            display: flex;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            animation: zoomIn; 
            animation-duration: 0.8s;
        }

        .left-side {
            width: 50%;
            padding: 40px 50px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side {
            width: 50%;
            /* Perbaikan Opacity: Menggunakan rgba dengan alpha 0.45 agar background gambar lebih terlihat jelas */
            background: linear-gradient(rgba(0, 29, 61, 0.50), rgba(0, 29, 61, 0.52)), 
                        url('<?php echo base_url("assets/images/bg-login1.jpg"); ?>'); 
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 30px;
        }

        .right-side div {
            transition: transform 0.5s ease;
            /* Memberikan sedikit bayangan teks agar tetap terbaca di background yang lebih terang */
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .login-card:hover .right-side div {
            transform: scale(1.05);
        }

        .brand-logo-box {
            width: 25px; 
            height: 35px;
            background: var(--gasra-blue-base);
            margin-right: 12px;
        }

        h2 { color: var(--gasra-blue-base); font-weight: 700; font-size: 1.6rem; margin-bottom: 5px; }
        .sub-text { color: #888; font-size: 0.8rem; margin-bottom: 20px; line-height: 1.4; }

        .form-group {
            border-bottom: 1px solid #eee;
            margin-bottom: 15px; 
            position: relative;
        }
        
        .form-group::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -1px;
            left: 0;
            background-color: var(--gasra-blue-base);
            transition: width 0.3s ease;
        }
        .form-group:focus-within::after {
            width: 100%;
        }

        .form-group label {
            font-size: 0.65rem;
            color: #aaa;
            text-transform: uppercase;
            font-weight: 600;
        }
        .form-group input {
            border: none;
            width: 100%;
            padding: 6px 0;
            outline: none;
            font-size: 0.9rem;
            background: transparent;
        }

        .btn-login {
            background: var(--gasra-blue-base);
            color: white;
            border: none;
            padding: 12px 45px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: var(--gasra-blue-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 29, 61, 0.3);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        .delay-1 { animation-delay: 0.3s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.5s; }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                height: auto;
                max-width: 400px;
                overflow-y: auto;
            }
            .left-side, .right-side { width: 100%; padding: 30px; }
            .right-side { order: -1; min-height: 150px; }
            body { overflow: auto; }
        }
    </style>
</head>
<body>

<div class="login-card shadow">
    <div class="left-side">
        <div class="d-flex align-items-center mb-4 animate__animated animate__fadeInLeft">
            <div class="brand-logo-box"></div>
            <div style="font-size: 0.9rem;">
                <strong class="d-block" style="line-height: 1.2;">GASRA</strong>
                <small class="text-muted" style="font-size: 0.65rem;">PLATFORM</small>
            </div>
        </div>

        <h2 class="animate__animated animate__fadeInUp delay-1">Welcome Back</h2>
        <p class="sub-text animate__animated animate__fadeInUp delay-1">Login to your account by filling these form:</p>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form action="<?php echo base_url('index.php/login/aksi_login'); ?>" method="post" class="animate__animated animate__fadeInUp delay-2">
            <div class="form-group">
                <label>Username / Email</label>
                <input type="text" name="username" placeholder="yourname@gasra.com" required autocomplete="username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="************" required autocomplete="current-password">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 0.75rem;">
                <label style="cursor: pointer;"><input type="checkbox" class="me-1"> Remember me</label>
                <a href="#" class="text-decoration-none text-dark fw-bold">Forgot password</a>
            </div>

            <div class="action-btns">
                <button type="submit" class="btn-login">LOGIN</button>
            </div>
        </form>
    </div>
    
    <div class="right-side">
        <div class="animate__animated animate__fadeInRight">
            <h1 class="fw-bold mb-0" style="font-size: 2.5rem;">GASRA</h1>
            <p class="mb-0" style="font-size: 0.85rem; opacity: 0.95; max-width: 300px;">
                Compressed Natural Gas distribution and commercialization in Indonesia since 2005.
            </p>
        </div>
    </div>
</div>

</body>
</html>