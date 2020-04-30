<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       apfm
 * @since      1.0.0
 *
 * @package    Apfm_Cta
 * @subpackage Apfm_Cta/admin/views
 */
?>

<div id="apfm-lighthouse-cpt-forms-settings" class="wrap">
    <h2>CTA Forms</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'apfm-lighthouse-cpt-group' ); ?>
        <?php do_settings_sections( 'apfm-lighthouse-cpt-group' ); ?>

            <table class="form-table">
                <tr valign="top">
                    <th><h3>Site Info</h3></th>
                    <td></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="apfm_cta_site_type">FDE Site Type</label></th>
                    <td>
                        <?php $value = get_option('apfm_cta_site_type'); ?>

                        <input type="text" id="apfm_cta_site_type" name="apfm_cta_site_type" value="<?php echo $value; ?>" class="regular-text" />
                        <p><small>Use short version like <strong>alz-site</strong> for Alzheimers.net or ask Matt Sickle's team.</small></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="apfm_cta_gmaps_api_key">Google Maps API Key</label></th>
                    <td>
                        <?php $value = get_option('apfm_cta_gmaps_api_key'); ?>

                        <input type="text" id="apfm_cta_gmaps_api_key" name="apfm_cta_gmaps_api_key" value="<?php echo $value; ?>" class="regular-text" />
                    </td>
                </tr>
                
                <?php
                    // get current wz3 env mode
                    // $mode = get_option('apfm_cta_ws3_mode');
                ?>
                <tr valign="top">
                    <th colspan="2">
                        <h3>WS3 Info</h3>
                        <!-- <div class="alert alert-danger prod-control" <?php //echo $mode=='dev'?'style="display:none"':''; ?> role="alert">Warning: you are in <strong>production</strong> mode, be carefull with what you change.</div> -->
                    </th>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="apfm_cta_subsource_id">SubSourceId</label></th>
                    <td>
                        <?php $value = get_option('apfm_cta_subsource_id'); ?>

                        <input type="text" id="apfm_cta_subsource_id" name="apfm_cta_subsource_id" value="<?php echo $value; ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th><h3>Legal Info</h3></th>
                    <td></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="apfm_cta_tcpa_text">TCPA Text</label></th>
                    <td>
                        <?php $value = get_option('apfm_cta_tcpa_text'); ?>

                        <!-- <textarea id="apfm_cta_tcpa_text" name="apfm_cta_tcpa_text" class="regular-text"><?php //echo trim($value); ?></textarea> -->
                        <?php wp_editor( $value, 'apfm_cta_tcpa_text' ); ?>
                        <p><small>Use <strong>{submit-button-text}</strong> to automatically insert the same text of the form submit button (Ex. 'Get Help' or 'Get Pricing'). <strong>Linebreaks will be ignored</strong>.</small></p>
                    </td>
                </tr>
                
            </table>
        
        <?php submit_button(); ?>
    </form>
</div>
