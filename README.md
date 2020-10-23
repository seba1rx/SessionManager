# SessionManager
Simple PHP session manager implementing security against hijicking

Requires PHP 7

install with `composer require seba1rx/sessionadmin`

if you get a message saying `Could not find a version of package seba1rx/sessionadmin matching your minimum-stability (stable).`
then add `"minimum-stability": "dev"` to your composer.json file before installing

Usage:

On each PHP page, call `activateSession()` method as you would with `session_start()`

example:

```
use Rx\SessionAdmin;
$rxSessionAdmin = new SessionAdmin();
$rxSessionAdmin->activateSession();
```

there are 2 public methods:

`activateSession()` and `createUserSession()`

You will find a working demo in `/demo`
The demo shows a basic website implementing the class, you can just install this package and then go to `/vendor/seba1rx/sessionadmin/demo/index.php` in order to try it out

This class can be useful in websites that have public content available but also restricted content accessible only if you log in

Features:
- Creates a session for guest and users
- Named session
- 3% chances of regenerating session id on each request
- Prevents hijicking
- Define allowed URL array for guests, that can be expanded when user logs in according to system profile
- session destruction on obsolete request
