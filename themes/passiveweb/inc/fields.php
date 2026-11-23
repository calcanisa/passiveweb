<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_f($type, $label, $default = '', $extra = array())
{
    return array_merge(array('type' => $type, 'label' => $label, 'default' => $default), $extra);
}

function pw_icon_choices()
{
    return array(
        'design' => 'Design pen',
        'code' => 'Code',
        'layers' => 'Layers',
        'mobile' => 'Mobile',
        'chart' => 'Growth chart',
        'server' => 'Server',
        'shield' => 'Shield',
        'cpu' => 'AI chip',
        'zap' => 'Lightning',
        'search' => 'Search',
        'bag' => 'Shopping bag',
        'user' => 'Person',
        'target' => 'Target',
        'briefcase' => 'Briefcase',
        'spark' => 'Sparkle',
        'building' => 'Building',
        'globe' => 'Globe',
        'card' => 'Payment card',
        'wrench' => 'Wrench',
        'cap' => 'Graduation cap',
        'rocket' => 'Rocket',
        'heart' => 'Heart',
        'check' => 'Check',
        'chat' => 'Chat',
    );
}

function pw_font_choices()
{
    return array(
        'heading' => array(
            'Syne' => 'Syne',
            'Unbounded' => 'Unbounded',
            'Bricolage Grotesque' => 'Bricolage Grotesque',
            'Space Grotesk' => 'Space Grotesk',
            'Familjen Grotesk' => 'Familjen Grotesk',
            'Fraunces' => 'Fraunces',
            'Playfair Display' => 'Playfair Display',
            'Outfit' => 'Outfit',
            'Sora' => 'Sora',
        ),
        'body' => array(
            'Inter' => 'Inter',
            'DM Sans' => 'DM Sans',
            'Manrope' => 'Manrope',
            'Plus Jakarta Sans' => 'Plus Jakarta Sans',
            'Figtree' => 'Figtree',
            'Outfit' => 'Outfit',
            'Sora' => 'Sora',
        ),
    );
}

function pw_section_ids()
{
    return array('about', 'services', 'ai', 'included', 'training', 'quote', 'process', 'faq', 'contact');
}

function pw_fields()
{
    static $fields = null;
    if (null !== $fields) {
        return $fields;
    }

    $icons = pw_icon_choices();
    $fonts = pw_font_choices();

    $fields = array();

    $fields['pw_layout'] = array(
        'title' => 'Layout and Sections',
        'description' => 'Turn sections on or off in each section panel. Change the order here.',
        'fields' => array(
            'section_order' => pw_f('text', 'Section order', implode(',', pw_section_ids()), array('description' => 'Comma separated, the hero always comes first. Available: about, services, ai, included, training, quote, process, faq, contact')),
            'marquee_enable' => pw_f('checkbox', 'Show the moving services ribbon under the hero', true),
            'marquee_items' => pw_f('textarea', 'Ribbon items (one per line)', "Web Design Pretoria\nWeb Development\nSoftware Development\nMobile Applications\nDigital Marketing\nHosting and Maintenance\nCyber Security\nAI Training"),
        ),
    );

    $fields['pw_design'] = array(
        'title' => 'Colours, Fonts and Effects',
        'fields' => array(
            'color_bg' => pw_f('color', 'Dark background', '#0c0806'),
            'color_surface' => pw_f('color', 'Dark surface (alternate dark sections)', '#161009'),
            'color_text' => pw_f('color', 'Text on dark', '#f6eee3'),
            'color_muted' => pw_f('color', 'Muted text on dark', '#b8a996'),
            'color_cream' => pw_f('color', 'Light background', '#f7f0e5'),
            'color_cream_alt' => pw_f('color', 'Light background (alternate)', '#efe5d6'),
            'color_ink' => pw_f('color', 'Text on light', '#1c130c'),
            'color_accent' => pw_f('color', 'Accent 1', '#ff8a3d'),
            'color_accent_2' => pw_f('color', 'Accent 2', '#ff4f7b'),
            'color_accent_3' => pw_f('color', 'Accent 3', '#9a6bff'),
            'font_heading' => pw_f('select', 'Heading font', 'Bricolage Grotesque', array('choices' => $fonts['heading'])),
            'font_body' => pw_f('select', 'Body font', 'Inter', array('choices' => $fonts['body'])),
            'radius' => pw_f('number', 'Corner roundness (px)', 22, array('min' => 0, 'max' => 48)),
            'fx_aurora' => pw_f('checkbox', 'Effect: glowing aurora behind the hero', true),
            'fx_web' => pw_f('checkbox', 'Effect: interactive dream web particles in the hero', true),
            'fx_cursor' => pw_f('checkbox', 'Effect: custom glowing cursor (desktop)', true),
            'fx_tilt' => pw_f('checkbox', 'Effect: 3D tilt and spotlight on cards (desktop)', true),
            'fx_magnetic' => pw_f('checkbox', 'Effect: magnetic buttons (desktop)', true),
            'fx_grain' => pw_f('checkbox', 'Effect: subtle film grain texture', true),
        ),
    );

    $fields['pw_header'] = array(
        'title' => 'Header',
        'description' => 'Upload your logo under Site Identity. The menu is built from the menu labels in each section.',
        'fields' => array(
            'logo_text' => pw_f('text', 'Brand name (shown when no logo is uploaded)', 'Passive Web'),
            'logo_tagline' => pw_f('text', 'Brand tagline', 'Dream Catchers'),
            'header_cta_text' => pw_f('text', 'Header button text', 'Get a free quote'),
            'header_cta_link' => pw_f('text', 'Header button link', '#contact'),
        ),
    );

    $fields['pw_hero'] = array(
        'title' => 'Hero',
        'fields' => array(
            'hero_eyebrow' => pw_f('text', 'Small label above the heading', 'Pretoria · South Africa · AI Engineers'),
            'hero_kicker' => pw_f('text', 'Heading line 1 (small, keyword rich)', 'Web design and development in Pretoria'),
            'hero_title' => pw_f('text', 'Heading line 2', 'We are'),
            'hero_highlight' => pw_f('text', 'Heading line 3 (gradient)', 'Dream Catchers'),
            'hero_build_prefix' => pw_f('text', 'Text before the rotating words', 'We build'),
            'hero_rotating' => pw_f('textarea', 'Rotating words (one per line)', "online businesses\npersonal websites\nlanding pages\nbusiness websites\nmobile apps\ncustom software\nanything you dream of"),
            'hero_text' => pw_f('textarea', 'Intro paragraph', 'Passive Web is a team of AI engineers in Pretoria, South Africa. We design and build websites, apps and software that are fast, secure and made to rank on Google, then we stay with you to help it grow.'),
            'hero_btn1_text' => pw_f('text', 'Main button text', 'Start my project'),
            'hero_btn1_link' => pw_f('text', 'Main button link', '#contact'),
            'hero_btn2_text' => pw_f('text', 'Second button text', 'Explore services'),
            'hero_btn2_link' => pw_f('text', 'Second button link', '#services'),
            'hero_badge_1' => pw_f('text', 'Badge 1', 'We beat any written quote'),
            'hero_badge_2' => pw_f('text', 'Badge 2', 'Free hosting for a limited period'),
            'hero_badge_3' => pw_f('text', 'Badge 3', '100% satisfaction or R0'),
            'hero_show_art' => pw_f('checkbox', 'Show the animated dream catcher', true),
            'hero_scroll_text' => pw_f('text', 'Scroll hint text', 'Scroll'),
        ),
    );

    $about = array(
        'about_enable' => pw_f('checkbox', 'Show this section', true),
        'about_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'Who we help'),
        'about_eyebrow' => pw_f('text', 'Small label', 'Who we help'),
        'about_title' => pw_f('text', 'Heading', 'Whatever you dream of online, we make it real'),
        'about_text' => pw_f('textarea', 'Paragraph', 'We are still dream catchers. Our aim is simple: help people who want to be online. Whether you are starting an online business, need a personal website, a landing page for your next campaign or a full business website, we take your idea and turn it into something that works and earns.'),
    );
    $audience = array(
        array('bag', 'Online business', 'Start selling online with a beautiful store, secure payments and everything set up for you.'),
        array('user', 'Personal website', 'Portfolios, CVs, blogs and personal brands that make you memorable and easy to find.'),
        array('target', 'Landing page', 'One focused, lightning fast page built to capture leads for a campaign, product or launch.'),
        array('briefcase', 'Business website', 'A professional website that builds trust, ranks on Google and brings in new enquiries.'),
        array('mobile', 'Web and mobile apps', 'Your app idea designed, built and launched on the web, Android and iOS.'),
        array('spark', 'Anything else', 'If you can dream it, we can build it. Any application, any requirement. Just ask.'),
    );
    foreach ($audience as $i => $a) {
        $n = $i + 1;
        $about["aud_{$n}_enable"] = pw_f('checkbox', "Card {$n}: show", true);
        $about["aud_{$n}_icon"] = pw_f('select', "Card {$n}: icon", $a[0], array('choices' => $icons));
        $about["aud_{$n}_title"] = pw_f('text', "Card {$n}: title", $a[1]);
        $about["aud_{$n}_text"] = pw_f('textarea', "Card {$n}: text", $a[2]);
    }
    $stats = array(
        array('', '7', '', 'Core services under one roof'),
        array('', '100', '%', 'Satisfaction or the charge is R0'),
        array('', '1', '', 'Team from idea to launch and beyond'),
        array('R', '0', '', 'Hosting for a limited period after launch'),
    );
    foreach ($stats as $i => $s) {
        $n = $i + 1;
        $about["stat_{$n}_enable"] = pw_f('checkbox', "Stat {$n}: show", true);
        $about["stat_{$n}_prefix"] = pw_f('text', "Stat {$n}: before number", $s[0]);
        $about["stat_{$n}_number"] = pw_f('number', "Stat {$n}: number", (int) $s[1], array('min' => 0, 'max' => 1000000));
        $about["stat_{$n}_suffix"] = pw_f('text', "Stat {$n}: after number", $s[2]);
        $about["stat_{$n}_label"] = pw_f('text', "Stat {$n}: label", $s[3]);
    }
    $fields['pw_about'] = array('title' => 'Section: Who we help', 'fields' => $about);

    $services = array(
        'services_enable' => pw_f('checkbox', 'Show this section', true),
        'services_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'Services'),
        'services_eyebrow' => pw_f('text', 'Small label', 'What we do'),
        'services_title' => pw_f('text', 'Heading', 'Every service your business needs online, under one roof'),
        'services_text' => pw_f('textarea', 'Paragraph', 'From the first sketch to the server it runs on, we cover every layer a modern business needs. Pick one service or hand us the whole project, either way it gets built properly.'),
    );
    $svc = array(
        array('design', 'Web Design', 'Pretoria web design that turns visitors into customers. Custom layouts, strong branding and pages that look and feel amazing on every screen.', 'UI and UX, Branding, Responsive'),
        array('code', 'Web Development', 'Fast, secure websites and web applications on WordPress or fully custom stacks, built to scale as your business grows.', 'WordPress, Custom builds, E-commerce'),
        array('layers', 'Software Development', 'Business systems, portals, dashboards and automation built around the way you actually work.', 'Custom software, APIs, Automation'),
        array('mobile', 'Mobile Applications', 'Android and iOS apps designed for real people, built to perform and launched to the app stores.', 'Android, iOS, Cross platform'),
        array('chart', 'Digital Marketing', 'SEO, Google Ads and social media campaigns that put your business in front of people ready to buy.', 'SEO, Google Ads, Social media'),
        array('server', 'Hosting and Maintenance', 'Fast managed hosting with backups, updates and monitoring, so your website stays online and up to date.', 'Managed hosting, Backups, Updates'),
        array('shield', 'Cyber Security', 'Security audits, hardening, SSL, firewalls and malware protection. We think like attackers so you do not have to.', 'Audits, Hardening, Protection'),
        array('cpu', '', '', ''),
        array('spark', '', '', ''),
    );
    foreach ($svc as $i => $s) {
        $n = $i + 1;
        $services["svc_{$n}_enable"] = pw_f('checkbox', "Service {$n}: show", '' !== $s[1]);
        $services["svc_{$n}_icon"] = pw_f('select', "Service {$n}: icon", $s[0], array('choices' => $icons));
        $services["svc_{$n}_title"] = pw_f('text', "Service {$n}: title", $s[1]);
        $services["svc_{$n}_text"] = pw_f('textarea', "Service {$n}: text", $s[2]);
        $services["svc_{$n}_tags"] = pw_f('text', "Service {$n}: tags (comma separated)", $s[3]);
    }
    $services['services_cta_text'] = pw_f('text', 'Text under the services', 'Not sure where to start? Tell us what you want to achieve and we will map out the right services for it.');
    $services['services_cta_btn'] = pw_f('text', 'Button text', 'Get a quote');
    $services['services_cta_link'] = pw_f('text', 'Button link', '#contact');
    $fields['pw_services'] = array('title' => 'Section: Services', 'fields' => $services);

    $ai = array(
        'ai_enable' => pw_f('checkbox', 'Show this section', true),
        'ai_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', ''),
        'ai_eyebrow' => pw_f('text', 'Small label', 'AI Engineers'),
        'ai_title' => pw_f('text', 'Heading', 'Built with the latest AI. Engineered for speed, security and search.'),
        'ai_text' => pw_f('textarea', 'Paragraph', 'We are AI engineers. We use the latest AI technologies to design and build advanced websites and applications, then optimise every single one so it loads fast, stays secure and gets found on search engines.'),
    );
    $pillars = array(
        array('zap', 'Optimised for speed', 'Lean code, optimised images and modern caching for near instant load times on any connection, including mobile data.'),
        array('shield', 'Secure by design', 'Hardened from day one with encryption, attack protection and secure coding, so your business and your customers stay safe.'),
        array('search', 'Search engine optimised', 'Clean structure, schema markup and tuned Core Web Vitals so Google can find you, understand you and rank you.'),
    );
    foreach ($pillars as $i => $p) {
        $n = $i + 1;
        $ai["pillar_{$n}_icon"] = pw_f('select', "Point {$n}: icon", $p[0], array('choices' => $icons));
        $ai["pillar_{$n}_title"] = pw_f('text', "Point {$n}: title", $p[1]);
        $ai["pillar_{$n}_text"] = pw_f('textarea', "Point {$n}: text", $p[2]);
    }
    $ai['ai_console_lines'] = pw_f('textarea', 'Console lines (first line is the command, one per line)', "build dream.site\nOptimising images and code\nHardening security\nGenerating structured data for Google\nReady to launch");
    $ai['ai_rings_caption'] = pw_f('text', 'Score rings caption', 'What every build is engineered for');
    $rings = array(array('Performance', 100), array('SEO', 100), array('Best practice', 100), array('Accessibility', 100));
    foreach ($rings as $i => $r) {
        $n = $i + 1;
        $ai["ring_{$n}_label"] = pw_f('text', "Ring {$n}: label", $r[0]);
        $ai["ring_{$n}_value"] = pw_f('number', "Ring {$n}: score (0 to 100)", $r[1], array('min' => 0, 'max' => 100));
    }
    $fields['pw_ai'] = array('title' => 'Section: AI Engineering', 'fields' => $ai);

    $inc = array(
        'included_enable' => pw_f('checkbox', 'Show this section', true),
        'included_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'All inclusive'),
        'included_eyebrow' => pw_f('text', 'Small label', 'We do everything'),
        'included_title' => pw_f('text', 'Heading', 'From business registration to launch day, we handle it all'),
        'included_text' => pw_f('textarea', 'Paragraph', 'Starting a business online has a lot of moving parts. We take care of every one of them, so you can focus on what you do best.'),
    );
    $items = array(
        array('building', 'Business registration', 'We register your company and get your business ready to trade properly.'),
        array('globe', 'Domain registration', 'We find and register the perfect .co.za or .com domain name for your brand.'),
        array('card', 'Payment gateway account', 'We register and connect your payment gateway account so you can accept online payments from day one.'),
        array('server', 'Free hosting', 'Your website is hosted free of charge for a limited period after launch.'),
        array('wrench', 'Free maintenance', 'Updates, backups and fixes are on us for a limited period too.'),
        array('rocket', 'Launch and growth', 'We launch it, then market it so real traffic starts flowing quickly.'),
    );
    foreach ($items as $i => $it) {
        $n = $i + 1;
        $inc["inc_{$n}_enable"] = pw_f('checkbox', "Item {$n}: show", true);
        $inc["inc_{$n}_icon"] = pw_f('select', "Item {$n}: icon", $it[0], array('choices' => $icons));
        $inc["inc_{$n}_title"] = pw_f('text', "Item {$n}: title", $it[1]);
        $inc["inc_{$n}_text"] = pw_f('textarea', "Item {$n}: text", $it[2]);
    }
    $inc['included_fineprint'] = pw_f('text', 'Small print', 'Free hosting and maintenance are included for a limited period. Ask us about the current offer.');
    $fields['pw_included'] = array('title' => 'Section: We do everything', 'fields' => $inc);

    $fields['pw_training'] = array(
        'title' => 'Section: AI Training',
        'fields' => array(
            'training_enable' => pw_f('checkbox', 'Show this section', true),
            'training_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'AI Training'),
            'training_eyebrow' => pw_f('text', 'Small label', 'AI Training'),
            'training_title' => pw_f('text', 'Heading', 'Put AI to work in your business'),
            'training_text' => pw_f('textarea', 'Paragraph', 'We train anybody who wants to use AI to help their business. Business owners, teams and individuals learn practical, hands on skills with no jargon, built around the work you actually do.'),
            'training_points' => pw_f('textarea', 'Points (one per line)', "Write content, emails and proposals in minutes\nAutomate repetitive admin and win back hours every week\nCreate images, video and marketing material with AI\nUse AI safely and keep your business data protected\nTraining for individuals, teams and whole companies"),
            'training_btn_text' => pw_f('text', 'Button text', 'Book AI training'),
            'training_btn_link' => pw_f('text', 'Button link', '#contact'),
            'training_demo_title' => pw_f('text', 'Chat demo title', 'AI assistant'),
            'training_demo_prompt' => pw_f('textarea', 'Chat demo question', 'Write a short welcome message for new customers of my bakery in Pretoria.'),
            'training_demo_input' => pw_f('text', 'Chat demo input placeholder', 'Ask anything'),
            'training_demo_reply' => pw_f('textarea', 'Chat demo answer', 'Welcome to the family! Every loaf, cake and pastry is baked fresh in Pretoria every morning. Show this message on your first visit and enjoy a free coffee on us.'),
        ),
    );

    $quote = array(
        'quote_enable' => pw_f('checkbox', 'Show this section', true),
        'quote_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', ''),
        'quote_ribbon' => pw_f('text', 'Giant moving background text', 'Beat any quote'),
        'quote_title' => pw_f('text', 'Heading', 'We beat any'),
        'quote_highlight' => pw_f('text', 'Heading highlight', 'written quote.'),
        'quote_text' => pw_f('textarea', 'Paragraph', 'Already have a written quote from another company? Send it to us. We will beat it, with the same quality or better.'),
        'quote_btn_text' => pw_f('text', 'Button text', 'Beat my quote'),
        'quote_btn_link' => pw_f('text', 'Button link', '#contact'),
    );
    $guar = array(
        array('spark', 'Any application, any requirement', 'If your business needs it built, we can build it, whatever the brief.'),
        array('heart', '100% satisfaction guaranteed', 'Not happy with the work? The charge is R0. Simple as that.'),
    );
    foreach ($guar as $i => $g) {
        $n = $i + 1;
        $quote["guar_{$n}_icon"] = pw_f('select', "Guarantee {$n}: icon", $g[0], array('choices' => $icons));
        $quote["guar_{$n}_title"] = pw_f('text', "Guarantee {$n}: title", $g[1]);
        $quote["guar_{$n}_text"] = pw_f('textarea', "Guarantee {$n}: text", $g[2]);
    }
    $fields['pw_quote'] = array('title' => 'Section: Beat any quote', 'fields' => $quote);

    $process = array(
        'process_enable' => pw_f('checkbox', 'Show this section', true),
        'process_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'Process'),
        'process_eyebrow' => pw_f('text', 'Small label', 'How it works'),
        'process_title' => pw_f('text', 'Heading', 'From dream to launch in four steps'),
    );
    $steps = array(
        array('Dream', 'Tell us what you want to achieve. We listen, ask the right questions and map out the best route.'),
        array('Design', 'We design your website or app and you approve every screen before a single line of code is written.'),
        array('Build', 'Our AI engineers build it fast, secure and search engine optimised, then test it on every device.'),
        array('Launch and grow', 'We launch, host, maintain and market it, and only hand over once everything works perfectly.'),
    );
    foreach ($steps as $i => $s) {
        $n = $i + 1;
        $process["step_{$n}_title"] = pw_f('text', "Step {$n}: title", $s[0]);
        $process["step_{$n}_text"] = pw_f('textarea', "Step {$n}: text", $s[1]);
    }
    $fields['pw_process'] = array('title' => 'Section: Process', 'fields' => $process);

    $faq = array(
        'faq_enable' => pw_f('checkbox', 'Show this section', true),
        'faq_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'FAQ'),
        'faq_eyebrow' => pw_f('text', 'Small label', 'Questions'),
        'faq_title' => pw_f('text', 'Heading', 'Web design in Pretoria, answered'),
        'faq_text' => pw_f('textarea', 'Paragraph', 'Still wondering about something? Ask us anything, we are happy to help.'),
    );
    $faqs = array(
        array('How much does web design in Pretoria cost?', 'Every project is different, so we quote on exactly what you need. Send us your brief and we will give you a clear written quote. If you already have a written quote from another company, we will beat it.'),
        array('How long does it take to build a website?', 'A landing page can be ready in days and a full business website usually takes a few weeks. Apps and custom software depend on the scope, and we always give you a timeline upfront.'),
        array('Can you register my business, domain and payment gateway?', 'Yes. We handle business registration, domain registration and payment gateway account registration for you, so you can start trading online without the admin headache.'),
        array('Is the hosting and maintenance really free?', 'Yes, hosting and maintenance are free for a limited period after your website launches. We explain the exact period in your quote, with no hidden costs.'),
        array('Do you only work with clients in Pretoria?', 'We are based in Pretoria and work with clients in Centurion, Midrand, Johannesburg, across Gauteng, all over South Africa and beyond.'),
        array('Do you offer AI training for businesses?', 'Yes. We train business owners, teams and individuals to use AI tools to save time, create content and grow their business, safely and practically.'),
        array('', ''),
        array('', ''),
    );
    foreach ($faqs as $i => $q) {
        $n = $i + 1;
        $faq["faq_{$n}_q"] = pw_f('text', "Question {$n}", $q[0]);
        $faq["faq_{$n}_a"] = pw_f('textarea', "Answer {$n}", $q[1]);
    }
    $fields['pw_faq'] = array('title' => 'Section: FAQ', 'description' => 'Leave a question empty to hide it. Questions are also added to Google as FAQ data.', 'fields' => $faq);

    $fields['pw_contact'] = array(
        'title' => 'Section: Contact',
        'description' => 'Form labels, options and the email address that receives quotes are under Passive Web Core, Quote Form.',
        'fields' => array(
            'contact_enable' => pw_f('checkbox', 'Show this section', true),
            'contact_nav' => pw_f('text', 'Menu label (empty hides it from the menu)', 'Contact'),
            'contact_eyebrow' => pw_f('text', 'Small label', 'Get in touch'),
            'contact_title' => pw_f('text', 'Heading', 'Let us catch your dream'),
            'contact_text' => pw_f('textarea', 'Paragraph', 'Tell us what you need. We reply quickly with a clear plan and a written quote that beats any other.'),
            'contact_email' => pw_f('email', 'Email address', 'hello@passiveweb.co.za'),
            'contact_phone' => pw_f('text', 'Phone number (empty hides it)', ''),
            'contact_whatsapp' => pw_f('text', 'WhatsApp number in international format, for example 27821234567 (empty hides it)', ''),
            'contact_address' => pw_f('text', 'Location', 'Pretoria, Gauteng, South Africa'),
            'contact_hours' => pw_f('text', 'Business hours (empty hides it)', ''),
            'social_facebook' => pw_f('url', 'Facebook URL', ''),
            'social_instagram' => pw_f('url', 'Instagram URL', ''),
            'social_linkedin' => pw_f('url', 'LinkedIn URL', ''),
            'social_x' => pw_f('url', 'X URL', ''),
            'social_tiktok' => pw_f('url', 'TikTok URL', ''),
            'social_youtube' => pw_f('url', 'YouTube URL', ''),
        ),
    );

    $fields['pw_footer'] = array(
        'title' => 'Footer',
        'fields' => array(
            'footer_big' => pw_f('text', 'Giant footer words', 'Dream Catchers'),
            'footer_text' => pw_f('textarea', 'Footer text', 'Web design, web development, software, mobile apps, digital marketing, hosting and cyber security by AI engineers in Pretoria, South Africa.'),
            'footer_copyright' => pw_f('text', 'Copyright line ({year} becomes the current year)', '© {year} Passive Web (Pty) Ltd. All rights reserved.'),
            'footer_top_text' => pw_f('text', 'Back to top text', 'Back to top'),
        ),
    );

    return $fields;
}

function pw_flat_fields()
{
    static $flat = null;
    if (null !== $flat) {
        return $flat;
    }
    $flat = array();
    foreach (pw_fields() as $section) {
        foreach ($section['fields'] as $key => $def) {
            $flat[$key] = $def;
        }
    }
    return $flat;
}
