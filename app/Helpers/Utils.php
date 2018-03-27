<?php

function ezReturnErrorMessage($msg)
{

    return array('isError' => true, 'msg' => $msg);

}

function ezReturnSuccessMessage($msg, $id = null)
{

    $success = array('success' => $msg);

    if($id)
        $success['id'] = $id;

    return $success;

}

// Format the date
function toMysqlDate($dateString)
{
	$date = DateTime::createFromFormat('d-m-Y', $dateString);
	return date_format($date,'Y-m-d');
}

// Format the date
function toDMYDate($dateString)
{
	$date = DateTime::createFromFormat('Y-m-d', $dateString);
	return date_format($date,'d-m-Y');
}

// Format the date
function toDMYTime($dateString)
{
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
	return date_format($date,'H:i:s d-m-Y');
}