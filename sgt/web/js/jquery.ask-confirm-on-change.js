
var formFieldsChanged=false
$(document).ready(function() {

    $(":input").change(function() {
      if ($('button:contains("Update")').size()>0)
      {
        $(this).closest('form').data('changed', true);
        formFieldsChanged=true;

      }
    });

    $("a[data-method='post']").on('click', function () {
      if(!formFieldsChanged) return true;
      return confirm('Le modifiche non sono state salvate.\n\nVuoi.. uscire senza salvare?');
    });

    //////////////////////////////////////////////////////////////
    //
    //////////////////////////////////////////////////////////////
    // If cookie is set, scroll to the position saved in the cookie.
    if ( Cookies("scroll") !== null ) {
        $(document).scrollTop( Cookies("scroll") );
    }

    // When a button is clicked...
    $('body').on("beforeSubmit", function() {
        // Set a cookie that holds the scroll position.
        Cookies("scroll", $(document).scrollTop() );
    });

});
