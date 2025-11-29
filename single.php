<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Test
 */

$context = Timber::context();
$post = Timber::get_post();
$post_type = get_post_type();
$context['test_variable'] = 'Hello, Timber!';
Timber::render( 'single.twig', $context );