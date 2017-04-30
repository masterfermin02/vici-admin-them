### vici-admin-them
This is a vicidial theme to apply new design to vicidial

### How to setup
cd to your vicidial root dir
```
	git clone git@github.com:masterfermin02/vici-admin-them.git
```
1. open admin.php
2. look for vicidial auth
```
	if ($user_auth > 0)
```
3.  add after the if $user_auth add
```
	require("vici-admin-them/template.php");
```
[![N|Solid](https://github.com/masterfermin02/vici-admin-them/blob/master/screen_shot/campaign.png)](https://github.com/masterfermin02/vici-admin-them/)
[![N|Solid](https://github.com/masterfermin02/vici-admin-them/blob/master/screen_shot/dashboard.png)](https://github.com/masterfermin02/vici-admin-them/)
[![N|Solid](http://viciexperts.com/img/portfolio/new-real-time-custom.png)](https://github.com/masterfermin02/vici-admin-them/)
it's done, have fun and enjoy.

### We still working in progress...
