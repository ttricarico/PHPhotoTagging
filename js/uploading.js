jQuery(document).ready(function($) {
  $('#uploadbox').on('dragover', function(e) {
    e.preventDefault();

    //do this once
    if(!$(this).hasClass('droppable')) {
        $(this).addClass('droppable');
    }

  });
  $('#uploadbox').on('dragleave', function(e) {
    e.preventDefault();
    if($(this).hasClass('droppable')){
      $(this).removeClass('droppable');
    }
  });
  $('#uploadbox').on('drop', function(e) {
    e.preventDefault();
    if($(this).hasClass('droppable')){
      $(this).removeClass('droppable');
    }

  });
  $('#uploadfile').on('change', function(e) {
    console.log(e);
  });
});
