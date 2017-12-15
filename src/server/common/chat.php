<?php

require_once('settings/settings.php');
require_once('user/user.php');
require_once('utils/utils.php');

class CBroChat {
  private $guid;
  private $hash;
  private static $instance;

  public function __construct($guid) {
    $this->guid = $guid;
    $this->hash = md5($guid);
  }

  public function generate_code($container_id = null, $static = false) {
    $siteurl = CBroUtils::get_site_url();
    $site_domain = CBroUtils::get_site_domain();
    $site_user_avatar_url = CBroUser::avatar_url();
    $profile_url = CBroUser::profile_url();

    $permissions = array();

    if (CBroUser::can_delete())
        array_push($permissions, 'delete');

    if (CBroUser::can_ban())
        array_push($permissions, 'ban');

    $params = "encodedChatGuid: '{$this->hash}', siteDomain: '" . base64_encode($site_domain) . "'";
    $sig_source = "";

    if (CBroUser::is_logged_in()) {
        $sig_source = $site_domain . CBroUser::id() . CBroUser::display_name() . $site_user_avatar_url . $profile_url . implode('', $permissions);
        $params .= ", siteUserFullName: '" . CBroUser::display_name() . "', siteUserExternalId: '" . CBroUser::id() . "'";

        if ($site_user_avatar_url != "")
            $params .= ", siteUserAvatarUrl: '" . base64_encode($site_user_avatar_url) . "'";

        if ($profile_url != '')
            $params .= ", siteUserProfileUrl: '" . base64_encode($profile_url) . "'";
    }
    else
        $sig_source = $site_domain;

    $signature = md5($sig_source . $this->guid);

    if ($container_id)
        $params .= ", containerDivId: '{$container_id}'";

    if ($static)
        $params .= ", isStatic: true";

    $params .= ", signature: '{$signature}'";
    $params .= ", platform: '" . CBroUtils::get_platform() . "'";

    if (!empty($permissions))
        $params .= ", permissions: ['" . implode("','", $permissions) . "']";

    ob_start();

    ?>
    <script id="chatBroEmbedCode">
    /* Chatbro Widget Embed Code Start */
        function ChatbroLoader(chats, async) {
            function decodeProp(prop) {
                if (chats.hasOwnProperty(prop)) chats[prop] = atob(chats[prop]);
            };
            decodeProp('siteDomain');
            decodeProp('siteUserAvatarUrl');
            decodeProp('siteUserProfileUrl');
            async = !1 !== async;
            var params = {
                    embedChatsParameters: chats instanceof Array ? chats : [chats],
                    lang: navigator.language || navigator.userLanguage,
                    needLoadCode: "undefined" == typeof Chatbro,
                    embedParamsVersion: localStorage.embedParamsVersion,
                    chatbroScriptVersion: localStorage.chatbroScriptVersion
                },
                xhr = new XMLHttpRequest;
            xhr.withCredentials = !0;
            xhr.onload = function() {
                eval(xhr.responseText);
            };
            xhr.onerror = function() {
                console.error("Chatbro loading error");
            };
            xhr.open("GET", "//www.chatbro.com/embed.js?" +
                btoa(unescape(encodeURIComponent(JSON.stringify(params)))), async);
            xhr.send();
        }
    /* Chatbro Widget Embed Code End */
    if (typeof chatBroHistoryPage === 'undefined' || !chatBroHistoryPage)
        ChatbroLoader({<?php echo $params; ?>});
    </script>
    <?php

    $code = ob_get_contents();
    ob_end_clean();

    return $code;
  }

  public function generate_sitewide_popup_code() {
    if (!CBroUser::can_view())
      return;

    $where_to_display = CBroSettings::get(CBroSettings::display);

    switch($where_to_display) {
        case '':
        case 'everywhere':
            break;

        case 'frontpage_only':
            if (!CBroUtils::is_front_page())
                return;
            break;

        case 'except_listed':
        case 'only_listed':
            if (!CBroUtils::check_path())
                return;
            break;

        default:
            return;
    }

    return $this->generate_code();
  }

  private static function get_instance() {
    if (!self::$instance)
      self::$instance = new CBroChat(CBroSettings::get(CBroSettings::guid));

    return self::$instance;
  }

  public static function get_sitewide_popup_chat_code() {
    return self::get_instance()->generate_sitewide_popup_code();
  }

  // public static function get_popup_chat_code() {
  //   return self::get_instance()->generate_chat_code();
  // }

  public static function get_chat_code() {
    return self::get_instance()->generate_code();
  }

  public static function get_static_chat_code() {
    $encoded_guid = self::get_instance()->hash;
    $container_id = "chatbro-{$encoded_guid}-" . rand(0, 99999);
    $code = $container_id ? "<div id=\"{$container_id}\"></div>" : "";

    return $code . self::get_instance()->generate_code($container_id, true);
  }
}

?>
