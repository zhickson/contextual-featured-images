/**
 * webpack FTW.
 * 
 * @since 1.0.0
 * 
 * @see https://laravel-mix.com/
 * @arigato https://github.com/JeffreyWay/
 */
const mix = require( 'laravel-mix' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const wpPot = require( 'wp-pot' );

// Fix for versioning
mix.setPublicPath( 'dist' );

// Fix for fonts
mix.setResourceRoot( '../' );

// Use WordPress jQuery
mix.webpackConfig( {
    externals: {
        $: 'jQuery',
        'jquery': 'jQuery',
        'react': 'React'
    }
} );

// Main scripts and styles
mix.react( 'assets/js/admin/cfi-admin.js', 'dist/scripts' );
mix.sass( 'assets/css/cfi-admin.scss', 'dist/styles' );

// Version in production
if ( mix.inProduction() ) {
    mix.version();
    
    // RTL support.
    mix.webpackConfig( {
        plugins: [
            new WebpackRTLPlugin( {
                suffix: '-rtl',
                minify: true,
            } )
        ]
    } );

     // POT file.
     wpPot( {
        package: 'Contextual Featured Images',
        domain: 'cfi',
        destFile: 'languages/cfi.pot',
        relativeTo: './',
        src: [ './**/*.php', '!./includes/libraries/**/*', '!./vendor/**/*', '!./docker/**/*', '!./dotorg/**/*', '!./node_modules/**/*' ],
        bugReport: 'https://github.com/zhickson/contextual-featured-images/issues/new',
        team: 'Dunktree <zhickson@dunktree.com>',
    } );
}