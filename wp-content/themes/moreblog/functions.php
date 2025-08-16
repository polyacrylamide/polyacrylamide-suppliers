<?php
if (!function_exists('moreblog_theme_enqueue_styles')) {
    add_action('wp_enqueue_scripts', 'moreblog_theme_enqueue_styles');

    function moreblog_theme_enqueue_styles()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $moreblog_version = wp_get_theme()->get('Version');
        $parent_style = 'morenews-style';

        // Enqueue Parent and Child Theme Styles
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css', array(), $moreblog_version);
        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style' . $min . '.css', array(), $moreblog_version);
        
        wp_enqueue_style(
            'moreblog',
            get_stylesheet_directory_uri() . '/style.css',
            array('bootstrap', $parent_style),
            $moreblog_version
        );

        // Enqueue RTL Styles if the site is in RTL mode
        if (is_rtl()) {
            wp_enqueue_style(
                'morenews-rtl',
                get_template_directory_uri() . '/rtl.css',
                array($parent_style),
                $moreblog_version
            );
        }
    }
}

function moreblog_override_morenews_header_section()
{
    remove_action('morenews_action_header_section', 'morenews_header_section', 40);
}

add_action('wp_loaded', 'moreblog_override_morenews_header_section');

function moreblog_header_section()
{

    $morenews_header_layout = morenews_get_option('header_layout');


?>

    <header id="masthead" class="<?php echo esc_attr($morenews_header_layout); ?> morenews-header">
        <?php morenews_get_block('layout-centered', 'header');  ?>
    </header>

<?php
}

add_action('morenews_action_header_section', 'moreblog_header_section', 40);

function moreblog_filter_default_theme_options($defaults)
{
    $defaults['select_header_image_mode']  = 'above';  
    $defaults['show_popular_tags_section'] = 1; 
    $defaults['frontpage_popular_tags_section_title'] = __('Trending Tags', 'moreblog');
    $defaults['select_popular_tags_mode']  = 'category'; 
    $defaults['site_title_font_size'] = 52;
    $defaults['site_title_uppercase']  = 0;
    $defaults['disable_header_image_tint_overlay']  = 1;
    $defaults['show_primary_menu_desc']  = 0;
    $defaults['show_main_news_section']  = 0;
    $defaults['show_featured_posts_section']  = 0;
    $defaults['header_layout'] = 'header-layout-centered';
    $defaults['show_watch_online_section']   = 1;   
    $defaults['aft_custom_title']           = __('Subscribe', 'moreblog'); 
    $defaults['secondary_color'] = '#cb1111';
    $defaults['global_show_min_read'] = 'no';   
    
    return $defaults;
}
add_filter('morenews_filter_default_theme_options', 'moreblog_filter_default_theme_options', 1);