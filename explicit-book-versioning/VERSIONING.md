Index of pages:
---------------

# <a name="Summary"></a>Summary

Given a version number DISRUPTIVE.INCOMPATIBLE.COMPATIBLE.FIX, increment the:

1. DISRUPTIVE is incremented when changing the INDEX, changing the UX or ending support for previous versions,
1. INCOMPATIBLE is incremented when adding, changing or removing TOPICS while breaking compatibility with previous versions.
1. COMPATIBLE is incremented when adding, changing or removing SENTENCES or EXERCISES while remaining compatible with previous versions,
1. FIX is incremented when a TYPO is fixed.

Additional labels for pre-release or NameOfThelanguage edition are available as extensions (MODIFIER) to the DISRUPTIVE.INCOMPATIBLE.COMPATIBLE.FIX format.


# <a name="Introduction"></a>Introduction

In the world of educational books there exists a dread place called "dependency hell." The bigger your system grows and the more content you integrate into your book, the more likely you are to find yourself, one day, in this pit of despair.

In books with many resources, releasing new editions can quickly become a nightmare. If the dependency specifications are too tight, you are in danger of version lock (the inability to upgrade a package without having to release new versions of every dependent package). If dependencies are specified too loosely, you will inevitably be bitten by version promiscuity (assuming compatibility with more future versions than is reasonable).
Dependency hell is where you are when version lock and/or version promiscuity prevent you from easily and safely moving your project forward.


As a solution to this problem, I propose a simple set of rules and requirements that dictate how editions numbers are assigned and incremented in a base of 4 digit, in that way we split in a different digit each one of the situations.


I call this system ["Explicit Books Versioning"](/VERSIONING.md) Under this scheme, version numbers and the way they change convey meaning about the underlying content and what has been modified from one version to the next.


   <a href="https://twitter.com/share" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
   
   <script src="https://apis.google.com/js/platform.js" async defer></script>
   <g:plus action="share"></g:plus>
 
---



[Start page](./)
