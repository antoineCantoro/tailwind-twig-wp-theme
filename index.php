<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Test
 */

// get_header();

$context = Timber::context();
$post = Timber::get_post();
$context['post'] = $post;
$templates = array('page-' . $post->post_name . '.twig', 'page.twig');

Timber::render($templates, $context);