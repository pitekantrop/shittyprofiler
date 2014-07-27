# Laravel Shitty Profiler

A shitty profiler for Laravel. It only shows some quick and dirty stats, but it's unobtrusive and easy to configure.

## Installation

Add the following to your `composer.json` file:
```json
"pitekantrop/shittyprofiler":"*"
```
Then, run `composer update` or `composer install` if you haven't already installed any packages.

While you're waiting, add the following line to the `providers` array in `app/config/app.php`:

```php
'Pitekantrop\ShittyProfiler\ProfilerServiceProvider',
```
And the profiler is installed.

## Usage

While your app is in debug mode simply add the `?profile` query string to the URL of the request that you wish to inspect, and the usual output will be replaced with the profiler view.

![](http://i.imgur.com/NOfkXeT.png)

## Custom Markers

To measure time from the application start up to a certain point add the following marker in your code:
```php
Profiler::mark('CustomMarker');
```
It is also possible to measure time between two markers:
```php
Profiler::mark('AnotherCustomMarker');
// Some code
Profiler::mark('AnotherCustomMarkerEnd');
```
