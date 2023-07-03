$(document).ready(function() {
  $("#send-button").click(function() {
    var text = $("#text-input").val();
   
    $.ajax({
      type: "POST",
      url: "index.php",
      data: { text: text },
      success: function(response) {
        console.log("отправлено на сервер");
        console.log(JSON.parse(response));
        var decodedString = JSON.parse(response);
        $("#processed-text").val(decodedString);
      },
      error: function(xhr, status, error) {
        // Обработка ошибки
        console.log(error);
      }
    });
  });
});






