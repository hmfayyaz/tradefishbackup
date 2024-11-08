(function ($) {
  "use strict";

  // Debounce function
  function debounce(func, delay) {
    let timer;
    return function () {
      const context = this;
      const args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        func.apply(context, args);
      }, delay);
    };
  }

  // Saving Feedback Board Status With Ajax Request
  $(".wp-feedback-roadmap-save").on(
    "click",
    debounce(function (event) {
      event.preventDefault();
      const _this = $(this);
      const valid = true;
      if (!$("#name").val()) {
        $(".input_validation").css("border", "1px solid red");
        return;
      }
      const name = $("#name").val();
      const color = $("#color").val();
      $.ajax({
        url: wp_roadmap_localize.ajaxurl,
        type: "post",
        data: {
          action: "save_feedback_roadmap_settings",
          _ajax_nonce: wp_roadmap_localize.nonce,
          name: name,
          color: color,
        },
        success: function (response) {
          _this.html("Save Changes");
          window.location.reload();
          if (response === true) {
            setTimeout(function () {
              Swal.fire({
                icon: "success",
                title: "Status has been saved!",
                showConfirmButton: false,
                timer: 2000,
              });
            }, 500);
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          }
        },
        error: function () {
          _this.html("Save Changes");
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        },
      });
    }, 1000) // Adjust the debounce delay as needed
  );

  // Edit Feedback Board Status With Ajax Request
  $(".wp-feedback-roadmap-update").on("click", function (event) {
    event.preventDefault();
    var _this = $(this);
    var form = _this[0]["form"];
    var form_id = form.id;
    var form_data = $("#" + form_id).serialize();
    $.ajax({
      url: wp_roadmap_localize.ajaxurl,
      type: "post",
      data: {
        action: "update_feedback_roadmap_settings",
        _ajax_nonce: wp_roadmap_localize.nonce,
        fields: form_data,
      },
      success: function (response) {
        _this.html("Save Changes");
        if (response === true) {
          setTimeout(function () {
            Swal.fire({
              icon: "success",
              title: "Settings has been saved!",
              showConfirmButton: false,
              timer: 2000,
            });
          }, 500);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        }
      },
      error: function () {
        _this.html("Save Changes");
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      },
    });
  });
  // Delete Status Data With Ajax Request
  $(".wp-feedback-status-delete").on("click", function (event) {
    event.preventDefault();
    var feedback_board_id = $(this).val();
    Swal.fire({
      title: "Are you sure you want to delete?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: wp_roadmap_localize.ajaxurl,
          type: "post",
          data: {
            action: "delete_feedback_roadmap_settings",
            _ajax_nonce: wp_roadmap_localize.nonce,
            id: feedback_board_id,
          },
          success: function (response) {
            if (response === true) {
              window.location.reload();
              setTimeout(function () {
                Swal.fire({
                  icon: "success",
                  title: "Settings has been Deleted!",
                  showConfirmButton: false,
                  timer: 2000,
                });
              }, 500);
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
            }
          },
        });
      }
    });
  });
  // Saving General Setting With Ajax Request
  $(".feedback-general-setting-save").on("click", function (event) {
    event.preventDefault();
    var _this = $(this);
    var title = $("#title").val();
    var description = $("#description").val();
    var wp_roadmap_status = $("#wp_roadmap_status").val();
    var suggestion = $("#suggestion").val();
    var request_feature_link = $("#request_feature_link").val();
    var selected_pages = $("#selected_pages").val();

    $.ajax({
      url: wp_roadmap_localize.ajaxurl,
      type: "post",
      data: {
        action: "save_feedback_roadmap_general_settings",
        _ajax_nonce: wp_roadmap_localize.nonce,
        title: title,
        description: description,
        wp_roadmap_status: wp_roadmap_status,
        suggestion: suggestion,
        request_feature_link: request_feature_link,
        selected_pages: selected_pages,
      },
      success: function (response) {
        _this.html("Save Changes");
        if (response === true) {
          setTimeout(function () {
            Swal.fire({
              icon: "success",
              title: "Settings has been saved!",
              showConfirmButton: false,
              timer: 2000,
            });
          }, 500);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        }
      },
      error: function () {
        _this.html("Save Changes");
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      },
    });
  });
  // Saving Feedback Data With Ajax Request
  $(".wp-feedback-data-save").on("click", function (event) {
    event.preventDefault();
    var _this = $(this);
    var valid = true;
    if (!$("#title").val()) {
      $(".input_validation").css("border", "1px solid red");
      valid = false;
      return valid;
    }
    $.ajax({
      url: wp_roadmap_localize.ajaxurl,
      type: "post",
      data: {
        action: "save_feedback_board_data",
        _ajax_nonce: wp_roadmap_localize.nonce,
        fields: $("form#wp_roadmap_feedback_add_form").serialize(),
      },
      success: function (response) {
        _this.html("Save Changes");
        $("#wp_roadmap_feedback_add_form")[0].reset();
        $("#wp-roadmap-feedback-modal").hide();

        if (response === true) {
          window.location.reload();
          setTimeout(function () {
            Swal.fire({
              icon: "success",
              title: "Feedback Task has been saved!",
              showConfirmButton: false,
              timer: 2000,
            });
          }, 500);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        }
      },
      error: function () {
        _this.html("Save Changes");
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      },
    });
  });
  // Get Feedback Data With Ajax Request
  $(".wp-feedback-data-edit ").on("click", function (event) {
    event.preventDefault();
    var _this = $(this);
    var id = $(this).attr("data-value");
    $.ajax({
      url: wp_roadmap_localize.ajaxurl,
      type: "post",
      data: {
        action: "edit_feedback_board_data",
        _ajax_nonce: wp_roadmap_localize.nonce,
        id: id,
      },
      success: function (response) {
        $("#id").val(response.data.id);
        $("#title").val(response.data.title);
        $("#description").val(response.data.description);
        $("#wp_roadmap_status").val(response.data.status_id);
        $("#myModal").modal("show");
      },
    });
  });
  // Feedback Data Detail Modal
  $(".wp-feedback-data-detail").on("click", function (event) {
    event.preventDefault();
    var id = $(this).attr("data-value");
    $.ajax({
      url: wp_roadmap_localize.ajaxurl,
      type: "post",
      data: {
        action: "wp_feedback_detail",
        _ajax_nonce: wp_roadmap_localize.nonce,
        id: id,
      },
      success: function (response) {
        $("#wp_detail_feedback").text(response.data.title);
        $("#wp_detail_feedback_description").text(response.data.title);
        $("#wp_detail_feedback_status").text(response.data.status_id);
        $("#wp_detail_feedback_date").text(response.data.created_date);
        $("#wp_detail_feedback_upvote").text(response.data.total_upvote);
        $("#wp-detail").modal("show");
      },
    });
  });
  // Deleting Feedback Data With Ajax Request
  $(".wp-feedback-data-delete").on("click", function (event) {
    event.preventDefault();
    var feedback_id = $(this).attr("data-value");
    Swal.fire({
      title: "Are you sure you want to delete?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: wp_roadmap_localize.ajaxurl,
          type: "post",
          data: {
            action: "delete_feedback_board_data",
            _ajax_nonce: wp_roadmap_localize.nonce,
            id: feedback_id,
          },
          success: function (response) {
            if (response === true) {
              Swal.fire({
                icon: "success",
                title: "Feedback Task has been deleted!",
                showConfirmButton: false,
                timer: 2000,
              });
              setTimeout(function () {
                window.location.reload();
              }, 500);
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          },
        });
      }
    });
  });

  // Reset Feedback Likes With Ajax Request
  $(".wp-feedback-data-reset").on("click", function (event) {
    event.preventDefault();
    var feedback_id = $(this).attr("data-value");
    Swal.fire({
      title: "Are you sure you want to reset?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, reset it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: wp_roadmap_localize.ajaxurl,
          type: "post",
          data: {
            action: "reset_feedback_board_data",
            _ajax_nonce: wp_roadmap_localize.nonce,
            id: feedback_id,
          },
          success: function (response) {
            if (response === true) {
              Swal.fire({
                icon: "success",
                title: "Feedback Task has been reset!",
                showConfirmButton: false,
                timer: 2000,
              });
              setTimeout(function () {
                window.location.reload();
              }, 2000);
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          },
        });
      }
    });
  });
})(jQuery);
