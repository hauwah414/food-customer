$('body').on('click', '#linkCs', function () {
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: `/cs`,
        type: "POST",
        cache: false,
        data: {
            "_token": token
        },
        success: function (response) {
            window.open(response.data.value);
        },
    });
});