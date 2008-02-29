WHAT IT DOES:
-------------
This module is intended to make relating content to eachother, as simple as possible. The meat of the interface, is a new CCK field type called a "subform". Subforms are very similar to MS Access subforms in that they provide CRUD operations on some child type, right inline on the parent type view/edit pages.

TO INSTALL:
-----------
Drop the subform folder into the 'modules' directory of your drupal installation, and then enable the content (cck), views, subform module, content_type_reference, and persistent_fieldset modules.

OVERVIEW:
---------
Subform works on the concept of "relation types" and "relation instances." For example, to dogs are owned by their human owner. That is a type of relationship, but the relationship between you and your dog is an actual instance of the previously mentioned relation type. Cars are kept in garages (relationship type), but your car is in your garage right now (relationship instance). To make subform work, you must first define some relationship types amongst your already specified cck content types.

QUICK TUTORIAL:
---------------
Assuming you already have some content types defined in your system, go to node/add/content_relation_type and create a relation type. If you created your relation type between the Person cck type and the Car cck type, then now edit either your Person or Car type and add a subform. In the config for this subform, select the relation type that you just created, and then specify which side of the relationship you want to display as child nodes (either left or right, ie type_one or type_two). The other config options should be self explanatory.

REQUIREMENTS:
-------------
external
  content.module
  views.module
bundled
  content_type_reference.module
  persistent_fieldset.module
