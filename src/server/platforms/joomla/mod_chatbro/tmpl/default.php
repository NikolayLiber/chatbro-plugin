<?php

defined('_JEXEC') or die('Access restricted');

require_once(JPATH_LIBRARIES . '/chatbro/common/chat.php');
echo CBroChat::get_static_chat_code();

?>
