/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/backend.js ***!
  \*********************************/
var event;
var height;
var starter = {
  init: function init() {
    starter.onClick();
    starter.onChange();
    starter.onSubmit();
    starter.onInput();
    starter.formStyled();
  },
  onChange: function onChange() {},
  onInput: function onInput() {
    $(document).on("input", ".input, .textarea", function (e) {
      e.target.value !== "" ? $(this).addClass("has-value").removeClass("no-value") : $(this).removeClass("has-value");
    });
  },
  onClick: function onClick() {
    $(document).on('click', '.bt-table .remove', function () {
      var fields = {};
      var url = $(this).attr('href') + '/' + $(this).data('id');
      var method = 'DELETE';
      var headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Authorization': 'Bearer ' + token
      };
      if (method === 'PUT' || method === 'DELETE') {
        headers['X-HTTP-Method-Override'] = method;
      }
      if (confirm('Czy na pewno trwale usunąć ten wpis?') == true) {
        axios({
          method: method,
          url: url,
          headers: headers,
          data: fields
        }).then(function (response) {
          $('.bt-table').bootstrapTable('refresh');
        })["catch"](function (error) {
          $(".error-post").text('');
          if (error.response) {
            alert(error.response.statusText);
          } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message);
          }
        });
      }
      return false;
    });
  },
  onSubmit: function onSubmit() {
    $(document).on('submit', 'form.save', function () {
      var fields = starter.getFields($(this));
      var url = $(this).attr('action');
      var method = $(this).attr('method');
      var headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Authorization': 'Bearer ' + token
      };
      if (method === 'PUT' || method === 'DELETE') {
        headers['X-HTTP-Method-Override'] = method;
      }
      axios({
        method: method,
        url: url,
        headers: headers,
        data: fields
      }).then(function (response) {
        window.location = response.data.results.url;
      })["catch"](function (error) {
        $(".error-post").text('');
        if (error.response) {
          Object.keys(error.response.data.errors).map(function (item) {
            $(".error-".concat(item)).text(error.response.data.errors[item][0]);
          });
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message);
        }
      });
      return false;
    });
  },
  formStyled: function formStyled() {
    $(".input").find("~ .error:not(:empty)").siblings(".input").addClass("no-value");
    $('.input:not(.select):not([value=""])').addClass("has-value");
    $(".textarea").find("~ .error:not(:empty)").siblings(".textarea").addClass("no-value");
    $(".textarea:not(:empty)").addClass("has-value");
    $("select.input.select").each(function (index, element) {
      $(element).find('option').each(function () {
        if ($(this).is(':selected') && $(this).is('[value]') && $(this).attr('value') !== '') {
          $(element).addClass('has-value');
        }
      });
    });
  },
  getFields: function getFields($form) {
    var inputs = $form.find('.input');
    var textareas = $form.find('.textarea');
    var checkboxes = $form.find('.checkbox');
    var files = $form.find('.file');
    var fields = {};
    $.each(inputs, function (index, item) {
      fields[$(item).attr('name')] = $(item).val();
    });
    $.each(textareas, function (index, item) {
      fields[$(item).attr('name')] = $(item).val();
    });
    $.each(checkboxes, function (index, item) {
      if ($(item).prop('checked')) {
        fields[$(item).attr('name')] = $(item).val();
      }
    });
    $.each(files, function (index, item) {
      if (item.files[0]) {
        fields[$(item).attr('name')] = item.files[0];
      }
    });
    fields['_token'] = $form.find('input[name=_token]').val();
    return fields;
  }
};
$(window).on("load", function (e) {
  event = e || window.event;
  starter.init();
});
/******/ })()
;