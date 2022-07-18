/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function ( $ ) {

    //------- Site title and description. --------/
    wp.customize(
        'blogname', function ( value ) {
            value.bind(
                function ( to ) {
                    $('.site-title a').text(to);
                } 
            );
        } 
    );

    //------- Blog Descrition --------/
    wp.customize(
        'blogdescription', function ( value ) {
            value.bind(
                function ( to ) {
                    $('.site-description').text(to);
                } 
            );
        } 
    );

    //-------- Footer Background --------------
    wp.customize(
        'dostart_footer_bg', function ( value ) {
            value.bind(
                function ( newval ) {
                    jQuery('.dostart-footer-area').css('background-color', newval);
                } 
            );
        } 
    );

    wp.customize(
        'dostart_copyright_text', function ( value ) {
            value.bind(
                function ( to ) {
                    $('.copyright-text').text(to);
                } 
            );
        } 
    );



}( jQuery ) );
