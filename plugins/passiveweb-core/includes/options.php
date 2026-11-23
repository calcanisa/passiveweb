<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_option_fields()
{
    return array(
        'pwc_form' => array(
            'title' => 'Quote Form',
            'description' => 'Every submission is saved under Quote Requests in the admin menu and emailed to the address below.',
            'fields' => array(
                'form_recipient' => array('email', 'Send quote requests to', ''),
                'form_subject' => array('text', 'Email subject start', 'New quote request'),
                'label_name' => array('text', 'Name label', 'Name'),
                'label_email' => array('text', 'Email label', 'Email'),
                'label_phone' => array('text', 'Phone label', 'Phone'),
                'label_company' => array('text', 'Company label', 'Company'),
                'label_service' => array('text', 'Service label', 'What do you need?'),
                'label_message' => array('text', 'Message label', 'Tell us about it'),
                'placeholder_message' => array('text', 'Message placeholder', 'Your idea, your goals, and any written quote you want us to beat.'),
                'service_options' => array('textarea', 'Service options (one per line)', "A complete project\nWeb design\nWeb development\nSoftware development\nMobile application\nDigital marketing\nHosting and maintenance\nCyber security\nAI training\nBusiness, domain and payment gateway registration\nBeat my written quote\nSomething else"),
                'show_required' => array('checkbox', 'Show a required marker next to required labels (on the same line)', true),
                'button_text' => array('text', 'Button text', 'Get my quote'),
                'button_sending' => array('text', 'Button text while sending', 'Sending'),
                'msg_success' => array('textarea', 'Success message', 'Thank you! Your request is in. We will be in touch shortly with a plan and a quote that beats any other.'),
                'msg_error' => array('text', 'General error message', 'Something went wrong. Please try again or email us directly.'),
                'msg_required' => array('text', 'Required field message', 'Please fill in this field.'),
                'msg_email' => array('text', 'Invalid email message', 'Please enter a valid email address.'),
                'msg_phone' => array('text', 'Invalid phone message', 'Please enter a valid phone number.'),
                'msg_limit' => array('text', 'Too many requests message', 'You have sent a few requests already. Please try again a little later.'),
                'msg_expired' => array('text', 'Expired form message', 'This form was open for too long. Please refresh the page and try again.'),
                'privacy_note' => array('text', 'Small note under the button (empty hides it)', ''),
            ),
        ),
        'pwc_seo' => array(
            'title' => 'SEO and Local Business',
            'description' => 'Search titles, descriptions and the Google local business data for Pretoria. If Yoast, Rank Math, SEOPress or All in One SEO is active, titles and descriptions are left to that plugin unless you untick the option below.',
            'fields' => array(
                'seo_enable' => array('checkbox', 'Output SEO tags and structured data', true),
                'seo_defer' => array('checkbox', 'Let an active SEO plugin handle titles and descriptions', true),
                'seo_title' => array('text', 'Home page search title', 'Web Design Pretoria | Web Development and AI Engineers | Passive Web'),
                'seo_description' => array('textarea', 'Home page search description', 'Passive Web is a web design and development company in Pretoria. Websites, apps, software, SEO, hosting and cyber security built by AI engineers. We beat any written quote.'),
                'seo_image' => array('image', 'Social sharing image (1200 x 630)', ''),
                'biz_type' => array('select', 'Business type', 'ProfessionalService', array(
                    'ProfessionalService' => 'Professional Service',
                    'LocalBusiness' => 'Local Business',
                    'Organization' => 'Organization',
                )),
                'biz_name' => array('text', 'Business name', 'Passive Web'),
                'biz_legal' => array('text', 'Registered company name', 'Passive Web (Pty) Ltd'),
                'biz_slogan' => array('text', 'Slogan', 'Dream Catchers'),
                'biz_email' => array('email', 'Business email (empty uses the theme contact email)', ''),
                'biz_phone' => array('text', 'Business phone (empty uses the theme contact phone)', ''),
                'biz_street' => array('text', 'Street address (optional)', ''),
                'biz_locality' => array('text', 'City', 'Pretoria'),
                'biz_region' => array('text', 'Province', 'Gauteng'),
                'biz_postal' => array('text', 'Postal code (optional)', ''),
                'biz_country' => array('text', 'Country code', 'ZA'),
                'biz_lat' => array('text', 'Latitude (optional)', ''),
                'biz_lng' => array('text', 'Longitude (optional)', ''),
                'biz_price' => array('text', 'Price range', 'R'),
                'biz_areas' => array('textarea', 'Areas served (one per line)', "Pretoria\nCenturion\nMidrand\nJohannesburg\nGauteng\nSouth Africa"),
                'biz_maps' => array('url', 'Google Business Profile or Maps link (optional)', ''),
                'security_headers' => array('checkbox', 'Send security headers on the website', true),
            ),
        ),
    );
}

function pwc_flat_options()
{
    static $flat = null;
    if (null !== $flat) {
        return $flat;
    }
    $flat = array();
    foreach (pwc_option_fields() as $section) {
        foreach ($section['fields'] as $key => $def) {
            $flat[$key] = array(
                'type' => $def[0],
                'label' => $def[1],
                'default' => $def[2],
                'choices' => isset($def[3]) ? $def[3] : array(),
            );
        }
    }
    return $flat;
}

function pwc_opt($key)
{
    $flat = pwc_flat_options();
    $default = isset($flat[$key]) ? $flat[$key]['default'] : '';
    $saved = get_option('pwc_options', array());
    if (!is_array($saved) || !array_key_exists($key, $saved)) {
        return $default;
    }
    return $saved[$key];
}

function pwc_text($key)
{
    return trim((string) pwc_opt($key));
}

function pwc_lines($key)
{
    $out = array();
    foreach (preg_split('/\r\n|\r|\n/', (string) pwc_opt($key)) as $line) {
        $line = trim($line);
        if ('' !== $line) {
            $out[] = $line;
        }
    }
    return $out;
}

function pwc_recipient()
{
    $email = sanitize_email(pwc_opt('form_recipient'));
    if (!is_email($email)) {
        $email = sanitize_email(get_option('admin_email'));
    }
    return $email;
}
