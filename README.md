# AOTP
Android Open Translation Platform

A open platform for translating Android Apps.

## Website
Official website with the latest stable version: [aotp.auerchri.at][website_stable]

## Branches
* [`master`][branch_master] branch contains the latest stable version
* [`develop`][branch_develop] branch contains the current develop (unstable) version

## Installation
Upload all files to your webserver, maybe you need to adjust some defines in `config/main.php`.
After that, you have two opportunities to install the platform:
* Open the website in your browser. A installer should appear
* Or install it manually:
  * Copy `config/templates/user.php` to `config/user.php`
  * Replace the placeholders in `config/user.php` with the real values
  * Execute the SQL-commands from `installation/database.sql` on your database to create the tables
  * Delete the `installation` folder


[//]: # (LINKS)
[website_stable]: http://aotp.auerchri.at
[branch_master]: https://github.com/auchri/AOTP/tree/master
[branch_develop]: https://github.com/auchri/AOTP/tree/develop
