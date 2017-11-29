<?php

/**
 * Plugin Name
 *
 * @uses wp_enqueue_script action
 */
function load_jquery() {

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
}

add_action('wp_enqueue_script', 'load_jquery');

function scripts() {
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7');
    wp_enqueue_style('basic-css', get_template_directory_uri() . '/style.css', array(), '3.3.7');
//    wp_enqueue_style('service-css', get_template_directory_uri() . '/css/service.css', array(), '3.3.7');
    wp_enqueue_style('habilitas-css', get_template_directory_uri() . '/css/habilitados.css', array(), '3.3.7');
    wp_enqueue_style('animate-css', get_template_directory_uri() . '/css/animate.css', array(), '3.3.7');
    wp_enqueue_style('form-css', get_template_directory_uri() . '/css/form.css', array(), '3.3.7');
    wp_enqueue_style('wizard-css', get_template_directory_uri() . '/css/wizard.css', array(), '1');
    wp_enqueue_style('justified-css', get_template_directory_uri() . '/css/jquery.justified.css', array(), '1');

// wp_enqueue_script('fonts', 'https://use.fontawesome.com/fc37eb67c4.js', false, '', false);

    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.3.7', true);
    wp_enqueue_script('jspdf', get_template_directory_uri() . '/js/jspdf.js', array('jquery'), '1', true);
    wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.js', array('jquery'), '1', true);
    wp_enqueue_script('split', get_template_directory_uri() . '/js/split_text_to_size.js', array('jquery'), '1', true);
    wp_enqueue_script('canvg', get_template_directory_uri() . '/js/canvg.js', array('jquery'), '1', true);
    wp_enqueue_script('toPrint', get_template_directory_uri() . '/js/toPrint.js', array('jquery'), '1', true);
    wp_enqueue_script('saveas', get_template_directory_uri() . '/js/FileSaver.js', array('jquery'), '1', true);
    wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array('jquery'), '1', false);
    wp_enqueue_script('justified-script', get_template_directory_uri() . '/js/jquery.justified.js', array('jquery'), '1', false);
    wp_enqueue_script('basic-script', get_template_directory_uri() . '/js/src-atlas.js', array('jquery', 'bootstrap'), '1', true);
    wp_enqueue_script('neon-script', get_template_directory_uri() . '/js/novacancy.js', false, '1', true);
//  wp_enqueue_script('apto-script', get_template_directory_uri() . '/js/src-apto.js', array('jquery', 'bootstrap'), '1', true);
//  wp_enqueue_script('basic-script-analytic', get_template_directory_uri() . '/js/analytic.js', false, '1', true);
}

add_action('wp_enqueue_scripts', 'scripts');


add_theme_support('title-tag');

// - - - - -- - - - - - - - - - - -  Global Functions


function node_activate() {
    global $wpdb;

    $table_name_node = $wpdb->prefix . "node";
    $table_name_relation = $wpdb->prefix . "relation";
    $table_name_actividad = $wpdb->prefix . "actividad";
    $table_name_persona = $wpdb->prefix . "persona";
    $table_name_dueno = $wpdb->prefix . "dueno";
    $table_name_lugar = $wpdb->prefix . "lugar";

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_node) != $table_name_node) {
        $sql = 'CREATE TABLE ' . $table_name_node . '(
id int(9) NOT NULL AUTO_INCREMENT,
`actividad` varchar(100) NOT NULL,
`profesion` varchar(100),
`lugar` varchar(100),
`type` varchar(20) NOT NULL,
`size` int(9) NOT NULL,
`personas` varchar(500),
`dueno` varchar(500),
`dt_creacion` timestamp,
PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
)';

        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_relation) != $table_name_relation) {
        $sql = 'CREATE TABLE ' . $table_name_relation . '(
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `source` varchar(100),
  `target` varchar(100),
  `type` varchar(100),
  `name` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
)';

        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_actividad) != $table_name_actividad) {
        $sql = 'CREATE TABLE ' . $table_name_actividad . '(
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `size` int(9) NOT NULL,
  `dt_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
)';

        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_persona) != $table_name_persona) {
        $sql = 'CREATE TABLE ' . $table_name_persona . '(
    `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `actividad` varchar(100) NOT NULL,
  `profesion` varchar(100) DEFAULT NULL,
  `size` int(9) NOT NULL,
  `dt_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
)';

        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_dueno) != $table_name_dueno) {
        $sql = 'CREATE TABLE ' . $table_name_dueno . '(
    `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL, 
  `correo` varchar(100) NOT NULL, 
  `dt_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
)';
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    if ($wpdb->get_var('SHOW TALBES LIKE ' . $table_name_lugar) != $table_name_lugar) {
        $sql = 'CREATE TABLE ' . $table_name_lugar . '(
    `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL, 
  `size` int(9) NOT NULL,
  `dt_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
)';
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

function node_insert() {

    global $wpdb;
    $timestamp = date('Y-m-d G:i:s');
    $table_name = $wpdb->prefix . "node";
    $wpdb->insert(
            $table_name, array(
        'dueno' => $_POST['duenoNode'],
        'actividad' => $_POST['actividadNode'],
        'lugar' => $_POST['lugarNode'],
        'type' => 'Actividad',
        'size' => '20',
        'profesion' => 'NA',
        'dt_creacion' => $timestamp,
        'personas' => $_POST['relationNode']
            )
    );



    echo 'console.log("PHP insert: ' .
    ' Nombre:' . $_POST['duenoNode'] .
    ' Typo:' . $_POST['actividadNode'] .
    ' Size:' . $_POST['lugarNode'] .
    ' Profesion:' . $_POST['relationNode'] .
    '")';
}
