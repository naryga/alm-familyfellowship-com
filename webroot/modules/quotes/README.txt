quotes.module
README.txt
$Id: README.txt,v 1.6 2007/02/14 15:28:35 jhriggs Exp $

The quotes module allows users to maintain a list of quotations that
they find notable, humorous, famous, infamous, or otherwise worthy of
sharing with website visitors. The quotes can be displayed in any
number of administrator-defined blocks. These blocks will display
either a randomly-selected quote or the most recent quote based on the
restrictions of each block. Blocks can be configured to restrict to
certain nodes, roles, users, or categories.

The display of quotes is themeable using two functions,
theme_quotes_quote() which displays a single quote/author and
theme_quotes_page() which displays a list of quotes. The default
implementation of theme_quotes_quote() uses two CSS classes to allow
you to control the display of quotes. The quote itself uses
"quotes-quote". The author/attribution uses "quotes-author".

Files
  - quotes.module
      the actual module (PHP source code)

  - quotes.info
      the module information file used by Drupal

  - quotes.install
      installation/upgrade functions (PHP source code)

  - README.txt (this file)
      general module information

  - INSTALL.txt
      installation/configuration instructions

  - CREDITS.txt
      information on those responsible for this module

  - TODO.txt
      feature requests and modification suggestions

  - CHANGELOG.txt
      change/release history for this module

  - LICENSE.txt
      the license (GNU General Public License) covering the usage,
      modification, and distribution of this software and its
      accompanying files
