<?php
if (!defined('ABSPATH')) {
    exit;
}

define('PW_SERVICE_PAGES_VERSION', '1');

function pw_service_page_config()
{
    return array(
        'apps' => array(
            'slug' => 'mobile-app-development-pretoria',
            'page_title' => 'Mobile App Development Pretoria',
            'section_title' => 'Service page: Mobile apps',
            'choice' => 'Mobile app development page',
            'menu_label' => 'Mobile app development',
            'icon' => 'mobile',
            'card_text' => 'Android and iOS apps designed, built and launched to the app stores.',
            'seo_title' => 'Mobile App Development Pretoria | Android and iOS | Passive Web',
            'seo_desc' => 'Mobile app developers in Pretoria. We design, build and launch Android and iOS apps for businesses and startups, then market them. We beat any written quote.',
            'hero_eyebrow' => 'Pretoria · Android · iOS',
            'hero_kicker' => 'Mobile app development in Pretoria',
            'hero_title' => 'Your app idea,',
            'hero_highlight' => 'built and launched',
            'hero_text' => 'We are app developers in Pretoria who design, build and launch Android and iOS apps for businesses, startups and entrepreneurs. One team takes your idea from the first sketch to the app stores, then helps you get downloads.',
            'hero_btn1_text' => 'Start my app',
            'hero_btn2_text' => 'What we build',
            'badges' => array('Android and iOS from one codebase', 'We beat any written quote', '100% satisfaction or R0'),
            'intro_eyebrow' => 'App developers in Pretoria',
            'intro_title' => 'Mobile apps that people actually keep on their phones',
            'intro_text' => "A great app is more than a pretty screen. It has to load fast, work on cheap and expensive phones alike, keep data safe and make the next step obvious. That is what we build. Passive Web is a team of developers in Pretoria who design and develop mobile apps for Android and iOS, together with the backend, admin dashboard and website that a real app needs to run.\n\nMost of our apps are built cross platform, so one codebase runs natively on Android and iPhone. You get both platforms for less than the cost of building two separate apps, and every update reaches all your users at the same time. When a project needs fully native code, we build that too.\n\nWe work with Pretoria businesses that want an app for their customers or staff, and with founders who have an idea and need a technical team to make it real. We handle the whole project: planning, design, development, testing, app store submission, hosting and marketing after launch.",
            'feat_eyebrow' => 'What we build',
            'feat_title' => 'Mobile app development services',
            'feat_text' => 'Everything you need to go from idea to a live app with real users, under one roof.',
            'features' => array(
                array('mobile', 'Android and iOS apps', 'Cross platform apps that feel native on every phone, built with modern frameworks and tested on real devices before launch.', 'Android, iOS, Cross platform'),
                array('design', 'App design', 'Clear, beautiful screens and flows designed around your users. You approve every screen before development starts.', 'UI and UX, Prototypes, Branding'),
                array('server', 'Backends and APIs', 'Secure servers, databases and APIs that power your app, sync data between devices and scale as your users grow.', 'APIs, Databases, Cloud'),
                array('layers', 'Admin dashboards', 'A web dashboard where you manage users, content, orders and bookings without touching code.', 'Dashboards, Reports, User management'),
                array('card', 'Payments and bookings', 'Accept payments, take bookings and sell subscriptions inside your app with secure, trusted payment gateways.', 'Payments, Subscriptions, Bookings'),
                array('rocket', 'App store launch', 'We prepare your listings, submit your app to Google Play and the App Store, and handle the review process for you.', 'Google Play, App Store, Launch'),
            ),
            'why_eyebrow' => 'Why Passive Web',
            'why_title' => 'Why Pretoria businesses choose us for their app',
            'why_text' => 'You deal with one team from the first conversation to launch day and beyond.',
            'why' => array(
                array('user', 'One team, start to finish', 'Design, development, hosting and marketing in one place, so nothing falls between the cracks.'),
                array('shield', 'Secure by design', 'We think like attackers, so your users, their data and your business stay protected.'),
                array('zap', 'Fast on every phone', 'Lean, optimised code that runs smoothly on entry level phones and on mobile data.'),
                array('check', 'Handed over when it works', 'We only hand your app over once everything works perfectly on real devices.'),
                array('chart', 'Marketing after launch', 'We market your app so real downloads start coming in quickly.'),
                array('heart', '100% satisfaction or R0', 'Not happy with the work? The charge is R0. Simple as that.'),
            ),
            'faq_title' => 'Mobile app development in Pretoria, answered',
            'faqs' => array(
                array('How much does it cost to develop an app in Pretoria?', 'Every app is different, so we quote on exactly what you need. Send us your idea and we will give you a clear written quote. If you already have a written quote from another developer, we will beat it.'),
                array('How long does it take to build a mobile app?', 'A simple app can be ready in a few weeks, while larger apps with payments, bookings and dashboards take longer. We give you a timeline upfront and keep you updated at every step.'),
                array('Do you build apps for both Android and iPhone?', 'Yes. We usually build cross platform, so one codebase runs on Android and iOS. That saves you money and keeps both versions in step with every update.'),
                array('Can you publish my app to Google Play and the App Store?', 'Yes. We prepare the store listings, submit your app to Google Play and the App Store and handle the review process for you.'),
                array('Do I need a website as well as an app?', 'Most apps need a backend and an admin dashboard, and many benefit from a website or landing page that brings in downloads. We build all of it, so everything works together.'),
                array('Do you only work with clients in Pretoria?', 'We are based in Pretoria and work with clients in Centurion, Midrand, Johannesburg, across Gauteng, all over South Africa and beyond.'),
            ),
            'contact_title' => 'Tell us about your app idea',
            'contact_text' => 'Share your idea and we will reply with a clear plan and a written quote that beats any other.',
        ),
        'ai' => array(
            'slug' => 'ai-training-pretoria',
            'page_title' => 'AI Training Pretoria',
            'section_title' => 'Service page: AI training',
            'choice' => 'AI training page',
            'menu_label' => 'AI training',
            'icon' => 'cap',
            'card_text' => 'Practical AI training for business owners, teams and individuals.',
            'seo_title' => 'AI Training Pretoria | AI Courses for Business | Passive Web',
            'seo_desc' => 'Practical AI training in Pretoria for business owners, teams and individuals. Learn to use AI tools to write, automate admin and market your business safely.',
            'hero_eyebrow' => 'Pretoria · Businesses · Teams',
            'hero_kicker' => 'AI training in Pretoria',
            'hero_title' => 'Put AI to work',
            'hero_highlight' => 'in your business',
            'hero_text' => 'We train business owners, teams and individuals in Pretoria to use AI in their everyday work. Practical, hands on sessions with no jargon, built around the work you actually do, taught by AI engineers who build with these tools every day.',
            'hero_btn1_text' => 'Book AI training',
            'hero_btn2_text' => 'What you will learn',
            'badges' => array('Hands on and practical', 'For individuals, teams and companies', 'Taught by AI engineers'),
            'intro_eyebrow' => 'AI training for business',
            'intro_title' => 'Learn the AI skills that save your business hours every week',
            'intro_text' => "AI tools can write, summarise, research, design and automate, but most people only scratch the surface. Our AI training in Pretoria shows you exactly how to use them in your business, step by step, with real tasks from your own work. You leave each session with skills you can use the same day.\n\nWe are AI engineers. We use AI every day to design and build websites, apps and marketing campaigns, so we teach what actually works in a real business, not theory. Whether you have never opened an AI tool or you already use one and want to get more out of it, we start where you are.\n\nWe also cover the part most courses skip: using AI safely. You learn what never to paste into an AI tool, how to check its answers and how to keep your business and customer data protected.",
            'feat_eyebrow' => 'What you will learn',
            'feat_title' => 'AI training built around your work',
            'feat_text' => 'Pick the topics that matter to your business, or let us put together a programme for your team.',
            'features' => array(
                array('chat', 'AI for writing', 'Write emails, proposals, quotes, social posts and website content in minutes, in your own voice.', 'Emails, Proposals, Content'),
                array('zap', 'Automate admin', 'Hand repetitive admin to AI and win back hours every week, from summarising documents to sorting enquiries.', 'Automation, Summaries, Workflows'),
                array('design', 'AI for marketing', 'Create images, video ideas, adverts and campaign plans with AI, then turn them into material that sells.', 'Images, Adverts, Campaigns'),
                array('search', 'Research and analysis', 'Use AI to research competitors, analyse data and spreadsheets, and turn information into decisions.', 'Research, Data, Reports'),
                array('shield', 'Safe and responsible AI', 'Learn what to share and what never to share, how to check AI answers and how to protect your data.', 'Privacy, Accuracy, Policies'),
                array('cpu', 'AI for your team', 'Training for whole teams, so everyone uses the same tools and methods and the business benefits together.', 'Teams, Companies, Workshops'),
            ),
            'why_eyebrow' => 'Why train with us',
            'why_title' => 'AI training from people who build with AI every day',
            'why_text' => 'Practical skills, taught in plain language, by engineers who use these tools on real projects.',
            'why' => array(
                array('cpu', 'Taught by AI engineers', 'We use AI daily to build websites, apps and campaigns, so we teach what works.'),
                array('target', 'Built around your work', 'Every exercise uses tasks from your business, so the skills stick.'),
                array('user', 'For every level', 'From complete beginners to people who want more from the tools they already use.'),
                array('briefcase', 'Individuals, teams and companies', 'Train on your own, with your team or across your whole company.'),
                array('shield', 'Safe by default', 'We show you how to use AI without putting your business or customer data at risk.'),
                array('rocket', 'Skills you use the same day', 'You leave every session ready to use what you learned in your own work.'),
            ),
            'faq_title' => 'AI training in Pretoria, answered',
            'faqs' => array(
                array('Who is the AI training for?', 'Business owners, teams and individuals who want to use AI to save time, create content and grow. No technical background is needed.'),
                array('Do I need any experience with AI?', 'No. We start where you are. Beginners learn the basics step by step, and people who already use AI learn how to get far more out of it.'),
                array('Which AI tools will we use?', 'We teach the leading AI assistants and tools for writing, images, research and automation, and we focus on the ones that fit your business and budget.'),
                array('Can you train my whole team?', 'Yes. We train individuals, teams and whole companies, and we tailor the content to your industry and the work your team does.'),
                array('Is it safe to use AI with business information?', 'It can be, if you know the rules. Our training shows you what never to share, how to check answers and how to keep your business and customer data protected.'),
                array('Where does the training take place?', 'We are based in Pretoria. Contact us and we will arrange the training in the way that suits you and your team.'),
            ),
            'contact_title' => 'Book your AI training',
            'contact_text' => 'Tell us who needs training and what you want to achieve. We will reply with a plan and a clear written quote.',
        ),
        'hosting' => array(
            'slug' => 'web-hosting-pretoria',
            'page_title' => 'Web Hosting Pretoria',
            'section_title' => 'Service page: Web hosting',
            'choice' => 'Web hosting page',
            'menu_label' => 'Web hosting',
            'icon' => 'server',
            'card_text' => 'Fast, secure managed hosting with backups, updates and monitoring.',
            'seo_title' => 'Web Hosting Pretoria | Managed Website Hosting | Passive Web',
            'seo_desc' => 'Managed web hosting in Pretoria with SSL, backups, updates and security, run by developers. Free hosting for a limited period with every new website.',
            'hero_eyebrow' => 'Pretoria · Managed hosting · Maintenance',
            'hero_kicker' => 'Web hosting in Pretoria',
            'hero_title' => 'Hosting that is',
            'hero_highlight' => 'fast, safe and looked after',
            'hero_text' => 'Passive Web offers managed web hosting in Pretoria for business websites, online stores and web apps. Your site runs on fast, secure servers, and the developers who look after it handle updates, backups and security for you.',
            'hero_btn1_text' => 'Host my website',
            'hero_btn2_text' => 'What is included',
            'badges' => array('Free hosting for a limited period', 'SSL certificate included', 'Looked after by developers'),
            'intro_eyebrow' => 'Managed hosting',
            'intro_title' => 'Web hosting that comes with a team behind it',
            'intro_text' => "Cheap hosting is easy to find. What is hard to find is hosting where someone actually looks after your website. With Passive Web, your site is hosted, updated, backed up and secured by the same developers who build websites every day, so when something needs attention it gets fixed properly and quickly.\n\nEvery website we build includes free hosting and maintenance for a limited period after launch. After that you can keep your site with us on managed hosting, so it stays fast, secure and online without you having to think about it.\n\nAlready have a website somewhere else? We can move it to our hosting, check it for problems, speed it up and harden its security along the way.",
            'feat_eyebrow' => 'What is included',
            'feat_title' => 'Managed web hosting and maintenance',
            'feat_text' => 'Hosting, maintenance and security in one service, so your website stays online and up to date.',
            'features' => array(
                array('server', 'Managed hosting', 'Fast, reliable hosting for WordPress and custom websites, set up and tuned by developers.', 'WordPress, Custom sites, Web apps'),
                array('shield', 'Security and SSL', 'SSL certificates, firewalls, malware protection and security hardening to keep attackers out.', 'SSL, Firewall, Hardening'),
                array('layers', 'Backups', 'Regular backups of your files and database, so your website can be restored if anything goes wrong.', 'Files, Databases, Restores'),
                array('wrench', 'Updates and maintenance', 'Core, theme and plugin updates, fixes and small changes handled for you.', 'Updates, Fixes, Changes'),
                array('zap', 'Speed optimisation', 'Caching, image optimisation and tuning so your website loads fast and ranks better on Google.', 'Caching, Images, Core Web Vitals'),
                array('globe', 'Domain registration', 'We register and manage your .co.za or .com domain and connect it to your website.', 'Domains, DNS, .co.za'),
            ),
            'why_eyebrow' => 'Why host with us',
            'why_title' => 'Why Pretoria businesses host with Passive Web',
            'why_text' => 'Hosting from the people who build websites, so you get real help when you need it.',
            'why' => array(
                array('user', 'Real developers, not a call centre', 'When something needs attention, it is handled by people who build websites every day.'),
                array('server', 'Free for a limited period', 'Every new website we build comes with free hosting and maintenance for a limited period.'),
                array('shield', 'Security first', 'We think like attackers and harden every website we host.'),
                array('zap', 'Built for speed', 'Fast hosting and tuned websites help your visitors and your Google rankings.'),
                array('rocket', 'Moving made easy', 'We move your existing website for you and check it along the way.'),
                array('check', 'One team for everything', 'Hosting, maintenance, design, development and marketing under one roof.'),
            ),
            'faq_title' => 'Web hosting in Pretoria, answered',
            'faqs' => array(
                array('How much does web hosting cost?', 'It depends on your website and the level of maintenance you need. Contact us for a clear written quote. Every new website we build includes free hosting for a limited period.'),
                array('Is the hosting really free with a new website?', 'Yes. Hosting and maintenance are free for a limited period after your new website launches. We explain the exact period in your quote, with no hidden costs.'),
                array('Can you move my existing website to your hosting?', 'Yes. We move your website and its data for you, check that everything works and let you know about any problems we find along the way.'),
                array('Do you host WordPress websites?', 'Yes. We host and maintain WordPress websites as well as custom websites and web applications.'),
                array('What happens if my website goes down?', 'We keep backups and look after your website, so if something goes wrong we restore it and get you back online as quickly as possible.'),
                array('Do you only host websites for clients in Pretoria?', 'We are based in Pretoria and host websites for clients across Gauteng, all over South Africa and beyond.'),
            ),
            'contact_title' => 'Get your website hosted properly',
            'contact_text' => 'Tell us about your website and we will reply with a clear written quote for hosting and maintenance.',
        ),
    );
}

function pw_service_keys()
{
    return array_keys(pw_service_page_config());
}

function pw_service_choices()
{
    $choices = array('' => 'No link');
    foreach (pw_service_page_config() as $key => $cfg) {
        $choices[$key] = $cfg['choice'];
    }
    return $choices;
}

function pw_service_page_sections()
{
    $icons = pw_icon_choices();
    $sections = array();

    $sections['pw_sp_general'] = array(
        'title' => 'All service pages',
        'panel' => 'pw_sp_panel',
        'description' => 'Settings shared by every service page. Each service page is a normal WordPress page, so it appears in your sitemap and can be linked anywhere.',
        'fields' => array(
            'sp_show_quote' => pw_f('checkbox', 'Show the Beat any quote section on service pages', true),
            'sp_show_process' => pw_f('checkbox', 'Show the Process section on service pages', true),
            'sp_related_enable' => pw_f('checkbox', 'Show links to the other services', true),
            'sp_related_eyebrow' => pw_f('text', 'Other services: small label', 'More from Passive Web'),
            'sp_related_title' => pw_f('text', 'Other services: heading', 'Explore our other services'),
            'sp_home_title' => pw_f('text', 'Home page card: title', 'Web design in Pretoria'),
            'sp_home_text' => pw_f('textarea', 'Home page card: text', 'Custom websites that look amazing, load fast and rank on Google.'),
            'sp_home_icon' => pw_f('select', 'Home page card: icon', 'design', array('choices' => $icons)),
            'sp_faq_eyebrow' => pw_f('text', 'FAQ small label', 'Questions'),
            'sp_faq_text' => pw_f('textarea', 'FAQ paragraph', 'Still wondering about something? Ask us anything, we are happy to help.'),
        ),
    );

    foreach (pw_service_page_config() as $key => $cfg) {
        $p = "sp_{$key}_";
        $f = array(
            $p . 'page' => pw_f('page', 'Page that shows this service', 0, array('description' => 'Created for you automatically. Choose another page here to move the service.')),
            $p . 'menu_label' => pw_f('text', 'Service name (used in links, the footer and Google data)', $cfg['menu_label']),
            $p . 'icon' => pw_f('select', 'Icon (used in links to this page)', $cfg['icon'], array('choices' => $icons)),
            $p . 'card_text' => pw_f('textarea', 'Short description (used in links to this page)', $cfg['card_text']),
            $p . 'seo_title' => pw_f('text', 'Google search title', $cfg['seo_title'], array('description' => 'Keep it under 60 characters.')),
            $p . 'seo_desc' => pw_f('textarea', 'Google search description', $cfg['seo_desc'], array('description' => 'Keep it under 160 characters.')),
            $p . 'hero_eyebrow' => pw_f('text', 'Hero: small label', $cfg['hero_eyebrow']),
            $p . 'hero_kicker' => pw_f('text', 'Hero: heading line 1 (main keyword)', $cfg['hero_kicker']),
            $p . 'hero_title' => pw_f('text', 'Hero: heading line 2', $cfg['hero_title']),
            $p . 'hero_highlight' => pw_f('text', 'Hero: heading line 3 (gradient)', $cfg['hero_highlight']),
            $p . 'hero_text' => pw_f('textarea', 'Hero: intro paragraph', $cfg['hero_text']),
            $p . 'hero_btn1_text' => pw_f('text', 'Hero: main button text', $cfg['hero_btn1_text']),
            $p . 'hero_btn1_link' => pw_f('text', 'Hero: main button link', '#contact'),
            $p . 'hero_btn2_text' => pw_f('text', 'Hero: second button text', $cfg['hero_btn2_text']),
            $p . 'hero_btn2_link' => pw_f('text', 'Hero: second button link', '#features'),
        );
        foreach ($cfg['badges'] as $i => $badge) {
            $n = $i + 1;
            $f[$p . "badge_{$n}"] = pw_f('text', "Hero: badge {$n}", $badge);
        }
        $f[$p . 'intro_eyebrow'] = pw_f('text', 'Intro: small label', $cfg['intro_eyebrow']);
        $f[$p . 'intro_title'] = pw_f('text', 'Intro: heading', $cfg['intro_title']);
        $f[$p . 'intro_text'] = pw_f('textarea', 'Intro: text (leave an empty line between paragraphs)', $cfg['intro_text']);
        $f[$p . 'feat_eyebrow'] = pw_f('text', 'Services: small label', $cfg['feat_eyebrow']);
        $f[$p . 'feat_title'] = pw_f('text', 'Services: heading', $cfg['feat_title']);
        $f[$p . 'feat_text'] = pw_f('textarea', 'Services: paragraph', $cfg['feat_text']);
        foreach ($cfg['features'] as $i => $feat) {
            $n = $i + 1;
            $f[$p . "feat_{$n}_icon"] = pw_f('select', "Service {$n}: icon", $feat[0], array('choices' => $icons));
            $f[$p . "feat_{$n}_title"] = pw_f('text', "Service {$n}: title (empty hides it)", $feat[1]);
            $f[$p . "feat_{$n}_text"] = pw_f('textarea', "Service {$n}: text", $feat[2]);
            $f[$p . "feat_{$n}_tags"] = pw_f('text', "Service {$n}: tags (comma separated)", $feat[3]);
        }
        $f[$p . 'why_eyebrow'] = pw_f('text', 'Why us: small label', $cfg['why_eyebrow']);
        $f[$p . 'why_title'] = pw_f('text', 'Why us: heading', $cfg['why_title']);
        $f[$p . 'why_text'] = pw_f('textarea', 'Why us: paragraph', $cfg['why_text']);
        foreach ($cfg['why'] as $i => $why) {
            $n = $i + 1;
            $f[$p . "why_{$n}_icon"] = pw_f('select', "Reason {$n}: icon", $why[0], array('choices' => $icons));
            $f[$p . "why_{$n}_title"] = pw_f('text', "Reason {$n}: title (empty hides it)", $why[1]);
            $f[$p . "why_{$n}_text"] = pw_f('textarea', "Reason {$n}: text", $why[2]);
        }
        $f[$p . 'faq_title'] = pw_f('text', 'FAQ: heading', $cfg['faq_title']);
        for ($n = 1; $n <= 8; $n++) {
            $faq = isset($cfg['faqs'][$n - 1]) ? $cfg['faqs'][$n - 1] : array('', '');
            $f[$p . "faq_{$n}_q"] = pw_f('text', "Question {$n} (empty hides it)", $faq[0]);
            $f[$p . "faq_{$n}_a"] = pw_f('textarea', "Answer {$n}", $faq[1]);
        }
        $f[$p . 'contact_title'] = pw_f('text', 'Contact: heading', $cfg['contact_title']);
        $f[$p . 'contact_text'] = pw_f('textarea', 'Contact: paragraph', $cfg['contact_text']);

        $sections['pw_sp_' . $key] = array(
            'title' => $cfg['section_title'],
            'panel' => 'pw_sp_panel',
            'fields' => $f,
        );
    }

    return $sections;
}

function pw_sp_key($key, $field)
{
    return 'sp_' . $key . '_' . $field;
}

function pw_sp_text($key, $field)
{
    return pw_text(pw_sp_key($key, $field));
}

function pw_service_page_id($key)
{
    if (!in_array($key, pw_service_keys(), true)) {
        return 0;
    }
    $id = absint(pw_mod(pw_sp_key($key, 'page')));
    if (!$id || 'page' !== get_post_type($id) || 'publish' !== get_post_status($id)) {
        return 0;
    }
    return $id;
}

function pw_service_url($key)
{
    $id = pw_service_page_id($key);
    return $id ? (string) get_permalink($id) : '';
}

function pw_current_service()
{
    if (!is_page()) {
        return '';
    }
    $current = (int) get_queried_object_id();
    if (!$current) {
        return '';
    }
    foreach (pw_service_keys() as $key) {
        if (pw_service_page_id($key) === $current) {
            return $key;
        }
    }
    return '';
}

function pw_service_links($exclude = '')
{
    $links = array();
    foreach (pw_service_keys() as $key) {
        if ($key === $exclude) {
            continue;
        }
        $url = pw_service_url($key);
        $label = pw_sp_text($key, 'menu_label');
        if ('' === $url || '' === $label) {
            continue;
        }
        $links[] = array(
            'key' => $key,
            'url' => $url,
            'label' => $label,
            'icon' => pw_mod(pw_sp_key($key, 'icon')),
            'text' => pw_sp_text($key, 'card_text'),
        );
    }
    return $links;
}

function pw_service_features($key)
{
    $items = array();
    for ($n = 1; $n <= 6; $n++) {
        $title = pw_sp_text($key, "feat_{$n}_title");
        if ('' === $title) {
            continue;
        }
        $items[] = array(
            'icon' => pw_mod(pw_sp_key($key, "feat_{$n}_icon")),
            'title' => $title,
            'text' => pw_sp_text($key, "feat_{$n}_text"),
            'tags' => pw_tags(pw_sp_key($key, "feat_{$n}_tags")),
        );
    }
    return $items;
}

function pw_service_reasons($key)
{
    $items = array();
    for ($n = 1; $n <= 6; $n++) {
        $title = pw_sp_text($key, "why_{$n}_title");
        if ('' === $title) {
            continue;
        }
        $items[] = array(
            'icon' => pw_mod(pw_sp_key($key, "why_{$n}_icon")),
            'title' => $title,
            'text' => pw_sp_text($key, "why_{$n}_text"),
        );
    }
    return $items;
}

function pw_service_faqs($key)
{
    $items = array();
    for ($n = 1; $n <= 8; $n++) {
        $q = pw_sp_text($key, "faq_{$n}_q");
        $a = pw_sp_text($key, "faq_{$n}_a");
        if ('' !== $q && '' !== $a) {
            $items[] = array('q' => $q, 'a' => $a);
        }
    }
    return $items;
}

function pw_local_anchors()
{
    if (is_front_page()) {
        return array();
    }
    $key = pw_current_service();
    if ('' === $key) {
        return array();
    }
    $anchors = array('home', 'intro', 'features', 'why', 'contact');
    if (!empty(pw_service_faqs($key))) {
        $anchors[] = 'faq';
    }
    if (pw_on('sp_show_quote') && pw_section_enabled('quote')) {
        $anchors[] = 'quote';
    }
    if (pw_on('sp_show_process') && pw_section_enabled('process')) {
        $anchors[] = 'process';
    }
    return $anchors;
}

function pw_service_template($template)
{
    if ('' === pw_current_service()) {
        return $template;
    }
    $located = locate_template('service-page.php');
    return '' !== $located ? $located : $template;
}
add_filter('template_include', 'pw_service_template', 20);

function pw_ensure_service_pages()
{
    if (wp_doing_ajax() || !current_user_can('publish_pages')) {
        return;
    }
    if (PW_SERVICE_PAGES_VERSION === get_option('pw_service_pages_version')) {
        return;
    }
    foreach (pw_service_page_config() as $key => $cfg) {
        if (pw_service_page_id($key)) {
            continue;
        }
        $existing = get_page_by_path($cfg['slug'], OBJECT, 'page');
        if ($existing instanceof WP_Post) {
            if ('publish' === $existing->post_status) {
                set_theme_mod(pw_sp_key($key, 'page'), (int) $existing->ID);
            }
            continue;
        }
        $id = wp_insert_post(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_title' => $cfg['page_title'],
            'post_name' => $cfg['slug'],
            'post_content' => '',
            'post_author' => get_current_user_id(),
            'comment_status' => 'closed',
            'ping_status' => 'closed',
        ), true);
        if (!is_wp_error($id) && $id) {
            set_theme_mod(pw_sp_key($key, 'page'), (int) $id);
        }
    }
    update_option('pw_service_pages_version', PW_SERVICE_PAGES_VERSION, false);
}
add_action('admin_init', 'pw_ensure_service_pages');
add_action('after_switch_theme', 'pw_ensure_service_pages');

function pw_service_page_state($states, $post)
{
    foreach (pw_service_keys() as $key) {
        if (pw_service_page_id($key) === (int) $post->ID) {
            $states['pw_service'] = 'Service page, edit in Customizer';
        }
    }
    return $states;
}
add_filter('display_post_states', 'pw_service_page_state', 10, 2);
