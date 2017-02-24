/**
 * Created by andy on 2/9/17.
 */
jQuery(document).ready(function ($) {
    var data = {
        'action': 'wco_ajax',
        'whatever': ajax_object.whatever,
        'data': ajax_object,      // We pass php values differently!
        'security' : ajax_object.nonce,
    };

    console.log(data);
    $('select').select2().on("change", function(e) {
        // mostly used event, fired to the original element when the value changes
        //log("change val=" + e.val);
       // alert(ajax_object.nonce);
    });

    $('#newrow').on('click', function() {
        //alert('hi');
        var i = parseInt( $('#wco_rows').val() );
        var j = i + 1;
        $('#wco_rows').attr('value', j);
        //alert(j);
    });

    $('.itemgrouping.button').on('click', function() {
        //alert('hi');
        var rows = $('#numrows').val();

        //alert(j);
    });



    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    jQuery.post(ajax_object.ajax_url, data, function (response) {
        //alert('seRespon ' + response);
    });


});

jQuery(function($) {



});
/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load event on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load event after posts have been inserted via Ajax:
 */
//jQuery(document.body).trigger('post-load');

/*
 *JavaScript listening to the post-load event:
 */
jQuery( document.body ).trigger( 'post-load' );
jQuery(document.body).on('post-load', function () {
    // New posts have been added to the page.
    console.log('posts');
});