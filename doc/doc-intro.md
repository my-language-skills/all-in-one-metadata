# All in one metadata

We're convinced that [structured data](https://developers.google.com/search/docs/guides/intro-structured-data) makes the web better, and we've worked hard to expand [Rich Snippets](https://webmasters.googleblog.com/2009/05/introducing-rich-snippets.html) and [Rich Cards](https://webmasters.googleblog.com/2016/05/introducing-rich-cards.html) for better search results. Thanks to the [metadata](https://www.youtube.com/watch?v=L9BqE01SLeE), the search engines can understand the relevance of that content in context. All in one metadata is a complete solution for adding metadata to a Wordpress site.

* [Webmasters Rich Snippets FAQ](/doc/doc-faq.md)
* [What a SEO plugin does](/doc/doc-seo.md)


## About All in one metadata plugin

This is a plugin for the Wordpress CMS that can be used to add metadata on a website. The plugin supports integration with the Pressbooks plugin that enables the user to add Books on a website. This plugin works on both multisite installation and singe site installation of Wordpress. When the plugin is operating on multisite it has extra functionality which is described later in this documentation.

The aim of All in one metadata is to accomplish a detailed description of the schema metadata.

This plugin is unbranded! This means that we don’t even put the name “All in one metadata” anywhere within the WordPress interface, aside from the plugin activation page.
This plugin makes great use of the default WordPress interface elements, like as if this plugin is part of WordPress. No ads, no nags.

Nobody has to know about the tools you’ve used to create your or someone else’s website. A clean interface, for everyone.

## What is not All in one metadata

Is not a SEO solution. Schemas don’t actually boost the organic search rankings. With Schemas review ratings, recipes or events in Google’s [SERPs](https://moz.com/learn/seo/serp-features) (search engine results pages) are not just normal search listings but also contain additional information that makes the crawling easier. Those are known as rich snippets and they are thanks to schema markup. Rich snippets actually increase clickthrough rates. Schema may not directly improve your search rankings, but it can still be beneficial for your SEO.

## About All in one metadata for Google
[Google Search](https://moz.com/blog/google-glossary) works hard to understand the content of a page. However, you can provide explicit clues about the meaning of a page to Google by including structured data on the page. [Structured Data](https://developers.google.com/search/docs/guides/intro-structured-data) is a standardized format for providing information about a page and classifying the page content; for example, if is it a recipe page, what are the ingredients, the cooking time and temperature, the calories, and so on.

Be sure to test your structured data using the [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/u/0/) during development, and the [Search Console Structured Data report](https://www.google.com/webmasters/tools/structured-data?pli=1) after deployment, to monitor the health of your pages, which might break after deployment due to templating or serving issues.

### Schema
[Schema.org](http://schema.org/) is a collaborative, community activity with a mission to create, maintain, and promote schemas for [structured data](https://moz.com/learn/seo/schema-structured-data) on the Internet, on web pages, in email messages, and beyond.

Schema.org vocabulary can be used with many different encodings, including RDFa, Microdata and JSON-LD. These vocabularies cover entities, relationships between entities and actions, and can easily be extended through a well-documented extension model. Over 10 million sites use Schema.org to markup their web pages and email messages.

Founded by Google, Microsoft, Yahoo and Yandex, Schema.org vocabularies are developed by an open community process, using the public-schemaorg@w3.org mailing list and through [GitHub](https://github.com/schemaorg/schemaorg).

[How to Add Schema.org Markup to WordPress for Better SEO](https://premium.wpmudev.org/blog/schema-wordpress-seo/)

Currently we use the version 3.2.

(FUTURE: https://developers.google.com/gmail/markup/)

## syntaxes

Syntaxes define attributes that get added to your existing HTML elements. You can mix them up as you like. (You could use both vocabularies with both syntaxes on the same page. You could use both vocabularies with only one syntax. You could use only one vocabulary with both syntaxes, or with only one syntax. …). It totally depends on your specific use case.

What do you want to achieve? If you are interested in a specific 3rd party parsing your content, you should check their documentation. They typically support only certain vocabularies with certain syntaxes.

But if you want to mark up your content with semantic metadata without having a specific use case in mind, you could stick to one syntax and use whichever vocabularies are appropriate for your content.

### Microdata

In the web context, [Microdata](https://html.spec.whatwg.org/multipage/microdata.html) is a WHATWG HTML specification for embedding semantically meaningful markup chiefly within the HTML body. Microdata isn’t the same thing as metadata, as microdata isn’t restricted to conveying only information about the creation of the text. Microdata becomes part of the web document itself and serves somewhat like an annotation within the HTML body text. Microdata tells machines something more about the meaning of the text.

Basically, microdata is an HTML specification that allows for the expression of other vocabularies, such as Schema.org, within a webpage.

By using Microdata, you are not directly playing part in the Semantic Web (and AFAIK Microdata doesn’t intend to), mostly because it’s not defined as RDF serialization (although there are ways to extract RDF from Microdata).

### JSON-LD

The [JSON-LD](https://www.w3.org/TR/json-ld/) scripts are Search Engine helpers which tell Search Engines how to connect and index the site.
They can tell the Search Engine if your site contains an internal search engine, what sites you’re socially connected to and what page structure you’re using.
This is also referred to as Structured Data.

JSON-LD is the recommended format. Google is in the process of adding JSON-LD support for all markup-powered features. The table below lists the exceptions to this. We recommend using JSON-LD where possible.

JSON-LD doesn't require change of HTML compared with Microdata and RDFa. Also you can make changes in JSON-LD without touching HTML. Like adding new fields, parameters, etc.

https://json-ld.org/spec/ED/json-ld-syntax/20110507/

http://www.seoskeptic.com/what-is-json-ld/
http://www.seoskeptic.com/basic-vocabulary-for-schema-org-and-structured-data/#jsonld
https://moz.com/blog/json-ld-for-beginners


### Why Use JSON-LD Versus Microdata?

JSON-LD was initially created to make it as easy as possible to bring legacy JSON data to the semantic web. So, if you already have a lot of data held in JSON documents (e.g. in a JSON document database, or a file) it can sometimes be the most straightforward solution to adding semantics to your raw JSON data.

If you prefer to keep the clutter out of your HTML layout too, you can publish your structured data separately from your HTML layout markup by adding JSON-LD to the header of your HTML page. For this reason, if you for example don't have the ability to edit your organisation's web pages, sometimes JSON-LD can be a suitable candidate.

Given that the structured data you defined in JSON-LD also isn't interspersed with lots of HTML layout code, it is also arguably more human readable.

JSON-LD is well supported. For example, Google's popular Gmail can read [JSON-LD within an email](https://developers.google.com/gmail/markup/reference/formats/json-ld)

### Turtle
Comming soon

### RDFa
Comming soon
https://stackoverflow.com/questions/8957902/microdata-vs-rdfa/25888436#25888436
RDFa can be used in various host languages, i.e. several (X)HTML variants and XML (thus also in SVG, MathML, Atom etc.). Thanks to its use of prefixes, RDFa allows to mix vocabularies. RDFa is published as W3C Recommendation. RDFa is an RDF serialization, and RDF is the foundation of W3C’s Semantic Web.

### Microformats
Comming soon

ogp.me
https://premium.wpmudev.org/blog/schema-wordpress-seo/

---
[Readme](/Readme.md)
