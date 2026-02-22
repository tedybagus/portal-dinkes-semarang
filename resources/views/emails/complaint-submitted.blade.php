<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Diterima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f8fafc;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .ticket-box {
            background: white;
            padding: 20px;
            border-left: 4px solid #3b82f6;
            margin: 20px 0;
            border-radius: 4px;
        }
        .ticket-number {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin: 10px 0;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
        }
        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 150px;
            color: #64748b;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #64748b;
            font-size: 14px;
        }
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Pengaduan Diterima</h1>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $reporterName }}</strong>,</p>

        <p>Terima kasih telah menyampaikan pengaduan Anda. Pengaduan Anda telah diterima dan akan segera kami proses.</p>

        <div class="ticket-box">
            <div style="color: #64748b; font-size: 14px;">Nomor Tiket Anda:</div>
            <div class="ticket-number">{{ $ticketNumber }}</div>
            <div style="color: #64748b; font-size: 14px;">Simpan nomor ini untuk tracking pengaduan</div>
        </div>

        <table class="info-table">
            <tr>
                <td>Layanan</td>
                <td>{{ $service }}</td>
            </tr>
            <tr>
                <td>Subjek</td>
                <td>{{ $subject }}</td>
            </tr>
            <tr>
                <td>Tanggal Diajukan</td>
                <td>{{ $createdAt }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 4px;">Menunggu Verifikasi</span></td>
            </tr>
        </table>

        <div class="alert">
            <strong>📌 Catatan Penting:</strong><br>
            • Simpan nomor tiket untuk tracking pengaduan Anda<br>
            • Kami akan segera memverifikasi pengaduan Anda<br>
            • Estimasi waktu proses: 3-7 hari kerja<br>
            • Anda akan mendapat notifikasi setiap ada update status
        </div>

        <center>
            <a href="{{ $trackingUrl }}" class="button">
                🔍 Lacak Pengaduan
            </a>
        </center>

        <p style="margin-top: 30px;">Jika ada pertanyaan, silakan hubungi kami melalui:</p>
        <p>
            📧 Email: pengaduan@dinkes-semarangkab.go.id<br>
            📞 Telepon: (024) 1234567<br>
            💬 WhatsApp: 0812-3456-7890
        </p>
    </div>

    <div class="footer">
        <p><strong>Dinas Kesehatan Kabupaten Semarang</strong></p>
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>