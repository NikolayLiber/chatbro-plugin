=== Chat Bro - Chat linked with Telegram or VK chat ===
Contributors: ChatBro
Tags: Chat, Telegram, Telegram chat, Chat Tool, Chat Widget, Free Live Chat, Group Chat, Live Chat, Online Live Chat, Plugin Chat, Web Chat, live chat widget, online support, wordpress live chat, chat software, chat services, live help, live chat help, chat widget, live support plugin, live chat support plugin
Requires at least: <%- cfg.wp.requires_at_least %>
Tested up to: <%- cfg.wp.tested_up_to %>
Stable tag: <%- cfg.common_version %>.<%- cfg.wp.plugin_minor_version %>
License: GPLv2

Chat Bro - live Chat for your website. Turns your Telegram Chat or VK Chat into Live Chat on your website. Allows your visitors to Chat in live group Chat with you and each other. Add chat to your blog. Live chat assistance. Chat with customers on your website. Website chat live chat group chat telegram chat wordpress chat. Chat tool chat widget.

== Description ==

[ChatBro](https://www.chatbro.com) - live group chat for your website.

= Why ChatBro? =

* Support [Telegram](https://telegram.org/), [VK](https://vk.com) chats and channels
* Audio, photo and video previews
* Web chat constructor
* Mobile ready
* Very fast
* Indexed by search robots

= Easy Installation =
After installing the plugin just name your chat. Chat can be easily configured with visual chat constructor tool. You can change color scheme, size, initial state, etc.

= Link with Telegram =
Add [@chatbrobot](https://telegram.me/chatbrobot?startgroup=chat) to your Telegram chat or channel. Send /sync command in case of channel. You'll receive sync url from bot.

= Group chat is better than privates with operators =
Most people just read chat and see admin's reactions to realize that the website is functional and adequate. You can chat with visitor in private if needed.

= Open Source =
ChatBro plugin is an open source project. You can get the [source code](https://github.com/NikolayLiber/chatbro-plugin) from GitHub.
Pull requests are welcome.

== ChangeLog ==
<% _.forEach(cfg.wp.releases, function(release) {
%>
= <%= release.version %> =
<% _.forEach(release.comments, function(comment) {
%><%= comment %>
<%})
})%>
