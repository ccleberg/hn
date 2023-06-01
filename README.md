# hn

[hn](https://hn.cleberg.net) is a simple front-end alternative for Hacker News. 
hn focuses on simplicity and privacy.

## Development

To deploy, ensure you have a publicly-available web server and configure it to 
fallback with all errors to the `index.php` file rather than returning a `404` 
error.

For nginx, include the following snippet in your website's conf file:

```conf
location / {
        # First attempt to serve request as file, then
        # as directory then fall back to index.php
        try_files $uri $uri/ /index.php?$args;
}
```

For Apache, you can include the following snippet in a `.htaccess` file within 
the directory you're serving the PHP file from:

```conf
FallbackResource /index.php
```
