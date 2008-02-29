// $Id: persistent_fieldset.js,v 1.1.2.3 2006/12/12 00:30:58 mrtaco Exp $

if (isJsEnabled()) {
  addLoadEvent(collapseMemoryAutoAttach);
}

/**
 * Sets a Cookie with the given name and value.
 *
 * name       Name of the cookie
 * value      Value of the cookie
 * [expires]  Expiration date of the cookie (default: end of current session)
 * [path]     Path where the cookie is valid (default: path of calling document)
 * [domain]   Domain where the cookie is valid
 *              (default: domain of calling document)
 * [secure]   Boolean value indicating if the cookie transmission requires a
 *              secure transmission
 */
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

/**
 * Gets the value of the specified cookie.
 *
 * name  Name of the desired cookie.
 *
 * Returns a string containing value of specified cookie,
 *   or null if cookie does not exist.
 */
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

function collapseMemoryAutoAttach() {

  var fieldsets = document.getElementsByTagName('fieldset');
  var legend, fieldset;
  
  for (var i = 0; fieldset = fieldsets[i]; i++) {
  
    if (!hasClass(fieldset, 'collapsible')) {
      continue;
    }
    legend = fieldset.getElementsByTagName('legend');
    if (legend.length == 0) {
      continue;
    }
    legend = legend[0];
    
  
    if( hasClass( fieldset, 'collapsed' ) && ( getCookie( fieldset.id ) == 'false' ) ) {
      toggleClass(fieldset, 'collapsed');
    }
    
    var a = legend.getElementsByTagName('a');
    if (a.length == 0) {
      continue;
    }
    a = a[0];
    
    
    a.oldOnClick = a.onclick;
    a.onclick = function() {
      this.oldOnClick();
      setCookie( this.parentNode.parentNode.id, hasClass( this.parentNode.parentNode, 'collapsed' ) );
      return false;
    };
    
  }
}
