<?php

namespace UnderscoreG\StylesScripts;

use GeneratePress_CSS;

// TODO: Edit colors
const COLORS = [
    'primary' => '#477da0', // blue
    'white' => '#ffffff',
    'blue-dark' => '#1e3759',
    'blue-light' => '#99d4de',
    'dark' => '#201e1d',
];

add_filter('generate_default_color_palettes', function () {
    return array_values(COLORS);
});


add_filter('after_setup_theme', function () {
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Primär', 'underscoreg'),
            'slug' => 'primary',
            'color' => COLORS['primary']
        ],
        [
            'name' => __('Weiss', 'underscoreg'),
            'slug' => 'white',
            'color' => COLORS['white']
        ],
        [
            'name' => __('Dunkel', 'underscoreg'),
            'slug' => 'dark',
            'color' => COLORS['dark']
        ],
        [
            'name' => __('Dark Blue', 'underscoreg'),
            'slug' => 'blue-dark',
            'color' => COLORS['blue-dark']
        ],
        [
            'name' => __('Light Blue', 'underscoreg'),
            'slug' => 'blue-light',
            'color' => COLORS['blue-light']
        ],
    ]);

    // add_theme_support('editor-font-sizes', [
    //     [
    //         'name' => __('Normal', 'underscoreg'),
    //         'slug' => 'normal',
    //         'size' => 16,
    //     ],
    // ]);

    add_theme_support('wp-block-styles');

    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');
});

function addCustomFonts($fonts)
{
    $fonts[] = 'Viva Beautiful';
    return $fonts;
}
add_filter('generate_typography_default_fonts', __NAMESPACE__ . '\addCustomFonts');

/**
 * Adds font fallbacks to custom local fonts in all generatepress dynamic generated css
 * hooked in `generate_external_dynamic_css_output` for all gp + generatepress theme output
 * and `generateblocks_css_output` for block output
 *
 * may need to regenerate css via customizer > general > change output method and click button to regenerate styles
 *
 * @param [type] $cssOutput
 * @return void
 */
function replaceFontFallbacks($cssOutput)
{
    $cssOutput = str_replace('font-family:"Viva Beautiful"', 'font-family: "Viva Beautiful", Arial, Helvetica, sans-serif', $cssOutput);
    return $cssOutput;
}
add_filter('generate_external_dynamic_css_output', __NAMESPACE__ . '\replaceFontFallbacks');
add_filter('generateblocks_css_output', __NAMESPACE__ . '\replaceFontFallbacks');

function generateColorCss()
{
    // Get our settings
    $generateSettings = wp_parse_args(
        get_option('generate_settings', []),
        generate_get_color_defaults()
    );

    // Initiate our CSS class
    $css = new \GeneratePress_CSS;

    // Add theme colors as CSS custom properties
    $css->set_selector(':root');
    foreach (COLORS as $color => $value) {
        $css->add_property('--' . esc_attr($color), esc_attr($value));
    }

    // Add standard WP-Block classes based on  theme colors
    foreach (COLORS as $color => $value) {
        $css->set_selector('.has-' . $color . '-color, .wp-block-button__link.has-text-color.has-' . $color . '-color');
        $css->add_property('color', $value);
        $css->set_selector('.has-' . $color . '-background-color');
        $css->add_property('background-color', $value);
    }

    // Form button-outline
    $css->set_selector('.button.button-outline, .button.button-outline:visited, .woocommerce .button.button-outline, .woocommerce .button.button-outline:visited');
    $css->add_property('border-color', esc_attr($generateSettings[ 'form_button_background_color' ]));
    $css->add_property('color', esc_attr($generateSettings[ 'form_button_background_color' ]));

    // Form button-outline hover
    $css->set_selector('.button.button-outline:hover, .button.button-outline:focus, .woocommerce .button.button-outline:hover, .woocommerce .button.button-outline:focus');
    $css->add_property('border-color', esc_attr($generateSettings[ 'form_button_background_color_hover' ]));
    $css->add_property('color', esc_attr($generateSettings[ 'form_button_background_color_hover' ]));

    // Return dynamic CSS
    return $css->css_output();
}

add_action('wp_enqueue_scripts', function () {
    $css = generateColorCss();
    wp_add_inline_style('generate-style', $css);

    wp_enqueue_style('underscoreg-main', get_stylesheet_directory_uri() . '/assets/css/main.css', ['generate-style'], filemtime(get_stylesheet_directory() . '/assets/css/main.css'));

    wp_enqueue_script('underscoreg-main', get_stylesheet_directory_uri() . '/assets/js/main.js', ['jquery'], filemtime(get_stylesheet_directory() . '/assets/js/main.js'), false);
}, 50);
