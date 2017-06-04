<?php
namespace ExodusCore\Model;
use ActiveRecord\Model;
class Player extends Model
{
    static $has_many = array(
        array('eq', 'class_name' => 'PlayerEQ')
    );
}