# Veridian Solutions - Dynamic Data Analysis & Architecture

## 1. Dynamic Data Summary

Based on the analysis of the provided HTML templates (`index.html`, `about/`, `services/`, `portfolio/`, `blog/`), the following areas require dynamic management via a CMS:

### Global Elements
- **General Settings:** Site title, logo, tagline, contact info (phone, email, address), social media links.
- **Navigation:** Main menu items, ordering, and hierarchy.
- **Footer:** Quick links, service links (dynamic based on active services), copyright text.
- **Language Switcher:** Active languages and default language.

### Content Sections
- **Hero Section:** Slider images/video, headlines, subheadlines, CTA buttons, and key statistics (e.g., "Languages Supported").
- **About Us:**
  - Company Overview (Title, Content, Images).
  - Mission, Vision, Core Values cards.
  - "Years of Experience" badge.
  - Company Timeline/Milestones.
  - Certifications & Awards.
- **Services:**
  - Service listing (Cards with icons/images, titles, short descriptions).
  - Service details (Full description, features list, benefits, pricing tiers, FAQs per service).
- **Portfolio/Case Studies:**
  - Project listing (filterable by category).
  - Project details (Title, Client, Date, Challenge, Solution, Result, Gallery, Technologies used).
- **Team:** Member profiles (Name, Role, Bio, Image, Social links, specialized languages).
- **Testimonials:** Client quotes, ratings, client name, position/company, photo.
- **Blog:** Posts, Categories, Tags, Author info, Comments (optional).
- **Inquiries:** Contact form submissions, Newsletter subscribers.

---

## 2. Database Schema Design (MySQL)

We will use a normalized schema with a dedicated **Translation Approach** for multi-language support.
**Strategy:** Tables containing translatable data will have a corresponding `_translations` table (e.g., `services` -> `service_translations`).

### Core System
- **users:** `id`, `name`, `email`, `password`, `role` (admin, editor), `created_at`, `updated_at`
- **languages:** `id`, `name` (English), `code` (en), `flag_icon`, `is_default`, `is_active`
- **settings:** `id`, `key`, `value` (For non-translatable global settings)
- **setting_translations:** `id`, `setting_id`, `locale`, `value` (For translatable global strings like Tagline)

### CMS Content Tables

#### 1. Hero & content Blocks
- **sliders:** `id`, `image_path`, `order`, `is_active`
  - **slider_translations:** `id`, `slider_id`, `locale`, `title`, `subtitle`, `button_text`, `button_link`
- **stats:** `id`, `icon`, `value`, `suffix`, `order`
  - **stat_translations:** `id`, `stat_id`, `locale`, `title`

#### 2. About Section
- **milestones:** `id`, `year`, `order`
  - **milestone_translations:** `id`, `milestone_id`, `locale`, `title`, `description`
- **values:** `id`, `icon`, `order`
  - **value_translations:** `id`, `value_id`, `locale`, `title`, `description`

#### 3. Services
- **services:** `id`, `slug`, `icon`, `image_path`, `is_active`, `order`
  - **service_translations:** `id`, `service_id`, `locale`, `name`, `short_description`, `description`, `meta_title`, `meta_desc`
- **service_features:** `id`, `service_id`, `icon`, `order`
  - **service_feature_translations:** `id`, `service_feature_id`, `locale`, `title`, `description`

#### 4. Portfolio
- **project_categories:** `id`, `slug`
  - **project_category_translations:** `id`, `category_id`, `locale`, `name`
- **projects:** `id`, `category_id`, `slug`, `client`, `completion_date`, `image_main`, `is_featured`
  - **project_translations:** `id`, `project_id`, `locale`, `title`, `description` (challenge/solution/result), `tags`
- **project_images:** `id`, `project_id`, `image_path`, `caption`

#### 5. Team & Testimonials
- **team_members:** `id`, `image_path`, `order`, `facebook`, `linkedin`, `twitter`
  - **team_member_translations:** `id`, `team_member_id`, `locale`, `name`, `role`, `bio`
- **testimonials:** `id`, `image_path`, `rating` (1-5), `order`
  - **testimonial_translations:** `id`, `testimonial_id`, `locale`, `client_name`, `client_position`, `content`

#### 6. Blog
- **blog_categories:** `id`, `slug`
  - **blog_category_translations:** `id`, `category_id`, `locale`, `name`
- **blog_posts:** `id`, `category_id`, `author_id`, `slug`, `image_path`, `published_at`, `status`
  - **blog_post_translations:** `id`, `post_id`, `locale`, `title`, `excerpt`, `content`

#### 7. Inquiries
- **contacts:** `id`, `name`, `email`, `subject`, `service_interest`, `message`, `created_at`
- **newsletter_subscribers:** `id`, `email`, `created_at`

---

## 3. CMS Menu Structure

The Admin Dashboard will be organized as follows:

1.  **Dashboard** (Overview of stats: unread messages, total posts, visitor stats)
2.  **Inquiries**
    *   Messages (Contact Form)
    *   Subscribers
3.  **Pages & Sections**
    *   Hero Sliders
    *   About Us (Manage content, Milestones, Values)
    *   Stats / Counter
4.  **Services Management**
    *   All Services
    *   Add New Service
5.  **Portfolio**
    *   Projects
    *   Categories
6.  **Team & Testimonials**
    *   Team Members
    *   Client Testimonials
7.  **Blog**
    *   Posts
    *   Categories
8.  **System Settings**
    *   General Information (Logo, SEO defaults, Contact Info)
    *   Languages (Add/Edit supported languages)
    *   Social Media Links
    *   User Management (Admins)

---

## 4. Multi-language Implementation Strategy

We will implement a robust internationalization (i18n) strategy using Laravel.

### 1. Database Level (`_translations` tables)
We will use the **Astrotomic/laravel-translatable** package pattern (or similar manual implementation).
- **Core Model:** (`Service`) stores language-agnostic data (images, dates, boolean flags).
- **Translation Model:** (`ServiceTranslation`) stores language-specific data (title, description).
- This allows searching and filtering by translated content easily and supports adding unlimited languages without schema changes.

### 2. Application Logic
- **Middleware:** A `SetLocale` middleware will detect the current language from the URL segment (e.g., `domain.com/en/about` vs `domain.com/id/about`) or session/cookie, and set the Laravel App Locale `app()->setLocale($locale)`.
- **Fallback:** If content is missing in the requested language, the system will fall back to the default language (English) to prevent empty pages.

### 3. Frontend Integration
- **Route Prefixing:** All frontend routes will be prefixed optionally with the locale: `Route::group(['prefix' => '{locale?}'], ...)`
- **Language Switcher:** A dynamic component that lists all 'active' languages from the database. Switching languages preserves the current route (e.g., switching from `/en/services` redirects to `/id/services`).

### 4. Admin Interface
- **Tabs for Languages:** In the CMS forms (Create/Edit), fields that are translatable will be organized in Tabs (one for each active language).
- Example:
  - **Input:** `Name (EN)` | `Name (ID)`
  - **Input:** `Description (EN)` | `Description (ID)`
- This ensures admins are reminded to fill in content for all matching languages.

---

## 5. Detailed Database Schema Specification

This section provides a comprehensive breakdown of the proposed database tables, including column types, descriptions, and example data.

### 5.1 Core System

#### `users`
*Stores administrative users who can access the CMS.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | AI | Primary Key |
| `name` | VARCHAR(255) | - | Full name of the user |
| `email` | VARCHAR(255) | - | Unique email for login |
| `password` | VARCHAR(255) | - | Hashed password (Bcrypt) |
| `role` | VARCHAR(20) | 'admin' | Role: 'admin' or 'editor' |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Update timestamp |

**Example Data:**
```json
{ "id": 1, "name": "Admin User", "email": "admin@veridian.com", "role": "admin" }
```

#### `languages`
*Defines which languages are supported by the system.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | AI | Primary Key |
| `name` | VARCHAR(50) | - | Language name (e.g., English) |
| `code` | VARCHAR(10) | - | ISO Code (en, id, fr) |
| `flag_icon` | VARCHAR(50) | NULL | Class name for flag icon |
| `is_default` | BOOLEAN | 0 | 1 = Default system language |
| `is_active` | BOOLEAN | 1 | 1 = Visible on frontend |

**Example Data:**
```json
[
  { "id": 1, "name": "English", "code": "en", "is_default": 1 },
  { "id": 2, "name": "Indonesian", "code": "id", "is_default": 0 }
]
```

### 5.2 Content Management

#### `services`
*Main table for services (language-agnostic data).*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | AI | Primary Key |
| `slug` | VARCHAR(255) | - | URL friendly identifier (unique) |
| `icon` | VARCHAR(50) | NULL | Bootstrap/FontAwesome icon class |
| `image_path` | VARCHAR(255) | NULL | Path to featured image |
| `is_active` | BOOLEAN | 1 | Visibility status |
| `order` | INT | 0 | Display order |

**Example Data:**
```json
{ "id": 1, "slug": "document-translation", "icon": "bi-file-text", "is_active": 1 }
```

#### `service_translations`
*Translatable content for services.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | AI | Primary Key |
| `service_id` | BIGINT UNSIGNED | - | Foreign Key -> services.id |
| `locale` | VARCHAR(10) | - | Language code (en, id) |
| `name` | VARCHAR(255) | - | Service Name |
| `short_description` | TEXT | NULL | Brief summary for cards |
| `description` | LONGTEXT | NULL | Full HTML content |
| `meta_title` | VARCHAR(255) | NULL | SEO Title |
| `meta_desc` | TEXT | NULL | SEO Description |

**Example Data:**
```json
[
  { "service_id": 1, "locale": "en", "name": "Document Translation", "short_description": "Accurate docs..." },
  { "service_id": 1, "locale": "id", "name": "Terjemahan Dokumen", "short_description": "Dokumen akurat..." }
]
```

#### `slider_translations` (and `sliders`)
*Hero section sliders.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `title` | VARCHAR(255) | - | Main headline |
| `subtitle` | TEXT | NULL | Sub-headline text |
| `button_text` | VARCHAR(50) | NULL | CTA Button label |
| `button_link` | VARCHAR(255) | NULL | CTA Button URL/Anchor |

**Example Data:**
```json
{ "locale": "en", "title": "Breaking Language Barriers", "button_text": "Get Started" }
```

#### `projects` (Portfolio)
*Portfolio items.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | AI | Primary Key |
| `category_id` | BIGINT UNSIGNED | - | FK -> project_categories |
| `slug` | VARCHAR(255) | - | URL slug |
| `client` | VARCHAR(255) | NULL | Client Name |
| `completion_date` | DATE | NULL | Project date |
| `image_main` | VARCHAR(255) | - | Main thumbnail |

**Example Data:**
```json
{ "id": 5, "slug": "legal-trans-xyz", "client": "XYZ Corp", "completion_date": "2024-02-01" }
```

#### `project_translations`
*Translatable details for portfolio items.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `title` | VARCHAR(255) | - | Project Title |
| `description` | LONGTEXT | - | Case study details |
| `challenge` | TEXT | NULL | The Challenge section |
| `solution` | TEXT | NULL | The Solution section |
| `tags` | VARCHAR(255) | NULL | CSV of tags (e.g. "Legal, Urgent") |

#### `team_members`
*Team profiles.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `image_path` | VARCHAR(255) | - | Profile photo |
| `social_links` | JSON | NULL | JSON of social URLs |
| `order` | INT | 0 | Display order |

#### `team_member_translations`
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `name` | VARCHAR(255) | - | Name (could be localized if needed) |
| `role` | VARCHAR(100) | - | Job Title (e.g. Senior Translator) |
| `bio` | TEXT | NULL | Biography |

#### `testimonials`
*Customer testimonials.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `image_path` | VARCHAR(255) | NULL | Client photo |
| `rating` | TINYINT | 5 | 1-5 Star rating |

#### `testimonial_translations`
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `client_name` | VARCHAR(255) | - | Name of reviewer |
| `client_position` | VARCHAR(255) | - | Job Title / Company |
| `content` | TEXT | - | The testimonial text |

#### `blog_posts`
*News and Articles.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `author_id` | BIGINT UNSIGNED | - | FK -> users.id |
| `category_id` | BIGINT UNSIGNED | - | FK -> blog_categories.id |
| `published_at` | TIMESTAMP | NULL | Schedule publish time |
| `status` | ENUM | 'draft' | 'draft', 'published' |

#### `blog_post_translations`
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `title` | VARCHAR(255) | - | Post Title |
| `excerpt` | TEXT | NULL | Short plain-text summary |
| `content` | LONGTEXT | - | Full HTML article content |
    
### 5.3 Communication

#### `contacts`
*Inquiry form submissions.*
| Column | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `name` | VARCHAR(255) | - | Sender Name |
| `email` | VARCHAR(255) | - | Sender Email |
| `subject` | VARCHAR(255) | NULL | Message Subject |
| `service_interest` | VARCHAR(50) | NULL | Selected Service (dropdown) |
| `message` | TEXT | - | Full message body |
| `created_at` | TIMESTAMP | NOW | Submission time |

---
*Note: All `id` columns are Primary Keys. Use Foreign Key constraints with `ON DELETE CASCADE` for translations to ensure cleanup.*
