<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Reset some basic elements */
        body, h1, p, a {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
        }

        .container {
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align text */
        }

        .header, .content, .footer {
            padding: 1.25rem;
        }

        .header {
            border-bottom: 1px solid #e5e7eb;
        }

        .header a {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
        }

        .header img {
            height: 2rem;
        }

        .header div {
            margin-top: 0.5rem;
            color: #000;
        }

        .header .title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .header .subtitle {
            font-size: 0.875rem;
        }

        .content h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #4f46e5;
        }

        .content p {
            margin-top: 1rem;
            font-size: 1rem;
            color: #374151;
            line-height: 1.5;
        }

        .content a.feedback-link {
            display: inline-block;
            margin-top: 1rem;
            font-size: 1rem;
            color: #4f46e5;
            text-decoration: none;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <div>
                    <p class="title">Pelayanan Statistik Terpadu</p>
                    <p class="subtitle">BPS Kota Bukittinggi</p>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>Halo, {{ $name }}!</h1>
            <p>Terima kasih telah mengunjungi PST BPS Kota Bukittinggi. Kami berharap Anda mendapatkan pengalaman yang
                menyenangkan dan bermanfaat.</p>
            <a href="{{ route('guest-book.feedback') }}" class="feedback-link">Layanan Feedback PST</a>
            <p>Kami sangat menghargai jika Anda dapat meluangkan waktu sejenak untuk memberikan feedback tentang
                layanan kami. Masukan Anda sangat berharga bagi kami untuk terus meningkatkan kualitas pelayanan.</p>
        </div>
        <div class="footer">
            <p>Hak Cipta © {{ date('Y') }} Badan Pusat Statistik</p>
        </div>
    </div>    
</body>
</html>
