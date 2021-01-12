<?php

namespace UnderscoreG\Settings;

function addSettingsPage() {
    acf_add_options_sub_page([
        'page_title' => __('Theme Einstellungen', 'underscoreg'),
        'menu_title' => __('Einstellungen', 'underscoreg'),
        'menu_slug' => 'theme-settings',
        'parent_slug' => 'themes.php',
        'capability' => 'edit_theme_options',
    ]);
}
add_action('acf/init', __NAMESPACE__ . '\addSettingsPage');
