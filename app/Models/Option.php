<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    
    protected $fillable = [ 'name', 'value' ];

    // save an option
    public static function update_option( $name, $value ) {

    	// update if already exists - create if it doesn't
    	$option = self::firstOrNew(['name' => $name]);
        $option->value = $value;
    	$option->save();

    }

    // get an option
    public static function get_option( $name ) {
        return self::where('name', $name)->pluck('value')->first();
    }

    // delete an option
    public static function delete_option( $name ) {
        $id = self::where('name', $name)->pluck('id')->first();

        if( $id )
            return self::destroy($id);

    }

    // get first from a comma separated list
    public static function first_from_list( $comma_separated_list ) {
        return reset(explode(',', $comma_separated_list));
    }

    // return brand in parts
    public static function brand_name( ) {
        // get site title
        $site_title = self::get_option('site_title');

        // split into parts
        preg_match( '/[^\.]*/i', $site_title, $begining );
        preg_match( '/\..*/i', $site_title, $ending );

        return reset( $begining ) . '<span class="sub-brand">' . reset( $ending ) . '</span>';

    }

}
