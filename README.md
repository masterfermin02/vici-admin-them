### vici-admin-them
This is a vicidial theme to apply new design to vicidial

### How to setup
### Composer install
```
    composer require masterfermin02/vici-admin-them 
```
### Download with git
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
4. on each file you like the new design you need to add this line
For example: user_status.php, AST_agent_time_sheet.php, user_stats.php
```
	require("vici-admin-them/template.php");
```
[![N|Solid](https://github.com/masterfermin02/vici-admin-them/blob/master/screen_shot/campaign.png)](https://github.com/masterfermin02/vici-admin-them/)
[![N|Solid](https://github.com/masterfermin02/vici-admin-them/blob/master/screen_shot/dashboard.png)](https://github.com/masterfermin02/vici-admin-them/)
[![N|Solid](http://viciexperts.com/img/portfolio/new-real-time-custom.png)](https://github.com/masterfermin02/vici-admin-them/)

### Realtime theme
1. cp realtime_reportnew.php and AST_timeonVDADallnew.php to your vicidial root folder (vicidial/AST_timeonVDADallnew.php, vicidial/realtime_reportnew.php)
2. open your browser and go to http://youserveripordomian/vicidial/realtime_reportnew.php
3. If you want you can replace the realtime_report.php with realtime_reportnew.php to open it from you admin o crear new custom link.

## Feedback, Bugs, and Questions
For any questions, feedback, and bug reports, please use the [Github Issues](https://github.com/masterfermin02/vici-admin-them/issues).

## Credits
Created by [Fermin Perdomo](https://masterfermin02.github.io/)
Thanks to [Viciexperts](https://viciexperts.com/)

## Contributions
Contributions are welcome. Please make a pull request.
You can also contribut with money if you want.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="HAHNNB855GKCY">
<input type="image" src="https://www.paypalobjects.com/es_XC/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>


## License
This code is available under the [MIT license](http://opensource.org/licenses/MIT).


### it's done, have fun and enjoy.

### We still working in progress...
