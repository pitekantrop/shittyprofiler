A shitty profiler for Laravel. It only shows some quick and dirty stats, but it's unobtrusive and easy to setup.

## Installation

Add the following to your `composer.json` file:

```json
"pitekantrop/shittyprofiler" : "*"
```

Then, run `composer update` or `composer install` if you have not already installed packages.

Add the following line to the `providers` array in `app/config/app.php`:

```php
'Pitekantrop\ShittyProfiler\ProfilerServiceProvider',
```

And the profiler is installed.

## Usage

Add the `?profile` query string to the end of request that you wish to inspect, and the usual output with be replaced with the profiler.

![](http://i.imgur.com/NOfkXeT.png)

## Custom Markers

To measure time from the application start up to a certain point add the following marker in your code.

```php
Profiler::mark('CustomMarker');
```

To measure time between two markers you can set them like so:
```php
Profiler::mark('AnotherCustomMarker');
// Some code
Profiler::mark('AnotherCustomMarkerEnd');
```
