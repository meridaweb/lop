<?php

/*
Plugin Name: Codepress Core
Description: Development core for Codepress projects
Version: 1.0.2
Author: Codepress
Author URI: http://codepress.nl
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// define constants
define( 'CPC_DIR', plugin_dir_path( __FILE__ ) );

// set up l10n
load_theme_textdomain( 'cpc', CPC_DIR . '/languages' );

$directory = new RecursiveDirectoryIterator( CPC_DIR . 'classes', RecursiveDirectoryIterator::SKIP_DOTS );

foreach( new RecursiveIteratorIterator( $directory ) as $filename => $file ) {
    include $filename;

    $format = implode( '_', array_map( 'ucfirst', explode( '-', $file->getFilename() ) ) );
    $class  = 'CPC' . str_replace( array( 'Class_Cpc', '.php' ), '', $format );

    new $class;
}
