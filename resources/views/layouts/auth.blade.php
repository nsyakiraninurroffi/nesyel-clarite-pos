<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESYÈL CLARITÉ - Auth</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8a1c4, #fbc2eb, #a18cd1, #8f7cc3);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 28px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            transform: scale(0.95);
            opacity: 0;
            animation: zoomIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes zoomIn {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .brand-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #8f7cc3;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            color: #a18cd1;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 18px;
            border: 2px solid transparent;
            background-color: #f8f5fc;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #a18cd1;
            box-shadow: 0 0 0 3px rgba(161, 140, 209, 0.2);
            outline: none;
        }

        .btn-auth {
            background: linear-gradient(135deg, #f8a1c4, #a18cd1);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
            width: 100%;
            transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 5px 15px rgba(161, 140, 209, 0.3);
        }

        .btn-auth:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 8px 24px rgba(161, 140, 209, 0.45);
            color: white;
        }
        .btn-auth:active {
            transform: translateY(0) scale(0.97);
            box-shadow: 0 3px 8px rgba(161, 140, 209, 0.3);
        }

        .auth-link {
            color: #a18cd1;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .auth-link:hover {
            color: #f8a1c4;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }
        
        /* Footer */
        .auth-footer {
            position: fixed;
            bottom: 16px;
            left: 0;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card { padding: 28px 24px; }
            .brand-text { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

    @yield('content')

    <div class="auth-footer">
        &copy; 2026 NESYÈL CLARITÉ. All rights reserved.
    </div>

</body>
</html>
