<?php
/**
 * @package ChatBro
 * @version <%- cfg.common_version %>.<%- cfg.wp_plugin_minor_version %>
 */
/*
Plugin Name: ChatBro
Plugin URI: http://chatbro.com
Description: Live group chat for your community with social networks integration. Chat conversation is being syncronized with popular messengers. Love ChatBro? Spread the word! <a href="https://wordpress.org/support/view/plugin-reviews/chatbro">Click here to review the plugin!</a>.
Version: <%- cfg.common_version %>.<%- cfg.wp_plugin_minor_version %>
Author: ChatBro
Author URI: http://chatbro.com
License: GPL3
Text Domain: chatbro
Domain Path: /common/languages/
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('init.php');
CBroInit::init();

?>
