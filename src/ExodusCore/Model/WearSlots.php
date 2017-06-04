<?php
namespace ExodusCore\Model;
use ActiveRecord\Model;
class WearSlots extends Model
{
    static $table_name = 'wear_slots';

    static $has_many = array(
        array('eq', 'class_name' => 'PlayerEQ')
    );
}