// $Id: htmlarea.js,v 1.4 2007/06/05 01:27:51 gordon Exp $

/**
 * Activate Xinha on all the TEXTAREA elements which has the attribute
 * editor="xinha"
 */

if (Drupal.jsEnabled) {
  $(document).ready(
    function () {
      var xinha_plugins = Drupal.settings.htmlarea.plugins;
      var xinha_editors = [];
      _editor_url = Drupal.settings.htmlarea.path+'/';
      $('textarea[@editor="xinha"]').each(
        function () {
          xinha_editors[xinha_editors.length] = this.id;
        }
      );

      var xinha_config = new HTMLArea.Config();
      xinha_config.sizeIncludesToolbar = false;
      xinha_config.autofocus = false;
      xinha_config.toolbar = Drupal.settings.htmlarea.toolbar;
      xinha_config.killWordOnPaste = (Drupal.settings.htmlarea.killWordOnPaste ? true : false);
      xinha_config.pageStyle = Drupal.settings.htmlarea.pageStyle;
      if (Drupal.settings.htmlarea.styles) {
        xinha_config.pageStyleSheets = Drupal.settings.htmlarea.styles;
      }

      if (Drupal.settings.htmlarea.fontname) {
        xinha_config.fontname = Drupal.settings.htmlarea.fontname;
      }
      if (Drupal.settings.htmlarea.fontsize) {
        xinha_config.fontsize = Drupal.settings.htmlarea.fontsize;
      }
      if (Drupal.settings.htmlarea.formatblock) {
        xinha_config.formatblock = Drupal.settings.htmlarea.formatblock;
      }

      if (Drupal.settings.htmlarea.custom) {
        eval(Drupal.settings.htmlarea.custom);
      }
      xinha_editors = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
      HTMLArea.startEditors(xinha_editors);
    }
  );
}
