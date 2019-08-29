/**
 * webpack FTW.
 * 
 * @since 1.0.0
 * 
 * @see https://laravel-mix.com/
 * @arigato https://github.com/JeffreyWay/
 */
const mix = require( 'laravel-mix' );

// Fix for versioning
mix.setPublicPath( 'dist' );

// Fix for fonts
mix.setResourceRoot( '../' );

// Use WordPress jQuery
mix.webpackConfig( {
    externals: {
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
}