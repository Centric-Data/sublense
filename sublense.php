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
define( 'SLF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 *
 */
class SubmitLenseForm
{

      public function __construct(){
          // enqueue scripts (js, css)
          add_action( 'wp_enqueue_scripts', array( $this, 'slf_load_assets' ) );

          // Call for the shortcode
          add_shortcode( 'sub-lense', array( $this, 'slf_load_shortcode' ) );

          // register post types
          add_action( 'init', array( $this, 'slf_create_custom_post' ) );

          // REST Route
          // add_filter( 'rest_route_for_post', array( $this, 'slf_rest_route_for_cpt' ), 10, 2 );

          // Register route
          add_action( 'rest_api_init', array( $this, 'slf_register_submission_route' ) );

          // Load Javascript
          add_action( 'wp_footer', array( $this, 'slf_load_scripts' ) );

          // Custom columns
          add_filter( 'manage_centric_submissions_posts_columns', array( $this, 'slf_submission_columns' ) );

          // Custom columns post data
          add_action( 'manage_centric_submissions_posts_custom_column', array( $this, 'slf_submission_columns_data' ), 10, 2 );
      }

      /**
      * Add shortcode to the page.
      */
      public function slf_load_assets(){
          wp_enqueue_style( 'sublense-css', SLF_PLUGIN_URL . 'css/sublense.css', [], time(), 'all' );
          wp_enqueue_script( 'sublense-js', SLF_PLUGIN_URL . 'js/sublense.js', [ 'jquery' ], time(), 1 );

          wp_localize_script( 'sublense-js', 'veriData', array( 'nonce' =>  wp_create_nonce( 'wp_rest' ) ) );
      }

      /**
      * Add shortcode to the page
      */
      public function slf_load_shortcode(){
        ?>
        <section>
          <div class="submit__page lense-row">
            <p>
              <?php
                echo esc_html__( 'Kindly submit the following forms here.', 'lands' );
              ?>
            </p>
            <div class="submit__columns">
                <form id="submit__form">
                  <div class="submit__columns--form">
                    <div class="submit__left">
                      <select id="slf-form-type" name="slf-form-type">
                        <option value="audit-form">Dispute Registration Form</option>
                      </select>
                      <input type="text" name="slf-name" id="slf-name" value="" placeholder="Fullname" required>
                      <input type="email" name="slf-email" id="slf-email" value="" placeholder="Email">
                      <input type="text" name="slf-business" id="slf-business" value="" placeholder="Business">
                      <textarea name="slf-abstract" id="slf-abstract" cols="30" rows="10" value="" placeholder="Message"></textarea>
                      <input type="file" name="slf-fileupload" id="slf-fileupload" value="">
                    </div>
                    <div class="submit__right">
                        <h4>Submit</h4>
                        <h3>Submitting your Form</h3>
                        <p>You can easily upload your form easily for processing. This is the easier way than to have a walk-through. You can submit these kinds of forms:</p>
                        <ul class="submit__right--items">
                          <li>
                            <span class="material-icons">file_present</span><h5>Audit Form</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Lease Form</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Dispute Form</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Application to Note Death</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Deposit of a Plan of Division</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Amendment of a Strata Plan</h5>
                          </li>
                          <li>
                            <span class="material-icons">file_present</span><h5>Cancellation of a Strata Plan</h5>
                          </li>
                        </ul>
                    </div>
                  </div>
                  <div class="submit__columns--button">
                    <button type="submit" id="submit_userform">Submit Form</button>
                  </div>
                </form>
            </div>
            <!-- <button id="loadcontent">Load Content</button>
            <div class="hello">
            </div> -->
          </div>
        </section>
        <?php
      }

      /**
      * Register Submissions custom-post-type
      */
      public function slf_create_custom_post(){
        $labels = array(
          'name'                => __( 'Submissions', 'sublense' ),
          'singular_name'       => __( 'Submission', 'sublense' ),
          'menu_name'           => _x( 'Submissions', 'Admin Menu text', 'sublense' ),
          'add_new'             => __( 'Add New', 'sublense' ),
          'add_new_item'        => __( 'Add New Submission', 'sublense' ),
          'new_item'            => __( 'New Submission', 'sublense' ),
          'edit_item'           => __( 'Edit Submission', 'sublense' ),
          'view_item'           => __( 'View Submission', 'sublense' ),
          'all_items'           => __( 'All Submissions', 'sublense' )
        );
        $args = array(
          'labels'                =>  $labels,
          'public'                =>  true,
          'has_archive'           =>  true,
          'hierarchical'          =>  false,
          'show_in_rest'          =>  true,
          'supports'              =>  array('title','editor','author'),
          'exclude_from_search'   =>  true,
          'publicly_queryable'    =>  false,
          'capability_type'       =>  'post',
          'menu_icon'       =>  'dashicons-pdf',
        );
        register_post_type( 'centric_submissions', $args );
      }


      public function slf_register_submission_route(){
        register_rest_route( 'wp/v2', 'submissions', array(
          'methods' =>  'POST',
          'callback'  =>  array( $this, 'slf_handle_submissions' ),
        ) );
      }

      // Run Script on Submit
      public function slf_load_scripts(){
        ?>

        <script>

        let slfnonce = '<?php echo wp_create_nonce('slfwp_rest'); ?>';

            ( function($){
              $('#submit__form').on('submit', function( e ) {
                e.preventDefault();

                var form = $( this ).serialize();
                console.log( form );

                $.ajax({
                  method: 'post',
                  url: '<?php echo get_rest_url( null, 'wp/v2/submissions' ); ?>',
                  headers: { 'WP-X-Nonce': slfnonce },
                  data: form
                })
              });
            } )(jQuery)

        </script>

        <?php
      }

      public function slf_handle_submissions( $data ){
        $headers = $data->get_headers();
        $params = $data->get_params();

        $nonce = $headers[ 'x_wp_nonce' ];

        //  Verify Nonce
        if ( ! wp_verify_nonce( $nonce, 'slfwp_rest' ) ){
          return new WP_REST_Response( 'Message not sent', 422 );
        }

        $post_id = wp_insert_post( [
            'post_type' => 'centric_submissions',
            'post_title' => wp_strip_all_tags( $params['slf-name'] ),
            'post_content'  =>  wp_strip_all_tags( $params['slf-abstract'] ),
            'post_status' => 'publish'
          ] );

          // add_post_meta( $post_id, '_clf_email_meta_key', $params['email'] );
          // add_post_meta( $post_id, '_clf_phone_meta_key', $params['phone'] );
          // Message success message
          if ( $post_id )
          {
            return new WP_REST_Response( $params['slf-name'], 200 );

          }
      }

      /**
      * Register a rest route for custom post type
      */
      // public function slf_rest_route_for_cpt( $route, $post ){
      //   if( $post->post_type === 'centric_submissions' ){
      //     $route = '/wp/v2/submissions/' . $post->ID;
      //   }
      //
      //   return $route;
      // }


      /**
      * Creating custom columns
      */
      public function slf_submission_columns( $columns ){

        $newColumns = array();
          $newColumns['title'] = 'Form Title';
          $newColumns['fullname'] = 'Fullname';
          $newColumns['email'] = 'Email';
          $newColumns['business'] = 'Business';
          $newColumns['message'] = 'Message Excerpt';
          $newColumns['form'] = 'Form';
          $newColumns['date'] = 'Date';

          return $newColumns;
      }

      /**
      * Creating custom columns
      */
      public function slf_submission_columns_data( $column, $post_id ){
        switch ( $column ) {
          case 'fullname':
            echo 'User';
            break;
          case 'email':
            echo 'Submission Email';
            break;
          case 'business':
            echo 'Submission Business';
            break;
          case 'message':
            echo get_the_excerpt();
            break;
          case 'form':
            echo get_the_title();
            break;
          default:
            // code...
            break;
        }
      }
}

new SubmitLenseForm;

?>
