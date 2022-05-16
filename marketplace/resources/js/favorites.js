$(document).ready(ajaxRequest(false));

function ajaxRequest(buttons) {
    if (!$('#favorites-list').length) {
        return
    }
    $.ajax({
        url: "http://127.0.0.1:8000/favorites",
        method: 'GET',
        success: function (favoritesObj) {
            let favoritesIds = []
            for (let i in favoritesObj) {
                favoritesIds.push(favoritesObj[i].id)
            }

            if (!buttons) {
                buttons = $(".favorites-toggle");
                buttons.each(function () {
                    if (favoritesIds.some(v => v == this.id)) {
                        imageToggle($(this))
                        $(this).removeClass('add')
                    }
                })
                buttonAction(buttons)
            }
        },
        error: function (error) {
            console.log(error)
        },
    })
}

function buttonAction(buttons = null) {
    buttons.click(function () {
        let current=$(this)
        let id = this.id
        let token = $("meta[name='csrf-token']").attr("content");
        let method
        if ($(this).hasClass('add')) {
            method = 'POST'
            imageToggle($(this))
        } else {
            method = 'DELETE'
            imageToggle($(this), true)
        }
        $(this).toggleClass('add')

        $.ajax({
            url: "http://127.0.0.1:8000/favorites/" + id,
            type: method,
            data: {
                "_token": token,
            },
            success: function () {
                $('#alert-message').text('Favorites list updated')
                $('#alert').trigger('showAlert')
                current.off()
                buttonAction(current)
                ajaxRequest(buttons)
            },
        })
    })
}

function imageToggle(element, fill = false) {
    element.children("img").attr("src", function (index, current) {
        return fill ? current.replace('filled', 'empty') : current.replace('empty', 'filled')
    })
}
