<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/../common/admin/interfaces.php');

class CBroWPAdminBackend implements ICBroAdminBackend {
  function has_permission_editor() {
    return true;
  }

  function has_shortcodes() {
    return true;
  }

  function get_login_url() {
    return wp_login_url(get_permalink());
  }

  function additional_fields() {
    wp_nonce_field("chatbro_save_settings", "chb-sec");
    ?>
      <input name="action" type="hidden" value="chatbro_save_settings">
    <?php
  }

  function render_permissions() {
    ?>
    <div id="permissions-group" class="form-group">
      <label class="control-label col-sm-2"><?php _e("Permissions", "chatbro"); ?></label>
      <div class="col-sm-10">
        <table id="chatbro-permissions" class="table table-active">
          <tr>
            <th><?php _e("Role", "chatbro"); ?></th>
            <th><?php _e("View", "chatbro"); ?></th>
            <th><?php _e("Ban", "chatbro"); ?></th>
            <th><?php _e("Delete", "chatbro"); ?></th>
          </tr>
          <?php
          foreach(get_editable_roles() as $name => $info) {
            $ctrlViewId = "chatbro_" . $name . "_view";
            $ctrlBanId = "chatbro_" . $name . "_ban";
            $ctrlDeleteId = "chatbro_" . $name . "_delete";

            $role = get_role($name);

            $chkView = $role->has_cap(CBroPermissions::cap_view) ? "checked" : "";
            $chkBan = $role->has_cap(CBroPermissions::cap_ban) ? "checked" : "";
            $chkDelete = $role->has_cap(CBroPermissions::cap_delete) ? "checked" : "";
            ?>
            <tr>
              <td><?php echo $info["name"] ?></td>
              <td><input id="<?php _e($ctrlViewId); ?>" name="<?php _e($ctrlViewId); ?>" type="checkbox" <?php echo $chkView; ?>></td>
              <td><input id="<?php _e($ctrlBanId); ?>" name="<?php _e($ctrlBanId); ?>" <?php echo $chkBan; ?> type="checkbox"></td>
              <td><input id="<?php _e($ctrlDeleteId); ?>" name="<?php _e($ctrlDeleteId); ?>"type="checkbox" <?php echo $chkDelete; ?>></td>
            </tr>
            <?php
          }
          ?>
        </table>
      </div>
    </div>
    <?php
  }

  function check_token() {
    return wp_verify_nonce($_POST['chb-sec'], "chatbro_save_settings") ? true : false;
  }

  function get_help_text() {
    ob_start();
    _e('Use shortcode <span>[chatbro]</span> to add the chat widget to the desired place of your page or post.', 'chatbro');
    ?>
      <h4><?php _e('Supported shortcode attributes:', 'chatbro'); ?></h4>
      <ul>
          <li>
              <?php
                // Translators: Attribute name "static" and attribut value "true" shouldn't be translated
                _e('<em><b>static</b></em> &ndash; static not movable chat widget (default <em>true</em>).', 'chatbro');
              ?>
          </li>
          <li>
              <?php
                // Translators: Attribute name "egistered_only" and attribut value "false" shouldn't be translated
                _e('<em><b>registered_only</b></em> &ndash; display chat widget to logged in users only (default <em>false</em>). If this attribute is explicitly set it precedes the global <em>"Display chat to guests"</em> setting value.', 'chatbro');
              ?>
          </li>
      </ul>
    <?php

    $text = ob_get_contents();
    ob_clean();

    return $text;
  }

  function generated_scripts() {
    ?>
      <script>
        var cBroGlobals = {
          saveSettingsUrl: ajaxurl,
          getFaqUrl: ajaxurl,
          getFaqPostData: {action: 'chatbro_get_faq'}
        }
      </script>
    <?php
  }

  function save_permissions() {
    global $_POST;

    foreach(get_editable_roles() as $name => $info) {
      $viewCap = $_POST['chatbro_' . $name . '_view'] == 'on' ? true : false;
      $banCap = $_POST['chatbro_' . $name . '_ban'] == 'on' ? true : false;
      $deleteCap = $_POST['chatbro_' . $name . '_delete'] == 'on' ? true : false;

      $role = get_role($name);

      if ($viewCap)
        $role->add_cap(CBroPermissions::cap_view);
      else
        $role->remove_cap(CBroPermissions::cap_view);

      if ($banCap)
        $role->add_cap(CBroPermissions::cap_ban);
      else
        $role->remove_cap(CBroPermissions::cap_ban);

      if ($deleteCap)
        $role->add_cap(CBroPermissions::cap_delete);
      else
        $role->remove_cap(CBroPermissions::cap_delete);
    }
  }
}

?>
