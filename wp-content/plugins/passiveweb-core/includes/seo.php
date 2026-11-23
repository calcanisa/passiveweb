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

function pwc_page_seo()
{
    static $cache = null;
    if (null !== $cache) {
        return $cache ? $cache : null;
    }
    $cache = false;
    if (is_front_page() || !is_singular()) {
        return null;
    }
    $seo = apply_filters('pwc_page_seo', null);
    if (!is_array($seo) || empty($seo['url'])) {
        return null;
    }
    $url = esc_url_raw((string) $seo['url']);
    $home = wp_parse_url(home_url(), PHP_URL_HOST);
    if ('' === $url || wp_parse_url($url, PHP_URL_HOST) !== $home) {
        return null;
    }
    $clean = array(
        'url' => $url,
        'title' => isset($seo['title']) ? sanitize_text_field((string) $seo['title']) : '',
        'description' => isset($seo['description']) ? sanitize_text_field((string) $seo['description']) : '',
        'heading' => isset($seo['heading']) ? sanitize_text_field((string) $seo['heading']) : '',
        'service' => isset($seo['service']) && is_array($seo['service']) ? $seo['service'] : array(),
        'faqs' => isset($seo['faqs']) && is_array($seo['faqs']) ? $seo['faqs'] : array(),
        'breadcrumbs' => isset($seo['breadcrumbs']) && is_array($seo['breadcrumbs']) ? $seo['breadcrumbs'] : array(),
    );
    $cache = $clean;
    return $clean;
}

function pwc_document_title($title)
{
    if (!pwc_handles_meta()) {
        return $title;
    }
    if (is_front_page() && '' !== pwc_text('seo_title')) {
        return pwc_text('seo_title');
    }
    $page = pwc_page_seo();
    if ($page && '' !== $page['title']) {
        return $page['title'];
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

function pwc_meta_tags($title, $desc, $url)
{
    $image = esc_url(pwc_opt('seo_image'));
    $name = pwc_text('biz_name');

    if ('' !== $desc) {
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    }
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

function pwc_head_meta()
{
    if (!pwc_handles_meta()) {
        return;
    }
    if (is_front_page()) {
        $title = pwc_text('seo_title');
        if ('' === $title) {
            $title = wp_get_document_title();
        }
        $url = home_url('/');
        echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
        pwc_meta_tags($title, pwc_text('seo_description'), $url);
        return;
    }
    $page = pwc_page_seo();
    if (!$page) {
        return;
    }
    $title = '' !== $page['title'] ? $page['title'] : wp_get_document_title();
    pwc_meta_tags($title, $page['description'], $page['url']);
}
add_action('wp_head', 'pwc_head_meta', 1);

function pwc_remove_core_canonical()
{
    if (is_front_page() && pwc_handles_meta()) {
        remove_action('wp_head', 'rel_canonical');
    }
}
add_action('template_redirect', 'pwc_remove_core_canonical');

function pwc_areas_served()
{
    $provinces = array('Gauteng', 'Western Cape', 'KwaZulu-Natal', 'Eastern Cape', 'Free State', 'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape');
    $areas = array();
    foreach (pwc_lines('biz_areas') as $area) {
        if ('South Africa' === $area) {
            $place_type = 'Country';
        } elseif (in_array($area, $provinces, true)) {
            $place_type = 'State';
        } else {
            $place_type = 'City';
        }
        $areas[] = array('@type' => $place_type, 'name' => $area);
    }
    return $areas;
}

function pwc_business_node()
{
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

    $areas = pwc_areas_served();
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

    return $business;
}

function pwc_faq_node($faqs, $id, $page_id)
{
    $entities = array();
    foreach ((array) $faqs as $faq) {
        if (!is_array($faq) || empty($faq['question']) || empty($faq['answer'])) {
            continue;
        }
        $entities[] = array(
            '@type' => 'Question',
            'name' => wp_strip_all_tags((string) $faq['question']),
            'acceptedAnswer' => array('@type' => 'Answer', 'text' => wp_strip_all_tags((string) $faq['answer'])),
        );
    }
    if (empty($entities)) {
        return null;
    }
    return array(
        '@type' => 'FAQPage',
        '@id' => $id,
        'isPartOf' => array('@id' => $page_id),
        'mainEntity' => $entities,
    );
}

function pwc_website_node($name)
{
    $home = home_url('/');
    return array(
        '@type' => 'WebSite',
        '@id' => $home . '#website',
        'url' => $home,
        'name' => $name,
        'inLanguage' => 'en-ZA',
        'publisher' => array('@id' => $home . '#business'),
    );
}

function pwc_front_graph()
{
    $home = home_url('/');
    $business = pwc_business_node();
    $areas = isset($business['areaServed']) ? $business['areaServed'] : array();

    $services = (array) apply_filters('pwc_services', array());
    if (!empty($services)) {
        $offers = array();
        foreach ($services as $svc) {
            if (!is_array($svc) || empty($svc['name'])) {
                continue;
            }
            $item = array(
                '@type' => 'Service',
                'name' => wp_strip_all_tags((string) $svc['name']),
                'provider' => array('@id' => $home . '#business'),
            );
            if (!empty($svc['description'])) {
                $item['description'] = wp_strip_all_tags((string) $svc['description']);
            }
            if (!empty($svc['url'])) {
                $svc_url = esc_url_raw((string) $svc['url']);
                if ('' !== $svc_url) {
                    $item['url'] = $svc_url;
                }
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

    $graph = array($business, pwc_website_node($business['name']));
    $graph[] = array(
        '@type' => 'WebPage',
        '@id' => $home . '#webpage',
        'url' => $home,
        'name' => '' !== pwc_text('seo_title') ? pwc_text('seo_title') : $business['name'],
        'isPartOf' => array('@id' => $home . '#website'),
        'about' => array('@id' => $home . '#business'),
        'inLanguage' => 'en-ZA',
    );
    $faq = pwc_faq_node(apply_filters('pwc_faq_items', array()), $home . '#faq', $home . '#webpage');
    if ($faq) {
        $graph[] = $faq;
    }
    return $graph;
}

function pwc_page_graph($page)
{
    $home = home_url('/');
    $url = $page['url'];
    $business = pwc_business_node();
    $areas = isset($business['areaServed']) ? $business['areaServed'] : array();
    $graph = array($business, pwc_website_node($business['name']));

    $webpage = array(
        '@type' => 'WebPage',
        '@id' => $url . '#webpage',
        'url' => $url,
        'name' => '' !== $page['title'] ? $page['title'] : get_the_title(),
        'isPartOf' => array('@id' => $home . '#website'),
        'about' => array('@id' => $home . '#business'),
        'inLanguage' => 'en-ZA',
    );
    if ('' !== $page['description']) {
        $webpage['description'] = $page['description'];
    }

    $crumbs = array();
    $position = 1;
    foreach ($page['breadcrumbs'] as $crumb) {
        if (!is_array($crumb) || empty($crumb['name']) || empty($crumb['url'])) {
            continue;
        }
        $crumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => wp_strip_all_tags((string) $crumb['name']),
            'item' => esc_url_raw((string) $crumb['url']),
        );
    }
    if (count($crumbs) > 1) {
        $webpage['breadcrumb'] = array('@id' => $url . '#breadcrumb');
    }

    $service = $page['service'];
    if (!empty($service['name'])) {
        $node = array(
            '@type' => 'Service',
            '@id' => $url . '#service',
            'name' => wp_strip_all_tags((string) $service['name']),
            'url' => $url,
            'provider' => array('@id' => $home . '#business'),
        );
        if (!empty($service['type'])) {
            $node['serviceType'] = wp_strip_all_tags((string) $service['type']);
        }
        if (!empty($service['description'])) {
            $node['description'] = wp_strip_all_tags((string) $service['description']);
        }
        if (!empty($areas)) {
            $node['areaServed'] = $areas;
        }
        $offers = array();
        foreach (isset($service['features']) ? (array) $service['features'] : array() as $feature) {
            if (!is_array($feature) || empty($feature['name'])) {
                continue;
            }
            $item = array('@type' => 'Service', 'name' => wp_strip_all_tags((string) $feature['name']));
            if (!empty($feature['description'])) {
                $item['description'] = wp_strip_all_tags((string) $feature['description']);
            }
            $offers[] = array('@type' => 'Offer', 'itemOffered' => $item);
        }
        if (!empty($offers)) {
            $node['hasOfferCatalog'] = array(
                '@type' => 'OfferCatalog',
                'name' => wp_strip_all_tags((string) $service['name']),
                'itemListElement' => $offers,
            );
        }
        $webpage['mainEntity'] = array('@id' => $url . '#service');
        $graph[] = $webpage;
        $graph[] = $node;
    } else {
        $graph[] = $webpage;
    }

    if (count($crumbs) > 1) {
        $graph[] = array(
            '@type' => 'BreadcrumbList',
            '@id' => $url . '#breadcrumb',
            'itemListElement' => $crumbs,
        );
    }

    $faq = pwc_faq_node($page['faqs'], $url . '#faq', $url . '#webpage');
    if ($faq) {
        $graph[] = $faq;
    }
    return $graph;
}

function pwc_schema()
{
    if (!pwc_opt('seo_enable')) {
        return;
    }
    if (is_front_page()) {
        $graph = pwc_front_graph();
    } else {
        $page = pwc_page_seo();
        if (!$page) {
            return;
        }
        $graph = pwc_page_graph($page);
    }
    $json = wp_json_encode(array('@context' => 'https://schema.org', '@graph' => $graph), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    if ($json) {
        echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
    }
}
add_action('wp_head', 'pwc_schema', 30);
