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
        'secondary' => "Sidebar secondaire",
        'footer' => "Items du Footer"
    );
    register_nav_menus($locations);
}

add_action('init', 'followjulien_menus');

function followjulien_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('followjulien-style', get_template_directory_uri() . "/style.css", array('followjulien-bootstrap'), $version, 'all');
    wp_enqueue_style('followjulien-menu_css', get_template_directory_uri() . "/menu_h.css", array(), $version, 'screen and (min-width:640px)');
    wp_enqueue_style('followjulien-menu_css_v', get_template_directory_uri() . "/menu_mobile.css", array(), $version, 'screen and (max-width:640px)');
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

/// On override la class Walker par défaut
class followjulien_Walker extends Walker_Nav_Menu
{
    /// Un Walker a quelques paramètres, celui-ci permet d'ouvrir l'objet
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        /// Ici on lui dit que si il a de la profondeur, il doit faire quelque chose
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        /// On met l'indentation dans l'output
        $output .= $indent . '<li>';
        /// On lui donne ses attributs
        $atts            = array();
        $atts['title']    = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target']    = !empty($item->target) ? $item->target : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['rel']        = !empty($item->xfn) ? $item->xfn : '';
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = '';

        /// Pour chaque attributs
        foreach ($atts as $attr => $value) {
            /// Si la valeur n'est pas vide
            if (!empty($value)) {
                /// Si l'attribut est href, mettre l'url, sinon, mettre la valeur
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                /// Puis on construit
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /// On lui met ses éléments avant
        $item_output = $args->before;
        /// Ses attributs
        $item_output .= '<a' . $attributes . '>';
        /// Son titre
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        /// On ferme
        $item_output .= '</a>';
        /// Les éléments après
        $item_output .= $args->after;
        /// Et on construit
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /// Ici, c'est l'élément de fin
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}
