
if (isJsEnabled()) {
  addLoadEvent(subformAutoAttach);
}

function subformAutoAttach()
{
  syncDuplicateFormElements( 'input' );
  syncDuplicateFormElements( 'textarea' );
  syncDuplicateFormElements( 'select' );
  syncDuplicateFormElements( 'optgroup' );
}

function syncDuplicateFormElements( formElementTag ) {
  
  var elements = document.getElementsByTagName( formElementTag );
  
  var duplicateElements = new Array;
  
  // look at each element
  for (var i = 0; element = elements[i]; i++)
  {
  
    var fieldUniqueId = getUniqueFieldId( element );
      
    // if its one of the elements we're interested in
    if( fieldUniqueId.length > 0 ) {
      
      // log it
      
      if( duplicateElements[ fieldUniqueId ] == null )
      {
        duplicateElements[ fieldUniqueId ] = new Array;
      }
      
      var duplicates = duplicateElements[ fieldUniqueId ];
      duplicates.push( element );
      
    }
  
  }
  
  // look at each element
  for (var i = 0; element = elements[i]; i++)
  {
  
    var fieldUniqueId = getUniqueFieldId( element );
      
    // if its one of the elements we're interested in
    if( fieldUniqueId.length > 0 ) {
    
      // teach it to update its duplicates
    
      element.onchange = function()
      {
      
        var myUniqueId = getUniqueFieldId( this );
        var duplicates = duplicateElements[ myUniqueId ];
      
        for (var i = 0; duplicate = duplicates[ i ]; i++)
        {
          if( duplicate != this )
          {
            duplicate.value = this.value;
          }
        }
        
      }
      
    }
  
  }
  
}

function getUniqueFieldId( element )
{
  var uniqueSectionStart = element.id.lastIndexOf( "-node" );
  if( uniqueSectionStart != -1 ) {
    return element.id.substring( uniqueSectionStart, element.id.length );
  }
  return ""; 
}

  

function setValueOfLastHiddenInputEndingIn( linkElement, endingText, newValue )
{

  var parent = linkElement.parentNode;
  var inputs = parent.getElementsByTagName('input');

  for (var i = 0; input = inputs[i]; i++)
  {
      
    if( ( ( input.id.substring( input.id.length - endingText.length, input.id.length ) ) == endingText ) && ( input.type == 'hidden' ) )
    {
      
      input.value = newValue;
      return false;
    }

  }


  if( parent == document.body )
  {
    // we've searched too far
    return false;
  }
  else
  {
  
    setValueOfLastHiddenInputEndingIn( parent, endingText, newValue );
  }

}
