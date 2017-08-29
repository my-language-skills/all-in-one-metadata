Index of pages:
---------------

* [Summary](/VERSIONING.md#Summary)
* [Introduction](/VERSIONING.md#Introduction)
* [Explicit Versioning](/VERSIONING-EXTENDED.md)
* [Why Explicit Versioning](/WHY.md)
* [FAQ](/FAQ.md)
* [ABOUT](/ABOUT.md)



# Why Use Explicit Versioning?

#not finish !!!!!

This is not a new or revolutionary idea. In fact, you probably do something close to this already. The problem is that "close" isn't good enough. Without compliance to some sort of formal specification, version numbers are essentially useless for dependency management. By giving a name and clear definition to the above ideas, it becomes easy to communicate your intentions to the users of your software. Once these intentions are clear, flexible (but not too flexible) dependency specifications can finally be made.

//

What many people are omitting is that people already use 4 digits with SimVer, anyway. Be it a 1.2.3.4RC5 or 1.2.3.4-5, they do have that fourth digit usage, but it's usage is NOT explicit.

Rules will always be broken sooner or later, but we're not talking about removing something that's impossible to remove, we're just trying to minimalize the cyclometric complexity in order to reduce the lack of clarity which make people who DO respect the rules uncounsciously break them, thus making the intended standard not be the same standard for everyone.

In other words, we're only setting some guidlines (which can and WILL be broken, at times) and we're trying to make things not be as vague as they are (because that makes the standard differ from people to people and from project to project).

While that might be the case, there is also the need for the software that deals the auto-updates to make backups before updating (configurable) and store them (by default) for a month (configurable). Because that's not only a matter of whether the files update well, but also a question of the integrity of the server and other possible security gaps.

SimVer works so well because it was one of the best guidlines at the moment of it's conception, but that does not mean that it's still one of the best options out there, but only that it's one of the most used ones.

//7

A simple example will demonstrate how Semantic Versioning can make dependency hell a thing of the past. Consider a library called "Firetruck." It requires a Semantically Versioned package named "Ladder." At the time that Firetruck is created, Ladder is at version 3.1.0. Since Firetruck uses some functionality that was first introduced in 3.1.0, you can safely specify the Ladder dependency as greater than or equal to 3.1.0 but less than 4.0.0. Now, when Ladder version 3.1.1 and 3.2.0 become available, you can release them to your package management system and know that they will be compatible with existing dependent software.

As a responsible developer you will, of course, want to verify that any package upgrades function as advertised. The real world is a messy place; there's nothing we can do about that but be vigilant. What you can do is let Semantic Versioning provide you with a sane way to release and upgrade packages without having to roll new versions of dependent packages, saving you time and hassle.

If all of this sounds desirable, all you need to do to start using Semantic Versioning is to declare that you are doing so and then follow the rules. Link to this website from your README so others know the rules and can benefit from them.


---




[Start page](./)
