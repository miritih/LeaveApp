<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 1/16/16
 * Time: 9:12 AM
 */
class Project extends Eloquent {
    protected $guarded = array('project_ID');
    protected $table = 'Projects';
}