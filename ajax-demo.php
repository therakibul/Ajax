<?php
/*
Plugin Name: Ajax Demo
Plugin URI:
Description: Ajax Demo
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: ajax-demo
 */

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_ajax-demo' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'ajax-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'ajax-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $ajax_url = admin_url("admin-ajax.php");
        $nonce = wp_create_nonce("ajaxTes");
        
        wp_localize_script("ajax-demo-js" , "ajax_url" , ["preview" => $ajax_url, "nonce" => $nonce]);

        wp_localize_script("ajax-demo-js", "bucket", ["name" => "MD Rakibul Hasan", "age" => 26]);
    }
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'Ajax Demo', 'Ajax Demo', 'manage_options', 'ajax-demo', 'ajaxdemo_admin_page' );
} );

function ajaxdemo_admin_page() {
    ?>
<div class="container" style="padding-top:20px;">
    <h1>Ajax Demo</h1>
    <div class="pure-g">
        <div class="pure-u-1-4" style='height:100vh;'>
            <div class="plugin-side-options">
                <button class="action-button" data-task='simple_ajax_call'>Simple Ajax Call</button>
                <button class="action-button" data-task='unp_ajax_call'>Unprivileged Ajax Call</button>
                <button class="action-button" data-task='ajd_localize_script'>Why wp_localize_script</button>
                <button class="action-button" data-task='ajd_secure_ajax_call'>Security with Nonce</button>
            </div>
        </div>
        <div class="pure-u-3-4">
            <div class="plugin-demo-content">
                <h3 class="plugin-result-title">Result</h3>
                <div id="plugin-demo-result" class="plugin-result"></div>
            </div>
        </div>
    </div>
</div>
<?php
}
function myajax_ajaxTest(){
    $nonce = $_POST["n"];
    $name = $_POST["name"];
    if(wp_verify_nonce($nonce, "ajaxTest")){
        echo $name;
    }else{
        echo "Nonce verification failed.";
    }
    die();
}
add_action("wp_ajax_ajaxTest", "myajax_ajaxTest");
add_action("wp_ajax_nopriv_ajaxTest", "myajax_ajaxTest");

function myajax_ajaxunp(){
    $info = $_POST["info"];
    echo $info;
    die();
}
add_action("wp_ajax_ajaxunp", "myajax_ajaxunp");
add_action("wp_ajax_nopriv_ajaxunp", "myajax_ajaxunp");

function myajax_ajaxLc(){
    $message = $_POST["message"];
    echo strtoupper($message["name"]), " Age: " .$message["age"];
    die();
}
add_action("wp_ajax_ajaxLc", "myajax_ajaxLc");