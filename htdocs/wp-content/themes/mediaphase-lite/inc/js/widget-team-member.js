var image_field;
jQuery(function ($) {
  $(document).on('click', 'input.mediaphase-select-img', function (evt) {
    image_field = $(this).siblings('.img');
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
  });
  var original_send_to_editor = window.send_to_editor;
  window.send_to_editor = function (html) {
    if (!image_field) {
      return original_send_to_editor(html);
    }
    imgurl = $('img', html).attr('src');
    image_field.val(imgurl);
    tb_remove();
  }
}(jQuery));