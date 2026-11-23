<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_projects = pw_get_projects((int) pw_mod('work_limit'));
if (empty($pw_projects)) {
    return;
}
$pw_visit = pw_text('work_visit_text');
?>
<section class="pw-section pw-section--light pw-work" id="work">
    <div class="pw-container">
        <div class="pw-head pw-head--split">
            <div>
                <?php pw_eyebrow('work_eyebrow'); ?>
                <?php pw_heading(pw_text('work_title')); ?>
            </div>
            <?php if ('' !== pw_text('work_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('work_text'); ?></div>
            <?php endif; ?>
        </div>
        <ul class="pw-work__grid" data-stagger>
            <?php foreach ($pw_projects as $pw_i => $pw_project) : ?>
                <li class="pw-card pw-card--light pw-project" data-reveal style="--i:<?php echo (int) $pw_i; ?>"<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <div class="pw-project__frame">
                        <span class="pw-project__bar" aria-hidden="true"><span></span><span></span><span></span><?php if ('' !== $pw_project['host']) : ?><em><?php echo esc_html($pw_project['host']); ?></em><?php endif; ?></span>
                        <?php if ($pw_project['shot']) : ?>
                            <?php echo wp_get_attachment_image($pw_project['shot'], 'pw-shot', false, array(
                                'class' => 'pw-project__shot',
                                'loading' => 'lazy',
                                'decoding' => 'async',
                                'sizes' => '(max-width: 640px) 100vw, (max-width: 1100px) 50vw, 400px',
                                'alt' => sprintf('%s website screenshot', $pw_project['title']),
                            )); ?>
                        <?php else : ?>
                            <span class="pw-project__placeholder" aria-hidden="true"><?php echo esc_html('' !== $pw_project['host'] ? $pw_project['host'] : $pw_project['title']); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ('' !== $pw_project['tag']) : ?>
                        <p class="pw-project__tag"><?php echo esc_html($pw_project['tag']); ?></p>
                    <?php endif; ?>
                    <h3 class="pw-card__title"><?php echo esc_html($pw_project['title']); ?></h3>
                    <?php if ('' !== $pw_project['excerpt']) : ?>
                        <p class="pw-card__text"><?php echo esc_html($pw_project['excerpt']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($pw_project['services'])) : ?>
                        <ul class="pw-tags">
                            <?php foreach ($pw_project['services'] as $pw_service) : ?>
                                <li><?php echo esc_html($pw_service); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ('' !== $pw_project['url'] && '' !== $pw_visit) : ?>
                        <a class="pw-card__more pw-project__link" href="<?php echo esc_url($pw_project['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($pw_visit); ?><span class="screen-reader-text"> <?php echo esc_html($pw_project['title']); ?> (opens in a new tab)</span><span aria-hidden="true"><?php echo pw_icon('arrow'); ?></span></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
