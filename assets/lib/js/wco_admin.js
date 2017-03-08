/*
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by andy on 2/9/17.
 */


jQuery(document).ready(function ($) {


  $('#newrow').on('click', function (e) {
    //alert('hi');
    var k = $('#wco_2_rows').val();
    var i = parseInt(k);
    var j = i + 1;
    $('#wco_2_rows').attr('value', j);
    //alert(j);
  });
  $('#delrow').on('click', function () {
    //alert('hi');
    var k = $('#wco_2_rows').val();
    var i = parseInt(k);
    var j = i - 1;
    $('#wco_2_rows').attr('value', j);
    //alert(j);
  });

  $('.wco_2_selector').on('change', function () {
    console.log($(this).attr('id'));
    console.log( $(this).select2('data') );
    var id = ($(this).attr('id'));
    var data = $(this).select2('data') ;
    var str = id+'_text';
    var text_id = document.getElementById(str);
    $(text_id).attr('value', data.text);
    //$('#'+id+'_text').attr('value', data.text);
   // $('')
   // console.log($(this).text());
  });

  $('span.saverow').click(function (e) {

    var data = {
      'url':ajax_object.ajax_url,
      'action':'wco_ajax',
      'security':ajax_object.nonce,
      'whatever':ajax_object.whatever,
      //'data':ajax_object     // We pass php values differently!
      //'security':ajax_object.nonce
    };

    console.log(data);
    console.log(e);

    sweetAlert({
        title:"Ajax request example",
        text:"Submit to run ajax request",
        type:"info",
        showCancelButton:true,
        closeOnConfirm:false,
        showLoaderOnConfirm:true,
      },
      function () {

        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        jQuery.post(ajax_object.ajax_url, data, function (response) {

          $('#feedme').html(response);

          setTimeout(function () {
            swal("Ajax request: " + response);
          });
          //alert('seRespon ' + response);
        });

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