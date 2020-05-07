<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
/**
 * This is a model for describing the submissions, part of the MVC (Model-View Controller) pattern
 *  It inherits a bunch of stuff from the default eloquent model which allows us to
 *  save the submission to the database, delete the submission, find different submissions, etc. 
 *   The primary key and the table are modified because we used upper case and singular
 *  table names at first so I wanted to stick with that convention
 */
class PlantSubmission extends Model
{
    use SoftDeletes;
    protected $table = 'PlantSubmission';
    protected $primaryKey ='plantSubmissionId';
}
