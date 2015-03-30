Expired
======================
~Current Version:1.1~

This was heavily based on Pippin's Simple Post Expiration. This is where I customize it even further and take over development.

A simple plugin that allows you to set an expiration date on posts. 

The Expired post will then be assigned a category of "Expired" and changed to the "Draft" post status.

You can show the expiration status of a post using the [expires] short code.

The [expires] short code accepts 5 optional parameters:
- expires_on - The text to be shown when a post has not yet expired. Default: `This item expires on: %s`
- expired - The text to be shown when a post is expired. Default: `This item expired on: %s`
- date_format - The format the expiration date should be displayed in
- class - The class or classes given to the DIV element
- id - The ID given to the DIV element

The `%s` will be replaced with the expiration date.
