# OpenVPN-Log-Watcher  
  
###Installation
####Server
* Place both `index.php` and `parser.php` in a directory accessible trough an url  
* Make a symbolic link of `/etc/openvpn/openvpn-status.log` in the same directory as the file  
* Grants access to www-data (if using apache) to `openvpn-status.log` in the original folder  
  *I changed the file group to a custom group in which www-data has access*  

####Clients
* You first need to set some parameters
 * Open `extension/js/popup.js` and set the url at line 37
 * If you want to change the key, remember to change it as well in `index.php` at line 8
* Go to `chrome://extensions/`
* Tick `Developper mode` if not already
* `Load unpacked extension` and then select the `extension/` folder
* You're done
