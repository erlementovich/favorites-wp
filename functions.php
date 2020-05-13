<?php

function wfm_favorites_count()
{
    $fav_posts = get_posts([
        'meta_key' => 'wfm_favorites',
    ]);
    return '<div class="wfm-favorites-count">' . count($fav_posts) . '</div>';
}

function wfm_favorites_content($content)
{
    $del = '<a class="wfm-favorites-toggle" data-action="del" href="#"><i class="fas fa-heart"></i></a>';
    $add = '<a class="wfm-favorites-toggle" data-action="add" href="#"><i class="far fa-heart"></i></a>';
    $loader = '<span class="wfm-favorites-hidden"><i class="fas fa-spinner fa-spin"></i></span>' . wfm_favorites_count();

    if (!is_single()) return $content;
    global $post;
    if (wfm_is_favorites($post->ID)) {
        return '<div class="wfm-favorites-link">' . $del . $loader . '</div>' . $content;
    }

    return '<div class="wfm-favorites-link">' . $add . $loader . '</div>' . $content;
}

function wfm_favorites_scripts()
{
    if (!is_single()) return;
    wp_enqueue_script('wfm-favorites-scripts', plugins_url('/js/init.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style('wfm-favorites-style', plugins_url('/css/init.css', __FILE__));
    global $post;
    wp_localize_script('wfm-favorites-scripts', 'wfmFavorites', ['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('wfm-favorites'), 'postId' => $post->ID]);
}

function wp_ajax_wfm_add()
{
    $del = '<a class="wfm-favorites-toggle" data-action="del" href="#"><i class="fas fa-heart"></i></a>';
    $add = '<a class="wfm-favorites-toggle" data-action="add" href="#"><i class="far fa-heart"></i></a>';
    $loader = '<span class="wfm-favorites-hidden"><i class="fas fa-spinner fa-spin"></i></span>';
    if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
        wp_die('Ошибка безопасности!');
    }
    $post_id = (int)$_POST['postId'];

    if (wfm_is_favorites($post_id)) wp_die($add . $loader . wfm_favorites_count());

    if (add_post_meta($post_id, 'wfm_favorites', $post_id)) {
        wp_die($del . $loader . wfm_favorites_count());
    }

    wp_die('Ошибка добавления');
}

function wp_ajax_wfm_del()
{
    $del = '<a class="wfm-favorites-toggle" data-action="del" href="#"><i class="fas fa-heart"></i></a>';
    $add = '<a class="wfm-favorites-toggle" data-action="add" href="#"><i class="far fa-heart"></i></a>';
    $loader = '<span class="wfm-favorites-hidden"><i class="fas fa-spinner fa-spin"></i></span>';
    if (!wp_verify_nonce($_POST['security'], 'wfm-favorites')) {
        wp_die('Ошибка безопасности!');
    }
    $post_id = (int)$_POST['postId'];

    if (!wfm_is_favorites($post_id)) wp_die($del . $loader . wfm_favorites_count());

    if (delete_post_meta($post_id, 'wfm_favorites', $post_id)) {
        wp_die($add . $loader . wfm_favorites_count());
    }

    wp_die('Ошибка удаления');
}


function wfm_is_favorites($post_id)
{
    $favorites = get_post_meta($post_id, 'wfm_favorites');
    foreach ($favorites as $favorite) {
        if ($favorite == $post_id) return true;
    }
    return false;
}

function wfm_ajax_count()
{
    $posts = new WP_Query();
    var_dump($posts);
}