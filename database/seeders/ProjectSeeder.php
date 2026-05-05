<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Wipe all existing projects and images so old manually-entered data doesn't linger
        ProjectImage::query()->delete();
        Project::query()->delete();

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
                'title'      => 'Ayoda CRM',
                'desc'       => 'Sistem CRM (Customer Relationship Management) berbasis web untuk mengelola data pelanggan, pipeline penjualan, dan aktivitas tim secara terpusat.',
                'tags'       => ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Bootstrap'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 1,
                'images_dir' => 'AYODA_CRM',
            ],
            [
                'title'      => 'Company Profile',
                'desc'       => 'Website company profile modern yang menampilkan profil perusahaan, layanan, portofolio, dan informasi kontak dengan tampilan responsif.',
                'tags'       => ['PHP', 'Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'MySQL'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 2,
                'images_dir' => 'COMPANY_PROFILE',
            ],
            [
                'title'      => 'ERP System',
                'desc'       => 'Sistem ERP (Enterprise Resource Planning) untuk manajemen inventori, pembelian, penjualan, dan laporan keuangan dalam satu platform terintegrasi.',
                'tags'       => ['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'jQuery'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 3,
                'images_dir' => 'ERP',
            ],
            [
                'title'      => 'SMRT QC',
                'desc'       => 'Aplikasi Smart Quality Control untuk monitoring dan pelaporan quality check produksi secara real-time di lingkungan industri manufaktur.',
                'tags'       => ['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'JavaScript'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 4,
                'images_dir' => 'SMRT_QC',
            ],
            [
                'title'      => 'UM Admin Dashboard',
                'desc'       => 'Dashboard admin untuk manajemen pengguna, hak akses, dan konfigurasi sistem dengan antarmuka yang bersih dan intuitif.',
                'tags'       => ['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'jQuery'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 5,
                'images_dir' => 'UM_ADMIN',
            ],
            [
                'title'      => 'UM Mobile',
                'desc'       => 'Aplikasi mobile lintas platform untuk manajemen pengguna dengan fitur autentikasi, notifikasi push, dan sinkronisasi data real-time.',
                'tags'       => ['Flutter', 'Dart'],
                'year'       => '2024',
                'category'   => 'Mobile',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 6,
                'images_dir' => 'UM_MOBILE',
            ],
            [
                'title'      => 'UM Web',
                'desc'       => 'Aplikasi web manajemen pengguna dengan fitur CRUD lengkap, role & permission, serta laporan aktivitas pengguna yang terperinci.',
                'tags'       => ['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'JavaScript'],
                'year'       => '2024',
                'category'   => 'Full Stack',
                'demo_url'   => null,
                'github_url' => null,
                'order'      => 7,
                'images_dir' => 'UM_WEB',
            ],
        ];

        foreach ($projects as $i => $data) {
            $imagesDir = $data['images_dir'];
            unset($data['images_dir']);

            $project = Project::create(
                array_merge($data, ['bg' => $bgs[$i % count($bgs)]])
            );

            $sourcePath = public_path("image/{$imagesDir}");
            if (! File::isDirectory($sourcePath)) {
                continue;
            }

            $files = collect(File::files($sourcePath))->sortBy(fn($f) => $f->getFilename());

            foreach ($files as $j => $file) {
                ProjectImage::create([
                    'project_id' => $project->id,
                    'path'       => "image/{$imagesDir}/{$file->getFilename()}",
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
