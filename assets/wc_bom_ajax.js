/*
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by andy on 2/24/17.
 */
/**
 * Created by andy on 2/9/17.
 */
jQuery(document).ready(function ($) {

    //sweetAlert('hi');

  //alert('hi');

  //return false;
  $('#yeahbtn').click(function(e) {

    console.log(e);
    var data = {
      'url':ajax_object.ajax_url,
      'action':'wco_ajax',
      'security':ajax_object.nonce,
      'whatever':ajax_object.whatever,
      'data':ajax_object     // We pass php values differently!
      //'security':ajax_object.nonce
    };

    console.log(data);

    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    jQuery.post(ajax_object.ajax_url, data, function (response) {

      $('#feedme').html(response);
      //alert('seRespon ' + response);
    });

  });



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
jQuery(document.body).trigger('post-load');
jQuery(document.body).on('post-load', function () {
  // New posts have been added to the page.
  console.log('posts');
});