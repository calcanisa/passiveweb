<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
get_template_part('template-parts/section', 'hero');
if (pw_on('marquee_enable')) {
    get_template_part('template-parts/section', 'marquee');
}
foreach (pw_section_order() as $pw_section) {
    if (pw_section_enabled($pw_section)) {
        get_template_part('template-parts/section', $pw_section);
    }
}
get_footer();
