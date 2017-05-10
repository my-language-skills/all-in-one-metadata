Index of pages:
---------------

* [Summary](/README.md#Summary)
* [Introduction](/README.md#Introduction)
* [Explicit Versioning](/VERSIONING.md)
* [Why Explicit Versioning](/WHY.md)
* [FAQ](/FAQ.md)
* [ABOUT](/ABOUT.md)
* [Who is using Explicit Versioning?](/USERS.md)

# <a name="Summary"></a>Summary

Given a version number DISRUPTIVE.INCOMPATIBLE.COMPATIBLE.FIX, increment the:

1. DISRUPTIVE is incremented when changing the INDEX, changing the UX or ending support for previous versions,
1. INCOMPATIBLE is incremented when adding, changing or removing TOPICS while breaking compatibility with previous versions.
1. COMPATIBLE is incremented when adding, changing or removing SECTIONS while remaining compatible with previous versions,
1. FIX is incremented when a TYPO is fixed.

Additional labels for pre-release, release candidate and build metadata are available as extensions (MODIFIER) to the DISRUPTIVE.INCOMPATIBLE.COMPATIBLE.FIX format.

**If you'd like to leave feedback, please [open an issue on GitHub](https://github.com/Software-Development-Guidelines/Explicit-Versioning/issues).**

# <a name="Introduction"></a>Introduction

In the world of software management there exists a dread place called "dependency hell." The bigger your system grows and the more packages you integrate into your software, the more likely you are to find yourself, one day, in this pit of despair.

In systems with many dependencies, releasing new package versions can quickly become a nightmare. If the dependency specifications are too tight, you are in danger of version lock (the inability to upgrade a package without having to release new versions of every dependent package). If dependencies are specified too loosely, you will inevitably be bitten by version promiscuity (assuming compatibility with more future versions than is reasonable).
Dependency hell is where you are when version lock and/or version promiscuity prevent you from easily and safely moving your project forward.

**In CMS (WordPress, Joomla, Drupal) also exist the problem of the complements (Modules, Aplications, Plugins, Components, add-ons ...) where we need to take care of the code once we integrate our development in the CMS.** Also Wordpress offer a last digit where nothing change but a security or bug fix. Such situation give us the security nothing wrong could happen after the update.

Many problems which Semver tries to solve do not exist outside of the area of dependency management. Is too API focus. 

As a solution to this problem, I propose a simple set of rules and requirements that dictate how version numbers are assigned and incremented in a base of 4 digit instead of the 3 digits of [Semantic Versioning](http://semver.org/), in that way we split in a different digit each one of the situations.

These rules are based on but not necessarily limited to pre-existing widespread common practices in use in both closed and open-source software.

For this system to work, you first need to declare a public API. This may consist of documentation or be enforced by the code itself. Regardless, it is important that this API be clear and precise. Once you identify your public API, you communicate changes to it with specific increments to your version number. Consider a version format of W.X.Y.Z (DISRUPTIVE.INCOMPATIBLE.COMPATIBLE.FIX). Bug fixes not affecting the API increment the FIX version, backwards compatible additions/changes increment the COMPATIBLE version, backwards incompatible changes increment the INCOMPATIBLE version and backwards incompatible API changes increment the DISRUPTIVE version.

I call this system ["Explicit Versioning"](/VERSIONING.md) Under this scheme, version numbers and the way they change convey meaning about the underlying code and what has been modified from one version to the next.


   <a href="https://twitter.com/share" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
   
   <script src="https://apis.google.com/js/platform.js" async defer></script>
   <g:plus action="share"></g:plus>
 
---



[Start page](./)
