Index of pages:
---------------

* [Summary](/VERSIONING.md#Summary)
* [Introduction](/VERSIONING.md#Introduction)
* [Explicit Versioning](/VERSIONING-EXTENDED.md)
* [Why Explicit Versioning](/WHY.md)
* [FAQ](/FAQ.md)
* [ABOUT](/ABOUT.md)


# FAQ


## How should I deal with revisions in the 0.x.y.z initial development phase?

The simplest thing to do is start your initial development release at 0.1.0.0 = 0.1.0 and then increment the FEATURE version for each subsequent release.


## How do I know when to release 1.0.0.0?

If your software is being used in production, it should probably already be 1.0.0.0. If you have a stable API on which users have come to depend, you should be 1.0.0.0. If you're worrying a lot about backwards compatibility, you should probably already be 1.0.0.0.

## Doesn't this discourage rapid development and fast iteration?

ENHANCED version zero is all about rapid development. If you're changing the API every day you should either still be in version 0.x.y.z or on a separate development branch working on the next major version.

## -If even the tiniest backwards incompatible changes to the public API require a major version bump, won't I end up at version 42.0.0 very rapidly?

This is a question of responsible development and foresight. Incompatible changes should not be introduced lightly to software that has a lot of dependent code. The cost that must be incurred to upgrade can be significant.
Having to bump major versions to release incompatible changes means you'll think through the impact of your changes, and evaluate the cost/benefit ratio involved.

## Documenting the entire public API is too much work!

It is your responsibility as a professional developer to properly document software that is intended for use by others. Managing software complexity is a hugely important part of keeping a project efficient, and that's hard to do if nobody knows how to use your software, or what methods are safe to call. In the long run, CMS Versioning (CMSver), and the insistence on a well defined public API can keep everyone and everything running smoothly.

## What do I do if I accidentally release a backwards incompatible change as a FEATURE version?

As soon as you realize that you've broken the CMS Versioning (CMSver) spec, fix the problem and release a new minor version that corrects the problem and restores backwards compatibility. Even under this circumstance, it is unacceptable to modify versioned releases. If it's appropriate, document the offending version and inform your users of the problem so that they are aware of the offending version.

## What should I do if I update my own dependencies without changing the public API?

That would be considered compatible since it does not affect the public API.
Software that explicitly depends on the same dependencies as your package should have their own dependency specifications and the author will notice any conflicts. Determining whether the change is a PATCH version level or FEATURE version level modification depends on whether you updated your dependencies in order to fix a bug or introduce new functionality. I would usually expect additional code for the latter instance, in which case it's obviously a minor level increment.

## What if I inadvertently alter the public API in a way that is not compliant with the version number change (i.e. the code incorrectly introduces a major breaking change in a patch release)

Use your best judgment. If you have a huge audience that will be drastically impacted by changing the behavior back to what the public API intended, then it may be best to perform a ENHANCED version release, even though the fix could strictly be considered a patch release. Remember, CMS Versioning (CMSver) is all about conveying meaning by how the version number changes. If these changes are important to your users, use the version number to inform them.

## How should I handle deprecating functionality?

Deprecating existing functionality is a normal part of software development and is often required to make forward progress. When you deprecate part of your public API, you should do two things: (1) update your documentation to let users know about the change, (2) issue a new minor release with the deprecation in place. Before you completely remove the functionality in a new ENHANCED version release there should be at least one FEATURE version release that contains the deprecation so that users can smoothly transition to the new API.

## Does CMS Versioning (CMSver) have a size limit on the version string?

No, but use good judgment. A 255 character version string is probably overkill, for example. Also, specific systems may impose their own limits on the size of the string.

## Alternaive options
In consumer applications, the version is not only a version, but also a marketing asset.

* Firefox and Chrome and increment their major version number at each release. This results in ridiculously high version numbers. A browser with a higher version number must simply be better than a browser with a lower version number, right?
* The major version number of Apple's operating system OS X has become part of the name (X is 10 in Roman numerals), making the minor version number the effective major version number.
* The Ubuntu operating system uses a year.month.patchlevel versioning scheme.
* The Linux kernel bumped the version number from 2.6.39 to 3.0.0 to commemorate Linux' 20th anniversary.

So, many applications are not well served by Semver. Pick a versioning scheme that's good for your users (regardless of whether these users are fellow programmers or consumers), and keep it consistent.

* http://semver.org/
* http://blog.legacyteam.info/2015/12/romver-romantic-versioning/
* http://sentimentalversioning.org/
* http://calver.org/
* https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/



---



[Start page](./)

