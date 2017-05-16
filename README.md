# Bootmodal

Bootmodal makes it easier for Laravel (currently only for Laravel 4.2) back-end and front-end developers to use Bootstrap modals. 
In administration interfaces modal dialogs are widely used but implementing them is always 
time consuming and involves lots of repetition especially if the requests are made through AJAX.   
Bootmodal Laravel package provides back-end and front-end classes and plug-ins to accelerate this process.

## Installation

### Composer
```sh
"require": {
    "torgheh/bootmodal": "1.0.0"
}
```
Then run the `composer update`.
### Laravel configuration

Add the Bootmodal service provider to the `providers` array in `app/cofig/app.php`:
```php
	'Torgheh\Bootmodal\BootmodalServiceProvider'
```

Next under the `aliases` array in  `app/cofig/app.php`, you may add the Modal facade.
```php
	'Modal'  => 'Torgheh\Bootmodal\Facades\Modal',

```
Finally to move the package Javascript asset to the public folder run the follwoing command.

```sh
php artisan asset:publish torgheh/bootmodal
```
The Javascript plugin must be added to the front-end layout.1
```html
<script src="{{asset('torgheh/bootmodal/bootmodal.min.js')" ></scrpit>
```
## Backend
### Modal
In your controller the same way you make views in Laravel you can make modal views and return an Ajax response. 
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

In some cases you might want to go from an Ajax response to a normal redirect, for instance after a successful sign in. 
```php
return \Modal::redirect($url);
```
You can also add the Laravel session data to the redirect response the same way Laravel works.
```php
retun \Modal::redirect($url)->withError($validator)->with('message', 'error');
```

### Options
Some of the Bootstrap modal options are adjustable through the Modal class:
- size of the dialog (normal, large and small)
- title
- close button
- animation

```php
return \Modal::make('dialogs.login')->with('data', $data)->setOption('size', 'small')->setOption('title', 'Login');
```

### View

The view extends on the `Bootmodal::layout`. There are two sections in a Bootstrap modal that can be extended:
modal-body and modal-footer.

## Frontend

```html
<script src="{{asset('torgheh/bootmodal/bootmodal.min.js')}}" ></script>
```

### Data attributes

You can bind two types of events to your HTML elements that will trigger the Bootmodal, click and submit.

#### Click:
```html
<a href="#" data-action="{{url('login')}}" data-toggle="bootmodal">Login</a>
```
This will create and show a modal dialog directed through `data-action` attributes.

#### Sumbit:

```html
<form action="{{url('login')}} method="post" data-toggle="bootmodal-form">
```
This will send an Ajax post request to the `action` attribute.

Two data attributes are necessary, `data-toggle="bootmodal"` and `data-action` for buttons.

### JavaScript

You can also enable bootmodal through Javascript for forms and buttons.
```js
$('#login-button').bootmodal();
$('#login-form').bootmodal();
```

### Options

There are only two options available, the modal container which is the HTML `body` and Ajax cache option which is `false`, both by default.

```js
$('#edit-button').bootmodal({ container: $('#modal-container') });
$('#tos-button').bootmodal({ cache: true });
```

## Example

### View
views/dialogs/login.blade.php
```php
@extends('Bootmodal::layout')
@section('modal-content')
	<form id="login-form" action="{{url('login')}}" method="post" data-toggle="bootmodal-form">

		<ul id="errors">
			@foreach($errors->all() as $error )
				<li>{{$error}}</li>
			@endforeach
		</ul>

		<label>
		Email: <input type="text" name="email" value="{{\Input::old('email')}}">
		</label>

		<label>
		Password: <input type="password" name="password">
		</label>

		<input type="submit" value="login">

	</form>
@stop
```

### Controller
controllers/AuthController.php
```php
<?php
class AuthController extends BaseController
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
			return \Modal::redirect('home')->with('message', 'Successful login');
		}
		return \Modal::make('dialogs.login')->withErrors($validator)->withInput();
	}
	...
}
```		
### Routes
```php
Route::get('login', array( 'uses'=>'AuthController@showLoginDialoge') );
Route::post('login', array( 'uses'=>'AuthController@postLogin') );
```

### frontend

```html
<a href="#" data-action="{{url('login')}}" data-toggle="bootmodal">Login</a>
```


