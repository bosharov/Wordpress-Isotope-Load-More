jQuery(document).ready(function($) {
    $('#hero-squares').isotope({
        itemSelector: '.item',
        masonry: {
            gutter:5,
            layoutMode: 'fitRows'
        }
    });
    var has_run = false;
    var init_offset = 0;
    $('button.load-more-posts').click(function(e) {

        e.preventDefault();
        var button = $(this);

        // Disable button
        button.prop( "disabled" , true );

        // Record Nonce
        var nonce = $(this).data("nonce");
        
        if(has_run == false) {
            button.data('offset', $(this).data("offset"));
            init_offset = $(this).data("offset");
        }
        
        // Set AJAX parameters
        data = {
            action: 'mft_load_more_ajax',
            init_offset: init_offset,
            offset: button.data('offset'),
            nonce: nonce
        };

        $.post(mft_load_more_ajax.ajaxurl, data, function(response) {

            // Set Container Name
            var response = JSON.parse(response);
            console.log(response);

            // Run through JSON
            $.each( response, function( key, value ) {
              // Set Value
              var val = $(value);

              // Set Container
              var $container = $('#hero-squares').isotope();

              // Append Val
              $container.append(val).isotope( 'appended', val );
              
            });

            // Undo Button Disable
            button.prop( "disabled" , false );

            // Set Offset
            var offset = button.data("offset");
            button.data("offset", offset + 10 );

            // If Has Run
            has_run = true;

            return false;
            
        });

    });
    
});