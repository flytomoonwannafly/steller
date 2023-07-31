jQuery(document).ready(function($){
    $('#dummy_image_button').on('click', function(e){
        e.preventDefault();
        var image = wp.media({
            title: 'Вибрати зображення',
            multiple: false
        }).open()
            .on('select', function(e){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#dummy_image').val(image_url);
            });
    });
});