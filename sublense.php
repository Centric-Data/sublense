<?php
/**
 * Sub-Lense Form
 *
 * @package     Sub-Lense Form
 * @author      Centric Data
 * @copyright   2021 Centric Data
 * @license     GPL-2.0-or-later
 *
*/
/*
Plugin Name: Sub-Lense Form
Plugin URI:  https://github.com/Centric-Data/sublense
Description: This is a custom submit user form plugin, it can be used in any empty full-width page. Its using a two column layout.
Author: Centric Data
Version: 1.0.0
Author URI: https://github.com/Centric-Data
Text Domain: sublense
*/
/*
Submit-Lense Form is free software: you can redistribute it and/or modify it under the terms of GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

Submit-Lense Form is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Submit-Lense Form.
*/

/* Exit if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define variable for path to this plugin file.
define( 'SLF_LOCATION', dirname( __FILE__ ) );
define( 'SLF_LOCATION_URL' , plugins_url( '', __FILE__ ) );
define( 'SLF_PLUGIN_URL', plugin_dir_url( __FILE__ )

/**
 *
 */
class SubmitLenseForm{

      public function __construct(){
          // enqueue scripts (js, css)
          add_action( 'wp_enqueue_scripts', array( $this, 'slf_load_assets' ) );

          // Call for the shortcode
          add_shortcode( 'sub-lense', array( $this, 'slf_load_shortcode' ) );


      }

      /**
      * Add shortcode to the page.
      */
      public function slf_load_assets(){
          wp_enqueue_style( 'sublense-css' SLF_PLUGIN_URL . 'css/sublense.css', [], time(), 'all' );
          wp_enqueue_script( 'sublense-js' SLF_PLUGIN_URL . 'js/sublense.js', [ 'jquery' ], time(), 1 );
      }

      /**
      * Add shortcode to the page
      */
      public function slf_load_shortcode(){
        ?>
        <section>
          <div class="submit__page lense-row">
            <h3>Submission Form</h3>
            <p>
              <?php
                echo esc_html__( 'Abstracts should be in English, with a maximum of 250 words. Please use single spacing and Times New Roman, font size 12. Abstracts of research papers should provide a brief description of research objectives, methodology, theory and summary of results and/or conclusions. Please do not include any charts, bibliographies or footnotes.', 'lands' );
              ?>
            </p>
            <div class="submit__columns">
                <form>
                  <div class="submit__columns--form">
                    <div class="submit__left">
                      <input type="text" name="slf-name" id="slf-name">
                      <input type="email" name="slf-email" id="slf-email">
                      <input type="text" name="slf-business" id="slf-business">
                      <textarea name="slf-abstract" id="slf-abstract" cols="30" rows="10"></textarea>
                    </div>
                    <div class="submit__right"></div>
                  </div>
                  <div class="submit__columns--button">
                    <button id="submit_userform">Submit Form</button>
                  </div>
                </form>
            </div>
          </div>
        </section>
        <?php
      }


}

new SubmitLenseForm;

?>
