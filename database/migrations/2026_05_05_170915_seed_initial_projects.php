<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('project_images')->delete();
        DB::table('projects')->delete();

        $bgs = [
            'bg-gradient-to-br from-violet-900 to-purple-900',
            'bg-gradient-to-br from-cyan-900 to-blue-900',
            'bg-gradient-to-br from-emerald-900 to-teal-900',
            'bg-gradient-to-br from-amber-900 to-orange-900',
            'bg-gradient-to-br from-pink-900 to-rose-900',
            'bg-gradient-to-br from-indigo-900 to-violet-900',
            'bg-gradient-to-br from-cyan-900 to-blue-900',
        ];

        $projects = [
            [
                'title'    => 'Ayoda CRM',
                'desc'     => 'Sistem CRM (Customer Relationship Management) berbasis web untuk mengelola data pelanggan, pipeline penjualan, dan aktivitas tim secara terpusat.',
                'tags'     => json_encode(['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Bootstrap']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 1,
                'images'   => ['AYODA_CRM', ['1.png','2.png','3.png','4.png','5.png']],
            ],
            [
                'title'    => 'Company Profile',
                'desc'     => 'Website company profile modern yang menampilkan profil perusahaan, layanan, portofolio, dan informasi kontak dengan tampilan responsif.',
                'tags'     => json_encode(['PHP', 'Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'MySQL']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 2,
                'images'   => ['COMPANY_PROFILE', ['1.png','2.png','3.png','4.png']],
            ],
            [
                'title'    => 'ERP System',
                'desc'     => 'Sistem ERP (Enterprise Resource Planning) untuk manajemen inventori, pembelian, penjualan, dan laporan keuangan dalam satu platform terintegrasi.',
                'tags'     => json_encode(['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'jQuery']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 3,
                'images'   => ['ERP', ['1.png','2.png','3.png','4.png','5.png']],
            ],
            [
                'title'    => 'SMRT QC',
                'desc'     => 'Aplikasi Smart Quality Control untuk monitoring dan pelaporan quality check produksi secara real-time di lingkungan industri manufaktur.',
                'tags'     => json_encode(['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'JavaScript']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 4,
                'images'   => ['SMRT_QC', ['1.png','2.png','3.png','4.png','5.png']],
            ],
            [
                'title'    => 'UM Admin Dashboard',
                'desc'     => 'Dashboard admin untuk manajemen pengguna, hak akses, dan konfigurasi sistem dengan antarmuka yang bersih dan intuitif.',
                'tags'     => json_encode(['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'jQuery']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 5,
                'images'   => ['UM_ADMIN', ['1.png','2.png','3.png','4.png','5.png']],
            ],
            [
                'title'    => 'UM Mobile',
                'desc'     => 'Aplikasi mobile lintas platform untuk manajemen pengguna dengan fitur autentikasi, notifikasi push, dan sinkronisasi data real-time.',
                'tags'     => json_encode(['Flutter', 'Dart']),
                'year'     => '2024',
                'category' => 'Mobile',
                'order'    => 6,
                'images'   => ['UM_MOBILE', ['1.jpeg','2.jpeg','3.jpeg','4.jpeg','5.jpeg','6.jpeg']],
            ],
            [
                'title'    => 'UM Web',
                'desc'     => 'Aplikasi web manajemen pengguna dengan fitur CRUD lengkap, role & permission, serta laporan aktivitas pengguna yang terperinci.',
                'tags'     => json_encode(['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'JavaScript']),
                'year'     => '2024',
                'category' => 'Full Stack',
                'order'    => 7,
                'images'   => ['UM_WEB', ['1.png','2.png','3.png','4.png','5.png','6.png']],
            ],
        ];

        $now = now();

        foreach ($projects as $i => $data) {
            [$dir, $files] = $data['images'];
            unset($data['images']);

            $id = DB::table('projects')->insertGetId(array_merge($data, [
                'bg'         => $bgs[$i],
                'demo_url'   => null,
                'github_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]));

            foreach ($files as $j => $filename) {
                DB::table('project_images')->insert([
                    'project_id' => $id,
                    'path'       => "image/{$dir}/{$filename}",
                    'sort_order' => $j,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('project_images')->delete();
        DB::table('projects')->delete();
    }
};
