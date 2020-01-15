<?php
$val = (get_option('test_drive_client_notification_template', '') != '') ? stripslashes(get_option('test_drive_client_notification_template', '')) :
    '<table>
        <tr>
            <td>Hi <Name>,</td>
        </tr>
        <tr>
            <td>You have requested for a test drive of [car] from [seller]. Your details:</td>
        </tr>
        <tr>
            <td>Email: [email]</td>
        </tr>
        <tr>
            <td>Phone number: [phone]</td>
        </tr>
        <tr>
            <td>Preferred time: [best_time]</td>
        </tr>
        <tr>
            <td>Thank you!</td>
        </tr>
    </table>';

$subject = (get_option('test_drive_client_notification_subject', '') != '') ? get_option('test_drive_client_notification_subject', '') : 'Request for a test drive [car]';
?>
<div class="etm-single-form">
    <h3>Test Drive For a Client</h3>
    <input type="text" name="test_drive_client_notification_subject" value="<?php echo esc_html($subject); ?>" class="full_width" />
    <div class="lr-wrap">
        <div class="left">
            <?php
            $sc_arg = array(
                'textarea_rows' => apply_filters( 'etm-sce-row', 10 ),
                'wpautop' => true,
                'media_buttons' => apply_filters( 'etm-sce-media_buttons', false ),
                'tinymce' => apply_filters( 'etm-sce-tinymce', true ),
            );

            wp_editor( $val, 'test_drive_client_notification_template', $sc_arg );
            ?>
        </div>
        <div class="right">
            <h4>Shortcodes</h4>
            <ul>
                <?php
                foreach (getTemplateShortcodes('testDriveClientNotification') as $k => $val) {
                    echo "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>
