$('input[type="checkbox"]').on('click', function(){
    var id = $(this).attr('id');
    var data = {};
    data.id = $(this).attr('id');
    data.value = $(this).is(':checked') ? 1 : 0;
    $.ajax({
        type: "GET",
    }).done(function(data) {
        window.location.href = '/set/'+id;
    });
});
