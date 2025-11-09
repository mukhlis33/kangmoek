<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kang Moek Tools</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #10b981;
            --primary-dark: #0d9c6d;
            --secondary: #059669;
            --accent: #34d399;
            --accent-light: #a7f3d0;
            --light: #f0fdf4;
            --dark: #052e16;
            --gray: #6b7280;
            --success: #22c55e;
            --card-bg: rgba(255, 255, 255, 0.92);
            --shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
            --shadow-hover: 0 15px 40px rgba(16, 185, 129, 0.15);
            --glow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf9 50%, #ccfbf1 100%);
            min-height: 100vh;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--dark);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 50% 50%, rgba(52, 211, 153, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            opacity: 0.1;
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 10%;
            animation-delay: -10s;
        }

        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 85%;
            animation-delay: -15s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(10px, 15px) rotate(90deg);
            }
            50% {
                transform: translate(0, 30px) rotate(180deg);
            }
            75% {
                transform: translate(-10px, 15px) rotate(270deg);
            }
            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 1200px;
            padding: 0 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 1rem;
            flex-direction: column;
        }

        .logo-icon {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.3));
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
            text-align: center;
            position: relative;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
            border-radius: 2px;
        }

        .subtitle {
            font-size: 1rem;
            color: var(--gray);
            font-weight: 400;
            max-width: 100%;
            margin: 1.5rem auto 0;
            line-height: 1.5;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 1.5rem 1.25rem;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(16, 185, 129, 0.05), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover), var(--glow);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover::after {
            opacity: 1;
            transform: rotate(45deg) translate(10%, 10%);
        }

        .card-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
        }

        .card h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .card p {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        .card a {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 1;
            width: 100%;
            max-width: 180px;
        }

        .card a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .card a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .card a:hover::before {
            opacity: 1;
        }

        footer {
            margin-top: 3rem;
            text-align: center;
            color: var(--gray);
            font-size: 0.85rem;
            padding: 1rem;
            width: 100%;
        }

        /* Tablet Styles (768px and up) */
        @media (min-width: 768px) {
            body {
                padding: 1.5rem;
            }
            
            .header {
                margin-bottom: 3rem;
            }
            
            .logo {
                flex-direction: row;
                margin-bottom: 1.5rem;
            }
            
            .logo-icon {
                font-size: 2.5rem;
            }
            
            h1 {
                font-size: 2.2rem;
                text-align: left;
            }
            
            h1::after {
                left: 0;
                transform: none;
            }
            
            .subtitle {
                font-size: 1.1rem;
                max-width: 600px;
            }
            
            .container {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            
            .card {
                padding: 1.75rem 1.5rem;
            }
            
            .card-icon {
                font-size: 2.25rem;
                margin-bottom: 1rem;
            }
            
            .card h2 {
                font-size: 1.25rem;
            }
            
            .card p {
                font-size: 0.95rem;
            }
            
            footer {
                margin-top: 4rem;
            }
        }

        /* Desktop Styles (1024px and up) */
        @media (min-width: 1024px) {
            body {
                padding: 2rem;
            }
            
            .header {
                margin-bottom: 3.5rem;
            }
            
            h1 {
                font-size: 2.5rem;
            }
            
            .container {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.75rem;
            }
            
            .card {
                padding: 2rem 1.5rem;
            }
            
            .card-icon {
                font-size: 2.5rem;
            }
            
            .card h2 {
                font-size: 1.3rem;
            }
            
            .card p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
        }

        /* Large Desktop Styles (1200px and up) */
        @media (min-width: 1200px) {
            .container {
                gap: 2rem;
            }
            
            .card {
                padding: 2.25rem 1.75rem;
            }
        }

        /* Small Mobile Adjustments (max-width: 360px) */
        @media (max-width: 360px) {
            body {
                padding: 0.75rem;
            }
            
            .header {
                margin-bottom: 1.5rem;
            }
            
            h1 {
                font-size: 1.6rem;
            }
            
            .subtitle {
                font-size: 0.9rem;
            }
            
            .container {
                padding: 0 0.5rem;
                gap: 1rem;
            }
            
            .card {
                padding: 1.25rem 1rem;
            }
            
            .card-icon {
                font-size: 1.75rem;
            }
            
            .card h2 {
                font-size: 1.1rem;
            }
            
            .card p {
                font-size: 0.85rem;
            }
            
            .card a {
                padding: 0.65rem 1.25rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="header">
        <div class="logo">
            <div class="logo-icon">🪶</div>
            <h1>Kang Moek Tools</h1>
        </div>
        <p class="subtitle">Koleksi alat digital praktis untuk produktivitas dan kreativitas Anda</p>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-icon">📄</div>
            <h2>Kompres PDF</h2>
            <p>Perkecil ukuran file PDF tanpa mengurangi kualitas yang terlihat.</p>
            <a href="KompresPdf/">Masuk</a>
        </div>

        <div class="card">
            <div class="card-icon">🎵</div>
            <h2>Komposer</h2>
            <p>Membuat not musik ringan sebagai media relaksasi dan kreativitas.</p>
            <a href="komposer/">Masuk</a>
        </div>

        <div class="card">
            <div class="card-icon">🕌</div>
            <h2>Generator Pegon</h2>
            <p>Mengonversi teks Latin menjadi tulisan Arab Pegon secara otomatis.</p>
            <a href="pegon/">Masuk</a>
        </div>

        <div class="card">
            <div class="card-icon">📸</div>
            <h2>Kompres Gambar</h2>
            <p>Kompres gambar dengan kualitas optimal dan hasil profesional</p>
            <a href="kompresgambar/">Masuk</a>
        </div>
         
        <div class="card">
            <div class="card-icon">🌐</div>
            <h2>Kunjungi Kinjeng</h2>
            <p>Langsung ke situs utama Kinjeng untuk informasi lebih lanjut.</p>
            <a href="https://kinjeng.ct.ws/" target="_blank">Buka</a>
        </div>

        <!-- Template untuk fitur baru -->
        <!--
        <div class="card">
            <div class="card-icon">🔧</div>
            <h2>Nama Fitur Baru</h2>
            <p>Deskripsi singkat fitur ini.</p>
            <a href="namaFolderAtauLink/">Masuk</a>
        </div>
        -->
    </div>

    <footer>© <span id="currentYear"></span> Kang Moek Tools</footer>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>