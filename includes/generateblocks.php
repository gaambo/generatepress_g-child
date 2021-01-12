<?php

namespace UnderscoreG\GenerateBlocks;

add_filter('generateblocks_defaults', function ($defaults) {
    $color_settings = wp_parse_args(
        get_option('generate_settings', array()),
        generate_get_color_defaults()
    );

    // make GB button blocks use default generatepress button styling
    $defaults['button']['backgroundColor'] = $color_settings['form_button_background_color'];
    $defaults['button']['backgroundColorHover'] = $color_settings['form_button_background_color_hover'];
    $defaults['button']['textColor'] = $color_settings['form_button_text_color'];
    $defaults['button']['textColorHover'] = $color_settings['form_button_text_color_hover'];
    $defaults['button']['paddingTop'] = '0';
    $defaults['button']['paddingRight'] = '20';
    $defaults['button']['paddingBottom'] = '0';
    $defaults['button']['paddingLeft'] = '20';

    // container
    $defaults['container']['paddingTop'] = '40';
    $defaults['container']['paddingRight'] = '40';
    $defaults['container']['paddingBottom'] = '40';
    $defaults['container']['paddingLeft'] = '40';

    return $defaults;
});
