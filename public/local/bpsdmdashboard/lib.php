<?php
// This file is part of Moodle - https://moodle.org/
//
// Renders the BPSDM dashboard design inside the existing Moodle dashboard
// page while leaving the theme header and footer untouched.

defined('MOODLE_INTERNAL') || die();

/**
 * Whether the current language is English.
 *
 * @return bool
 */
function local_bpsdmdashboard_is_english(): bool {
    return strpos(current_language(), 'en') === 0;
}

/**
 * Translated interface strings.
 *
 * @param bool $en
 * @return array
 */
function local_bpsdmdashboard_strings(bool $en): array {
    if ($en) {
        return [
            'kicker' => 'Participant dashboard',
            'greeting' => 'Hello, {$a}.',
            'subtitle' => 'Welcome back. Continue learning or find a new course to develop your competence.',
            'stat_courses' => 'Active courses',
            'stat_progress' => 'Learning progress',
            'stat_certificates' => 'Certificates',
            'continue' => 'Continue learning',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'continue_btn' => 'Continue Learning',
            'courses_title' => 'Courses in progress',
            'courses_copy' => 'Continue from where you left off.',
            'view_all' => 'View all',
            'shortcuts' => 'Shortcuts',
            'timeline' => 'Timeline',
            'shortcut_catalog' => 'Search Course Catalogue',
            'shortcut_progress' => 'View Learning Progress',
            'shortcut_guide' => 'Participant Guide',
            'shortcut_courses' => 'All Courses',
            'no_courses' => 'You are not enrolled in any course yet.',
            'no_events' => 'No activities in the next 7 days.',
            'progress_label' => '{$a}% complete',
            'admin_kicker' => 'Administration',
            'admin_copy' => 'Overview of users, courses, storage, and site health.',
            'users' => 'Users',
            'all' => 'All',
            'active' => 'Active',
            'online' => 'Online',
            'all_courses' => 'All courses',
            'visible_courses' => 'Visible courses',
            'disk_usage' => 'Disk usage',
            'performance' => 'Performance problems',
            'course_overview' => 'Course overview',
            'course_overview_copy' => 'Latest courses on the site.',
            'all_categories' => 'All',
            'search_course' => 'Search course...',
            'sort_name' => 'Sort by course name',
            'view_card' => 'Card',
            'course_meta' => 'Course',
        ];
    }

    return [
        'kicker' => 'Dashboard peserta',
        'greeting' => 'Halo, {$a}.',
        'subtitle' => 'Selamat datang kembali. Lanjutkan pembelajaran atau temukan course baru untuk mengembangkan kompetensi Anda.',
        'stat_courses' => 'Course aktif',
        'stat_progress' => 'Progres belajar',
        'stat_certificates' => 'Sertifikat',
        'continue' => 'Lanjutkan belajar',
        'in_progress' => 'Sedang berjalan',
        'completed' => 'Selesai',
        'continue_btn' => 'Lanjutkan Belajar',
        'courses_title' => 'Course yang sedang diikuti',
        'courses_copy' => 'Lanjutkan dari tempat Anda berhenti.',
        'view_all' => 'Lihat semua',
        'shortcuts' => 'Pintasan',
        'timeline' => 'Linimasa',
        'shortcut_catalog' => 'Cari di Katalog Course',
        'shortcut_progress' => 'Lihat Progres Belajar',
        'shortcut_guide' => 'Buku Panduan Peserta',
        'shortcut_courses' => 'Semua Course',
        'no_courses' => 'Belum ada course yang sedang diikuti.',
        'no_events' => 'Tidak ada aktivitas dalam 7 hari ke depan.',
        'progress_label' => '{$a}% selesai',
        'admin_kicker' => 'Administrasi',
        'admin_copy' => 'Ringkasan pengguna, course, penyimpanan, dan kondisi situs.',
        'users' => 'Pengguna',
        'all' => 'Semua',
        'active' => 'Aktif',
        'online' => 'Online',
        'all_courses' => 'Semua kursus',
        'visible_courses' => 'Course terlihat',
        'disk_usage' => 'Penggunaan disk',
        'performance' => 'Masalah performa',
        'course_overview' => 'Ikhtisar kursus',
        'course_overview_copy' => 'Daftar course terbaru di situs.',
        'all_categories' => 'Semua',
        'search_course' => 'Cari course...',
        'sort_name' => 'Urut berdasarkan nama kursus',
        'view_card' => 'Kartu',
        'course_meta' => 'Course',
    ];
}

/**
 * First overview image of a course.
 *
 * @param stdClass $course
 * @return string|null
 */
function local_bpsdmdashboard_course_image(stdClass $course): ?string {
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
 * Course completion percentage.
 *
 * @param stdClass $course
 * @param int $userid
 * @return int
 */
function local_bpsdmdashboard_progress(stdClass $course, int $userid): int {
    if (!class_exists('\core_completion\progress')) {
        return 0;
    }

    try {
        $progress = \core_completion\progress::get_course_progress_percentage($course, $userid);
        return $progress === null ? 0 : (int) round($progress);
    } catch (\Throwable $e) {
        return 0;
    }
}

/**
 * Course category name.
 *
 * @param stdClass $course
 * @return string
 */
function local_bpsdmdashboard_category(stdClass $course): string {
    global $DB;

    $name = $DB->get_field('course_categories', 'name', ['id' => $course->category]);
    return $name ? format_string($name) : '';
}

/**
 * Participant dashboard HTML.
 *
 * @param bool $en
 * @return string
 */
function local_bpsdmdashboard_render_user(bool $en): string {
    global $CFG, $DB, $USER;

    $t = local_bpsdmdashboard_strings($en);
    $courseurl = (string) new moodle_url('/course/');
    $catalogurl = (string) new moodle_url('/course/index.php');
    $guideurl = 'https://drive.google.com/drive/folders/1_EnFDShAeWEWWU7MQAN9TxWkLkmsPjVm';

    require_once($CFG->libdir . '/enrollib.php');
    $courses = enrol_get_users_courses($USER->id, true);
    $courses = array_values($courses);
    usort($courses, function($a, $b) {
        return ((int) ($b->lastaccess ?? 0)) <=> ((int) ($a->lastaccess ?? 0));
    });

    $sample = array_slice($courses, 0, 12);
    $progress = [];
    $completed = 0;
    foreach ($sample as $course) {
        $p = local_bpsdmdashboard_progress($course, (int) $USER->id);
        $progress[$course->id] = $p;
        if ($p >= 100) {
            $completed++;
        }
    }
    $total = count($courses);
    $average = $sample ? (int) round(array_sum($progress) / count($sample)) : 0;

    $continue = null;
    foreach ($sample as $course) {
        if ($progress[$course->id] < 100) {
            $continue = $course;
            break;
        }
    }
    if (!$continue && $sample) {
        $continue = $sample[0];
    }

    // Upcoming events for the next seven days.
    $events = [];
    if ($sample) {
        require_once($CFG->dirroot . '/calendar/lib.php');
        if (function_exists('calendar_get_events')) {
            try {
                $courseids = array_map(function($course) {
                    return (int) $course->id;
                }, $sample);
                $events = calendar_get_events(time(), time() + 7 * DAYSECS, false, false, $courseids, true, true);
                $events = array_slice(array_values($events), 0, 2);
            } catch (\Throwable $e) {
                $events = [];
            }
        }
    }

    $html = '<div class="bpsdm-dash-page">';
    $html .= '<section class="dash-intro">';
    $html .= '<div><div class="dash-kicker">' . s($t['kicker']) . '</div>';
    $html .= '<h1>' . s(str_replace('{$a}', fullname($USER), $t['greeting'])) . '</h1>';
    $html .= '<p>' . s($t['subtitle']) . '</p></div>';
    $html .= '<div class="dash-stats">';
    $html .= '<div class="dash-stat"><strong>' . s((string) $total) . '</strong><span>' . s($t['stat_courses']) . '</span></div>';
    $html .= '<div class="dash-stat"><strong>' . s($average . '%') . '</strong><span>' . s($t['stat_progress']) . '</span></div>';
    $html .= '<div class="dash-stat"><strong>' . s((string) $completed) . '</strong><span>' . s($t['stat_certificates']) . '</span></div>';
    $html .= '</div></section>';

    $html .= '<div class="dash-layout"><main class="dash-main">';

    if ($continue) {
        $continueprogress = $progress[$continue->id];
        $continueimage = local_bpsdmdashboard_course_image($continue);
        $continuecat = local_bpsdmdashboard_category($continue);
        $continueurl = (string) new moodle_url('/course/view.php', ['id' => $continue->id]);

        $html .= '<section class="dash-continue">';
        $html .= '<div class="dash-continue-cover">';
        if ($continueimage) {
            $html .= '<img src="' . s($continueimage) . '" alt="' . s($continue->fullname) . '">';
        } else {
            $html .= '<div class="dash-cover-fallback">' . s(mb_substr($continue->fullname, 0, 2)) . '</div>';
        }
        $html .= '<span>' . s($continuecat ?: $t['course_meta']) . '</span></div>';
        $html .= '<div class="dash-continue-body">';
        $html .= '<span class="dash-tag">' . s($t['continue']) . '</span>';
        $html .= '<h2>' . s($continue->fullname) . '</h2>';
        $html .= '<div class="dash-progress-row"><div class="dash-progress"><span style="width:' . (int) $continueprogress . '%"></span></div>';
        $html .= '<span class="dash-progress-label">' . s(str_replace('{$a}', (string) $continueprogress, $t['progress_label'])) . '</span></div>';
        $html .= '<div class="dash-continue-foot"><span class="dash-status"><i></i>' . s($continueprogress >= 100 ? $t['completed'] : $t['in_progress']) . '</span>';
        $html .= '<a class="dash-btn dash-btn-primary" href="' . s($continueurl) . '">' . s($t['continue_btn']) . ' <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div>';
        $html .= '</div></section>';
    }

    $html .= '<div class="dash-section-head"><div><h2>' . s($t['courses_title']) . '</h2><p>' . s($t['courses_copy']) . '</p></div>';
    $html .= '<a class="dash-section-link" href="' . s($courseurl) . '">' . s($t['view_all']) . ' <i class="bi bi-arrow-right" aria-hidden="true"></i></a></div>';

    $html .= '<div class="dash-course-grid">';
    if (!$sample) {
        $html .= '<p class="dash-empty">' . s($t['no_courses']) . '</p>';
    } else {
        foreach (array_slice($sample, 0, 3) as $course) {
            $p = $progress[$course->id];
            $image = local_bpsdmdashboard_course_image($course);
            $category = local_bpsdmdashboard_category($course);
            $url = (string) new moodle_url('/course/view.php', ['id' => $course->id]);
            $html .= '<a class="dash-course-card" href="' . s($url) . '">';
            $html .= '<div class="dash-course-cover">';
            if ($image) {
                $html .= '<img src="' . s($image) . '" alt="' . s($course->fullname) . '">';
            } else {
                $html .= '<div class="dash-cover-fallback">' . s(mb_substr($course->fullname, 0, 2)) . '</div>';
            }
            $html .= '<span class="dash-course-badge">' . s($category ?: $t['course_meta']) . '</span></div>';
            $html .= '<div class="dash-course-body"><h3>' . s($course->fullname) . '</h3>';
            $html .= '<div class="dash-course-meta">' . s(str_replace('{$a}', (string) $p, $t['progress_label'])) . '</div>';
            $html .= '<div class="dash-course-progress"><div class="dash-progress"><span style="width:' . (int) $p . '%"></span></div><small>' . (int) $p . '%</small></div>';
            $html .= '<span class="dash-course-link">' . s($t['continue_btn']) . ' <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>';
            $html .= '</div></a>';
        }
    }
    $html .= '</div></main>';

    $html .= '<aside class="dash-sidebar">';
    $html .= '<section class="dash-panel"><h3>' . s($t['shortcuts']) . '</h3>';
    $html .= '<a class="dash-shortcut" href="' . s($catalogurl) . '"><i class="bi bi-compass" aria-hidden="true"></i>' . s($t['shortcut_catalog']) . '</a>';
    $html .= '<a class="dash-shortcut" href="' . s($courseurl) . '"><i class="bi bi-bar-chart" aria-hidden="true"></i>' . s($t['shortcut_progress']) . '</a>';
    $html .= '<a class="dash-shortcut" href="' . s($guideurl) . '" target="_blank" rel="noopener"><i class="bi bi-book" aria-hidden="true"></i>' . s($t['shortcut_guide']) . '</a>';
    $html .= '<a class="dash-shortcut" href="' . s($courseurl) . '"><i class="bi bi-grid" aria-hidden="true"></i>' . s($t['shortcut_courses']) . '</a>';
    $html .= '</section>';

    $html .= '<section class="dash-panel"><h3>' . s($t['timeline']) . '</h3>';
    if ($events) {
        foreach ($events as $event) {
            $date = userdate($event->timestart, '%d %b');
            $parts = explode(' ', $date);
            $day = $parts[0] ?? '';
            $month = $parts[1] ?? '';
            $coursename = '';
            if (!empty($event->courseid)) {
                $coursename = (string) $DB->get_field('course', 'fullname', ['id' => $event->courseid]);
            }
            $html .= '<div class="dash-timeline-item"><div class="dash-date"><strong>' . s($day) . '</strong><span>' . s($month) . '</span></div>';
            $html .= '<div><h4>' . s($event->name) . '</h4><p>' . s($coursename) . '</p></div></div>';
        }
    } else {
        $html .= '<div class="dash-empty">' . s($t['no_events']) . '</div>';
    }
    $html .= '</section></aside></div></div>';

    return $html;
}

/**
 * Admin dashboard HTML.
 *
 * @param bool $en
 * @return string
 */
function local_bpsdmdashboard_render_admin(bool $en): string {
    global $DB;

    $t = local_bpsdmdashboard_strings($en);
    $courseurl = (string) new moodle_url('/course/');

    $totalusers = $DB->count_records_select('user', 'deleted = 0 AND suspended = 0');
    $activeusers = $DB->count_records_select('user', 'deleted = 0 AND suspended = 0 AND lastaccess > ?', [time() - 30 * DAYSECS]);
    $onlineusers = $DB->count_records_select('user', 'deleted = 0 AND suspended = 0 AND lastaccess > ?', [time() - 5 * MINSECS]);
    $totalcourses = $DB->count_records_select('course', 'id <> ?', [SITEID]);
    $visiblecourses = $DB->count_records_select('course', 'id <> ? AND visible = 1', [SITEID]);
    $diskbytes = (int) $DB->get_field_sql('SELECT COALESCE(SUM(filesize), 0) FROM {files}');
    $diskusage = display_size($diskbytes);
    $problems = $DB->count_records_select('task_adhoc', 'faildelay > 0');

    $latest = $DB->get_records_select('course', 'id <> ? AND visible = 1', [SITEID], 'timecreated DESC', '*', 0, 4);

    $allpct = $totalusers ? 100 : 0;
    $activepct = $totalusers ? (int) round(($activeusers / $totalusers) * 100) : 0;
    $onlinepct = $totalusers ? (int) round(($onlineusers / $totalusers) * 100) : 0;

    $html = '<div class="bpsdm-dash-page bpsdm-dash-admin">';
    $html .= '<div class="dash-admin-head"><div class="dash-kicker">' . s($t['admin_kicker']) . '</div><p>' . s($t['admin_copy']) . '</p></div>';

    $html .= '<section class="dash-admin-overview">';
    $html .= '<div class="dash-panel dash-users"><h2>' . s($t['users']) . '</h2><div class="dash-rings">';
    $html .= '<div class="dash-ring-wrap"><div class="dash-ring" style="--p:' . $allpct . '"><b>' . $totalusers . '</b></div><span>' . s($t['all']) . '</span></div>';
    $html .= '<div class="dash-ring-wrap active"><div class="dash-ring" style="--p:' . $activepct . '"><b>' . $activeusers . '</b></div><span>' . s($t['active']) . '</span></div>';
    $html .= '<div class="dash-ring-wrap online"><div class="dash-ring" style="--p:' . $onlinepct . '"><b>' . $onlineusers . '</b></div><span>' . s($t['online']) . '</span></div>';
    $html .= '</div></div>';

    $html .= '<div class="dash-metrics">';
    $html .= '<div class="dash-metric navy"><div class="dash-metric-top"><span>' . s($t['all_courses']) . '</span><i class="bi bi-journal-text" aria-hidden="true"></i></div><b>' . $totalcourses . '</b></div>';
    $html .= '<div class="dash-metric orange"><div class="dash-metric-top"><span>' . s($t['visible_courses']) . '</span><i class="bi bi-journals" aria-hidden="true"></i></div><b>' . $visiblecourses . '</b><span class="dash-metric-badge">100%</span></div>';
    $html .= '<div class="dash-metric light"><div class="dash-metric-top"><span>' . s($t['disk_usage']) . '</span><i class="bi bi-hdd" aria-hidden="true"></i></div><b>' . s($diskusage) . '</b></div>';
    $html .= '<div class="dash-metric light"><div class="dash-metric-top"><span>' . s($t['performance']) . '</span><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></div><b>' . $problems . '</b></div>';
    $html .= '</div></section>';

    $html .= '<section class="dash-panel dash-course-panel">';
    $html .= '<div class="dash-course-panel-head"><div><h2>' . s($t['course_overview']) . '</h2><p>' . s($t['course_overview_copy']) . '</p></div><a href="' . s($courseurl) . '">' . s($t['view_all']) . ' <i class="bi bi-arrow-right" aria-hidden="true"></i></a></div>';
    $html .= '<div class="dash-toolbar"><select aria-label="' . s($t['all_categories']) . '"><option>' . s($t['all_categories']) . '</option></select>';
    $html .= '<input type="search" placeholder="' . s($t['search_course']) . '" aria-label="' . s($t['search_course']) . '">';
    $html .= '<select aria-label="' . s($t['sort_name']) . '"><option>' . s($t['sort_name']) . '</option></select>';
    $html .= '<button type="button">' . s($t['view_card']) . '</button></div>';
    $html .= '<div class="dash-admin-course-grid">';
    if ($latest) {
        foreach ($latest as $course) {
            $image = local_bpsdmdashboard_course_image($course);
            $category = local_bpsdmdashboard_category($course);
            $url = (string) new moodle_url('/course/view.php', ['id' => $course->id]);
            $html .= '<a class="dash-admin-course" href="' . s($url) . '"><div class="dash-admin-course-cover">';
            if ($image) {
                $html .= '<img src="' . s($image) . '" alt="' . s($course->fullname) . '">';
            } else {
                $html .= '<div class="dash-cover-fallback"><i class="bi bi-book" aria-hidden="true"></i></div>';
            }
            $html .= '</div><div class="dash-admin-course-body"><h3>' . s($course->fullname) . '</h3><span>' . s($category ?: $t['course_meta']) . '</span></div></a>';
        }
    } else {
        $html .= '<p class="dash-empty">' . s($t['no_courses']) . '</p>';
    }
    $html .= '</div></section></div>';

    return $html;
}

/**
 * Render the dashboard fragment.
 *
 * @return string
 */
function local_bpsdmdashboard_render(): string {
    global $USER;

    $en = local_bpsdmdashboard_is_english();
    $isadmin = is_siteadmin($USER);

    // Optional preview switch for administrators: ?bpsdmview=user|admin.
    $view = optional_param('bpsdmview', '', PARAM_ALPHA);
    if ($isadmin && $view === 'user') {
        $isadmin = false;
    } else if ($isadmin && $view === 'admin') {
        $isadmin = true;
    }

    $html = '<style id="bpsdm-dashboard-styles">' . file_get_contents(__DIR__ . '/styles.css') . '</style>';
    $html .= '<div id="bpsdm-dashboard" style="display:none">';
    $html .= $isadmin ? local_bpsdmdashboard_render_admin($en) : local_bpsdmdashboard_render_user($en);
    $html .= '</div>';
    $html .= '<script>(function(){function boot(){var node=document.getElementById("bpsdm-dashboard");var main=document.getElementById("page-content");if(!node||!main||document.body.classList.contains("bpsdm-dashboard-ready")){return;}var style=document.getElementById("bpsdm-dashboard-styles");if(style&&style.parentNode!==document.head){document.head.appendChild(style);}document.body.classList.add("bpsdm-dashboard-active");main.innerHTML="";node.style.display="block";main.appendChild(node);document.body.classList.add("bpsdm-dashboard-ready");}if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",boot);}else{boot();}})();</script>';

    return $html;
}

/**
 * Inject the dashboard before the theme footer on the dashboard page.
 *
 * @return string
 */
function local_bpsdmdashboard_before_footer(): string {
    if (!isloggedin() || isguestuser()) {
        return '';
    }

    // Moodle reports the same my-index page type for /my/courses.php, so
    // check the actual script and only replace the real dashboard page.
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    if (!in_array($script, ['/my', '/my/', '/my/index.php'], true)) {
        return '';
    }

    return local_bpsdmdashboard_render();
}
