jQuery(document).ready(function($) {
  var _upload = document.getElementById('uploadbox'),
      $upload = $(_upload);

  _upload.addEventListener('drop', function(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    var files = evt.target.files || evt.dataTransfer.files;

    for(var i = 0; file = files[i]; i++) {
      $.ajax({
        //settings
      });
      console.log(file);
    }
    $upload.removeClass('droppable');
  });
  _upload.addEventListener('dragover', function(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    if(!$upload.hasClass('droppable')) {
      $upload.addClass('droppable');
    }
  });
  _upload.addEventListener('dragleave', function(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    $upload.removeClass('droppable');
  });
});
