<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_icon_paths()
{
    return array(
        'design' => '<path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/><circle cx="11" cy="11" r="2"/>',
        'code' => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/><line x1="14" y1="4" x2="10" y2="20"/>',
        'layers' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
        'mobile' => '<rect x="5" y="2" width="14" height="20" rx="3"/><line x1="11" y1="18" x2="13" y2="18"/>',
        'chart' => '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
        'server' => '<rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>',
        'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>',
        'cpu' => '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>',
        'zap' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'bag' => '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'user' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'target' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'spark' => '<path d="M12 2l2.2 6.6L21 11l-6.8 2.4L12 20l-2.2-6.6L3 11l6.8-2.4z"/><path d="M19 2v4M17 4h4"/>',
        'building' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M12 6h.01M16 6h.01M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"/>',
        'globe' => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        'card' => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/><line x1="5" y1="15" x2="9" y2="15"/>',
        'wrench' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        'cap' => '<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/><line x1="22" y1="10" x2="22" y2="16"/>',
        'rocket' => '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>',
        'heart' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        'check' => '<polyline points="20 6 9 17 4 12"/>',
        'chat' => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>',
        'arrow' => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'arrow-up' => '<line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>',
        'mail' => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'pin' => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'whatsapp' => '<path d="M3 21l1.65-4.65A9 9 0 1 1 8.4 19.9z"/><path d="M9 9.5c.3 2.6 2.4 4.9 5.5 5.5l1.1-1.4-1.9-1-0.9.8c-.9-.4-1.7-1.2-2.2-2.2l.8-.9-1-1.9z"/>',
        'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
        'linkedin' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
        'x' => '<path d="M4 4l16 16"/><path d="M20 4L4 20"/>',
        'tiktok' => '<path d="M9 12a4 4 0 1 0 4 4V3c.8 2.4 2.8 4 5 4"/>',
        'youtube' => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>',
    );
}

function pw_icon($name, $class = 'pw-icon')
{
    $paths = pw_icon_paths();
    if (!isset($paths[$name])) {
        $name = 'spark';
    }
    return '<svg class="' . esc_attr($class) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[$name] . '</svg>';
}

function pw_mark($class = 'pw-mark')
{
    return '<svg class="' . esc_attr($class) . '" viewBox="0 0 48 48" width="40" height="40" aria-hidden="true" focusable="false"><circle cx="24" cy="24" r="20" fill="none" stroke="url(#pw-grad)" stroke-width="3"/><path d="M24 6L36 30H12z M24 42L12 18h24z" fill="none" stroke="url(#pw-grad)" stroke-width="1.6" stroke-linejoin="round"/><circle cx="24" cy="24" r="3.4" fill="url(#pw-grad)"/></svg>';
}

function pw_dreamcatcher()
{
    $cx = 200;
    $cy = 190;
    $r = 160;
    $out = '<svg class="pw-dc" viewBox="0 0 400 600" width="400" height="600" aria-hidden="true" focusable="false">';
    $out .= '<defs><linearGradient id="pw-dc-grad" gradientUnits="userSpaceOnUse" x1="40" y1="20" x2="360" y2="560"><stop offset="0%" style="stop-color:var(--a1)"/><stop offset="50%" style="stop-color:var(--a2)"/><stop offset="100%" style="stop-color:var(--a3)"/></linearGradient><radialGradient id="pw-dc-glow" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:var(--a2);stop-opacity:.45"/><stop offset="60%" style="stop-color:var(--a3);stop-opacity:.12"/><stop offset="100%" style="stop-color:var(--a3);stop-opacity:0"/></radialGradient></defs>';
    $out .= '<circle class="pw-dc__halo" cx="' . $cx . '" cy="' . $cy . '" r="200" fill="url(#pw-dc-glow)"/>';

    $out .= '<g class="pw-dc__ring">';
    $out .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" fill="none" stroke="url(#pw-dc-grad)" stroke-width="7"/>';
    $out .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . ($r - 12) . '" fill="none" stroke="url(#pw-dc-grad)" stroke-width="1" stroke-dasharray="2 9" opacity=".7"/>';
    $out .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . ($r + 12) . '" fill="none" stroke="url(#pw-dc-grad)" stroke-width="1" stroke-dasharray="40 14" opacity=".45"/>';
    for ($i = 0; $i < 36; $i++) {
        $a = deg2rad($i * 10);
        $x = round($cx + cos($a) * $r, 2);
        $y = round($cy + sin($a) * $r, 2);
        $out .= '<circle class="pw-dc__wrap" cx="' . $x . '" cy="' . $y . '" r="' . (0 === $i % 3 ? 4.5 : 2.2) . '"/>';
    }
    $out .= '</g>';

    $levels = array($r - 18, 116, 80, 48, 22);
    $points = 12;
    $grid = array();
    foreach ($levels as $li => $lr) {
        $row = array();
        $offset = deg2rad($li * 15);
        for ($p = 0; $p < $points; $p++) {
            $a = $offset + deg2rad($p * (360 / $points));
            $row[] = array(round($cx + cos($a) * $lr, 2), round($cy + sin($a) * $lr, 2));
        }
        $grid[] = $row;
    }
    $out .= '<g class="pw-dc__web" fill="none" stroke="url(#pw-dc-grad)" stroke-width="1.15" stroke-linejoin="round">';
    foreach ($grid as $li => $row) {
        if (0 === $li) {
            continue;
        }
        $pts = array();
        foreach ($row as $pt) {
            $pts[] = $pt[0] . ',' . $pt[1];
        }
        $out .= '<polygon points="' . implode(' ', $pts) . '" opacity="' . (0.95 - $li * 0.12) . '"/>';
    }
    for ($li = 0; $li < count($grid) - 1; $li++) {
        for ($p = 0; $p < $points; $p++) {
            $a = $grid[$li][$p];
            $b = $grid[$li + 1][$p];
            $c = $grid[$li + 1][($p + $points - 1) % $points];
            $out .= '<path d="M' . $a[0] . ' ' . $a[1] . 'L' . $b[0] . ' ' . $b[1] . 'M' . $a[0] . ' ' . $a[1] . 'L' . $c[0] . ' ' . $c[1] . '" opacity=".75"/>';
        }
    }
    $out .= '</g>';

    $out .= '<g class="pw-dc__beads">';
    foreach (array(1, 3) as $li) {
        foreach ($grid[$li] as $p => $pt) {
            if (0 === $p % 3) {
                $out .= '<circle cx="' . $pt[0] . '" cy="' . $pt[1] . '" r="3.2"/>';
            }
        }
    }
    $out .= '</g>';
    $out .= '<circle class="pw-dc__core" cx="' . $cx . '" cy="' . $cy . '" r="9" fill="url(#pw-dc-grad)"/>';

    $feathers = array(array(118, 0), array(200, 1), array(282, 2));
    foreach ($feathers as $f) {
        $fx = $f[0];
        $top = 200 === $fx ? $cy + $r : $cy + (int) round(sqrt(max(0, $r * $r - ($fx - $cx) * ($fx - $cx))));
        $len = 200 === $fx ? 90 : 60;
        $fy = $top + $len;
        $out .= '<g class="pw-dc__feather" style="--d:' . ($f[1] * 0.6) . 's">';
        $out .= '<line x1="' . $fx . '" y1="' . $top . '" x2="' . $fx . '" y2="' . $fy . '" stroke="url(#pw-dc-grad)" stroke-width="1.4"/>';
        $out .= '<circle class="pw-dc__bead" cx="' . $fx . '" cy="' . ($top + (int) ($len * 0.45)) . '" r="5"/>';
        $out .= '<circle class="pw-dc__bead" cx="' . $fx . '" cy="' . ($top + (int) ($len * 0.7)) . '" r="3.5"/>';
        $out .= '<path d="M' . $fx . ' ' . $fy . 'c22 26 22 86 0 128c-22-42-22-102 0-128z" fill="url(#pw-dc-grad)" opacity=".22" stroke="url(#pw-dc-grad)" stroke-width="1.3"/>';
        $out .= '<path d="M' . $fx . ' ' . $fy . 'v134" stroke="url(#pw-dc-grad)" stroke-width="1.2"/>';
        for ($k = 1; $k <= 6; $k++) {
            $yy = $fy + 12 + $k * 16;
            $out .= '<path d="M' . $fx . ' ' . $yy . 'l-13 -10M' . $fx . ' ' . $yy . 'l13 -10" stroke="url(#pw-dc-grad)" stroke-width=".9" opacity=".7"/>';
        }
        $out .= '</g>';
    }
    $out .= '</svg>';
    return $out;
}

function pw_gradient_defs()
{
    return '<svg class="pw-defs" width="0" height="0" aria-hidden="true" focusable="false"><defs><linearGradient id="pw-grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:var(--a1)"/><stop offset="55%" style="stop-color:var(--a2)"/><stop offset="100%" style="stop-color:var(--a3)"/></linearGradient></defs></svg>';
}
