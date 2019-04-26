# Debugging

## PHP

This guide assumes that you are using Laravel Homestead, as documented in the [installation guide](docs/INSTALL.md), with Visual Studio Code.

You will also need an XDebug browser extension for your chosen browser:  
[Firefox](https://addons.mozilla.org/en-GB/firefox/addon/xdebug-ext-quantum/?src=search)  
[Chrome](https://chrome.google.com/webstore/detail/xdebug/nhodjblplijafdpjjfhhanfmchplpfgl)

SSH Into your Homestead machine  
`vagrant ssh`

Enable Xdebug  
`sudo phpenmod xdebug`

Restart PHP  
`sudo systemctl restart php7.3-fpm`

Please note that Xdebug does affect performance, you can disable it again with:  
`sudo phpdismod xdebug`  
Followed by restarting PHP again

Enable Autostart (Recommended):  
`sudo nano /etc/php/7.3/conf.d/20-debug.ini`  
and add the line:  
`xdebug.remote_autostart = 1`

You should now be able to run the browser extension. You can then go into the debug tab in VS code and press 'Listen for Xdebug', once running, you will be able to add breakpoints.

## Javascript

All Vue JS debugging is done via the Vue browser extension:  
[Firefox](https://addons.mozilla.org/en-GB/firefox/addon/vue-js-devtools/?src=search)  
[Chrome](https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd)
