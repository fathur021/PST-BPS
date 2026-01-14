<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - BPS Bukittinggi</title>

    <style>
        /* ================= FULL BLEED PAGE ================= */
        @page {
            size: A7;
            margin: 0; /* 🔥 WAJIB 0 */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        html, body {
            width: 100%;
            height: 100%;
            background: #0f172a; /* 🔥 SAMAKAN */
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ================= CARD (FULL A7) ================= */
        .modal-card {
            width: 100%;
            height: 100%;
            background: #0f172a;
            color: #e5e7eb;
            overflow: hidden;
        }

        /* ================= THEME ================= */
        .modal-card.modal-wa .modal-header {
            background: #16a34a;
            color: #ffffff;
        }

        .modal-card.modal-wa .queue-box {
            border: 2px solid #22c55e;
            color: #22c55e;
        }

        .modal-card.modal-wa .modal-info {
            border-left: 4px solid #22c55e;
        }

        .modal-card.modal-web .modal-header {
            background: #facc15;
            color: #1f2937;
        }

        .modal-card.modal-web .queue-box {
            border: 2px solid #fde047;
            color: #fde047;
        }

        .modal-card.modal-web .modal-info {
            border-left: 4px solid #fde047;
        }

        /* ================= HEADER ================= */
        .modal-header {
            position: relative;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .modal-title {
            font-size: 11px;
            letter-spacing: 0.05em;
        }

        .modal-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            font-size: 8px;
            padding: 2px 6px;
            border-radius: 8px;
            background: rgba(255,255,255,0.3);
        }

        /* ================= BODY ================= */
        .modal-body {
            padding: 10px;
            text-align: center;
            margin-top: 10px; 
        }

        .modal-subtitle {
            font-size: 9px;
            margin-bottom: 15px; 
            font-weight: 600;
        }

        .queue-box {
            background: #020617;
            font-size: 28px;
            font-weight: 900;
            padding: 6px 14px;
            border-radius: 10px;
            letter-spacing: 3px;
            display: inline-block;
            margin-bottom: 15px; /* 🔥 Diubah dari 6px ke 15px */
            text-shadow: 0 0 6px currentColor;
        }

        .queue-info {
            font-size: 8px;
            opacity: 0.85;
            margin-bottom: 15px; /* 🔥 Ditambahkan */
        }

        .modal-time {
            font-size: 9px;
            margin: 15px 0; /* 🔥 Diubah dari 8px 0 ke 15px 0 */
            padding: 4px 6px;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
            display: inline-block;
        }

        .modal-info {
            background: #020617;
            padding: 8px;
            font-size: 9px;
            border-radius: 6px;
            line-height: 1.4;
            margin-top: 15px; /* 🔥 Ditambahkan */
        }

        /* ================= FOOTER ================= */
        .modal-footer {
            background: #020617;
            padding: 6px;
            text-align: center;
            font-size: 8px;
            opacity: 0.7;
            margin-top: 70px; /* 🔥 Tetap ada untuk menggeser footer ke bawah */
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>

<div class="modal-card {{ $source === 'wa' ? 'modal-wa' : 'modal-web' }}">

    <div class="modal-header">
        <div class="modal-badge">{{ strtoupper($source) }}</div>
        <div class="modal-title">
            Pendaftaran {{ $source === 'wa' ? 'WhatsApp' : 'Web' }}
        </div>
    </div>

    <div class="modal-body">

        <div class="modal-subtitle">
            NOMOR ANTRIAN {{ strtoupper($source) }}
        </div>

        <div class="queue-box">
            {{ sprintf('%03d', $nomorAntrian) }}
        </div>

        <div class="queue-info">
            Antrian {{ strtoupper($source) }} terpisah
        </div>

        <div class="modal-time">
            {{ now()->format('H:i') }} • {{ now()->format('d/m/Y') }}
        </div>

        <div class="modal-info">
            <strong>Pendaftaran Berhasil</strong><br>
            Silakan menunggu panggilan petugas.
        </div>

    </div>

    <div class="modal-footer">
        BPS Kota Bukittinggi
    </div>

</div>

</body>
</html>