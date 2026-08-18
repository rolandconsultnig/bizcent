# Deploy RolandERP on XAMPP, WAMP, or any Apache PHP host

RolandERP is a standard PHP (CodeIgniter 3) app. Copy the project folder onto the web server, create a MySQL database, and either run the installer or point `application/config/database.php` at an existing database.

## Requirements

- PHP **7.4+** (8.1–8.3 recommended; XAMPP/WAMP PHP 8.x is fine)
- Apache with **mod_rewrite** enabled
- MySQL or MariaDB
- Extensions: `mysqli`, `mbstring`, `curl`, `openssl`, `zip`, `pdo`, `pdo_mysql`
- Recommended: `gd`, `fileinfo`, `imap` (mailbox only)

## A. XAMPP (Windows)

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this project into `C:\xampp\htdocs\rolanderp` (any folder name is fine).
3. In phpMyAdmin (`http://localhost/phpmyadmin`):
   - Create an empty database named `rolanderp` (utf8mb4).
   - Default user is `root` with an **empty** password.
4. Enable rewrite if needed: Apache is already set to `AllowOverride All` for `htdocs` on stock XAMPP.
5. Open **`http://localhost/rolanderp/install/`** and complete the three installer steps.
   - Host: `localhost`
   - Database: `rolanderp`
   - Username: `root`
   - Password: leave blank
6. Log in at **`http://localhost/rolanderp/login`**.
7. After a successful install, delete the `install` folder.

### PHP extensions on XAMPP

Edit `C:\xampp\php\php.ini`, remove the leading `;` on these lines, then restart Apache:

```
extension=mysqli
extension=mbstring
extension=curl
extension=openssl
extension=zip
extension=gd
extension=fileinfo
extension=pdo_mysql
; optional for mailbox:
extension=imap
```

If pretty URLs 404, open `C:\xampp\apache\conf\httpd.conf` and confirm:

```
LoadModule rewrite_module modules/mod_rewrite.so
```

and that the htdocs `<Directory>` block has `AllowOverride All`.

If the app lives in a subfolder and routes still 404, edit the root `.htaccess` and set:

```
RewriteBase /rolanderp/
```

## B. WAMP

Same as XAMPP, but the folder is `C:\wamp64\www\rolanderp`.

- Left-click the WAMP icon → **Apache** → **Apache modules** → enable **rewrite_module**.
- phpMyAdmin: `http://localhost/phpmyadmin`
- App URL: `http://localhost/rolanderp/`

WAMP also uses `root` / empty password unless you changed it.

## C. Copy this already-installed project (no installer)

Use this when you already have a working database (for example the one on this machine).

1. Copy the project folder to `htdocs` or `www`.
2. Create the MySQL database on the new server.
3. Import a dump of `db_saas_module` (phpMyAdmin → Import, or `mysqldump`).
4. Edit `application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',          // XAMPP/WAMP default
'database' => 'rolanderp',   // the database you created
```

5. Visit `http://localhost/rolanderp/login`.

A ready-made XAMPP template is in `application/config/database.php.sample`.

## D. Shared / live Apache hosting

1. Upload the project to `public_html` (or a subdomain document root).
2. Create a MySQL database and user in cPanel (or equivalent).
3. Either run `/install/` or import a dump and edit `database.php`.
4. Ensure `mod_rewrite` is on. Most hosts already allow `.htaccess`.
5. Make these folders writable (`755` or `775`):

   - `application/cache`
   - `application/logs`
   - `uploads`
   - `filemanager`
   - `application/config` (only during install, so `database.php` can be written)

6. Delete `install/` after setup.
7. The app uses **production** mode automatically when it is not accessed from `127.0.0.1`. To force it, set an Apache environment variable: `SetEnv CI_ENV production`.

## Fresh installer on a copy that is already set up

Create this empty marker file:

`application/config/install.php`

(You can copy `application/config/install.php.sample`.) Then open `/install/` in the browser.

## Login

Administrators sign in at `/login` (not `/admin` until after login).

## Common problems

| Symptom | Fix |
|---|---|
| Every URL is 404 except the homepage | Enable `mod_rewrite`, `AllowOverride All`, or set `RewriteBase` in `.htaccess` |
| Database connection failed | XAMPP/WAMP password is usually empty, not `root` |
| Blank page | Enable `display_errors` in php.ini, or check `application/logs/` |
| CSS/JS missing | Confirm you opened the folder URL (`/rolanderp/`) not a parent listing |
| File manager / uploads fail | Enable `fileinfo` and `gd`; make `uploads` and `filemanager` writable |
| Mailbox errors | Enable the `imap` extension (optional) |
