<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_nav = pw_nav_items();
$pw_cta = pw_text('header_cta_text');
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<span id="top" class="pw-top-anchor"></span>
<?php echo pw_gradient_defs(); ?>
<a class="pw-skip" href="#main">Skip to content</a>
<div class="pw-progress" aria-hidden="true"><span data-progress></span></div>
<?php if (pw_on('fx_cursor')) : ?>
<div class="pw-cursor" aria-hidden="true" data-cursor><span class="pw-cursor__dot"></span><span class="pw-cursor__ring"></span></div>
<?php endif; ?>
<header class="pw-header" data-header>
    <div class="pw-container pw-header__inner">
        <a class="pw-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
            <?php if (has_custom_logo()) : ?>
                <?php
                $pw_logo_id = get_theme_mod('custom_logo');
                echo wp_get_attachment_image($pw_logo_id, 'full', false, array(
                    'class' => 'pw-brand__logo',
                    'alt' => esc_attr(pw_text('logo_text')),
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                ));
                ?>
            <?php else : ?>
                <?php echo pw_mark('pw-brand__mark'); ?>
                <span class="pw-brand__text">
                    <span class="pw-brand__name"><?php pw_e('logo_text'); ?></span>
                    <?php if ('' !== pw_text('logo_tagline')) : ?>
                        <span class="pw-brand__tag"><?php pw_e('logo_tagline'); ?></span>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </a>
        <nav class="pw-nav" id="pw-nav" aria-label="Main menu" data-nav>
            <?php if (!empty($pw_nav)) : ?>
                <ul class="pw-nav__list">
                    <?php foreach ($pw_nav as $pw_item) : ?>
                        <?php if (!empty($pw_item['children'])) : ?>
                            <li class="pw-nav__item pw-nav__item--sub" data-subnav>
                                <a class="pw-nav__link" href="<?php echo esc_url($pw_item['url']); ?>" data-nav-link="<?php echo esc_attr($pw_item['id']); ?>"><?php echo esc_html($pw_item['label']); ?></a>
                                <button class="pw-nav__toggle" type="button" aria-expanded="false" aria-controls="pw-sub-<?php echo esc_attr($pw_item['id']); ?>" aria-label="<?php echo esc_attr('Show ' . $pw_item['label']); ?>" data-subnav-toggle><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="6 9 12 15 18 9"/></svg></button>
                                <ul class="pw-nav__sub" id="pw-sub-<?php echo esc_attr($pw_item['id']); ?>">
                                    <?php foreach ($pw_item['children'] as $pw_child) : ?>
                                        <li><a class="pw-nav__sublink" href="<?php echo esc_url($pw_child['url']); ?>"<?php echo $pw_child['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html($pw_child['label']); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="pw-nav__item"><a class="pw-nav__link" href="<?php echo esc_url($pw_item['url']); ?>"<?php echo $pw_item['is_page'] ? '' : ' data-nav-link="' . esc_attr($pw_item['id']) . '"'; ?><?php echo $pw_item['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html($pw_item['label']); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ('' !== $pw_cta) : ?>
                <a class="pw-btn pw-btn--primary pw-btn--sm pw-nav__cta" href="<?php echo esc_url(pw_link(pw_mod('header_cta_link'))); ?>"<?php echo pw_on('fx_magnetic') ? ' data-magnetic' : ''; ?>><span class="pw-btn__label"><?php echo esc_html($pw_cta); ?></span><span class="pw-btn__icon" aria-hidden="true"><?php echo pw_icon('arrow'); ?></span></a>
            <?php endif; ?>
        </nav>
        <button class="pw-burger" type="button" aria-expanded="false" aria-controls="pw-nav" aria-label="Open menu" data-burger><span></span><span></span></button>
    </div>
</header>
<main id="main" class="pw-main">
