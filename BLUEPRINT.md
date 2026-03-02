Berikut adalah \*\*Dokumen Spesifikasi Teknis \& Blueprint Implementasi\*\* yang lengkap. Dokumen ini dirancang khusus untuk menjadi acuan mutlak ("Source of Truth") bagi Google Antigravity dan pengembangan sistem CMS Veridian Solutions.



Dokumen ini menggabungkan arsitektur \*Multi-language Relational\*, standar keamanan \*Enterprise\*, dan \*Laravel 12 Best Practices\* tahun 2025/2026.



---



\# BLUEPRINT: Veridian Solutions - Enterprise Multi-language CMS



\*\*Target Framework:\*\* Laravel 12



\*\*Database:\*\* MySQL 8.0+



\*\*Architecture Pattern:\*\* MVC + Service Layer + Repository (Optional)



\*\*Localization Strategy:\*\* Relational Database (Main Table + Translation Table)



\*\*Primary Key Standard:\*\* Custom (`id\_{table\_name}`)



\*\*Audit Standard:\*\* Full Record (`created\_by`, `updated\_by` on every table)



---



\## 1. Prinsip \& Standar Pengembangan (Laravel 12 Best Practices)



Seluruh kode yang ditulis harus mematuhi standar berikut tanpa kecuali:



\### 1.1 Struktur \& Desain Pattern



\* \*\*Single Responsibility Principle (SRP):\*\* Controller hanya menerima request dan mengembalikan response. Logika bisnis \*\*WAJIB\*\* dipisah ke `App\\Services`.

\* \*\*Fat Models (Smart), Skinny Controllers:\*\* Logic query scope dan relasi di Model. Logic kompleks di Service.

\* \*\*Validation:\*\* Dilarang melakukan validasi di Controller. Gunakan \*\*Form Request Classes\*\* (`php artisan make:request`).

\* \*\*Atomic Transactions:\*\* Setiap operasi Create/Update/Delete yang melibatkan lebih dari satu tabel (misal: simpan Service + simpan Translation) wajib dibungkus `DB::transaction()`.



\### 1.2 Optimasi Database



\* \*\*Eager Loading:\*\* Dilarang keras membiarkan N+1 Query. Gunakan `with(\['translations', 'category'])` saat mengambil data list.

\* \*\*Chunking:\*\* Gunakan `chunk()` untuk pemrosesan data massal (misal: export subscriber).

\* \*\*Custom Primary Keys:\*\* Setiap Model harus mendefinisikan `protected $primaryKey = 'id\_nama\_tabel';`.



\### 1.3 Keamanan \& Konfigurasi



\* \*\*Config Caching:\*\* Jangan pernah memanggil `env()` di dalam Controller/Blade. Panggil via `config('app.name')`.

\* \*\*Mass Assignment Protection:\*\* Semua Model wajib mendefinisikan `$fillable` secara eksplisit.

\* \*\*Audit Trail:\*\* Menggunakan \*Trait\* khusus (`HasAuditColumns`) untuk mengisi `created\_by` dan `updated\_by` secara otomatis via Model Boot events.



---



\## 2. Skema Database (Database Schema)



Menggunakan konvensi penamaan khusus:



\* \*\*Primary Key:\*\* `id\_{nama\_tabel}` (contoh: `id\_user`, `id\_service`).

\* \*\*Foreign Key:\*\* `id\_{tabel\_referensi}` (contoh: `id\_user`, `id\_service`).

\* \*\*Audit Columns:\*\* `created\_by` (BigInt), `updated\_by` (BigInt), `created\_at`, `updated\_at`.



\### A. Core System \& Security



| Tabel | Primary Key | Kolom Penting | Keterangan |

| --- | --- | --- | --- |

| \*\*`users`\*\* | `id\_user` | `name`, `email`, `password`, `is\_active`, `last\_login\_at` | Admin pengguna CMS. |

| \*\*`languages`\*\* | `id\_language` | `name`, `code` (en, id), `icon`, `is\_default`, `is\_active` | Pusat kontrol bahasa. |

| \*\*`ip\_whitelists`\*\* | `id\_ip\_whitelist` | `ip\_address`, `label`, `is\_active`, `created\_by`, `updated\_by` | Keamanan akses admin. |

| \*\*`roles`\*\* | `id` | \*(Spatie Default)\* | Role Management. |

| \*\*`permissions`\*\* | `id` | \*(Spatie Default)\* | Permission Management. |

| \*\*`activity\_log`\*\* | `id` | \*(Spatie Default)\* | Log sistem. |



\### B. Content Modules (Pola: Main Table + Translations)



\#### 1. Services (Layanan)



\* \*\*`services`\*\*

\* PK: `id\_service`

\* Cols: `icon\_class`, `image\_main`, `sort\_order`, `is\_active`, `created\_by`, `updated\_by`.





\* \*\*`service\_translations`\*\*

\* PK: `id\_service\_translation`

\* FK: `id\_service` (cascade delete), `locale` (index).

\* Cols: `slug` (unique per locale), `name`, `short\_desc`, `content` (HTML), `meta\_title`, `meta\_desc`.







\#### 2. Portfolio (Proyek)



\* \*\*`project\_categories`\*\*

\* PK: `id\_project\_category`

\* Cols: `is\_active`, `created\_by`, `updated\_by`.





\* \*\*`project\_category\_translations`\*\*

\* PK: `id\_project\_category\_translation`

\* FK: `id\_project\_category`, `locale`.

\* Cols: `name`, `slug`.





\* \*\*`projects`\*\*

\* PK: `id\_project`

\* FK: `id\_project\_category`.

\* Cols: `client\_name`, `completion\_date`, `image\_thumbnail`, `is\_featured`, `created\_by`, `updated\_by`.





\* \*\*`project\_translations`\*\*

\* PK: `id\_project\_translation`

\* FK: `id\_project`, `locale`.

\* Cols: `slug`, `title`, `description`, `challenge`, `solution`, `result`, `meta\_title`, `meta\_desc`.







\#### 3. Blog / News



\* \*\*`blog\_categories`\*\*

\* PK: `id\_blog\_category`

\* Cols: `is\_active`, `created\_by`, `updated\_by`.





\* \*\*`blog\_category\_translations`\*\*

\* PK: `id\_blog\_category\_translation`

\* FK: `id\_blog\_category`, `locale`.

\* Cols: `name`, `slug`.





\* \*\*`blog\_posts`\*\*

\* PK: `id\_blog\_post`

\* FK: `id\_blog\_category`, `id\_author` (ref: `id\_user`).

\* Cols: `image\_featured`, `status` (draft/published), `published\_at`, `created\_by`, `updated\_by`.





\* \*\*`blog\_post\_translations`\*\*

\* PK: `id\_blog\_post\_translation`

\* FK: `id\_blog\_post`, `locale`.

\* Cols: `slug`, `title`, `excerpt`, `content` (HTML), `meta\_title`, `meta\_desc`.







\#### 4. Components (Hero, Testimoni, Team)



\*Mengikuti pola yang sama: Tabel Utama (id\_{nama}, shared data, audit) + Tabel Translations (id\_{nama}\_translation, localized data).\*



---



\## 3. Roadmap \& Fase Pengerjaan (Step-by-Step)



\### FASE 1: Foundation \& Configuration



1\. \*\*Install Laravel 12.\*\*

2\. \*\*Setup Database:\*\* Konfigurasi `.env` dan MySQL.

3\. \*\*Install Packages:\*\* `astrotomic/laravel-translatable`, `spatie/laravel-permission`, `spatie/laravel-activitylog`, `yajra/laravel-datatables`.

4\. \*\*Helper Setup:\*\* Buat Trait `HasAuditColumns` (untuk otomatis mengisi `created\_by`/`updated\_by`).



\### FASE 2: Database Architecture



1\. \*\*Migration Core:\*\* Buat migrasi `users`, `languages`, `ip\_whitelists` dengan custom PK (`id\_user`, dst).

2\. \*\*Migration Content:\*\* Buat migrasi untuk Services, Portfolio, Blog sesuai skema di atas.

3\. \*\*Model Generation:\*\* Buat Model dengan properti `$primaryKey` yang disesuaikan dan implementasi interface `Translatable`.



\### FASE 3: Logic \& Security Layer



1\. \*\*Middleware `IpWhitelistMiddleware`:\*\* Logic pengecekan IP vs Database.

2\. \*\*Middleware `LocalizationMiddleware`:\*\* Logic parsing URL `/{locale}/...`, validasi locale aktif, dan `app()->setLocale()`.

3\. \*\*Service Classes:\*\* Siapkan base structure untuk `Service/UserService`, `Service/ContentService`.



\### FASE 4: Backend CMS (Infrastructure)



1\. \*\*Auth System:\*\* Custom login page (Admin only).

2\. \*\*Layouting:\*\* Integrasi template Admin Bootstrap 5 (Blade Components: Sidebar, Navbar).

3\. \*\*Module System Settings:\*\* CRUD Bahasa (`languages`) dan IP Whitelist.

4\. \*\*Module RBAC:\*\* UI untuk assign Role \& Permission ke User.



\### FASE 5: Content Management Modules (The Core)



1\. \*\*Form Components:\*\* Buat Blade Component untuk "Translatable Tabs" (Tab EN | Tab ID) agar \*reusable\*.

2\. \*\*Services Module:\*\* CRUD Services (Transaction-based store/update).

3\. \*\*Portfolio Module:\*\* CRUD Projects \& Categories.

4\. \*\*Blog Module:\*\* CRUD Posts (Summernote Integration) \& Categories.

5\. \*\*Media Handling:\*\* Implementasi upload gambar yang aman.



\### FASE 6: Frontend Public Implementation (SEO Focused)



1\. \*\*Blade Template:\*\* Convert HTML Landing Page ke Blade (`layouts.app`, `partials.header`, dll).

2\. \*\*Routing:\*\* Define routes `Route::group(\['prefix' => '{locale}'], function() { ... })`.

3\. \*\*Controller Public:\*\* Logic `show($slug)` yang mencari data berdasarkan slug di tabel translation.

4\. \*\*SEO Tags:\*\* Inject Meta Title/Desc dan `hreflang` tags dinamis di `<head>`.



\### FASE 7: Final Optimization



1\. \*\*Caching:\*\* `php artisan config:cache`, `route:cache`.

2\. \*\*Security Audit:\*\* Tes penetrasi dasar (XSS, CSRF, Access Control).

3\. \*\*Deployment:\*\* Setup Production Server.



---



\## 4. Instruksi Teknis Khusus (Notes for AI)



Untuk setiap kode yang di-generate oleh Google Antigravity/Partner Coding, wajib:



1\. \*\*Model Definition:\*\*

```php

class Service extends Model implements TranslatableContract {

&nbsp;   use Translatable, HasAuditColumns; // Custom Trait for created\_by

&nbsp;   protected $primaryKey = 'id\_service'; // Custom PK

&nbsp;   public $translatedAttributes = \['name', 'slug', 'content', ...];

&nbsp;   protected $fillable = \['icon\_class', 'is\_active', 'created\_by', 'updated\_by'];

}



```





2\. \*\*Migration Definition:\*\*

```php

$table->id('id\_service'); // Custom PK

$table->unsignedBigInteger('created\_by')->nullable();

$table->unsignedBigInteger('updated\_by')->nullable();

// Foreign keys manually defined if not using standard naming



```





3\. \*\*Routing:\*\* Semua route public harus divalidasi regex untuk locale yang diizinkan (misal: `where('locale', '\[a-z]{2}')`).



---



Dokumen ini adalah \*\*Instruksi Kerja Tetap\*\*. Jangan menyimpang dari penamaan tabel, struktur primary key, atau prinsip arsitektur yang telah ditetapkan di sini.

