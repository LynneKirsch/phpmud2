<?php
namespace ExodusCore\Utility;

class Config
{
    public static function getDSN()
    {
        return 'mysql:dbname='.self::getDBName().';host=45.40.164.80';
    }

    public static function getDBName()
    {
        return 'exodus';
    }

    public static function getDBUsername()
    {
        return 'exodus';
    }

    public static function getDBUserPW()
    {
        return 'polkij7890A#';
    }
}