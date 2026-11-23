<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_seo_plugin_active()
{
    return defined('WPSEO_VERSION') || class_exists('RankMath') || defined('SEOPRESS_VERSION') || defined('AIOSEO_VERSION');
}

function pwc_handles_meta()
{
    if (!pwc_opt('seo_enable')) {
        return false;
    }
    if (pwc_opt('seo_defer') && pwc_seo_plugin_active()) {
        return false;
    }
    return true;
}

function pwc_document_title($title)
{
    if (is_front_page() && pwc_handles_meta() && '' !== pwc_text('seo_title')) {
        return pwc_text('seo_title');
    }
    return $title;
}
add_filter('pre_get_document_title', 'pwc_document_title', 20);

function pwc_business_contact()
{
    $contact = array(
        'email' => sanitize_email(pwc_opt('biz_email')),
        'phone' => pwc_text('biz_phone'),
    );
    $contact = apply_filters('pwc_business_contact', $contact);
    return array(
        'email' => is_email($contact['email']) ? $contact['email'] : '',
        'phone' => sanitize_text_field((string) $contact['phone']),
    );
}

function pwc_logo_url()
{
    $id = (int) get_theme_mod('custom_logo');
    if ($id) {
        $src = wp_get_attachment_image_url($id, 'full');
        if ($src) {
            return $src;
        }
    }
    $icon = get_site_icon_url(512);
    return $icon ? $icon : '';
}

function pwc_head_meta()
{
    if (!is_front_page() || !pwc_handles_meta()) {
        return;
    }
    $title = pwc_text('seo_title');
    if ('' === $title) {
        $title = wp_get_document_title();
    }
    $desc = pwc_text('seo_description');
    $url = home_url('/');
    $image = esc_url(pwc_opt('seo_image'));
    $name = pwc_text('biz_name');

    if ('' !== $desc) {
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    }
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:locale" content="en_ZA">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr('' !== $name ? $name : get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    if ('' !== $desc) {
        echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    }
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    if ('' !== $image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    } else {
        echo '<meta name="twitter:card" content="summary">' . "\n";
    }
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    if ('' !== $desc) {
        echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    }
    $region = strtoupper(pwc_text('biz_country'));
    if ('ZA' === $region && 0 === strcasecmp(pwc_text('biz_region'), 'Gauteng')) {
        $region = 'ZA-GP';
    }
    echo '<meta name="geo.region" content="' . esc_attr($region) . '">' . "\n";
    if ('' !== pwc_text('biz_locality')) {
        echo '<meta name="geo.placename" content="' . esc_attr(pwc_text('biz_locality')) . '">' . "\n";
    }
    if ('' !== pwc_text('biz_lat') && '' !== pwc_text('biz_lng')) {
        echo '<meta name="geo.position" content="' . esc_attr(pwc_text('biz_lat') . ';' . pwc_text('biz_lng')) . '">' . "\n";
        echo '<meta name="ICBM" content="' . esc_attr(pwc_text('biz_lat') . ', ' . pwc_text('biz_lng')) . '">' . "\n";
    }
}
add_action('wp_head', 'pwc_head_meta', 1);

function pwc_remove_core_canonical()
{
    if (is_front_page() && pwc_handles_meta()) {
        remove_action('wp_head', 'rel_canonical');
    }
}
add_action('template_redirect', 'pwc_remove_core_canonical');

function pwc_schema()
{
    if (!is_front_page() || !pwc_opt('seo_enable')) {
        return;
    }
    $home = home_url('/');
    $contact = pwc_business_contact();
    $logo = pwc_logo_url();
    $type = pwc_text('biz_type');
    if (!in_array($type, array('ProfessionalService', 'LocalBusiness', 'Organization'), true)) {
        $type = 'ProfessionalService';
    }

    $business = array(
        '@type' => $type,
        '@id' => $home . '#business',
        'name' => '' !== pwc_text('biz_name') ? pwc_text('biz_name') : get_bloginfo('name'),
        'url' => $home,
    );
    if ('' !== pwc_text('biz_legal')) {
        $business['legalName'] = pwc_text('biz_legal');
    }
    if ('' !== pwc_text('biz_slogan')) {
        $business['slogan'] = pwc_text('biz_slogan');
    }
    if ('' !== pwc_text('seo_description')) {
        $business['description'] = pwc_text('seo_description');
    }
    if ('' !== $contact['email']) {
        $business['email'] = $contact['email'];
    }
    if ('' !== $contact['phone']) {
        $business['telephone'] = $contact['phone'];
    }
    if ('' !== $logo) {
        $business['logo'] = $logo;
        $business['image'] = $logo;
    }
    $og = esc_url_raw(pwc_opt('seo_image'));
    if ('' !== $og) {
        $business['image'] = $og;
    }
    if ('Organization' !== $type && '' !== pwc_text('biz_price')) {
        $business['priceRange'] = pwc_text('biz_price');
    }

    $address = array('@type' => 'PostalAddress');
    foreach (array('streetAddress' => 'biz_street', 'addressLocality' => 'biz_locality', 'addressRegion' => 'biz_region', 'postalCode' => 'biz_postal', 'addressCountry' => 'biz_country') as $prop => $key) {
        if ('' !== pwc_text($key)) {
            $address[$prop] = pwc_text($key);
        }
    }
    if (count($address) > 1) {
        $business['address'] = $address;
    }
    if ('Organization' !== $type && '' !== pwc_text('biz_lat') && '' !== pwc_text('biz_lng')) {
        $business['geo'] = array(
            '@type' => 'GeoCoordinates',
            'latitude' => (float) pwc_text('biz_lat'),
            'longitude' => (float) pwc_text('biz_lng'),
        );
    }

    $areas = array();
    foreach (pwc_lines('biz_areas') as $area) {
        $place_type = 'Place';
        if (in_array($area, array('South Africa'), true)) {
            $place_type = 'Country';
        } elseif (in_array($area, array('Gauteng', 'Western Cape', 'KwaZulu-Natal', 'Eastern Cape', 'Free State', 'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape'), true)) {
            $place_type = 'State';
        } else {
            $place_type = 'City';
        }
        $areas[] = array('@type' => $place_type, 'name' => $area);
    }
    if (!empty($areas)) {
        $business['areaServed'] = $areas;
    }

    $same = array();
    foreach ((array) apply_filters('pwc_same_as', array()) as $u) {
        $u = esc_url_raw($u);
        if ('' !== $u) {
            $same[] = $u;
        }
    }
    if ('' !== pwc_text('biz_maps')) {
        $business['hasMap'] = esc_url_raw(pwc_opt('biz_maps'));
    }
    if (!empty($same)) {
        $business['sameAs'] = array_values(array_unique($same));
    }

    $services = (array) apply_filters('pwc_services', array());
    if (!empty($services)) {
        $offers = array();
        foreach ($services as $svc) {
            if (empty($svc['name'])) {
                continue;
            }
            $item = array(
                '@type' => 'Service',
                'name' => wp_strip_all_tags($svc['name']),
                'provider' => array('@id' => $home . '#business'),
            );
            if (!empty($svc['description'])) {
                $item['description'] = wp_strip_all_tags($svc['description']);
            }
            if (!empty($areas)) {
                $item['areaServed'] = $areas;
            }
            $offers[] = array('@type' => 'Offer', 'itemOffered' => $item);
        }
        if (!empty($offers)) {
            $business['hasOfferCatalog'] = array(
                '@type' => 'OfferCatalog',
                'name' => 'Web design, development and AI services',
                'itemListElement' => $offers,
            );
        }
    }

    $graph = array($business);
    $graph[] = array(
        '@type' => 'WebSite',
        '@id' => $home . '#website',
        'url' => $home,
        'name' => $business['name'],
        'inLanguage' => 'en-ZA',
        'publisher' => array('@id' => $home . '#business'),
    );
    $graph[] = array(
        '@type' => 'WebPage',
        '@id' => $home . '#webpage',
        'url' => $home,
        'name' => '' !== pwc_text('seo_title') ? pwc_text('seo_title') : $business['name'],
        'isPartOf' => array('@id' => $home . '#website'),
        'about' => array('@id' => $home . '#business'),
        'inLanguage' => 'en-ZA',
    );

    $faqs = (array) apply_filters('pwc_faq_items', array());
    $entities = array();
    foreach ($faqs as $faq) {
        if (empty($faq['question']) || empty($faq['answer'])) {
            continue;
        }
        $entities[] = array(
            '@type' => 'Question',
            'name' => wp_strip_all_tags($faq['question']),
            'acceptedAnswer' => array('@type' => 'Answer', 'text' => wp_strip_all_tags($faq['answer'])),
        );
    }
    if (!empty($entities)) {
        $graph[] = array(
            '@type' => 'FAQPage',
            '@id' => $home . '#faq',
            'isPartOf' => array('@id' => $home . '#webpage'),
            'mainEntity' => $entities,
        );
    }

    $json = wp_json_encode(array('@context' => 'https://schema.org', '@graph' => $graph), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    if ($json) {
        echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
    }
}
add_action('wp_head', 'pwc_schema', 30);
