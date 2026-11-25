<?php
// This file is part of Moodle - https://moodle.org/
//
// Renders the BPSDM Jatim homepage variant inside the existing theme layout.
// The site header, footer, and the homepage-only footer block are not modified.

defined('MOODLE_INTERNAL') || die();

/**
 * Return whether the current language is English.
 *
 * @return bool
 */
function local_bpsdmhome_is_english(): bool {
    return strpos(current_language(), 'en') === 0;
}

/**
 * Return the translated static strings for the homepage.
 *
 * @param bool $en
 * @return array
 */
function local_bpsdmhome_strings(bool $en): array {
    if ($en) {
        return [
            'hero_lead' => 'A digital learning platform by BPSDM to strengthen the competence, knowledge, and professionalism of public servants through accessible and integrated learning.',
            'hero_primary' => 'View All Courses',
            'hero_secondary' => 'Explore BPSDM Channel',
            'stat_courses' => 'active courses',
            'stat_categories' => 'learning categories',
            'stat_access' => 'digital access',
            'hero_image' => 'Hero image',
            'hero_image_alt' => 'BPSDM participants learning together',
            'placeholder' => 'Placeholder',
            'profile_live' => 'BPSDM PROFILE',
            'profile_channel' => 'BPSDM JATIM TV',
            'profile_caption' => 'Corporate University SDGs facilities of BPSDM East Java',
            'profile_youtube' => 'YouTube',
            'about_kicker' => 'About BPSDM',
            'about_title' => 'BPSDM East Java Province',
            'about_copy' => 'BPSDM East Java Province delivers Corporate University (Corpu) and SDG-based training to develop public servants who are competent, professional, and people of integrity, ready to provide the best public services.',
            'about_link' => 'Explore BPSDM East Java Channel',
            'categories_kicker' => 'Explore your interests',
            'categories_title' => 'Course Categories',
            'categories_copy' => 'Strengthen your professional expertise through interactive, expert-certified course programmes.',
            'courses_kicker' => 'Best picks',
            'courses_title' => 'Our Popular Courses',
            'courses_copy' => 'The training programmes most in demand by participants. Start here to develop your competence.',
            'courses_all' => 'View all courses',
            'open_course' => 'Open course',
            'benefits_kicker' => 'Why BPSDM',
            'benefits_title' => 'Strengthen competence and professionalism with BPSDM.',
            'benefits_copy' => 'BPSDM is committed to supporting competence development through structured learning that is easy to access and aligned with participants’ needs.',
            'benefit_1_title' => 'Quality learning',
            'benefit_1_copy' => 'Develop knowledge and skills through structured and relevant learning.',
            'benefit_2_title' => 'Flexible access',
            'benefit_2_copy' => 'Study anytime and anywhere through an easy-to-use digital platform.',
            'benefit_3_title' => 'Structured certification',
            'benefit_3_copy' => 'Strengthen your competence through programmes and certifications available to public servants.',
            'benefits_image' => 'Image placeholder',
            'benefits_image_alt' => 'BPSDM participants collaborating during a training session',
            'preview' => 'Preview',
            'cta_kicker' => 'Take the next step',
            'cta_title' => 'Take your skills to the next level.',
            'cta_copy' => 'Join our training programmes and develop your professional potential for a better future.',
            'cta_button' => 'Learn More',
            'cta_image_alt' => 'BPSDM participants learning with laptops',
            'footer_about' => 'BPSDM East Java Province delivers Corporate University (Corpu) and SDG-based training to develop public servants who are competent, professional, and people of integrity, ready to provide the best public services.',
            'footer_links_title' => 'Links',
            'footer_contact_title' => 'Contact Us',
            'footer_home' => 'Home',
            'footer_knowledge' => 'Knowledge Management',
            'footer_guide' => 'User Guide',
            'footer_courses' => 'All Courses',
            'footer_services' => 'Services',
            'footer_address' => 'Jalan Balongsari Tama, Tandes, Surabaya - East Java',
            'footer_logo_alt' => 'BPSDM East Java',
            'course_fallback' => 'A structured training programme to strengthen professional competence in public service.',
        ];
    }

    return [
        'hero_lead' => 'Platform pembelajaran digital BPSDM untuk mendukung peningkatan kompetensi, pengetahuan, dan profesionalisme melalui pembelajaran yang mudah diakses dan terintegrasi.',
        'hero_primary' => 'Lihat Semua Kursus',
        'hero_secondary' => 'Jelajahi Kanal BPSDM',
        'stat_courses' => 'kursus aktif',
        'stat_categories' => 'kategori belajar',
        'stat_access' => 'akses digital',
        'hero_image' => 'Hero image',
        'hero_image_alt' => 'Peserta BPSDM belajar bersama',
        'placeholder' => 'Placeholder',
        'profile_live' => 'PROFIL BPSDM',
        'profile_channel' => 'BPSDM JATIM TV',
        'profile_caption' => 'Fasilitas Corporate University SDG\'s BPSDM Jawa Timur',
        'profile_youtube' => 'YouTube',
        'about_kicker' => 'Tentang BPSDM',
        'about_title' => 'BPSDM Provinsi Jawa Timur',
        'about_copy' => 'BPSDM Provinsi Jawa Timur menyelenggarakan pelatihan berbasis Corporate University (Corpu) dan SDGs untuk mencetak Aparatur Sipil Negara (ASN) yang kompeten, profesional, berintegritas, serta siap memberikan pelayanan publik terbaik.',
        'about_link' => 'Jelajahi Kanal BPSDM Jatim',
        'categories_kicker' => 'Jelajahi minat Anda',
        'categories_title' => 'Kategori Kursus',
        'categories_copy' => 'Tingkatkan keahlian profesional melalui program kursus interaktif bersertifikasi ahli.',
        'courses_kicker' => 'Pilihan terbaik',
        'courses_title' => 'Kursus Populer Kami',
        'courses_copy' => 'Pilihan pelatihan yang paling diminati peserta. Mulai dari sini untuk mengembangkan kompetensi Anda.',
        'courses_all' => 'Lihat semua kursus',
        'open_course' => 'Buka kursus',
        'benefits_kicker' => 'Mengapa BPSDM',
        'benefits_title' => 'Meningkatkan kompetensi dan profesionalisme bersama BPSDM.',
        'benefits_copy' => 'BPSDM berkomitmen mendukung pengembangan kompetensi melalui pembelajaran yang terstruktur, mudah diakses, dan sesuai kebutuhan peserta.',
        'benefit_1_title' => 'Pembelajaran berkualitas',
        'benefit_1_copy' => 'Kembangkan pengetahuan dan keterampilan melalui pembelajaran yang terstruktur dan relevan.',
        'benefit_2_title' => 'Akses fleksibel',
        'benefit_2_copy' => 'Belajar kapan saja dan di mana saja melalui platform digital yang mudah digunakan.',
        'benefit_3_title' => 'Sertifikasi terstruktur',
        'benefit_3_copy' => 'Tingkatkan kompetensi melalui program dan sertifikasi yang tersedia untuk ASN.',
        'benefits_image' => 'Image placeholder',
        'benefits_image_alt' => 'Peserta BPSDM berkolaborasi dalam sesi pelatihan',
        'preview' => 'Preview',
        'cta_kicker' => 'Ambil langkah selanjutnya',
        'cta_title' => 'Tingkatkan keterampilan Anda ke tingkat berikutnya.',
        'cta_copy' => 'Bergabunglah dengan program pelatihan kami dan kembangkan potensi profesional Anda untuk masa depan yang lebih baik.',
        'cta_button' => 'Info Lebih Lanjut',
        'cta_image_alt' => 'Peserta BPSDM belajar dengan laptop',
        'footer_about' => 'BPSDM Provinsi Jawa Timur menyelenggarakan pelatihan berbasis Corporate University (Corpu) dan SDGs untuk mencetak Aparatur Sipil Negara (ASN) yang kompeten, profesional, berintegritas, serta siap memberikan pelayanan publik terbaik.',
        'footer_links_title' => 'Pranala',
        'footer_contact_title' => 'Kontak Kami',
        'footer_home' => 'Beranda',
        'footer_knowledge' => 'Manajemen Pengetahuan',
        'footer_guide' => 'Buku Panduan',
        'footer_courses' => 'Semua Kursus',
        'footer_services' => 'Layanan',
        'footer_address' => 'Jalan Balongsari Tama, Tandes, Surabaya - Jawa Timur',
        'footer_logo_alt' => 'BPSDM Jawa Timur',
        'course_fallback' => 'Program pelatihan terstruktur untuk memperkuat kompetensi profesional dalam pelayanan publik.',
    ];
}

/**
 * Return the first overview image for a course, if it has one.
 *
 * @param stdClass $course
 * @return string|null
 */
function local_bpsdmhome_course_image(stdClass $course): ?string {
    $context = context_course::instance($course->id, IGNORE_MISSING);
    if (!$context) {
        return null;
    }

    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', 0, 'sortorder, itemid, filepath, filename', false);
    foreach ($files as $file) {
        if (strpos((string) $file->get_mimetype(), 'image/') !== 0) {
            continue;
        }

        return (string) moodle_url::make_pluginfile_url(
            $file->get_contextid(),
            $file->get_component(),
            $file->get_filearea(),
            null,
            $file->get_filepath(),
            $file->get_filename(),
            false
        );
    }

    return null;
}

/**
 * Short label for a course category badge.
 *
 * @param int $categoryid
 * @param string $categoryname
 * @param bool $en
 * @return string
 */
function local_bpsdmhome_category_label(int $categoryid, string $categoryname, bool $en): string {
    $labels = [
        2 => ['id' => 'Pelatihan KPK', 'en' => 'KPK Training'],
        4 => ['id' => 'Fungsional 2026', 'en' => 'Functional 2026'],
        5 => ['id' => 'Fungsional 2025', 'en' => 'Functional 2025'],
        6 => ['id' => 'Fungsional 2024', 'en' => 'Functional 2024'],
        13 => ['id' => 'PKA', 'en' => 'PKA'],
        15 => ['id' => 'Pelatihan Dasar', 'en' => 'Basic Training'],
        20 => ['id' => 'ASN Membaca', 'en' => 'ASN Reading'],
        21 => ['id' => 'ASN Berbagi Praktik Baik', 'en' => 'ASN Good Practice Sharing'],
    ];

    if (isset($labels[$categoryid])) {
        return $labels[$categoryid][$en ? 'en' : 'id'];
    }

    if (preg_match('/Fungsional.*?(20\d{2})/i', $categoryname, $matches)) {
        return ($en ? 'Functional ' : 'Fungsional ') . $matches[1];
    }

    return $categoryname;
}

/**
 * Build the homepage HTML fragment.
 *
 * @return string
 */
function local_bpsdmhome_render(): string {
    global $CFG, $DB;

    $en = local_bpsdmhome_is_english();
    $t = local_bpsdmhome_strings($en);
    $www = $CFG->wwwroot;
    $homeurl = (string) new moodle_url('/');
    $courseurl = (string) new moodle_url('/course/');
    $categoryurl = (string) new moodle_url('/course/index.php', ['categoryid' => 18]);
    $servicesurl = (string) new moodle_url('/course/index.php', ['categoryid' => 23]);
    $guideurl = 'https://drive.google.com/drive/folders/1_EnFDShAeWEWWU7MQAN9TxWkLkmsPjVm';
    $profileurl = 'https://www.youtube.com/watch?v=BoZsXNSrdJo';
    $pix = $www . '/local/bpsdmhome/pix';

    // Four most recently updated visible courses, excluding the site home.
    $sql = "SELECT c.*
              FROM {course} c
             WHERE c.visible = 1
               AND c.id <> :siteid
               AND c.category <> 0
          ORDER BY c.timemodified DESC, c.id DESC";
    $records = $DB->get_records_sql($sql, ['siteid' => SITEID], 0, 12);

    $categorynames = $DB->get_records_menu('course_categories', null, '', 'id, name');
    $courses = [];
    foreach ($records as $course) {
        $image = local_bpsdmhome_course_image($course);
        $summary = trim(strip_tags((string) format_text((string) $course->summary, (int) $course->summaryformat)));
        if ($summary === '') {
            $summary = $t['course_fallback'];
        } else {
            $summary = shorten_text($summary, 150);
        }

        $categoryname = isset($categorynames[$course->category]) ? $categorynames[$course->category] : '';
        $courselabel = local_bpsdmhome_category_label((int) $course->category, $categoryname, $en);

        $courses[] = [
            'id' => (int) $course->id,
            'title' => $course->fullname,
            'summary' => $summary,
            'image' => $image,
            'category' => $courselabel,
        ];

        if (count($courses) >= 4) {
            break;
        }
    }

    $coursecount = $DB->count_records_select('course', 'id <> ? AND visible = 1', [SITEID]);

    $categories = [
        ['id' => 2, 'icon' => 'bi-shield-check', 'idlabel' => 'Pelatihan KPK', 'enlabel' => 'KPK Training'],
        ['id' => 4, 'icon' => 'bi-journal-bookmark', 'idlabel' => 'Pelatihan Kompetensi Fungsional 2026', 'enlabel' => 'Functional Competency Training 2026'],
        ['id' => 5, 'icon' => 'bi-journal-text', 'idlabel' => 'Pelatihan Kompetensi Fungsional 2025', 'enlabel' => 'Functional Competency Training 2025'],
        ['id' => 6, 'icon' => 'bi-archive', 'idlabel' => 'Pelatihan Kompetensi Fungsional 2024', 'enlabel' => 'Functional Competency Training 2024'],
        ['id' => 13, 'icon' => 'bi-pencil-square', 'idlabel' => 'PKA', 'enlabel' => 'PKA'],
        ['id' => 15, 'icon' => 'bi-mortarboard', 'idlabel' => 'Pelatihan Dasar', 'enlabel' => 'Basic Training'],
        ['id' => 21, 'icon' => 'bi-people', 'idlabel' => 'ASN Berbagi Praktik Baik', 'enlabel' => 'ASN Good Practice Sharing'],
        ['id' => 20, 'icon' => 'bi-book', 'idlabel' => 'ASN Membaca', 'enlabel' => 'ASN Reading'],
    ];

    $html = '';
    $html .= '<style id="bpsdm-v4-styles">' . file_get_contents(__DIR__ . '/styles.css') . '</style>';
    $html .= '<div id="bpsdm-v4-home" style="display:none">';

    // Hero.
    $html .= '<section class="v4-hero" id="beranda">';
    $html .= '<div class="v4-container"><div class="v4-hero-grid">';
    $html .= '<div class="v4-hero-copy">';
    $html .= '<h1>LEGEND BOS<span>BPSDM JATIM</span></h1>';
    $html .= '<div class="v4-hero-subtitle">Learning Management and Collaborative System</div>';
    $html .= '<p class="v4-hero-lead">' . s($t['hero_lead']) . '</p>';
    $html .= '<div class="v4-actions">';
    $html .= '<a class="v4-btn v4-btn-main" href="' . s($courseurl) . '">' . s($t['hero_primary']) . ' <span>↗</span></a>';
    $html .= '<a class="v4-btn v4-btn-ghost" href="#tentang">' . s($t['hero_secondary']) . ' <span>↓</span></a>';
    $html .= '</div>';
    $html .= '<div class="v4-hero-stats">';
    $html .= '<div><strong>' . s((string) $coursecount) . '</strong><span>' . s($t['stat_courses']) . '</span></div>';
    $html .= '<div><strong>8</strong><span>' . s($t['stat_categories']) . '</span></div>';
    $html .= '<div><strong>100%</strong><span>' . s($t['stat_access']) . '</span></div>';
    $html .= '</div></div>';
    $html .= '<div class="v4-hero-visual"><img class="v4-hero-photo" src="' . s($pix . '/hero.webp') . '" alt="' . s($t['hero_image_alt']) . '"></div>';
    $html .= '</div></div></section>';

    // Profile / video.
    $html .= '<section class="v4-profile v4-section" id="tentang">';
    $html .= '<img class="v4-profile-bg" src="' . s($pix . '/profile-bg.webp') . '" alt="" aria-hidden="true">';
    $html .= '<div class="v4-container"><div class="v4-profile-grid">';
    $html .= '<div><div class="v4-profile-media"><a class="v4-profile-link" href="' . s($profileurl) . '" target="_blank" rel="noopener" aria-label="' . s($en ? 'Play the BPSDM East Java Corporate University SDGs profile video' : 'Putar video profil Corpu SDGs BPSDM Jawa Timur') . '">';
    $html .= '<img src="' . s($www . '/local/bpsdmhome/pix/profile-video.jpg') . '" alt="' . s($en ? 'BPSDM East Java Corporate University SDGs profile video' : 'Video profil Corpu SDGs BPSDM Jawa Timur') . '">';
    $html .= '<span class="v4-profile-bar"><span class="v4-live-dot"></span><strong>' . s($t['profile_live']) . '</strong><small>' . s($t['profile_channel']) . '</small></span>';
    $html .= '<span class="v4-profile-play"><i class="bi bi-play-fill" aria-hidden="true"></i></span>';
    $html .= '<span class="v4-profile-caption"><span>' . s($t['profile_caption']) . '</span><span>' . s($t['profile_youtube']) . ' ↗</span></span>';
    $html .= '</a></div></div>';
    $html .= '<div><div class="v4-kicker">' . s($t['about_kicker']) . '</div>';
    $html .= '<h2>' . s($t['about_title']) . '</h2>';
    $html .= '<p class="v4-about-copy">' . s($t['about_copy']) . '</p>';
    $html .= '<a class="v4-text-link" href="' . s($categoryurl) . '">' . s($t['about_link']) . ' <span>↗</span></a>';
    $html .= '</div></div></div></section>';

    // Categories.
    $html .= '<section class="v4-section" id="kategori">';
    $html .= '<div class="v4-container"><div class="v4-categories-head">';
    $html .= '<div class="v4-kicker">' . s($t['categories_kicker']) . '</div>';
    $html .= '<h2>' . s($t['categories_title']) . '</h2>';
    $html .= '<p>' . s($t['categories_copy']) . '</p>';
    $html .= '</div><div class="v4-category-grid">';
    foreach ($categories as $index => $category) {
        $href = (string) new moodle_url('/course/index.php', ['categoryid' => $category['id']]);
        $html .= '<a class="v4-category-card" href="' . s($href) . '">';
        $html .= '<div class="v4-category-top"><span class="v4-category-icon"><i class="bi ' . s($category['icon']) . '" aria-hidden="true"></i></span><span class="v4-category-arrow" aria-hidden="true">↗</span></div>';
        $html .= '<h3>' . s($category[$en ? 'enlabel' : 'idlabel']) . '</h3>';
        $html .= '<span class="v4-category-index">' . s(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) . '</span>';
        $html .= '</a>';
    }
    $html .= '</div></div></section>';

    // Courses.
    $html .= '<section class="v4-courses v4-section" id="kursus">';
    $html .= '<div class="v4-container"><div class="v4-courses-head">';
    $html .= '<div class="v4-courses-heading"><div class="v4-kicker">' . s($t['courses_kicker']) . '</div>';
    $html .= '<h2>' . s($t['courses_title']) . '</h2>';
    $html .= '<p>' . s($t['courses_copy']) . '</p></div>';
    $html .= '<a class="v4-courses-all" href="' . s($courseurl) . '">' . s($t['courses_all']) . ' <span>↗</span></a>';
    $html .= '</div><div class="v4-course-grid">';
    if (empty($courses)) {
        $html .= '<p style="color:#fff">' . s($en ? 'No courses are available yet.' : 'Belum ada kursus yang tersedia.') . '</p>';
    } else {
        foreach ($courses as $course) {
            $link = (string) new moodle_url('/course/view.php', ['id' => $course['id']]);
            $html .= '<a class="v4-course-card" href="' . s($link) . '">';
            $html .= '<div class="v4-course-cover">';
            if (!empty($course['image'])) {
                $html .= '<img src="' . s($course['image']) . '" alt="' . s($course['title']) . '">';
            } else {
                $html .= '<div class="v4-course-cover-fallback">' . s(mb_substr($course['title'], 0, 2)) . '</div>';
            }
            $html .= '<span class="v4-course-badge">' . s($course['category']) . '</span>';
            $html .= '</div><div class="v4-course-body">';
            $html .= '<span class="v4-course-cat">' . s($course['category']) . '</span>';
            $html .= '<h3>' . s($course['title']) . '</h3>';
            $html .= '<p>' . s($course['summary']) . '</p>';
            $html .= '<span class="v4-course-link">' . s($t['open_course']) . ' <span>↗</span></span>';
            $html .= '</div></a>';
        }
    }
    $html .= '</div></div></section>';

    // Benefits.
    $html .= '<section class="v4-benefits v4-section" id="manfaat">';
    $html .= '<div class="v4-container"><div class="v4-benefits-grid">';
    $html .= '<div class="v4-benefits-left"><div class="v4-kicker">' . s($t['benefits_kicker']) . '</div>';
    $html .= '<h2>' . s($t['benefits_title']) . '</h2>';
    $html .= '<p class="v4-section-copy">' . s($t['benefits_copy']) . '</p>';
    $html .= '<div class="v4-benefit-list">';
    $html .= '<div class="v4-benefit-item"><span class="v4-benefit-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span><div class="v4-benefit-copy"><h3>' . s($t['benefit_1_title']) . '</h3><p>' . s($t['benefit_1_copy']) . '</p></div></div>';
    $html .= '<div class="v4-benefit-item"><span class="v4-benefit-icon"><i class="bi bi-clock" aria-hidden="true"></i></span><div class="v4-benefit-copy"><h3>' . s($t['benefit_2_title']) . '</h3><p>' . s($t['benefit_2_copy']) . '</p></div></div>';
    $html .= '<div class="v4-benefit-item"><span class="v4-benefit-icon"><i class="bi bi-patch-check" aria-hidden="true"></i></span><div class="v4-benefit-copy"><h3>' . s($t['benefit_3_title']) . '</h3><p>' . s($t['benefit_3_copy']) . '</p></div></div>';
    $html .= '</div></div>';
    $html .= '<div class="v4-benefits-visual"><img class="v4-benefits-photo" src="' . s($pix . '/benefits.webp') . '" alt="' . s($t['benefits_image_alt']) . '"></div>';
    $html .= '</div></div></section>';

    // CTA.
    $html .= '<section class="v4-section" id="mulai">';
    $html .= '<div class="v4-container"><div class="v4-cta-panel"><div class="v4-cta-copy">';
    $html .= '<div class="v4-kicker">' . s($t['cta_kicker']) . '</div>';
    $html .= '<h2>' . s($t['cta_title']) . '</h2>';
    $html .= '<p>' . s($t['cta_copy']) . '</p>';
    $html .= '<a class="v4-btn v4-btn-main" href="' . s($courseurl) . '">' . s($t['cta_button']) . ' <span>↗</span></a>';
    $html .= '</div><div class="v4-cta-mark"><img class="v4-cta-photo" src="' . s($pix . '/cta.webp') . '" alt="' . s($t['cta_image_alt']) . '"></div>';
    $html .= '</div></div></section>';

    // Homepage-only big footer (the theme footer below is left untouched).
    $html .= '<section class="v4-footer" id="kontak">';
    $html .= '<div class="v4-footer-art" aria-hidden="true"><img src="' . s($pix . '/footer-bg.webp') . '" alt=""></div>';
    $html .= '<div class="v4-container"><div class="v4-footer-grid">';
    $html .= '<div class="v4-footer-brand"><a class="v4-footer-logo" href="' . s($homeurl) . '">';
    $html .= '<img src="' . s($pix . '/logo-white.svg') . '" alt="' . s($t['footer_logo_alt']) . '"></a>';
    $html .= '<p>' . s($t['footer_about']) . '</p>';
    $html .= '<div class="v4-footer-social">';
    $html .= '<a href="https://www.instagram.com/bpsdmjatim/" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>';
    $html .= '<a href="https://www.facebook.com/bpsdmjawatimur/" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>';
    $html .= '<a href="https://x.com/bpsdm_jatim" target="_blank" rel="noopener" aria-label="X"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>';
    $html .= '<a href="https://www.youtube.com/channel/UCS9pHfAZEeelx1tYtDh_ZAg" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>';
    $html .= '</div></div>';
    $html .= '<div class="v4-footer-col"><h4>' . s($t['footer_links_title']) . '</h4><ul>';
    $html .= '<li><a href="' . s($homeurl) . '">' . s($t['footer_home']) . '</a></li>';
    $html .= '<li><a href="' . s($categoryurl) . '">' . s($t['footer_knowledge']) . '</a></li>';
    $html .= '<li><a href="' . s($guideurl) . '" target="_blank" rel="noopener">' . s($t['footer_guide']) . '</a></li>';
    $html .= '<li><a href="' . s($courseurl) . '">' . s($t['footer_courses']) . '</a></li>';
    $html .= '<li><a href="' . s($servicesurl) . '">' . s($t['footer_services']) . '</a></li>';
    $html .= '</ul></div>';
    $html .= '<div class="v4-footer-col"><h4>' . s($t['footer_contact_title']) . '</h4><ul class="v4-footer-contact">';
    $html .= '<li><i class="bi bi-envelope" aria-hidden="true"></i><a href="mailto:humas-bpsdm@jatimprov.go.id">humas-bpsdm@jatimprov.go.id</a></li>';
    $html .= '<li><i class="bi bi-telephone" aria-hidden="true"></i><a href="tel:+62317412278">031-7412278</a></li>';
    $html .= '<li><i class="bi bi-geo-alt" aria-hidden="true"></i><span>' . s($t['footer_address']) . '</span></li>';
    $html .= '</ul></div>';
    $html .= '</div></div></section>';

    $html .= '</div>';
    $html .= '<script>(function(){function boot(){var node=document.getElementById("bpsdm-v4-home");var main=document.getElementById("page-content");if(!node||!main||document.body.classList.contains("bpsdm-v4-ready")){return;}var style=document.getElementById("bpsdm-v4-styles");if(style&&style.parentNode!==document.head){document.head.appendChild(style);}document.body.classList.add("bpsdm-v4-active");main.innerHTML="";node.style.display="block";main.appendChild(node);document.body.classList.add("bpsdm-v4-ready");}if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",boot);}else{boot();}})();</script>';

    return $html;
}

/**
 * Inject the homepage just before the theme footer, then move it into the main
 * content area on the client so the theme header/footer markup is preserved.
 *
 * @return string
 */
function local_bpsdmhome_before_footer(): string {
    global $PAGE;

    if ($PAGE->pagetype !== 'site-index') {
        return '';
    }

    // The live homepage is now maintained in the MB2Builder page editor.
    // Keep the plugin installed so its image assets remain available, but do
    // not replace the builder content on the front page.
    return '';
}
