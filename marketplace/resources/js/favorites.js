function ajaxRequest() {
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
            let products = $(".favorites-toggle");
            products.each(function () {
                if (favoritesIds.some(v => v == this.id)) {
                    $(this).children("img").attr("src", function (index, current) {
                        return current.replace('empty', 'filled')
                    })
                    $(this).removeClass('add')
                }
            })
            // BUTTON
            products.off()
            products.click(function () {
                let id = this.id
                let token = $("meta[name='csrf-token']").attr("content");
                let method
                method = $(this).hasClass('add') ? 'POST' : 'DELETE'
                if (method === 'DELETE') {
                    $(this).children("img").attr("src", function (index, current) {
                        return current.replace('filled', 'empty')
                    })
                    $(this).addClass('add')
                }
                $.ajax({
                    url: "http://127.0.0.1:8000/favorites/" + id,
                    type: method,
                    data: {
                        "_token": token,
                    },
                    success: function () {
                        console.log("it Works " + method);
                        ajaxRequest()
                    },
                })
            })
        },
        error: function (error) {
            console.log(error)
        },
    })
}

$(document).ready(ajaxRequest());
