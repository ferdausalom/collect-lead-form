jQuery(document).ready(function ($) {
  $("#name").on("input", function () {
    checkName();
  });

  $("#email").on("input", function () {
    checkEmail();
  });

  function checkName() {
    const pattern = /^[A-Za-z0-9_ -]+$/;
    const name = $("#name").val();
    const validname = pattern.test(name);
    if (name == "") {
      $("#name_err").html("Name is required.");
      return false;
    } else if ($("#name").val().length < 4) {
      $("#name_err").html("Name length is too short.");
      return false;
    } else if (!validname) {
      $("#name_err").html("Name should be a-z or 0-9 only.");
      return false;
    } else {
      $("#name_err").html("");
      return true;
    }
  }

  function checkEmail() {
    const pattern1 = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    const email = $("#email").val();
    const validemail = pattern1.test(email);
    if (email == "") {
      $("#email_err").html("Email is required.");
      return false;
    } else if (email.length < 8) {
      $("#email_err").html("Email length is too short.");
      return false;
    } else if (!validemail) {
      $("#email_err").html("Invalid email.");
      return false;
    } else {
      $("#email_err").html("");
      return true;
    }
  }

  $("#cl-lead-form").submit(function (e) {
    e.preventDefault();
    $(".error").fadeOut();
    $(".success").fadeOut();

    if (!checkName() || !checkEmail()) {
      $(".error").fadeIn();
      $(".err-message").html("Please fill all required fields.").fadeIn();
    } else {
      const form = $(this).serialize();

      $.ajax({
        method: "post",
        url: clcf_rest_url.url,
        data: form,
        beforeSend: function () {
          $(".cl-loader-spinner").fadeIn(800);
        },
        success: function (res) {
          if (res.success) {
            $(".error").slideUp();
            $("#name").val("");
            $("#email").val("");
            $("#message").val("");
            $(".cl-loader-spinner").slideUp(800);
            $(".success").slideDown(800);
            $(".message").html(res.message).slideDown(800);
          } else {
            $(".success").slideUp();
            $(".cl-loader-spinner").slideUp(800);
            $(".error").slideDown(800);
            $(".err-message").html(res.message).slideDown(800);
          }
        },
      });
    }
  });

  $(document).on("click", ".cl-close", function () {
    $(".error").slideUp();
    $(".success").slideUp();
  });
});
