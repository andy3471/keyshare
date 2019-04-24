# Setting Up Dev Environment with Laravel Homestead

## Requirements

Windows:
[Composer](https://getcomposer.org/download/)  
[Vagrant](https://www.vagrantup.com/downloads.html)

A Virtual Machine Application is also required, tested on Hyper-V and Virtualbox. [Supported Applications](https://laravel.com/docs/5.8/homestead):
[Virtualbox](https://download.virtualbox.org/virtualbox/6.0.4)  
[Hyper-V](https://docs.microsoft.com/en-us/virtualization/hyper-v-on-windows/quick-start/enable-hyper-v)

Linux:
(Commands Required for install for Arch + Ubuntu)

## Recommended Software

Windows:
[GitBash](https://git-scm.com/downloads) (Recommended: setting the Use Git and optional Unix Tools from the command Promp).

[Visual Studio Code](https://code.visualstudio.com/)  
For VSCode, it is recommended that you set up to use GitBash

Go File -> Preferences -> Settings  
Search terminal.intergrated.windows.shell  
Put: C:\\Program Files\\Git\\bin\\bash.exe  
In “Terminal > Integrated > Shell: Windows”  
  
Linux:  
(Commands Required for install for Arch + Ubuntu)  

## Environment Install

Clone the git repository:  
`git clone github.com/andy3471/keyshare.git`  

Go Into Directory (Or open folder in VS Code, and use terminal -> new terminal):  
`cd keyshare`  

If required, switch to the correct branch:  
`git checkout BRANCHNAME`  

Install Composer Dependancies:  
`composer install`

Copy .env.example File:  
`cp .env.example .env`  

Make Homestead File:  
`./vendor/bin/homestead make`  

Edit the newly created Homestead file at Homestead.yaml, add the site map to keyshare.local (recommended name). Set the internal IP.  

Edit C:\Windows\System32\drivers\etc\hosts, add (IP is the one from homestead.yaml):  
`192.168.10.10 tnb.local`  
Please note, this does not currently work in Hyper-V, you will be given a unique IP at startup, so VB is recommended - [Visit the Homestead Documentation](https://laravel.com/docs/5.8/homestead) for more details.  

Make SSH Keys  
`ssh-keygen -t rsa -C "your@email.com"`  

Create Vagrant Box  
`vagrant up`  

SSH into vagrant box:  
`vagrant ssh`  

Go into code directory:  
`cd ./code`  

Install NPM Dependancies:  
`npm install`

Create Storage link:  
`php artisan storage:link`  

Build the database:  
`php artisan migrate` 

Generate Key:  
`php artisan key:generate`  

Clear Cache:  
`php artisan config:cache`  

The site should now be available at keyshare.local in your browser.  

To Do:  
Add guidance on SMTP  
Add Guidance on Steam Auth Key  
