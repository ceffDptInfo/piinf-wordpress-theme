<?php

function followjulien_theme_support()
{
    /// Ajoute un support dynamique de la balise title
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'followjulien_theme_support');

function followjulien_menus()
{
    $locations = array(
        'primary' => "Sidebar principale pour Desktop",
        'footer' => "Items du Footer"
    );
    register_nav_menus($locations);
}

add_action('init', 'followjulien_menus');

function followjulien_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('followjulien-style', get_template_directory_uri() . "/style.css", array('followjulien-bootstrap'), $version, 'all');
    wp_enqueue_style('followjulien-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), "4.4.1", 'all');
    wp_enqueue_style('followjulien-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), "5.13.0", 'all');
}

add_action('wp_enqueue_scripts', 'followjulien_register_styles');

function followjulien_register_scripts()
{
    wp_enqueue_script('followjulien-jquery', 'https://code.jquery.com/jquery-3.4.1.slim.min.js', array(), '3.4.1', true);
    wp_enqueue_script('followjulien-popperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', true);
    wp_enqueue_script('followjulien-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array(), '4.4.1', true);
    wp_enqueue_script('followjulien-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'followjulien_register_scripts');

/// Un Widget
function followjulien_widget_areas()
{
    /// Enregistrer le Widget
    register_sidebar(
        /// Son paramètre, un array
        array(
            /// Ici, on peut mettre des balises HTML pour entourer le Titre (<h4></h4> par exemple)
            'before_title' => '',
            'after_title' => '',
            /// Et là, on peut y demander d'ajouter une balise spécifique autour du Widget
            'before_widget' => '',
            'after_widget' => '',
            /// Le nom, doit être unique
            'name' => 'Sidebar Area',
            /// Et l'Id, doit être unique, appellez-le "footer-1" pour un footer par exemple
            'id' => 'sidebar-1',
            /// Et une petite description
            'description' => 'Sidebar Widget Area',
        )
    );
}
/// Et enfin on appelle la fonction des Widgets
add_action('widgets_init', 'followjulien_widget_areas');
