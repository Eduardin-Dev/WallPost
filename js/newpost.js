$(document).ready(function () {

   $("#postimg").hide();

   $('#arquivo').change(function () {

      $("#newpost").css({ padding: '0px' });
      $("#newpost").css({ width: '210px' });
      $("#newpost").css({ height: '265px' });
      $("#postimg").show();
      $("#imgpost").hide();

      const file = $(this)[0].files[0]

      const fileReader = new FileReader()

      fileReader.onloadend = function () {
         $('#postimg').attr('src', fileReader.result);
      }

      fileReader.readAsDataURL(file)
   });
});