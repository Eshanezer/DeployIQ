<?php

use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Session;

function required_mark()
{
    return '<span class="text-danger"> *</span>';
}

function doPermitted($checkarray)
{
    if (Session::has('routes')) {
        return in_array($checkarray, Session::get('routes'));
    }
    return false;
}

function showBoolean($value)
{
    return '<span class="badge badge-sm bg-gradient-' . (($value == 1) ? 'success' : 'danger') . '">' . (($value == 1) ? 'TRUE' : 'FALSE') . '</span>';
}

function getFactorPrefix($factor, $value)
{
    $prefix = '';

    if ($factor == 'temperature') {
        $prefix = $value . '°C';
    } else if ($factor == 'humidity' || $factor == 'soil') {
        $prefix = $value . '%';
    } else {
        $prefix = showBoolean($value);
    }

    return $prefix;
}

function isDateTime($dateString)
{
    if (strtotime($dateString)) {
        return true;
    }
    return false;
}

function doTrim($data)
{
    return trim($data, " \n\r\t\v\x00");
}

function days_between($end, $start)
{
    return (strtotime($end) - strtotime($start)) / (60 * 60 * 24);
}

function leftSpace($value)
{
    return ($value) ? ' ' . $value : '';
}

function rightSpace($value)
{
    return ($value) ? $value . ' ' : '';
}

function leftrightSpace($value)
{
    return ($value) ? ' ' . $value . ' ' : '';
}

function leftRightBrakets($value)
{
    return ($value) ? '( ' . $value . ' )' : '';
}

function resizeUploadImage($imageFile, $path, $name, $height, $width)
{
    $name = $name . '.' . strtolower($imageFile->getClientOriginalExtension());
    Image::make($imageFile->path())->resize($height, $width, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path($path) . '/' . $name);
    return $name;
}

function format_currency($value, $currency = 2)
{
    return (($currency == 2) ? env('CURRENCY') : env('CURRENCYUSD')) . ' ' . number_format($value, 2);
}

function getUploadsPath($name)
{
    $name = 'uploads/' . $name;
    return asset($name);
}

function getDownloadFileName($prefix = null)
{
    return (($prefix) ? $prefix : '') . Carbon::now()->format('YmdHs');
}

function isntEmpty($val)
{
    return ($val && $val != '') ? true : false;
}

function getCarbonDate($text = null)
{
    return ($text == null) ? Carbon::now()->timezone('Asia/Colombo') : Carbon::parse($text)->timezone('Asia/Colombo');
}

function uploadImage($driver, $image)
{
    return $image->store($driver, 'public');
}
