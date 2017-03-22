jQuery(document).ready(function ($) {
  var t = ['except_listed', 'only_listed']
  var oldGuid

  $('#chatbro_chat_display').change(function () {
    if (t.indexOf($('#chatbro_chat_display').val()) !== -1) {
      $('#chatbro_chat_selected_pages-group').show()
    } else {
      $('#chatbro_chat_selected_pages-group').hide()
    }
  })

  $('#chatbro_chat_display').change()

  $('#chatbro-settings-form').ajaxForm({
    url: ajaxurl,
    type: 'POST',

    success: function (response) {
      if (response === '0') {
        window.location = $('#chb-login-url').val()
        return
      }

      response = JSON.parse(response)

      var msgDiv = $('#chatbro-message')
      msgDiv.removeClass()
      msgDiv.html('')
      msgDiv.hide()

      if (response.hasOwnProperty('message')) {
        if (response.hasOwnProperty('msg_type') && response['msg_type'] === 'error') {
          msgDiv.addClass('bs-callout-small bs-callout-small-danger')
        } else {
          msgDiv.addClass('bs-callout-small bs-callout-small-success')
        }

        msgDiv.html(response['message'])
        msgDiv.show()
      }

      $('.with-errors').empty()
      $('.form-group').removeClass('has-error has-success')

      if (response.hasOwnProperty('field_messages')) {
        var focused = false

        Object.keys(response.field_messages).forEach(function (id) {
          var m = response.field_messages[id]
          var group = $('#' + id + '-group')

          $('.with-errors', group).html('<ul class="list-unstyled"><li>' + m.message + '</li></ul>')

          if (m.type === 'error') {
            group.addClass('has-error')

            if (!focused) {
              $('#' + id).focus()
              focused = true
            }
          }
        })
      }

      enableSubmit()
    }
  })

  function disableSubmit () {
    $('#chatbro-save').button('saving').addClass('disabled').blur()
  }

  function enableSubmit () {
    $('#chatbro-save').button('reset').removeClass('disabled')
  }

  $('#chatbro-save').click(function () {
    disableSubmit()

    oldGuid = $('#chb-sec-key').val()
    var newGuid = $('#chatbro_chat_guid').val()

    if (oldGuid !== newGuid) {
      $('#chb-old-key span').html(oldGuid)
      $('#chb-confirm-guid-modal').modal('show')
      return
    }

    $('#chatbro-settings-form').submit()
  })

  $('#chb-confirm-guid-modal').on('hidden.bs.modal', function () {
    if ($(this).hasClass('submit-confirmed')) {
      $(this).removeClass('submit-confirmed')
      $('#chatbro-settings-form').submit()
    } else {
      $('#chatbro_chat_guid').val(oldGuid)
      enableSubmit()
    }
  })

  $('#chb-confirm-guid-modal button.btn-primary').click(function () {
    $('#chb-confirm-guid-modal').addClass('submit-confirmed').modal('hide')
  })

  // Modal div must not be inside any element with relative or fixed postition
  // or it will be shown behind it's backdrop. Let's move it to the top level of the body.
  var modal = $('#chb-confirm-guid-modal')
  $('body').append(modal)

  function adjustChatWidth () {
    if (window.innerWidth >= 1200) {
      var chat = $('#support-chat')
      var left = chat[0].getBoundingClientRect().left
      chat.width(window.innerWidth - left - 35 + 'px')
    }
  }

  function adjustChatHeight () {
    var c = $(window).outerWidth >= 1200 ? 0.9 : 0.7
    var h = $(window).outerHeight() * c
    $('#chatbro-chat-panel').height(h)
  }

  $(window).resize(function () {
    if ($('#support-chat').hasClass('affix')) {
      adjustChatWidth()
    }
    adjustChatHeight()
  })

  $('#support-chat')
  .on('affixed.bs.affix', adjustChatWidth)
  .on('affix-top.bs.affix', function () {
    $(this).width('')
  })

  // $.post(ajaxurl, {action: 'chatbro_get_faq'}, function (response) {
  //   $('#chatbro-faq').html(response)
  // })

  adjustChatHeight()
})
