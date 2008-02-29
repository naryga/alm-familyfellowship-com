Content Template (contemplate) Module for Drupal
by Jeff Robbins | Lullabot | www.lullabot.com
------------------------------------------------

This module allows modification of Drupal's teaser, body, and RSS feed using administrator defined templates. These templates use PHP code and all of the node object variables are available for use in the template. An example node object is displayed and it is as simple as clicking on its properties to add them to the current template.

This module was written to solve a need with the Content Construction Kit (CCK), where it had a tendency toward outputting content in a not-very-pretty way. And as such, it dovetails nicely with CCK, adding a "template" tab to CCK content-type editing pages and pre-populating the templates with CCK's default layout. This makes it easy to rearrange fields, output different fields for teaser and body, remove the field title headers, output fields wrapped for use with tabs.module (part of JSTools), or anything you need.

But Content Template can actually be used on any node type and allows modification of the teaser and body properties before they go out in an RSS feed or are handed off to the theme.