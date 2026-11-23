<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_service_items()
{
    $items = array();
    for ($n = 1; $n <= 9; $n++) {
        if (!pw_on("svc_{$n}_enable")) {
            continue;
        }
        $title = pw_text("svc_{$n}_title");
        if ('' === $title) {
            continue;
        }
        $items[] = array(
            'n' => $n,
            'icon' => pw_mod("svc_{$n}_icon"),
            'title' => $title,
            'text' => pw_text("svc_{$n}_text"),
            'tags' => pw_tags("svc_{$n}_tags"),
            'url' => pw_service_url((string) pw_mod("svc_{$n}_page")),
            'more' => pw_text("svc_{$n}_more"),
        );
    }
    return $items;
}

function pw_faq_items()
{
    $items = array();
    for ($n = 1; $n <= 8; $n++) {
        $q = pw_text("faq_{$n}_q");
        $a = pw_text("faq_{$n}_a");
        if ('' !== $q && '' !== $a) {
            $items[] = array('q' => $q, 'a' => $a);
        }
    }
    return $items;
}

add_filter('pwc_services', function ($services) {
    if (!pw_section_enabled('services')) {
        return $services;
    }
    foreach (pw_service_items() as $item) {
        $services[] = array('name' => $item['title'], 'description' => $item['text'], 'url' => $item['url']);
    }
    $listed = wp_list_pluck($services, 'url');
    foreach (pw_service_links() as $link) {
        if (!in_array($link['url'], $listed, true)) {
            $services[] = array('name' => $link['label'], 'description' => $link['text'], 'url' => $link['url']);
        }
    }
    return $services;
});

add_filter('pwc_page_seo', function ($seo) {
    $key = pw_current_service();
    if ('' === $key) {
        return $seo;
    }
    $url = pw_service_url($key);
    $faqs = array();
    foreach (pw_service_faqs($key) as $item) {
        $faqs[] = array('question' => $item['q'], 'answer' => $item['a']);
    }
    $features = array();
    foreach (pw_service_features($key) as $item) {
        $features[] = array('name' => $item['title'], 'description' => $item['text']);
    }
    $name = pw_sp_text($key, 'menu_label');
    return array(
        'url' => $url,
        'title' => pw_sp_text($key, 'seo_title'),
        'description' => pw_sp_text($key, 'seo_desc'),
        'heading' => pw_sp_text($key, 'hero_kicker'),
        'service' => array(
            'name' => '' !== pw_sp_text($key, 'hero_kicker') ? pw_sp_text($key, 'hero_kicker') : $name,
            'type' => $name,
            'description' => pw_sp_text($key, 'seo_desc'),
            'features' => $features,
        ),
        'faqs' => $faqs,
        'breadcrumbs' => array(
            array('name' => pw_text('logo_text'), 'url' => home_url('/')),
            array('name' => '' !== pw_sp_text($key, 'hero_kicker') ? pw_sp_text($key, 'hero_kicker') : $name, 'url' => $url),
        ),
    );
});

add_filter('pwc_faq_items', function ($items) {
    if (!pw_section_enabled('faq')) {
        return $items;
    }
    foreach (pw_faq_items() as $item) {
        $items[] = array('question' => $item['q'], 'answer' => $item['a']);
    }
    return $items;
});

add_filter('pwc_same_as', function ($urls) {
    foreach (pw_socials() as $social) {
        $urls[] = $social['url'];
    }
    return $urls;
});

add_filter('pwc_business_contact', function ($contact) {
    $email = sanitize_email(pw_mod('contact_email'));
    $phone = pw_text('contact_phone');
    if ('' === $contact['email'] && '' !== $email) {
        $contact['email'] = $email;
    }
    if ('' === $contact['phone'] && '' !== $phone) {
        $contact['phone'] = $phone;
    }
    return $contact;
});

add_filter('pwc_default_image', function ($image) {
    if ('' !== $image) {
        return $image;
    }
    return PW_URI . '/assets/img/og-default.png';
});

add_filter('pwc_indexable_empty_pages', function ($ids) {
    foreach (pw_service_keys() as $key) {
        $id = pw_service_page_id($key);
        if ($id) {
            $ids[] = $id;
        }
    }
    return $ids;
});

add_filter('pwc_default_logo', function ($logo) {
    if ('' !== $logo) {
        return $logo;
    }
    return PW_URI . '/assets/img/logo-560.png';
});
