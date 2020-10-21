# SessionManager
Simple PHP session manager implementing security against hijicking

Requires PHP 7

Usage:

On each PHP page, call `activateSession()` method as you would with `session_start()`

example:

```
use rx\SessionAdmin;
$rxSessionAdmin = new SessionAdmin();
$rxSessionAdmin->activateSession();
```

there are 2 public methods:

`activateSession()` and `createUserSession()`

You will find a working demo in /demo

Features:
- Creates a session for guest and users
- Named session
- 3% chances of regenerating session id on each request
- Prevents hijicking
- Define allowed URL array for guests, that can be expanded when user logs in according to system profile
- session destruction on obsolete request
