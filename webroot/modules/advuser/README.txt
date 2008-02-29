// $Id: README.txt,v 1.3 2006/08/27 14:21:48 mojah Exp $

****************
Module Functions
****************

- Filtering of users based on profile.module fields
- Filter user based on status active or blocked
- Mass emailing/deleting of the filtered users
- Notify selected roles when a new user registers for an account
- Show all users who never logged in
- notfiy site admin when profile fields has been updated by a user


This module allows the advanced filtering of users based on profile.module fields
Site administrators will have access to a list of profile.module fields through which users can be filtered via the settings->advuser menu of the module.
It also has memory capabilities and remembers the last used filter so that users can be narrowed down to specific common denominators
eg. All female users with pet frogs who live in Alaska
The module can then be used to send a mass email to all selected users of the above filtered common denominators ie. All females with frogs in Alaska.
It can also be used to delete all users of this group.

*************
Installation
*************


Simply drop the module into the Drupal modules folder, and activate via the admin panel as normal. No database installation required.

Usage:
Navigate to settings -> advuser to select which profile_fields can be filtered
You also have the option to config number of users to display per listing
