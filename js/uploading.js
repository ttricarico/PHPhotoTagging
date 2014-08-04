jQuery(document).ready(function($) {
  var _upload = document.getElementById('uploadbox'),
      $upload = $(_upload);

  _upload.addEventListener('drop', function(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    var files = evt.target.files || evt.dataTransfer.files;

    for(var i = 0; file = files[i]; i++) {

      var fileid = Math.floor(Math.random() * 1000000);


      //send file
      var filesend = new FormData();
      filesend.append('uploadfile', file, file.name);
      $.ajax({
        url: '',
        type: 'POST',
        data: filesend,
        dataType: 'json',
        processData: false,
        contentType:false,
        cache: false,
        xhr: function() {
          var xhr = new XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
            if(evt.lengthComputable) {
              var percentComplete =  (parseFloat(evt.loaded) / parseFloat(evt.total) ) * 100;
              $('#upload_' + fileid + ' .upload-progress-bar').text(Math.round(percentComplete) + '%')
                                                              .addClass('active')
                                                              .css({'width' : percentComplete + '%'});
            } else {
              $('#upload_' + fileid + ' .upload-progress-bar').text('Uploading...');
              $('#upload_' + fileid + ' .upload-progress-bar').addClass('active').css({'width' : '100%'});
            }
          }, false);
          return xhr;
        },
        beforeSend: function() {
          var uploadHTML = '<div class="uploadinfo" id="upload_' + fileid + '">' +
                            '<div class="progress upload-progress">' +
                              '<div class="progress-bar progress-bar-striped upload-progress-bar" role="progressbar" style="width: 100%;">' +
                                '<i class="fa fa-spinner fa-spin"></i> Starting...' +
                              '</div>' +
                            '</div>' +
                            '<div class="fileinfo">' +
                              '<div class="filename col-md-4">File Name: ' + file.name + '</div>' +
                              '<div class="filesize col-md-4">File Size:' + file.size + ' bytes</div>' +
                            '</div>' +
                            '<div class="filemessage">' +
                            '</div>' +
                          '</div>';

          $('#uploading-status').append(uploadHTML);
        },
        complete: function() {
          $('#upload_' + fileid + ' .upload-progress-bar').removeClass('progress-bar-striped active');
        },
        success: function(json) {
          //put some checking for duplicates and such
          switch(json.status) {
            case 'success':
              $('#upload_' + fileid + ' .upload-progress-bar').addClass('progress-bar-success clickable').text('Finished! Click to go to the image!');

              $('#upload_' + fileid).on('click', function() {
                window.open(json.href);
              });
              break;

            case 'error':
              $('#upload_' + fileid + ' .upload-progress-bar').addClass('progress-bar-danger').text('Oh no! There seems to be a problem!');
              $('#upload_' + fileid + ' .filemessage').html('Something odd happened. Please try again in a few minutes.');
              break;
          }


        },
        error: function(x, s, e) {
          $('#upload_' + fileid + ' .upload-progress-bar').addClass('progress-bar-danger').text('Oh no! There seems to be a problem!');
          $('#upload_' + fileid + ' .filemessage').html('Something really odd happened. Try again in a few minutes.');
        }
      });

      console.log(file);
    } //end for loop
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
function computeFileSize(fs) {
  var cf = 0;
  var s = ['B','KB','MB','GB','TB','PB'];
  do {
    if(fs < 1024)
      break;
    fs = Math.round(fs / 1024);
    cf++;
  }while(true);
  return fs + s[cf];
}
