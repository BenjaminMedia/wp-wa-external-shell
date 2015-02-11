<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    White_Album_External_Header
 * @subpackage White_Album_External_Header/admin/partials
 */
?>

<div class="wrap">
  <form action='options.php' method='post'>

    <h2>Bonnier co-branding settings</h2>

    <?php
    settings_fields( $this->plugin_name );
    do_settings_sections( $this->plugin_name );
    submit_button();
    ?>

  </form>
</div>
