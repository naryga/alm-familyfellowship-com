Drupal Module
------------------------------------------------------------------------------
Name: Frequently Asked Questions module
Author: Stella Power
Drupal: 5.0.x
------------------------------------------------------------------------------

Description
============
The Frequently Asked Questions (faq) module allows users with the 'administer
faq' permission to create question and answer pairs which they want displayed on
the 'faq' page.  The 'faq' page is automatically generated from the FAQ nodes
configured and the layout of this page can be modified on the settings page.
Users will need the 'view faq' permission to view the 'faq' page. 

There are 2 blocks included in this module, one shows a list of FAQ categories
while the other can show a configurable number of recent FAQs added.

Note the function theme_faq_highlights(), which shows the last X recently
created FAQs, used by one of the blocks, can also be called in a php-filtered 
node if desired.


Configuration
=============
Once the module is activated, you can create your question and answer pairs by
creating FAQ nodes (Create content >> FAQ).  This allows you to edit the
question and answer text.  In addition, if the 'Taxonomy' module is enabled and
there are some terms configured for the FAQ node type, it will also be possible
to put the questions into different categories when editing.

On the Frequently Asked Questions settings configuration page (Administer >> 
Site Configuration >> Frequently Asked Questions (admin/settings/faq)), you will
find a form that will allow you to configure the layout of the questions and 
answers on the 'faq' page.  

The 'administer faq' permission is needed for configuring the 'faq' page layout
and editing of FAQ nodes.

Current maintainer
===================
Stella Power (http://drupal.org/user/66894)
