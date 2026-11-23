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
        $services[] = array('name' => $item['title'], 'description' => $item['text']);
    }
    return $services;
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
