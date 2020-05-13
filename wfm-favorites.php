<?php
/*
Plugin Name: Добавление статей в Избранное
Description: Плагин добавляет для авторизованных пользователей ссылку к статьям, позволяющую добавить статью в список избранных статей
Plugin URI:
Author:
Author URI:
Version: 1.0
*/
require dirname(__DIR__) . '/wfm-favorites/functions.php';

add_action('get_favorites', 'wfm_favorites_content');
add_action('wp_enqueue_scripts', 'wfm_favorites_scripts');
/* Запрос для авторизованных и не авторизованных пользователей */
add_action('wp_ajax_nopriv_wfm_add', 'wp_ajax_wfm_add');
/* удаление */
add_action('wp_ajax_nopriv_wfm_del', 'wp_ajax_wfm_del');