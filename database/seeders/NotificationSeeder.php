<?php

namespace Database\Seeders;

use App\Models\PushNotification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@siri.id')->first();

        $notifications = [
            [
                'title'            => 'Selamat Datang di Siri! 🎉',
                'body'             => 'Temukan berbagai layanan antar jemput, pesan makanan, dan kirim paket dengan mudah.',
                'type'             => 'system',
                'target'           => 'all',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::whereIn('role', ['user', 'driver'])->count(),
                'sent_at'          => now()->subDays(7),
            ],
            [
                'title'            => 'Promo Ramadan 50% OFF 🌙',
                'body'             => 'Dapatkan diskon 50% untuk semua pesanan makanan hari ini. Gunakan kode RAMADAN50.',
                'type'             => 'promo',
                'target'           => 'user',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::where('role', 'user')->count(),
                'sent_at'          => now()->subDays(5),
            ],
            [
                'title'            => 'Gratis Ongkir Seharian! 🛵',
                'body'             => 'Nikmati gratis ongkos kirim untuk semua layanan hari ini. Berlaku sampai pukul 23.59.',
                'type'             => 'promo',
                'target'           => 'user',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::where('role', 'user')->count(),
                'sent_at'          => now()->subDays(3),
            ],
            [
                'title'            => 'Pesanan Kamu Sedang Diproses 📦',
                'body'             => 'Driver sedang dalam perjalanan menuju lokasi penjemputan. Harap siap di lokasi.',
                'type'             => 'order_status',
                'target'           => 'user',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::where('role', 'user')->count(),
                'sent_at'          => now()->subDays(2),
            ],
            [
                'title'            => 'Ada Order Baru Untukmu! 🔔',
                'body'             => 'Terdapat pesanan baru yang menunggu untuk diambil. Cek aplikasi sekarang.',
                'type'             => 'order_status',
                'target'           => 'driver',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::where('role', 'driver')->count(),
                'sent_at'          => now()->subDay(),
            ],
            [
                'title'            => 'Update Aplikasi Tersedia ⚙️',
                'body'             => 'Versi terbaru Siri sudah tersedia. Update sekarang untuk pengalaman yang lebih baik.',
                'type'             => 'system',
                'target'           => 'all',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::whereIn('role', ['user', 'driver'])->count(),
                'sent_at'          => now()->subHours(12),
            ],
            [
                'title'            => 'Happy Hour 14.00 - 16.00 🎁',
                'body'             => 'Diskon 25% untuk semua pesanan di jam happy hour. Jangan sampai ketinggalan!',
                'type'             => 'promo',
                'target'           => 'user',
                'sent_by'          => $admin->id,
                'recipient_count'  => User::where('role', 'user')->count(),
                'sent_at'          => now()->subHours(3),
            ],
            // Draft (belum dikirim)
            [
                'title'            => 'Promo Akhir Bulan 🔥',
                'body'             => 'Cashback 20% untuk semua transaksi di akhir bulan ini.',
                'type'             => 'promo',
                'target'           => 'all',
                'sent_by'          => $admin->id,
                'recipient_count'  => 0,
                'sent_at'          => null, // draft
            ],
        ];

        foreach ($notifications as $notif) {
            PushNotification::create($notif);
        }
    }
}
