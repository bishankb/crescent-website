$(document).ready(function() {
	$(function () {
	    $('#table-control').DataTable({
	      'paging'      : true,
	      'lengthChange': true,
	      'searching'   : true,
	      'ordering'    : false,
	      'info'        : false,
	      'autoWidth'   : true
	    })
	});

	$('div.alert').not('.alert-important').delay(3000).fadeOut(1000);

    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }

    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });

    $(window).on("popstate", function() {
        var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
        $("a[href='" + anchor + "']").tab("show");
    });

    $('.image-margin').hide();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();             
            reader.onload = function (e) {
                $('.selected-img').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#input_image").change(function(){
        $('.selected-img').addClass('custom-thumbnail');
        $('.image-margin').show();
        $('.show-image').show();
        readURL(this);
    });

	$('.custom-select').select2({
        tags: true,
        placeholder: "Select an option",
    });
});

function removeImage()
{
    if (confirm('Are you sure you want to delete the image?')) {
        $('#input_image').val('');
        $('.image-margin').hide();
    }
}
