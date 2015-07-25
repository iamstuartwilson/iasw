{{
title: graze.com
tagline: In-house Front End Development
backgroundColour: #00989E
tags: HTML5, CSS3, JavaScript, Node, Twig, PHP, E-commerce
}}

As an in house developer at graze.com, I work with many parts of the business to deliver great experiences for our users.  My day to day work involves building out new core features for the website using LESS, Twig templating language, PHP and JavaScript.

![graze wesbite](/public/img/screenshots/graze.jpg)

## Browserify
Within a few months of working at graze I got to work on modernising the JavaScript development ecosystem using Node build tools. Employing Gulp as a task runner along with Browserify for JavaScript compilation, I was able to rewrite core modules to be CommonJS compliant, giving us more modular code which plugged together using require calls.  This allowed us to write more scalable code which could freely use other packaged, whilst opening up unit testing during code releases to catch any naughty breaking changes.

## Pistachio
My colleague Lee Jordan did wonders in modernising the HTML and CSS with his grazestrap work.  When I joined we had a set of reusable components which were built around Bootstrap.  This was great, but meant we were tightly coupled to third party framework with loose semantics and and an increasingly bloated CSS file.  Pistachio is our grazestrap (or bootsnack) 2.0.  Written using BEM syntax and only using the Bootstrap grid (which we modified to give us a third small mobile grid) the new CSS framework gives us a better arsenal of reusable components which are less opinionated and can work across different brand assets. At 10% the size of grazestrap, it’s fair to say it’s a little more performant too.

![pistachio styleguide](/public/img/screenshots/pistachio.jpg)

[Visit Website](https://graze.com)
