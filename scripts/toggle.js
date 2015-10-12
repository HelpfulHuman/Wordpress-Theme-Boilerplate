jQuery(function ($) {

  $(document).on('click', '[data-toggle]', function (event) {
    event.preventDefault();
    var target = $(this).data('toggle');
    var $target = $(target);
    var togClass = $(this).data('toggle-class');

    if (togClass) {
      $target.toggleClass(togClass);
    }
    else {
      $target.toggle();
    }
  });

});
