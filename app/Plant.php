<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

/**
 * This is a model for describing the plants, part of the MVC (Model-View Controller) pattern
 *  It inherits a bunch of stuff from the default eloquent model which allows us to
 *  save the plant to the database, delete the plant, find different plants, etc. 
 *   The primary key and the table are modified because we used upper case and singular
 *  table names at first so I wanted to stick with that convention
 */
class Plant extends Model
{
    use SoftDeletes;
    protected $table = 'Plant';
    protected $primaryKey ='plantId';
}
