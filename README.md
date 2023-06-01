# hn

[hn](https://hn.cleberg.net) is a simple front-end alternative for Hacker 
News, focusing on privacy and simplicity.

## TODO

A scratch pad of ideas that may be useful to implement:

- [ ] Add functionality to view item-specific page with comments.
- [ ] Add functionality to view a user's profile.
- [ ] Add functionality to load more items or paginate?
- [ ] Add minimal CSS.

## Development

This just uses plain PHP and HTML, no special package managers or development 
tools needed. Just start editing the files with your favorite editor and use a 
server with PHP if you want to view the results or deploy your own version.

## Deployment

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
