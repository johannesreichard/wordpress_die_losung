<?php
/*
Plugin Name: Losung Widget
Plugin URI: https://github.com/johannesreichard/wordpress_die_losung
Description: Showing the Losung from http://losung.de
Version: 1.0.0
Author: Johannes Reichard
Author URI: http://johannesreichard.de
License: MIT (Source Code), The Content is under Copywrite by Herrenhuter Brüder-Unität and is restricted in usage, details under http://losung.de
 */

require_once(ABSPATH .'/wp-admin/includes/file.php');

/**
 * Register the widget
 */
add_action('widgets_init', create_function('', 'return register_widget("Losung_Widget");'));
/**
 * Class Losung_Widget
 */
class Losung_Widget extends WP_Widget
{
    /** Basic Widget Settings */
    const WIDGET_NAME = "Die Losung Widget";
    const WIDGET_DESCRIPTION = "Das Die Losung Widget zeigt die deutsche Losung der Brüder-Unität Herrnhut. Weitere Infos unter: http://losung.de";
    const WIDGET_TITLE = "Die Losung";
    var $textdomain;
    var $fields;
    /**
     * Construct the widget
     */
    function __construct()
    {
        //We're going to use $this->textdomain as both the translation domain and the widget class name and ID
        $this->textdomain = strtolower(get_class($this));
        //Figure out your textdomain for translations via this handy debug print
        //var_dump($this->textdomain);
        //Add fields
        //Translations
        load_plugin_textdomain($this->textdomain, false, basename(dirname(__FILE__)) . '/languages' );
        //Init the widget
        parent::__construct($this->textdomain, __(self::WIDGET_NAME, $this->textdomain), array( 'description' => __(self::WIDGET_DESCRIPTION, $this->textdomain), 'classname' => $this->textdomain));
    }


    /**
     * Widget frontend
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        /* Before and after widget arguments are usually modified by themes */
        echo $args['before_widget'];
        echo $args['before_title'] . self::WIDGET_TITLE . $args['after_title'];
        /* Widget output here */
        $this->widget_output($args, $instance);
        /* After widget */
        echo $args['after_widget'];
    }


    /**
     * This function will execute the widget frontend logic.
     * Everything you want in the widget should be output here.
     */
    private function widget_output($args, $instance)
    {
        extract($instance);

        $file_name = 'Losungen Free ' . date('Y') . '.xml';

        # determin/create content path
        $file_path = wp_upload_dir()['basedir'] .'/losung/';
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }

        # download content if not existing
        if ( ! file_exists( $file_path . $file_name ) ) {
            $archive_name = 'Losung_' . date('Y') . '_XML.zip';
            WP_Filesystem();
            file_put_contents($file_path . $archive_name, file_get_contents('http://www.brueder-unitaet.de/download/' . $archive_name));
            if ( ! unzip_file( $file_path . $archive_name, $file_path) ) {
                echo "Error, could not get Content.";
                exit;
            }

        }

        # parse xml -> get data
        $xml_data = simplexml_load_file( $file_path . $file_name );
        # get day of the year
        $index = (int)date('z');

        $losung = $xml_data->Losungen[$index];
        ?>
            <p style="clear: right; padding-bottom: .8em">
                <?php echo $losung->Losungstext; ?><br>
                <small style="float: right""><?php echo $losung->Losungsvers ?></small>
            </p>
            <p style="clear: right; padding-bottom: .8em;">
                <?php echo $losung->Lehrtext; ?><br>
                <small style="float: right""><?php echo $losung->Lehrtextvers ?></small>
            </p>
            <p>
                <small>
                    <a href="http://herrnhuter.de" target="blank">
                        © Evangelische Brüder-Unität – Herrnhuter Brüdergemeine
                    </a>
                    Weitere Infos unter: <a target="blank" 
href="http://losung.de">www.losung.de</a>
                </small>
            </p>
        <?php
    }


    /**
     * Widget backend
     *
     * @param array $instance
     * @return string|void
     */
    public function form( $instance )
    {
        /* Generate admin for fields */
        ?>
            <p>
                Dieses Widget kann nicht konfiguriert werden. Die Losung wird automatisch in Ihr
                Upload Verzeichniss herruntergeladen und entpackt. Dies ist Notwendig, da die
                Rechte der Texte nicht beim Author des Plugins liegen und hat den Vorteil, dass
                die Texte automatisch im neuen Jahr aktualisiert werden. Bei Fehlern kontaktieren
                Sie bitte den Author des Plugins. Weitere Infos unter 
                <a href="http://losung.de">losung.de</a>
            </p>
        <?php
    }

    /**
     * Updating widget by replacing the old instance with new
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
}
