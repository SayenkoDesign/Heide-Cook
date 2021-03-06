<?php
/**
 * Created by PhpStorm.
 * User: rpark
 * Date: 6/8/2016
 * Time: 11:20 PM
 */

namespace Supertheme\WordPress\Twig;


class WordPress
{
    public function ID()
    {
        return get_the_ID();
    }

    public function title($post = 0, $before = '', $after = '')
    {
        if(!$post && is_archive()) {
            return get_the_archive_title();
        }

        if(!$post && !in_the_loop() && !is_front_page())
        {
            return wp_title('', false);
        }

        $title = get_the_title($post);

        if (strlen($title) == 0) {
            return '';
        }

        $title = $before . $title . $after;

        return $title;
    }

    public function wp_title()
    {
        return wp_title('', false);
    }

    public function archiveTitle()
    {
        return get_the_archive_title();
    }

    public function content($more_link_text = null, $strip_teaser = false)
    {
        $content = get_the_content($more_link_text, $strip_teaser);
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        return $content;
    }

    public function thePost()
    {
        the_post();
    }

    public function excerpt($post = null)
    {
        return get_the_excerpt($post);
    }

    public function featuredImage($post = null, $size = 'post-thumbnail', $attr = '')
    {
        return get_the_post_thumbnail($post, $size, $attr);
    }

    public function classes($class = '')
    {
        return 'class="'.join(' ', get_body_class($class )).'"';
    }

    public function header()
    {
        ob_start();
        wp_head();
        return ob_get_clean();
    }

    public function footer()
    {
        ob_start();
        wp_footer();
        return ob_get_clean();
    }

    public function templateURI()
    {
        return get_template_directory_uri();
    }

    public function URL($post = 0, $leavename = false) {
        return get_permalink($post, $leavename);
    }

    public function siteURL($blog_id = null, $path = '', $scheme = null) {
        return get_site_url($blog_id, $path, $scheme);
    }

    public function isHome()
    {
        return is_home();
    }

    public function isPostTypeArchive($post_types = '')
    {
        return is_post_type_archive($post_types);
    }

    public function isTax($taxonomy = '', $term = '')
    {
        return is_tax($taxonomy, $term);
    }

    public function getType($post = null)
    {
        return get_post_type($post);
    }

    public function getCategory($id = false)
    {
        return get_the_category($id);
    }

    public function getCategoryURL($category)
    {
        return get_category_link($category);
    }

    public function getCategories($args = '')
    {
        return get_categories($args);
    }

    public function getTerms($post, $taxonomy)
    {
        return get_the_terms($post, $taxonomy);
    }

    public function getPreviousLink($format = '&laquo; %link', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category')
    {
        return get_previous_post_link($format, $link, $in_same_term, $excluded_terms, $taxonomy);
    }

    public function getNextLink($format = '%link &raquo;', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category')
    {
        return get_next_post_link($format, $link, $in_same_term, $excluded_terms, $taxonomy);
    }

    public function getAuthor()
    {
        return get_the_author();
    }

    public function getAvatar($size = 64, $id = null)
    {
        return get_avatar($id ?: get_the_author_meta('ID'), $size);
    }

    public function menu($args = [])
    {
        $args['echo'] = false;
        return wp_nav_menu($args);
    }

    public function processShortcode($content, $ignore = false)
    {
        ob_start();
        do_shortcode($content, $ignore);
        return ob_get_clean();
    }

    public function searchForm()
    {
        return get_search_form(false);
    }

    public function getForm($id_or_title, $display_title = true, $display_description = true, $display_inactive = false, $field_values = null, $ajax = false, $tabindex = 1)
    {
        return gravity_form($id_or_title, $display_title, $display_description, $display_inactive, $field_values, $ajax, $tabindex, false);
    }

    public function query($var, $default = '')
    {
        return get_query_var($var, $default);
    }

    public function postTypeArchiveURL($post_type)
    {
        return get_post_type_archive_link($post_type);
    }

    public function getOption($option, $default = false)
    {
        return get_option($option, $default);
    }
}