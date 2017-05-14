# Bootmodal

Bootmodal makes it easier for Laravel back-end and front-end develepers to use Bootstrap modals. 
In administration interfaces modal dialogs are widly used but implementing them is always 
time consuming and involes lots of repeatation especially if the requets are made through AJAX.   
Bootmodal Laravel package, provides back-end and front-end packages to accelerate this proccess.

## Installation

### Composer
```sh
"require": {
    "torgheh/bootmodal": "1.0.0"
}
```
Then run the `composer update`.
### Laravel config app.php

Add the bootmodal service provider to the `prviders` array:
```php
	'Torgheh\Bootmodal\BootmodalServiceProvider'
```

Next under the `aliases` array, you may add the Modal facade.
```php
	'Modal'  => 'Torgheh\Bootmodal\Facades\Modal',

```
You also so have to add the Javascript plugin to the front-end layout.
```html
<script src="path/to/public/js/bootmodal.min.js" ></scrpit>
```
## Backend
### Modal
In your controller the same way you make views in Laravel you can make modal views and return a proper Ajax response. 
The view should extend the default `Bootmodal::layout`.

```php
return \Modal::make('dialogs.login')->with('data', $data);
```
You can also add validation errors and the old input data to the modal view. This is
useful when you have Ajax form validation inside your modal.

```php
return \Modal::make('dialogs.login')->withInput()->withErrors($validation);
```

### Redirect

Some cases you want to go from an Ajax response to a normal redirect, for example after a succesfull sign in. 
```php
return \Modal::redirect($url);
```
You can also add the Laravel session data to the redirect the same way Laravel works.
```php
retun \Modal::redirect($url)->withError($validator)->with('message', 'error');
```

### Options
Some of the bootstrap modal options are interchanglable through the Modal class:
- size of the dialoge(normal, large and small)
- title
- close button
- animation

```php
return \Modal::make('dialogs.login')->with('data', $data)->setOption('size', 'small')->setOption('title', 'Login');
```

### View

The view extends on the `Bootmodal::layout`. there are two section in a bootstrap modal that you can extend:
modal-body and modal-footer.

## Frontend

```html
<script src="{{asset('js/bootmodal.min.js')}}" ></script>
```

### Data attributes

You can bind two type of event to your Html elements that will trigger the bootmodal, click and submit.

```html
<a href="#" data-action="{{url('login')}}" data-toggle="bootmodal">Login</a>
```
This will create and then show a modal dialogue pointed through `data-action`.
or
```html
<form action="{{url('login')}} method="post" data-toggle="bootmodal-form">
```
This will send a Ajax post request to the controller action indicated by action attribute.

Two data attributes are neccessary, `data-toggle="bootmodal"` and `data-action` for buttons.

### JavaScript

You can also enable bootmodal thorugh javascript for forms and buttons.
```js
$('#login-button').bootmodal();
$('#login-form').bootmodal();
```

### Options

There are only two options available, the modal container which is the Html `body` by default and Ajax cache option which is `false`.

```js
$('#edit-button').bootmodal({ container: $('#modal-container') });
$('#tof-button').bootmodal({ cache: true });
```

## Example

### View
views/dialogs/login.blade.php
```php
@extends('Bootmodal::layout')
@section('modal-content')
	<form id="login-form" action="{{url('login')}}" method="post" data-toggle="bootmodal-form">

		<ul id="errros">
			@foreach($errors->all() as $error )
				<li>{{$error}}</li>
			@endforeach
		</ul>

		<label>
		Email: <input tupe="text" name="email" value="{{\Input::old('email')}}">
		</label>

		<label>
		Password: <input tupe="password" name="password">
		</label>

		<input type="submit" value="login">

	</form>
@stop
```

### Controller
controllers/AuthController.php
```php
<?php
class AuthController extends BaceController
{
	public function showLoginDialoge()
	{
		$foo = '';
		return \Modal::make('dialogs.login', compact('foo'))->setOption('title', 'Login form');
	}
	public function postLogin()
	{
		$rules = ['email'=>'required|email', 'password'=>'required' ];
		$validator = \Validator::make(\Input::all(), $rules);
		
		if($validator->passes()){
		
			///authentication process
			return \Modal::redirect('home')->with('message', 'Successfull login');
		}
		return \Modal::make('dialogs.login')->withErros($validator)->withInput();
	}
	...
}
```		

### frontend

```html
<a href="#" data-action="{{url('login')}}" data-toggle="bootmodal">Login</a>
```


