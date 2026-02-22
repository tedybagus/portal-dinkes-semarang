# 🔧 Fix Gmail Connection Error - Quick Solutions

## ❌ Error yang Terjadi

```
Connection could not be established with host "smtp.gmail.com:587"
stream_socket_client(): Unable to connect
```

**Penyebab:**
- Port 587 di-block oleh firewall/antivirus
- ISP memblokir SMTP
- Koneksi internet issue
- Gmail server down

---

## ✅ Solusi 1: Gunakan Port SSL (465) - RECOMMENDED

### **Update .env:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465                          # ← Ganti dari 587 ke 465
MAIL_USERNAME=tedy.bagus@gmail.com
MAIL_PASSWORD=gntqvlmqqocwipui
MAIL_ENCRYPTION=ssl                    # ← Ganti dari tls ke ssl
MAIL_FROM_ADDRESS=noreply@dinkeskabsemarang@gmail.com
MAIL_FROM_NAME="Dinas Kesehatan"
```

### **Clear cache & Test:**

```bash
php artisan config:clear
php artisan cache:clear

# Test
php artisan tinker
```

```php
Mail::raw('Test Email', function($message) {
    $message->to('tedy.bagus@gmail.com')
            ->subject('Test dari Laravel');
});
// Tunggu beberapa detik, check inbox
exit
```

---

## ✅ Solusi 2: Pakai Mailtrap (TERCEPAT untuk Testing)

Mailtrap adalah fake SMTP server untuk testing. Email tidak benar-benar terkirim, tapi bisa lihat preview.

### **Step 1: Daftar Mailtrap**

1. Buka: https://mailtrap.io
2. Sign up (gratis, pakai Google)
3. Buat inbox baru
4. Copy credentials

### **Step 2: Update .env**

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username      # Dari dashboard Mailtrap
MAIL_PASSWORD=your-mailtrap-password      # Dari dashboard Mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Test Sender"
```

### **Step 3: Clear cache & Test**

```bash
php artisan config:clear

php artisan tinker
```

```php
Mail::raw('Test Email', function($message) {
    $message->to('test@test.com')
            ->subject('Test Mailtrap');
});
exit
```

### **Step 4: Check Mailtrap Dashboard**

Buka Mailtrap dashboard → Inbox → Email muncul disana!

**Keuntungan Mailtrap:**
- ✅ Tidak perlu App Password
- ✅ Tidak di-block firewall
- ✅ Preview HTML email
- ✅ Lihat source code email
- ✅ Gratis untuk development

---

## ✅ Solusi 3: Pakai Log Driver (Development Only)

Email akan tersimpan di log file, tidak benar-benar terkirim.

### **Update .env:**

```env
MAIL_MAILER=log
# Comment semua MAIL_* lainnya
```

### **Clear cache & Test:**

```bash
php artisan config:clear

php artisan tinker
```

```php
Mail::raw('Test Email', function($message) {
    $message->to('test@test.com')
            ->subject('Test Log');
});
exit
```

### **Check Log:**

```bash
tail -f storage/logs/laravel.log
```

Email content akan muncul di log file.

**Keuntungan:**
- ✅ Paling cepat untuk development
- ✅ Tidak perlu koneksi internet
- ✅ Lihat email content di log

**Kekurangan:**
- ❌ Tidak bisa lihat HTML preview
- ❌ Tidak benar-benar terkirim

---

## ✅ Solusi 4: Disable Firewall/Antivirus (Temporary)

Jika mau tetap pakai Gmail:

### **Windows:**

1. **Disable Windows Firewall:**
   - Control Panel → System and Security → Windows Defender Firewall
   - Turn off (temporary)

2. **Disable Antivirus:**
   - Temporary disable your antivirus
   - Test email lagi

3. **Re-enable setelah test**

### **Test Gmail lagi:**

```bash
php artisan config:clear

telnet smtp.gmail.com 587
# Jika connect → OK, firewall sudah tidak blocking
```

---

## 🎯 RECOMMENDED Solution untuk Project Anda

Karena ini untuk **development/testing**, gunakan **Mailtrap**:

### **Quick Setup (2 Menit):**

1. **Daftar Mailtrap:** https://mailtrap.io (sign up dengan Google)

2. **Copy credentials** dari dashboard:
   ```
   Host: sandbox.smtp.mailtrap.io
   Port: 2525
   Username: abcd1234
   Password: xyz5678
   ```

3. **Update .env:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=abcd1234
   MAIL_PASSWORD=xyz5678
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=test@example.com
   MAIL_FROM_NAME="Dinas Kesehatan"
   ```

4. **Clear cache:**
   ```bash
   php artisan config:clear
   ```

5. **Test:**
   ```bash
   php artisan tinker
   >>> Mail::raw('Test', fn($m) => $m->to('test@test.com')->subject('Test'));
   >>> exit
   ```

6. **Check Mailtrap inbox** → Email muncul!

---

## 📧 Untuk Production (Nanti)

Saat deploy ke production, pakai:

### **Option 1: Gmail dengan SSL (Port 465)**

```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

### **Option 2: SendGrid (Recommended)**

- Free: 100 emails/day
- Tidak di-block ISP
- Lebih reliable

Daftar: https://sendgrid.com

### **Option 3: Mailgun**

- Free: 5000 emails/month
- Professional service

Daftar: https://mailgun.com

---

## ✅ Quick Fix NOW (Pilih Salah Satu)

### **Opsi A: SSL Port (5 detik)**

```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

```bash
php artisan config:clear
php artisan tinker
>>> Mail::raw('Test', fn($m) => $m->to('tedy.bagus@gmail.com')->subject('Test'));
```

### **Opsi B: Mailtrap (2 menit)**

1. https://mailtrap.io → Sign up
2. Copy credentials
3. Update .env
4. Test → Check Mailtrap inbox

### **Opsi C: Log Driver (Instant)**

```env
MAIL_MAILER=log
```

```bash
php artisan config:clear
tail -f storage/logs/laravel.log
# Test email, lihat di log
```

---

## 🐛 Still Not Working?

### **Check Port Accessibility:**

```bash
# Test port 587
telnet smtp.gmail.com 587

# Test port 465
telnet smtp.gmail.com 465

# If both fail → ISP/Firewall blocking
```

### **Alternative: Use Mobile Hotspot**

Kadang ISP kantor/kampus block SMTP. Coba:
1. Connect ke mobile hotspot
2. Test email lagi
3. Jika work → berarti ISP yang blocking

---

## 📝 Summary

**Untuk Development:** Gunakan **Mailtrap** ✅  
**Untuk Production:** Gunakan **Gmail SSL (465)** atau **SendGrid** ✅  
**Quick Test:** Gunakan **Log Driver** ✅

---

**Status:** Choose one solution above  
**Recommended:** Mailtrap (2 minutes setup)  
**Time:** 2-5 minutes

Port 587 di-block oleh network Anda. Pilih solusi alternatif! 🚀
