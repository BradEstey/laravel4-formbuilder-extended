# Laravel 4 FormBuilder Extended

This class extends Laravel 4's FormBuilder class adding a `selectWeekday` method, translations to `selectWeekday` and `selectMonth`, and adds the ability to prepend an array of options to select fields.

## Installation

Install this package through Composer by editing your project's `composer.json` file to require `estey/formbuilder`.

	"require": {
		"estey/formbuilder": "4.0.*"
	}

Then, update Composer:

    composer update

Open `app/config/app.php`, and replace `'Illuminate\Html\HtmlServiceProvider'` with:

    'Estey\FormBuilder\HtmlServiceProvider'

## Usage

- [selectWeekday](#selectweekday)
- [Translations](#translations)
- [Prepend Options](#prepend-options)

### selectWeekday

The `selectWeekday` method allows you to quickly generate a select field with a list of weekdays.

``` php
     selectWeekday('weekday');
```

Will return:

``` html
     <select name="weekday">
      	<option value="1">Sunday</option>
      	<option value="2">Monday</option>
      	<option value="3">Tuesday</option>
      	<option value="4">Wednesday</option>
      	<option value="5">Thursday</option>
      	<option value="6">Friday</option>
      	<option value="7">Saturday</option>
     </select>
```

### Translations

The `selectWeekday` and `selectMonth` methods will respect the locale settings. For example, to use Spanish, create a `app/lang/es` directory and create a file named `datetime.php`. The `app/lang/es/datetime.php` file should be formatted as follows:

``` php
	<?php // app/lang/es/datetime.php

	return array(

		'january' => 'enero',
		'february' => 'febrero',
		'march' => 'marzo',
		'april' => 'abril',
		'may' => 'mayo',
		'june' => 'junio',
		'july' => 'julio',
		'august' => 'agosto',
		'september' => 'septiembre',
		'october' => 'octubre',
		'november' => 'noviembre',
		'december' => 'diciembre',

		'sunday' => 'domingo',
		'monday' => 'lunes',
		'tuesday' => 'martes',
		'wednesday' => 'miércoles',
		'thursday' => 'jueves',
		'friday' => 'viernes',
		'saturday' => 'sábado',

	);
```

After setting the locale to 'es' and creating the `app/lang/es/datetime.php` file, `selectWeekday()` should return:

``` html
     <select>
      	<option value="1">domingo</option>
      	<option value="2">lunes</option>
      	<option value="3">martes</option>
      	<option value="4">miércoles</option>
      	<option value="5">jueves</option>
      	<option value="6">viernes</option>
      	<option value="7">sábado</option>
     </select>     
```

### Prepend Options

To prepend options to a `selectWeekday` and `selectMonth` method, add a `_prepend` array to the options array.

``` php
     selectMonth('month', '', array(
     	'id' => 'foo', 
     	'_prepend' => array('' => '-- Choose a Month --')
     ));
```

Will return:

``` html
     <select name="month" id="foo">
      	<option value="" selected="selected">-- Choose a Month --</option>
      	<option value="1">January</option>
      	<option value="2">February</option>
      	<option value="3">March</option>
      	<option value="4">April</option>
      	<option value="5">May</option>
      	<option value="6">June</option>
      	<option value="7">July</option>
      	<option value="8">August</option>
      	<option value="9">September</option>
      	<option value="10">October</option>
      	<option value="11">November</option>
      	<option value="12">December</option>
     </select>   
```  