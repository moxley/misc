README

This is a self-contained demo of Mustache.js. It uses the Rhino JavaScript
engine as the language runtime for Mustache.

Requirements

 * Java
 * Either a Unix-like shell, or PHP

Instructions

 * With a Unix-like shell, issue this command: ./run
 * With PHP, issue this command: php run.php
 * With PHP, alt.: Put everything in a PHP-enabled web directory, and visit
 * run.php from a web browser.

Performance

Latency is quite high (about 0.4 seconds) because of the Java startup overhead.
A quick test with Google's V8 engine showed even worse results (0.8 seconds),
but that could be a result of debug flags left on in my version of V8.

The PHP engine adds about 0.1 second startup overhead. If the various overheads
are not enough of a concern, this is a neat way to sneak server-side JavaScript
into the enterprise. If you use a Java web app server instead of PHP, then the
startup overhead obviously goes away.

