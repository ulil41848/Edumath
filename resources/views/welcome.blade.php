<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EduMath</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="{{ asset('study-schedule.css') }}">
</head>

<body>

    <!-- SPLASH SCREEN -->
    <section id="splash" class="screen splash-screen">

        <div class="splash-content">

            <img src="assets/logo.png" alt="Logo EduMath" class="logo">

            <h1 class="logo-text">
                <span>Edu</span><span>Math</span>
            </h1>

        </div>

    </section>


    <!-- LOGIN PAGE -->
    <section id="login" class="screen login-screen hidden">

        <div class="login-content">

            <img src="assets/logo.png" alt="Logo EduMath" class="login-logo">

            <h2 class="logo-text">
                <span>Edu</span><span>Math</span>
            </h2>

            <label>EMAIL ATAU USERNAME</label>

            <input
                type="text"
                id="username"
                value=""
            >

            <label>KATA SANDI</label>

            <input
                type="password"
                id="password"
                value=""
            >

            <a href="#" class="forgot">
                Lupa Kata Sandi?
            </a>

            <button onclick="login()">
                Masuk Akun
            </button>

            <p>
                Belum punya akun?
                <a href="#" onclick="openRegister(event)">Daftar Sekarang</a>
            </p>

        </div>

    </section>


<!-- FORM PENDAFTARAN -->
<section id="register-screen" class="screen login-screen hidden">
    <div class="login-content">

        <img src="/assets/logo.png" alt="Logo EduMath" class="login-logo">
        <h2 class="logo-text"><span>Edu</span><span>Math</span></h2>

        <form id="register-form" onsubmit="submitRegistration(event)">
            <label for="register-name">NAMA LENGKAP</label>
            <input id="register-name" name="name" type="text"
                   maxlength="100" required>

            <label for="register-email">EMAIL</label>
            <input id="register-email" name="email" type="email"
                   maxlength="254" required>

            <label for="register-password">KATA SANDI</label>
            <input id="register-password" name="password" type="password"
                   minlength="8" autocomplete="new-password" required>

            <label for="register-confirm">ULANGI KATA SANDI</label>
            <input id="register-confirm" name="password_confirmation"
                   type="password" minlength="8"
                   autocomplete="new-password" required>

            <button type="submit">Daftar dan Kirim OTP</button>
        </form>

        <p id="register-message" role="status" aria-live="polite"></p>
        <p>Sudah punya akun?
            <a href="#" onclick="backToLogin(event)">Masuk</a>
        </p>
    </div>
</section>

<!-- FORM VERIFIKASI OTP -->
<section id="otp-screen" class="screen login-screen hidden">
    <div class="login-content">

        <img src="/assets/logo.png" alt="Logo EduMath" class="login-logo">
        <h2 class="logo-text"><span>Edu</span><span>Math</span></h2>

        <p>Kami mengirimkan kode verifikasi ke email Anda.</p>

        <form id="otp-form" onsubmit="submitOtp(event)">
            <label for="otp-email">EMAIL</label>
            <input id="otp-email" name="email" type="email" readonly required>

            <label for="otp-code">KODE OTP 6 DIGIT</label>
            <input id="otp-code" name="otp" type="text"
                   inputmode="numeric" autocomplete="one-time-code"
                   pattern="[0-9]{6}" maxlength="6" required>

            <button type="submit">Verifikasi Email</button>
        </form>

        <p id="otp-message" role="status" aria-live="polite"></p>

        <p>
            <a href="#" onclick="resendOtp(event)">Kirim Ulang OTP</a>
        </p>

        <p>
            <a href="#" onclick="backToLogin(event)">Kembali ke Login</a>
        </p>
    </div>
</section>

<!-- HOME PAGE: redesign visual, mempertahankan ID screen dan showPage lama -->
<section id="home" class="screen home-screen hidden redesign-home">
    <header class="rd-header">
        <a class="rd-brand" href="#" onclick="showHome(); return false;">
            <img src="assets/logo.png" alt="" onerror="this.style.display='none'">
            <span>Edu<span>Math</span></span>
        </a>
        <label class="rd-search"><span>⌕</span><input type="search" placeholder="Cari materi, kelas, atau fitur..." aria-label="Cari materi"></label>
        <div class="rd-user-tools">
            <button class="rd-icon-button" type="button" onclick="showPage('notifications')" aria-label="Notifikasi">♧<i></i></button>
            <button class="rd-user" type="button" onclick="showPage('profile')">
                <img src="assets/avatar.png" alt="Avatar pengguna">
                <span><strong id="dashboard-display-name">Pengguna EduMath</strong><small>Siswa EduMath</small></span><b>⌄</b>
            </button>
            <button class="rd-icon-button rd-menu-button" type="button" onclick="showPage('profile')" aria-label="Buka profil">⋮</button>
        </div>
    </header>
    <div class="rd-content">
        <section class="rd-hero">
            <div class="rd-hero-copy">
                <p class="rd-eyebrow">SELAMAT DATANG DI EDUMATH</p>
                <h1>👋 Halo, <span id="dashboard-greeting-name">Sobat EduMath</span>!</h1>
                <h2>Siap belajar hal baru hari ini?</h2>
                <p>Teruslah belajar dan raih cita-citamu bersama kami!</p>
                <button class="rd-primary" type="button" onclick="showPage('edubot')">Mulai Belajar <span>→</span></button>
            </div>
            <div class="rd-hero-art" aria-hidden="true"><span class="rd-equation">a² + b² = c²</span><div class="rd-book">📚</div><div class="rd-bulb">💡</div><div class="rd-mascot">🧑🏻‍🎓</div></div>
        </section>
        <section class="rd-stats" aria-label="Statistik belajar">
            <article class="rd-stat rd-stat-green"><span class="rd-stat-icon">🎓</span><div><strong>75%</strong><p>Progress Kursus</p><div class="rd-progress"><i style="width:75%"></i></div></div></article>
            <article class="rd-stat rd-stat-purple"><span class="rd-stat-icon">🗓️</span><div><strong>52</strong><p>Day Streak</p><div class="rd-progress"><i style="width:52%"></i></div></div></article>
            <article class="rd-stat rd-stat-blue"><span class="rd-stat-icon">⭐</span><div><strong>52</strong><p>Lencana</p><div class="rd-progress"><i style="width:68%"></i></div></div></article>
        </section>
        <div class="rd-section-heading"><div><p class="rd-eyebrow">JELAJAHI FITUR</p><h2>Kategori Belajar</h2></div><button type="button" onclick="showPage('pustaka')">Lihat Semua <span>→</span></button></div>
        <section class="rd-categories" aria-label="Kategori belajar">
            <button class="rd-category rd-pink" type="button" onclick="showPage('edubot')"><span class="rd-category-icon">🤖</span><span class="rd-category-copy"><strong>Edubot</strong><small>Asisten belajar pintar<br>untuk membantu kamu.</small></span><span class="rd-arrow">→</span></button>
            <button class="rd-category rd-blue" type="button" onclick="showPage('pustaka')"><span class="rd-category-icon">📖</span><span class="rd-category-copy"><strong>Pustaka Edu</strong><small>Akses materi, buku, dan<br>referensi pembelajaran.</small></span><span class="rd-arrow">→</span></button>
            <button class="rd-category rd-purple" type="button" onclick="showPage('kilas')"><span class="rd-category-icon">▶️</span><span class="rd-category-copy"><strong>Kilas Belajar</strong><small>Ikuti kelas interaktif<br>dengan mudah.</small></span><span class="rd-arrow">→</span></button>
            <button class="rd-category rd-mint" type="button" onclick="showPage('jadwal')"><span class="rd-category-icon">🗓️</span><span class="rd-category-copy"><strong>Jadwal Kursus</strong><small>Lihat jadwal kursus<br>dan kegiatan belajar.</small></span><span class="rd-arrow">→</span></button>
            <button class="rd-category rd-yellow" type="button" onclick="showPage('guru')"><span class="rd-category-icon">🏆</span><span class="rd-category-copy"><strong>Mode Sang Guru</strong><small>Fitur khusus untuk guru<br>dan pengajar.</small></span><span class="rd-arrow">→</span></button>
        </section>
        <footer class="rd-footer"><span>© 2026 EduMath</span><em>Belajar jadi lebih menyenangkan ✨</em></footer>
    </div>
</section>
<!-- EDUBOT PAGE -->
<section id="edubot" class="screen feature-screen hidden">

    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>

        <h2>Tanya EduBot!</h2>
    </div>

    <div class="feature-description">
        Asisten belajar AI pribadimu siap membantu
        menjawab semua soal pelajaranmu.
    </div>

    <h3>Kategori Belajar</h3>

    <div class="feature-list">
            <div class="feature-item" onclick="showPage('tanya-ai')" style="cursor: pointer;">
                <div class="feature-icon blue">🤖</div>
                <div>
                    <h4>Tanya AI</h4>
                    <p>Ketik atau foto soal pelajaranmu dan dapatkan penjelasan instan.</p>
                </div>
                <span>›</span>
            </div>

        <div class="feature-item" onclick="showPage('belajar-ai')" style="cursor: pointer;">
            <div class="feature-icon purple">👨‍🏫</div>

            <div>
                <h4>Belajar dengan AI</h4>
                <p>
                    Latihan interaktif dengan materi
                    yang disesuaikan untuk kebutuhanmu.
                </p>
            </div>

            <span>›</span>
        </div>


        <div class="feature-item" onclick="showPage('jadwal')" style="cursor: pointer;">
            <div class="feature-icon orange">📅</div>

            <div>
                <h4>Penjadwalan Kursus</h4>
                <p>
                    Atur jadwal belajarmu dan pantau
                    progres kursus harianmu.
                </p>
            </div>

            <span>›</span>
        </div>

    </div>

</section>


<!-- PUSTAKA EDU PAGE -->
<section id="pustaka" class="screen feature-screen hidden">

    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>

        <h2>Pustaka Edu</h2>
    </div>

    <div class="feature-description">
        Tempat materi dan buku yang bisa kalian baca.
    </div>

    <h3>Kategori Belajar</h3>

    <div class="book-grid">

        <div class="book-item">
            <img src="assets/books/buku1.jpg">
            <h4>Kisah Mahabharata</h4>
            <p>Tradisional</p>
        </div>

        <div class="book-item">
            <img src="assets/books/buku2.jpg">
            <h4>Fisika Dasar Semesta</h4>
            <p>Dr. G. Surya</p>
        </div>

        <div class="book-item">
            <img src="assets/books/buku3.jpg">
            <h4>Bahasa Sansekerta</h4>
            <p>P. R. Sharma</p>
        </div>

        <div class="book-item">
            <img src="assets/books/buku4.jpg">
            <h4>Babad Tanah Jawi</h4>
            <p>Ronggowarsito</p>
        </div>

    </div>

</section>


<!-- KILAS BELAJAR PAGE -->
<section id="kilas" class="screen feature-screen hidden">

    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>

        <h2>Kilas Belajar</h2>
    </div>

    <div class="feature-description">
        Tempat untuk mencurahkan isi hati tentang
        pembelajaran atau apapun.
    </div>

    <h3>Kategori Belajar</h3>

    <div class="feature-list">

        <div class="feature-item">

            <div class="feature-icon blue">
                🤖
            </div>

            <div>
                <h4>Beruang Pendengar</h4>

                <p>
                    Sini ceritakan apa yang terjadi
                    hari ini.
                </p>
            </div>

            <span>›</span>

        </div>


        <div class="feature-item">

            <div class="feature-icon purple">
                👨‍🏫
            </div>

            <div>
                <h4>Hasil Sesi</h4>

                <p>
                    Mungkin ini bisa membantumu
                    nanti.
                </p>
            </div>

            <span>›</span>

        </div>

    </div>

</section>
<!-- KILAS BELAJAR PAGE -->
<section id="kilas" class="screen feature-screen hidden">

    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>

        <h2>Kilas Belajar</h2>
    </div>

    <div class="feature-description">
        Tempat untuk mencurahkan isi hati tentang
        pembelajaran atau apapun.
    </div>

    <h3>Kategori Belajar</h3>

    <div class="feature-list">

        <div class="feature-item">

            <div class="feature-icon blue">
                🤖
            </div>

            <div>
                <h4>Beruang Pendengar</h4>

                <p>
                    Sini ceritakan apa yang terjadi
                    hari ini.
                </p>
            </div>

            <span>›</span>

        </div>


        <div class="feature-item">

            <div class="feature-icon purple">
                👨‍🏫
            </div>

            <div>
                <h4>Hasil Sesi</h4>

                <p>
                    Mungkin ini bisa membantumu
                    nanti.
                </p>
            </div>

            <span>›</span>

        </div>

    </div>

</section>
<!-- MODE SANG GURU -->
<section id="guru" class="screen feature-screen hidden">

    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>
        <h2>Mode Sang Guru</h2>
    </div>

    <div class="feature-description">
        Mengajari AI dari materi yang sudah kamu
        pelajari sebelumnya.
    </div>

    <h3>Kategori Belajar</h3>

    <div class="feature-list">

        <div class="feature-item">

            <div class="feature-icon blue">
                🤖
            </div>

            <div>
                <h4>Sesi penjelasan</h4>
                <p>
                    Jadikan AI menjadi murid yang
                    kamu ajari.
                </p>
            </div>

            <span>›</span>

        </div>


        <div class="feature-item">

            <div class="feature-icon purple">
                👨‍🏫
            </div>

            <div>
                <h4>Materi pembelajaran</h4>
                <p>
                    Persiapkan materi yang akan
                    kamu ajari. Untuk evaluasi dirimu.
                </p>
            </div>

            <span>›</span>

        </div>


        <div class="feature-item">

            <div class="feature-icon orange">
                📅
            </div>

            <div>
                <h4>Jadwal mengajar</h4>
                <p>
                    Atur jadwal mengajarmu dan pantau
                    progres kursus harianmu secara rapi.
                </p>
            </div>

            <span>›</span>

        </div>

    </div>

</section>

<!-- NOTIFIKASI PAGE -->
<section id="notifications" class="screen notification-screen hidden">

    <!-- HEADER -->
    <div class="notification-header">

        <div class="back-button" onclick="showHome()">‹</div>

        <h2>Notifikasi</h2>

        <button class="read-all-btn" onclick="markAllRead()">
            Selesai Baca
        </button>

    </div>


    <!-- JUDUL -->
    <div class="notification-title">
        <strong>BARU-BARU INI</strong>

        <button onclick="clearNotifications()">
            Bersihkan
        </button>
    </div>


    <!-- DAFTAR NOTIFIKASI -->
    <div id="notification-list">


        <!-- NOTIFIKASI 1 -->
        <div class="notification-item unread"
             onclick="readNotification(this)">

            <div class="notification-icon blue">
                📖
            </div>

            <div class="notification-content">

                <h4>Materi Baru Tersedia!</h4>

                <p>
                    Yuk pelajari Bab 4: Ekosistem Alam
                    di kelas IPA. Ada kuis seru berhadiah
                    lencana baru!
                </p>

                <span class="notification-time">
                    10 mnt lalu
                </span>

                <span class="notification-label">
                    MATERI BARU
                </span>

            </div>

            <span class="unread-dot"></span>

        </div>


        <!-- NOTIFIKASI 2 -->
        <div class="notification-item unread"
             onclick="readNotification(this)">

            <div class="notification-icon green">
                🏆
            </div>

            <div class="notification-content">

                <h4>Hasil Kuis Matematika Keluar 🎉</h4>

                <p>
                    Selamat! Kamu berhasil meraih nilai
                    sempurna 100 pada latihan 'Perkalian Dasar'.
                </p>

                <span class="notification-time">
                    1 jam yang lalu
                </span>

                <span class="notification-label">
                    KUIS SELESAI
                </span>

            </div>

            <span class="unread-dot"></span>

        </div>


        <!-- NOTIFIKASI 3 -->
        <div class="notification-item"
             onclick="readNotification(this)">

            <div class="notification-icon purple">
                💬
            </div>

            <div class="notification-content">

                <h4>Ibu Maria Mengirim Pesan</h4>

                <p>
                    "Selamat pagi anak-anak, pastikan
                    tugas kelompok IPS sudah dikumpulkan
                    di Pustaka Edu hari ini ya."
                </p>

                <span class="notification-time">
                    3 jam yang lalu
                </span>

                <span class="notification-label">
                    PESAN
                </span>

            </div>

        </div>


        <!-- NOTIFIKASI 4 -->
        <div class="notification-item unread"
             onclick="readNotification(this)">

            <div class="notification-icon red">
                📅
            </div>

            <div class="notification-content">

                <h4>Tenggat Tugas Kurang 1 Hari! 🚨</h4>

                <p>
                    Tugas Prakarya 'Membuat Kolase'
                    Kertas harus diserahkan paling lambat
                    besok pukul 12.00 WIB.
                </p>

                <span class="notification-time">
                    Kemarin
                </span>

                <span class="notification-label">
                    Batas Waktu
                </span>

            </div>

            <span class="unread-dot"></span>

        </div>


        <!-- NOTIFIKASI 5 -->
        <div class="notification-item"
             onclick="readNotification(this)">

            <div class="notification-icon yellow">
                🔥
            </div>

            <div class="notification-content">

                <h4>Streak Belajar 5 Hari Terjaga! 🔥</h4>

                <p>
                    Kamu hebat! Sudah 5 hari berturut-turut
                    kami aktif belajar. 1 hari lagi untuk
                    bonus 50 poin skor ekstra!
                </p>

                <span class="notification-time">
                    2 hari lalu
                </span>

                <span class="notification-label">
                    PENCAPAIAN
                </span>

            </div>

        </div>


    </div>


    <!-- PESAN KOSONG -->
    <div id="empty-notification" class="empty-notification hidden">
        <div>🔔</div>
        <h3>Tidak ada notifikasi</h3>
        <p>Semua notifikasi sudah dibersihkan.</p>
    </div>

</section>

<!-- PROFILE PAGE -->
<section id="profile" class="screen hidden">

    <!-- HEADER PROFILE & TOMBOL KEMBALI -->
    <div class="feature-header">
        <div class="back-button" onclick="showHome()">‹</div>
        <h2>Profil Saya</h2>
    </div>

    <div class="profile-container">

        <!-- CARD ATAS (INFORMASI AKUN & STATS) -->
        <div class="profile-page-card">
            <div class="profile-header-info">
                <div class="profile-avatar-large">
                    <img src="assets/avatar.png" alt="Avatar">
                </div>
                <div class="profile-details">
                    <h3 id="profile-display-name">Nama Pengguna</h3>
                    <p id="profile-display-email">email@contoh.com</p>
                </div>
            </div>

            <div class="profile-stats-row">
                <div class="p-stat">
                    <strong class="blue">14</strong>
                    <span>Selesai</span>
                </div>
                <div class="p-stat">
                    <strong class="yellow">52</strong>
                    <span>Hari Streak</span>
                </div>
                <div class="p-stat">
                    <strong class="green">2.4k</strong>
                    <span>Total XP</span>
                </div>
            </div>
        </div>

        <!-- MENU LIST PROFIL -->
        <div class="profile-menu-list">

            <div class="profile-menu-item" onclick="openAccountSettings()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' ') openAccountSettings()">
                <div class="p-menu-icon blue">👤</div>
                <div class="p-menu-text">
                    <h4>Pengaturan Akun</h4>
                    <p>Detail info profil, sandi & keamanan</p>
                </div>
                <span class="p-arrow">›</span>
            </div>

            <div class="profile-menu-item">
                <div class="p-menu-icon blue-light">📈</div>
                <div class="p-menu-text">
                    <h4>Riwayat Pembelajaran</h4>
                    <p>Analisis & laporan perkembangan</p>
                </div>
                <span class="p-arrow">›</span>
            </div>

            <div class="profile-menu-item">
                <div class="p-menu-icon blue-sky">🔔</div>
                <div class="p-menu-text">
                    <h4>Notifikasi Belajar</h4>
                    <p>Atur pengingat & alarm belajar</p>
                </div>
                <span class="p-arrow">›</span>
            </div>

            <div class="profile-menu-item">
                <div class="p-menu-icon blue-border">✔️</div>
                <div class="p-menu-text">
                    <h4>Hubungi Bantuan</h4>
                    <p>Layanan support bantuan teknis</p>
                </div>
                <span class="p-arrow">›</span>
            </div>

            <!-- TOMBOL KELUAR -->
            <div class="profile-menu-item logout" onclick="logoutAccount()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' ') logoutAccount()">
                <div class="p-menu-icon red-light">✔️</div>
                <div class="p-menu-text">
                    <h4 class="red-text">Keluar Akun</h4>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- PENGATURAN AKUN -->
<section id="account-settings" class="screen hidden account-settings-screen">
    <div class="feature-header">
        <div class="back-button" onclick="showPage('profile')">‹</div>
        <h2>Pengaturan Akun</h2>
    </div>
    <div class="account-settings-container">
        <div class="account-settings-card">
            <h3>Informasi Profil</h3>
            <p class="settings-description">Perbarui nama yang ditampilkan pada akun EduMath.</p>
            <form id="profile-settings-form" onsubmit="saveProfileSettings(event)">
                <label for="settings-name">Nama lengkap</label>
                <input id="settings-name" name="name" type="text" minlength="2" maxlength="100" autocomplete="name" required>
                <label for="settings-email">Email akun</label>
                <input id="settings-email" type="email" disabled>
                <p class="settings-hint">Email tidak dapat diubah dari halaman ini.</p>
                <button class="settings-primary-button" type="submit">Simpan Profil</button>
            </form>
            <p id="profile-settings-message" class="settings-message" aria-live="polite"></p>
        </div>
        <div class="account-settings-card">
            <h3>Keamanan Kata Sandi</h3>
            <p class="settings-description">Gunakan kata sandi minimal 8 karakter.</p>
            <form id="password-settings-form" onsubmit="savePasswordSettings(event)">
                <label for="current-password">Kata sandi saat ini</label>
                <input id="current-password" name="current_password" type="password" autocomplete="current-password" required>
                <label for="new-password">Kata sandi baru</label>
                <input id="new-password" name="password" type="password" minlength="8" autocomplete="new-password" required>
                <label for="confirm-password">Ulangi kata sandi baru</label>
                <input id="confirm-password" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" required>
                <button class="settings-primary-button" type="submit">Ubah Kata Sandi</button>
            </form>
            <p id="password-settings-message" class="settings-message" aria-live="polite"></p>
        </div>
    </div>
</section>

    <!-- PASTE KODEMU TEPAT DI SINI -->
    <!-- HALAMAN BELAJAR DENGAN AI: PILIH KELAS DAN SEMESTER -->
    <section id="belajar-ai" class="screen feature-screen hidden">
        <div class="ba-header">
            <div class="back-button" onclick="showPage('edubot')" aria-label="Kembali">‹</div>
            <div><h2>Belajar dengan AI</h2><p>Pilih kelas dan semester untuk mulai belajar.</p></div>
        </div>
        <div class="ba-content">
            <div class="ba-section-heading"><div><span class="ba-eyebrow">KURIKULUM SD</span><h3>Pilih Kelas</h3></div><span class="ba-active-note">Kelas 3 aktif</span></div>
            <div class="ba-class-grid">
                <button type="button" class="ba-class-card is-locked" disabled aria-disabled="true"><span class="ba-class-number">1</span><strong>Kelas 1</strong><small>Belum tersedia</small><span class="ba-lock">🔒</span></button>
                <button type="button" class="ba-class-card is-locked" disabled aria-disabled="true"><span class="ba-class-number">2</span><strong>Kelas 2</strong><small>Belum tersedia</small><span class="ba-lock">🔒</span></button>
                <button type="button" class="ba-class-card is-active" aria-current="true"><span class="ba-class-number">3</span><strong>Kelas 3</strong><small>Kelas aktif</small><span class="ba-check">✓</span></button>
                <button type="button" class="ba-class-card is-locked" disabled aria-disabled="true"><span class="ba-class-number">4</span><strong>Kelas 4</strong><small>Belum tersedia</small><span class="ba-lock">🔒</span></button>
                <button type="button" class="ba-class-card is-locked" disabled aria-disabled="true"><span class="ba-class-number">5</span><strong>Kelas 5</strong><small>Belum tersedia</small><span class="ba-lock">🔒</span></button>
                <button type="button" class="ba-class-card is-locked" disabled aria-disabled="true"><span class="ba-class-number">6</span><strong>Kelas 6</strong><small>Belum tersedia</small><span class="ba-lock">🔒</span></button>
            </div>
            <div class="ba-section-heading ba-semester-heading"><div><span class="ba-eyebrow">KELAS TERPILIH</span><h3>Kelas 3 <span>· Pilih Semester</span></h3></div></div>
            <div class="ba-semester-grid">
                <button type="button" class="ba-semester-card" onclick="setKelas3Semester(1); showPage('detail-kursus')"><span class="ba-semester-icon ba-blue">📘</span><span class="ba-semester-copy"><strong>Semester 1</strong><small>Materi, latihan, dan bantuan AI</small><span class="ba-semester-tag">Buka materi →</span></span></button>
                <button type="button" class="ba-semester-card" onclick="setKelas3Semester(2); showPage('detail-kursus')"><span class="ba-semester-icon ba-purple">📚</span><span class="ba-semester-copy"><strong>Semester 2</strong><small>Materi, latihan, dan bantuan AI</small><span class="ba-semester-tag">Buka materi →</span></span></button>
            </div>
            <p class="ba-note">Materi Kelas 3 akan ditambahkan secara bertahap. Kelas lain akan dibuka setelah materinya siap.</p>
        </div>
    </section>
<!-- TANYA AI CHAT PAGE -->
    <section id="tanya-ai" class="screen hidden">

        <!-- HEADER CHAT -->
        <div class="chat-header">
            <div class="back-button" onclick="showPage('edubot')">‹</div>
            <div class="chat-user-info">
                <div class="chat-avatar">🤖</div>
                <div>
                    <h4>EduBot AI</h4>
                    <span class="status-online">Aktif & Online</span>
                </div>
            </div>
            <div class="chat-settings">⚙️</div>
        </div>

        <!-- AREA PESAN / CHAT BODY -->
        <div class="chat-body">

            <!-- PESAN DARI USER -->
            <div class="chat-bubble user">
                <p>EduBot, jelaskan apa perbedaan antara gaya magnet dan gaya gravitasi secara sederhana dong!</p>
                <span class="chat-time">09:42</span>
            </div>

            <!-- PESAN DARI BOT -->
            <div class="chat-bubble-container bot">
                <div class="bot-icon">🤖</div>
                <div class="chat-bubble bot">
                    <h4>EduBot</h4>
                    <p>Tentu! Gini ya:</p>
                    <ol>
                        <li><b>Gaya Gravitasi</b> itu selalu menarik semua benda ke pusat bumi. Mirip seperti mangga jatuh dari pohonnya.</li>
                        <li><b>Gaya Magnet</b> hanya bekerja pada benda logam tertentu (bisa tarik-menarik atau tolak-menolak).</li>
                    </ol>
                    <span class="chat-time">09:43</span>
                </div>
            </div>

        </div>

        <!-- INPUT CHAT (BAR BAWAH) -->
        <div class="chat-input-area">
            <input type="text" placeholder="Ketik pertanyaanmu di sini...">
            <button class="send-btn">➤</button>
        </div>

    </section>
    <!-- JADWAL PAGE (PENJADWALAN KURSUS / DETAIL KURSUS) -->
    <section id="jadwal" class="screen feature-screen hidden">

        <!-- HEADER BIRU + KARTU KURSUS -->
        <header class="jd-hero">
            <div class="jd-hero-inner">

                <div class="jd-topbar">
                    <button type="button" class="jd-back" onclick="showPage('edubot')" aria-label="Kembali">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M12.5 4.5L7 10l5.5 5.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <h2>Detail Kursus</h2>
                </div>

                <div class="jd-course-card hidden">
                    <div class="jd-course-top">
                        <h3>Matematika Dasar Kelas 3</h3>
                        <span class="jd-count">12/16</span>
                    </div>
                    <p class="jd-course-sub">Bilangan Cacah</p>
                    <div class="jd-progress" role="progressbar" aria-label="Progres kursus" aria-valuemin="0" aria-valuemax="100" aria-valuenow="75">
                        <span style="width: 75%;"></span>
                    </div>
                    <span class="jd-progress-label">75% Selesai</span>
                </div>

            </div>
        </header>

        <div class="jd-body">

            <div id="legacy-course-controls" hidden>
            <!-- DESKRIPSI -->
            <p class="jd-label">Deskripsi Pelajaran</p>
            <p class="jd-desc">
                Materi ini mencakup konsep dasar aljabar, termasuk persamaan linear
                dan ketidaksamaan, serta pengenalan geometri dasar seperti bentuk
                dan perhitungan area. Anda juga akan mempelajari dasar-dasar logika
                matematika.
            </p>

            <!-- WAKTU BELAJAR -->
            <h3 class="jd-heading">Waktu Belajar</h3>
            <div class="jd-card">

                <!-- PILIH HARI (tanggalnya diisi otomatis oleh script.js sesuai minggu ini) -->
                <div class="jd-days" role="group" aria-label="Hari belajar">
                    <button type="button" class="jd-day" data-day="0" aria-pressed="false"><span class="jd-day-name">Senin</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="1" aria-pressed="false"><span class="jd-day-name">Selasa</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="2" aria-pressed="false"><span class="jd-day-name">Rabu</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="3" aria-pressed="false"><span class="jd-day-name">Kamis</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="4" aria-pressed="false"><span class="jd-day-name">Jumat</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="5" aria-pressed="false"><span class="jd-day-name">Sabtu</span><b class="jd-day-num"></b></button>
                    <button type="button" class="jd-day" data-day="6" aria-pressed="false"><span class="jd-day-name">Minggu</span><b class="jd-day-num"></b></button>
                </div>

                <!-- JAM BELAJAR -->
                <div class="jd-time-row">

                    <div class="jd-time-pill">
                        <button type="button" class="jd-step" id="jd-start-minus" aria-label="Majukan jam mulai 15 menit lebih awal">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M3 7h8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <label class="jd-time-field is-start">
                            <span id="jd-start-text">14:00</span>
                            <input type="time" id="jd-start" value="14:00" aria-label="Jam mulai belajar">
                        </label>
                    </div>

                    <span class="jd-time-sep" aria-hidden="true">-</span>

                    <div class="jd-time-pill">
                        <label class="jd-time-field is-end">
                            <span id="jd-end-text">15:00</span>
                            <input type="time" id="jd-end" value="15:00" aria-label="Jam selesai belajar">
                        </label>
                        <button type="button" class="jd-step jd-updown" id="jd-end-step" aria-label="Ubah jam selesai (atas: tambah 15 menit, bawah: kurangi 15 menit)">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M4.5 6.2L8 2.7l3.5 3.5M4.5 9.8L8 13.3l3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- PENGATURAN JADWAL -->
            <h3 class="jd-heading">Pengaturan Jadwal</h3>
            <div class="jd-card">
                <label class="jd-field-label" for="jd-freq">Frekuensi Belajar</label>
                <div class="jd-freq-row">
                    <div class="jd-select">
                        <select id="jd-freq">
                            <option value="setiap-hari">Setiap Hari</option>
                            <option value="hari-kerja">Hari Kerja (Sen–Jum)</option>
                            <option value="akhir-pekan">Akhir Pekan (Sab–Min)</option>
                            <option value="pilihan">Pilih Sendiri</option>
                        </select>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <button type="button" class="jd-change" id="jd-save">Ubah Jadwal</button>
                </div>
            </div>

            </div>

            <!-- JADWAL KHUSUS: tanggal, materi, durasi, dan pengingat email -->
            <h3 class="jd-heading">Buat Jadwal Belajar</h3>
            <div class="jd-card jd-extra-card">
                <div class="jd-extra-grid">
                    <label class="jd-extra-field">Tanggal dan jam mulai
                        <input type="datetime-local" id="study-starts-at" required>
                    </label>
                    <label class="jd-extra-field">Semester
                        <select id="study-semester"><option value="1">Semester 1 · Penjumlahan & Pengurangan</option><option value="2">Semester 2 · Perkalian & Pembagian</option></select>
                    </label>
                    <label class="jd-extra-field">Materi yang dipelajari
                        <select id="study-material"><option>Penjumlahan</option><option>Pengurangan</option><option>Soal Cerita Penjumlahan dan Pengurangan</option></select>
                    </label>
                    <label class="jd-extra-field">Durasi belajar
                        <select id="study-duration"><option value="15">15 menit</option><option value="30" selected>30 menit</option><option value="45">45 menit</option><option value="60">60 menit</option><option value="90">90 menit</option><option value="120">120 menit</option></select>
                    </label>
                    <label class="jd-extra-field">Email pengingat (Gmail atau email lain)
                        <input type="email" id="study-reminder-email" placeholder="nama@gmail.com" required>
                    </label>
                    <label class="jd-extra-field">Kirim pengingat
                        <select id="study-reminder-minutes"><option value="5">5 menit sebelumnya</option><option value="10">10 menit sebelumnya</option><option value="15" selected>15 menit sebelumnya</option><option value="30">30 menit sebelumnya</option><option value="60">1 jam sebelumnya</option></select>
                    </label>
                </div>
                <button type="button" class="jd-change jd-save-study" id="study-schedule-save">Simpan Jadwal</button>
                <p id="study-schedule-status" class="jd-desc" role="status" aria-live="polite"></p>
            </div>
            <h3 class="jd-heading">Jadwal Mendatang</h3>
            <div class="jd-card" id="study-schedule-list"><p class="jd-desc">Jadwal yang disimpan akan muncul di sini setelah akun terhubung.</p></div>

            <!-- TOMBOL MULAI -->
            <button type="button" class="jd-start" onclick="showPage('detail-kursus')">MULAI</button>

        </div>

        <!-- PESAN SINGKAT (TOAST) -->
        <div class="jd-toast" id="jd-toast" role="status" aria-live="polite"></div>

    </section>
    <!-- DETAIL KURSUS PAGE -->
    <section id="detail-kursus" class="screen feature-screen hidden">

        <!-- HEADER -->
        <div class="dk-header">
            <!-- Tombol back kembali ke halaman Kursus Saya (belajar-ai) -->
            <div class="back-button" onclick="showPage('belajar-ai')">‹</div>
            <h2 id="kelas3-course-title">Matematika Kelas 3 · Semester 1</h2>
        </div>

        <div class="dk-content">

            <!-- KARTU PROGRES BIRU -->
            <div class="dk-progress-card">          
            <div class="dk-circle-progress" id="kelas3-progress-circle" style="--progress: 0%;">
                <span id="kelas3-progress-percent">0%</span>
            </div>
                <div class="dk-progress-text">
                    <h3>Progres Belajar</h3>
                    <p id="kelas3-course-progress">Materi tersedia untuk dipelajari</p>
                </div>
            </div>

            <!-- TABS MENU -->
            <div class="dk-tabs">
                <div class="dk-tab active">Materi</div>
                <div class="dk-tab">Kuis</div>
            </div>

            <!-- DAFTAR MATERI (BAB) -->
            <div class="dk-module-list" id="kelas3-module-list"></div>

            </div>
        </div>

    </section>
    <!-- HALAMAN MATERI PAGE -->
    <section id="halaman-materi" class="screen feature-screen hidden">

        <!-- HEADER -->
        <div class="hm-header">
            <div class="back-button" onclick="showPage('detail-kursus')">‹</div>
            <h2 id="kelas3-lesson-header">Bab 1: Pertambahan</h2>
        </div>

        <div class="hm-content">

            <!-- VIDEO PLACEHOLDER -->
            <div class="hm-video-box">
                <div class="hm-play-btn">▶</div>
            </div>

            <!-- JUDUL -->
            <div class="hm-title-section">
                <h3 id="kelas3-lesson-title">Pertambahan</h3>
                <p>Aljabar & Geometri Dasar</p>
            </div>

            <!-- RINGKASAN MATERI -->
            <div class="hm-text-section">
                <h4>Ringkasan Materi</h4>
                <p id="kelas3-lesson-summary">Pertambahan adalah operasi matematika untuk menggabungkan dua bilangan atau lebih. Contoh: 125 + 243 = 368.</p>
            </div>

            <!-- POIN PENTING BELAJAR -->
            <div class="hm-text-section">
                <h4>Poin Penting Belajar</h4>
                <ul id="kelas3-lesson-points">
                    <li>Susun angka berdasarkan nilai tempat.</li>
                    <li>Jumlahkan satuan, puluhan, lalu ratusan.</li>
                    <li>Periksa kembali hasil pertambahan.</li>
                </ul>
            </div>

        </div>

        <!-- TOMBOL MULAI KUIS (BAR BAWAH) -->
        <div class="hm-bottom-bar">
            <button class="hm-btn-primary" onclick="showPage('halaman-kuis')">Mulai Kuis ➔</button>
        </div>

    </section>
    <!-- HALAMAN KUIS PAGE -->
    <section id="halaman-kuis" class="screen feature-screen hidden">

        <!-- HEADER -->
        <div class="hk-header">
            <div class="back-button" onclick="showPage('halaman-materi')">‹</div>
            <h2>Kuis Bab 3</h2>
            <span class="hk-progress-text">Soal 2 dari 5</span>
        </div>

        <!-- PROGRESS BAR ATAS -->
        <div class="hk-progress-bar-container">
            <div class="hk-progress-bar-fill" style="width: 40%;"></div>
        </div>

        <div class="hk-content">

            <!-- KARTU PERTANYAAN -->
            <div class="hk-question-card">
                <span class="hk-question-label">PERTANYAAN</span>
                <h3>Berapakah jumlah sudut dalam segitiga?</h3>
            </div>

            <!-- PILIHAN JAWABAN -->
            <div class="hk-options">

                <div class="hk-option">
                    <div class="hk-radio"></div>
                    <span>A. 90°</span>
                </div>

                <!-- PILIHAN B: AKTIF/TERPILIH -->
                <div class="hk-option active">
                    <div class="hk-radio"><div class="hk-radio-inner"></div></div>
                    <span>B. 180°</span>
                </div>

                <div class="hk-option">
                    <div class="hk-radio"></div>
                    <span>C. 270°</span>
                </div>

                <div class="hk-option">
                    <div class="hk-radio"></div>
                    <span>D. 360°</span>
                </div>

            </div>

        </div>

        <!-- TOMBOL SELANJUTNYA (BAR BAWAH) -->
        <div class="hk-bottom-bar">
            <button class="hk-btn-primary">Selanjutnya ➔</button>
        </div>

    </section>

    <script src="script.js"></script>

    <script src="{{ asset('study-schedule.js') }}"></script>
</body>
</html>
