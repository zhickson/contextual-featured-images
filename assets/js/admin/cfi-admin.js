import jQuery from 'jquery';

const { render, createElement } = wp.element;

import { cfiApp } from './components/cfiApp.jsx';

jQuery( function() {
    'use strict';

    jQuery(document).ready(function () {

        // Grab the initial data that WP loads
        // This is essentially the current post's terms
        let initialData = window.CFI_DATA;

        // Make sure we have some initial data
        if ( initialData ) {

            // Render the UI, always handy
            render(
                createElement( cfiApp, {
                    initialData
                } ),
                document.getElementById( 'cfiApp' )
            );
        }
    });

});