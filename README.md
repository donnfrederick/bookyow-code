# Bookyow

## Local Machine Setup

### Step 1: Checkout Bookyow repository
Open your Git Bash or CMD, and go to your desired project location.
<br>
eg. `C:/Users/USER/Desktop/`
<br><br>
Write the following command in your terminal
<br>
```
git clone -b master https://github.com/donnfrederick/bookyow.git
```
You might need to enter your GitHub account (password keys you enter won't show in your terminal)<br>
<sub>You also might need to download GitHub Desktop from https://desktop.github.com/</sub>

### Step 2: Hosts setup
It's necessary to use PHP7. If you are using PHP8, you might encounter a problem
<br>
Check your php version using terminal
<br>
`php -v`
<br><br>
Open your Notepad as Administrator
<br>
Press `Ctrl + O` to open a file
<br><br>
Go to `C:\Windows\System32\drivers\etc` and open `hosts`
<br><br>
**Can't find what you looking for?**
<br><br>
It's because Notepad will find text `.txt` files by default.
<br>
Try to click the drop down that contains `Text Document (*.txt)` and select `All Files`
<br><br>
**Yup, wow magic**
<br><br>
Create another line at the bottom
<br>
and write `127.0.0.1 bookyow`
<br><br>
<sub>Note:</sub>
<br>
`"bookyow"` will stand as your local domain name or your server name.
<br>
And you won't be able to save your changes if you didn't open your Notepad as Administrator
### Step 3: XAMPP Conf setup
Open `httpd-vhost.conf` in your xampp
<br>
<sub>You might need to use VS Code on this one</sub>
<br><br>
Once your VS Code is open, or any other IDE you might like, press `Ctrl + 0`
<br>
Go to `C:\xampp\apache\conf\extra` and open `httpd-vhost.conf`
<br><br>
<sub>Paste the following code</sub>
<br>
```
<VirtualHost *:80>
    DocumentRoot "C:/Users/USER/Desktop/bookyow"
    ServerName bookyow
    ErrorLog "logs/ec-error.log"
    CustomLog "logs/ec-error.log" combined

    <Directory "C:/Users/USER/Desktop/bookyow">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
    </Directory>
</VirtualHost>
```
`ServerName` will be `bookyow` (the domain name or server name you wrote in `C:\Windows\System32\drivers\etc\hosts`)
<br>
And the `DocumentRoot` will be your project's directory (`C:/Users/USER/Desktop/bookyow`)
<br><br>
<sub>You might need to restart your apache if you already did start it previously</sub>
<br><br>
Now you can see your project in this link http://bookyow/
<br><br><br><br><br>

## View your project from you phone

### Step 1: Setup new `VirtualHost` in your `httpd-vhost.conf` file

Open your VSCode
<br>

Press `Ctrl + O` to open files
<br>

Go to `C:\xampp\apache\conf\extra` and open `httpd-vhost.conf`
<br><br>
<sub>Paste the following code</sub>
```
<VirtualHost *:81>
    ServerAdmin bookyow
    DocumentRoot "C:/Users/USER/Desktop/iFiles/bookyow"
    ErrorLog "logs/ec-error.log"
    CustomLog "logs/ec-error.log" combined
    SSLEngine On
    SSLCertificateFile "C:/xampp/apache/conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl.key/server.key"

    <Directory "C:/Users/USER/Desktop/iFiles/bookyow">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
    </Directory>
</VirtualHost>
```

The difference between the first and the second VirtualHost is their ports. You see, your main VirtualHost's port is 80, because XAMPP is rendering port 80 by default. And you need a different port to render from your mobile device. The port used in this example is 81, but you can use any other unique ports as you like

### Step 2: Add new Listener

Open your Notepad, but it's not necessary to open it as Administrator this time
<br>

Press `Ctrl + O` to open files
<br>
Go to `C:\xampp\apache\conf` and open `httpd.conf`
<br>

**Can't see it again? Just do the magic once more**
<br>

Find `Listen 80` by pressing `Ctrl + F`
<br>
Once you saw the `Listen 80` (the default port listened by XAMPP), write `Listen 81` beneath that
<br><br>
It will be like this
<br>
```
Listen 80
Listen 81
```
<br>
The port 80 is for your laptop/desktop (pc), and port 81 is for your mobile

### Step 3: Get your PC's IP

Open your CMD, and type
<br>
`ipconfig`
<br>

Check your `IPv4 Address`, for example `192.168.1.60`

### Step 4: View it in your Mobile Browser

Open your Mobile Browser, and type your PC's `IPv4 Address`
<br>

But this time, you will put your port for mobile that you created along with your PC's IP Address
<br>

The port we've created is `81`
<br>

And in your Mobile Browser, it should be like this
<br>
`https://192.168.1.60:81`

<br><br><br><br>

### Good luck
