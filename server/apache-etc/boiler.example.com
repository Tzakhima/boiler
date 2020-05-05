<VirtualHost <IP>:443>
	ServerAdmin me@example.com
	DocumentRoot /var/www/boiler.example.com
	ServerName boiler.example.com
	ServerAlias boiler.example.com
	ErrorLog /var/log/apache2/boiler.example.com/error.log
	# Possible values include: debug, info, notice, warn, error, crit,
	# alert, emerg.
	LogLevel info
	CustomLog ${APACHE_LOG_DIR}/boiler.example.com/access.log combined
	ServerSignature off
        SSLEngine on
        SSLProtocol all -SSLv3
        SSLCertificateFile /etc/letsencrypt/live/boiler.example.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/boiler.example.com/privkey.pem
        
        RewriteEngine on
        RewriteCond %{QUERY_STRING} session=<RANDOM STRING FOR ACCESS WITHOUT USER-PASS> [NC]
        RewriteRule ^/server.php - [E=no_auth_required:1] 

       <Directory /var/www/boiler.example.com>
	        AuthName BOILER
                AuthFormProvider file
                AuthType form
		AuthUserFile "/etc/apache2/passwords.conf"
                AuthFormLoginRequiredLocation "https://login.example.com"
                #AuthFormLoginSuccessLocation "https://boiler.example.com"
                Session On
                SessionCookieName session path=/;domain=example.com
                SessionCryptoPassphrase <Crypto PassPhrase>
                SessionMaxAge 3153600
		Require  valid-user
                Satisfy any
                Deny from all
                # If you have static IP at home - it will not require user or pass
                allow from <IP Address>
                allow from env=no_auth_required
                Options -Indexes -Includes
                AllowOverride None
                <LimitExcept GET POST HEAD>
                deny from all
                </LimitExcept>

        </Directory>
      
</VirtualHost>
