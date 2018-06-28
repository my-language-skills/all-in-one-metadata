# All in one metadata

We're convinced that [structured data](https://developers.google.com/search/docs/guides/intro-structured-data) makes the web better, and we've worked hard to expand [Rich Snippets](https://webmasters.googleblog.com/2009/05/introducing-rich-snippets.html) and [Rich Cards](https://webmasters.googleblog.com/2016/05/introducing-rich-cards.html) for better search results. Thanks to the [metadata](https://www.youtube.com/watch?v=L9BqE01SLeE), the search engines can understand the relevance of that content in context. All in one metadata is a complete solution for adding metadata to a Wordpress site.

* [Webmasters Rich Snippets FAQ](/doc/doc-faq.md)
* [What a SEO plugin does](/doc/doc-seo.md)


## About All in one metadata plugin

This is a plugin for the Wordpress CMS that can be used to add metadata on a website. The plugin supports integration with the Pressbooks plugin that enables the user to add Books on a website. This plugin works on both multisite installation and singe site installation of Wordpress. When the plugin is operating on multisite it has extra functionality which is described later in this documentation.

The aim of All in one metadata is to accomplish:

* A detailed description of the schema metadata.
* To use other vocabularies for specifical purposes
 * Google schoolar
 * Dublin Core
 * Coins
 * Educational metadata (LRMI) trough schema

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


### Google schoolar
[Google Scholar](https://scholar.google.es/) is a search engine focused specifically on the discovery of scholarly literature as opposed to the broader google.com web search engine. Google Scholar provides search across many disciplines and sources: articles, theses, books, abstracts and court opinions, from academic publishers, professional societies, online repositories, universities and other web sites.

[Google schoolar overview](https://scholar.google.com/intl/en-US/scholar/inclusion.html#overview).

## Other vocabularies
A [vocabulary](https://www.w3.org/standards/semanticweb/ontology) allows the markup of structured data in HTML documents.

On the Semantic Web, vocabularies define the concepts and relationships (also referred to as “terms”) used to describe and represent an area of concern. Vocabularies are used to classify the terms that can be used in a particular application, characterize possible relationships, and define possible constraints on using those terms. In practice, vocabularies can be very complex (with several thousands of terms) or very simple (describing one or two concepts only).

### LRMI
The [LRMI](http://lrmi.dublincore.net/) has developed a common metadata framework for describing or ‘tagging’ learning resources on the web. This framework is a key first step in developing a richer, more fruitful search experience for educators and learners. The metadata schema developed by the [LRMI is adopted by Schema.org](http://lrmi.dublincore.net/lrmi-1-1/), meaning that anyone who publishes or curates educational content can now use [LRMI markup to provide rich, education-specific metadata about their resources with the confidence that this metadata will be recognized by major search engines.

### Dublin Core
[Dublin Core](http://dublincore.org/documents/2000/07/16/usageguide/)  is an initiative to create a digital "library card catalog" for the Web. Dublin Core is made up of 15 metadata (data that describes data) elements that offer expanded cataloging information and improved document indexing for search engine programs.

Two forms of Dublin Core exist: [Simple Dublin Core](http://dublincore.org/documents/dces/) and [Qualified Dublin Core](http://dublincore.org/documents/dcmi-terms/). Simple Dublin Core expresses elements as attribute-value pairs using just the 15 metadata elements from the Dublin Core Metadata Element Set. Qualified Dublin Core increases the specificity of metadata by adding information about encoding schemes, enumerated lists of values, or other processing clues. While enabling searches to be more specific, qualifiers are also more complex and can pose challenges to interoperability.

### Coins
COinS (ContextObjects in Spans) is as “a simple, ad hoc community specification for publishing OpenURL references in HTML.” A microformat developed particularly to embed citation information. This extends the types information we can provide to tools that focus more on scholarly needs.

For example, the citation manager [Zotero](http://www.zotero.org/) knows how to read COinS. So, when viewing one of our publications in a browser with Zotero installed, a folder icon will appear in the URL bar.

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
