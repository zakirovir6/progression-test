<?php

define( 'ARG_DIGITS', 'digits' );
define( 'DELIMITER', ',' );

foreach( $argv as $index => $arg )
{
    if ( $index === 0 )
        continue;

    $pattern = '@^' . ARG_DIGITS . '=((?:\d+)(?:,\d+)*)$@';
    $matches = [];
    if ( preg_match( $pattern, $arg, $matches ) )
    {
        $sequence = array_map( 'intval', explode( DELIMITER, $matches[1] ) );

        if ( arithmeticCheck( $sequence ) )
        {
            echo $matches[1] . ' is an arithmetic progression';
            exit;
        }

        if ( geometricCheck( $sequence ) )
        {
            echo $matches[1] . ' is an geometric progression';
            exit;
        }

        echo $matches[1] . ' is not a progression';
        exit;
    }
}

echo 'There is no valid ' . ARG_DIGITS . ' argument';

function arithmeticCheck( $sequence )
{
    $a1 = array_shift( $sequence );
    if ( ! count( $sequence ) )
    {
        return true;
    }

    $d = $sequence[0] - $a1;

    foreach ( $sequence as $key => $member )
    {
        $n = $key + 2;
        $computedMember = $a1 + ( $n - 1 ) * $d;
        if ( $computedMember !== $member )
        {
            return false;
        }
    }

   return true;
}

function geometricCheck( $sequence )
{
    $b1 = array_shift( $sequence );

    if ( ! count( $sequence ) )
    {
        return true;
    }

    if ( $b1 === 0 )
    {
        return false;
    }

    $q = $sequence[0] / $b1;

    foreach ( $sequence as $key => $member )
    {
        $n = $key + 2;
        $computedMember = $b1 * pow( $q, $n - 1 );
        if ( $computedMember !== $member )
        {
            return false;
        }
    }

    return true;
}