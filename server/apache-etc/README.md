<h3 align="center">Setting Apache Server Config</h3>


---

<p align="center"> Virtual Host Configuration
    <br> 
</p>  

## Prerequisites  
1. [Install Apache](https://httpd.apache.org/)  
2. [Get an TLS certificate](https://letsencrypt.org/getting-started/)  
3. Create Apache login password file - `sudo htpasswd -c /etc/apache2/passwords.conf <user>`
4. OPTIONAL - [Secure your Apache server](https://www.apachecon.eu/)  
  
## Variables to change
You should replace the following variables in the `login.conf` file:  
- Search for "example.com" and change it with your apex domain.  
- Search for "boiler.example.com" and change it with your domain.
- Search for "login.example.com" and change it with your domain.
- Search for "\<Crypto PassPhrase>" and change it. This will encrypt the session cookie content.  
- Search for "\<IP>" and change it to your server IP.



You should replace the following variables in the `boiler.example.com` file:  
- Search for "example.com" and change it with your apex domain.  
- Search for "boiler.example.com" and change it with your domain.
- Search for "login.example.com" and change it with your domain.
- Search for "\<Crypto PassPhrase>" and change it. This will encrypt the session cookie content.  
- Search for "\<IP>" and change it to your server IP.
- Search for "\<RANDOM STRING FOR ACCESS WITHOUT USER-PASS>" and enter any LONG random string. This is used to allow access without authentication. It was needed for the integration of Google Assistant and IFTT.  
The URL should look like `https://boiler.example.com/server.php?session=<RANDOM STRING FOR ACCESS WITHOUT USER-PASS>`
