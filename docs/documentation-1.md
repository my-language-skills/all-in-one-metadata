# All in one metadata

All in one metadata is a complete solution for adding metadata to a Wordpress site or a Wordpress site with Pressbooks plugin activated. Thanks to the metadata, the search engines can understand the relevance of that content in context.

## About All in one metadata plugin

The aim of All in one metadata is to accomplish:

* A detailed description of the schema metadata.
* To use other vocabularies for specifical purposes
 * Google schoolar
 * Dublin Core
 * Coins
 * Educational metadata (LRMI)

## What is not All in one metadata

Is not a SEO solution. Schemas don’t actually boost the organic search rankings. With Schemas review ratings, recipes or events in Google’s SERPs (search engine results pages) are not just normal search listings but also contain additional information. Those are known as rich snippets and they are thanks to schema markup. Rich snippets actually increase clickthrough rates. Schema may not directly improve your search rankings, but it can still be beneficial for your SEO.



## About All in one metadata for Google

[Introduction to Structured Data](https://developers.google.com/search/docs/guides/intro-structured-data)

Google Search works hard to understand the content of a page. However, you can provide explicit clues about the meaning of a page to Google by including structured data on the page. Structured data is a standardized format for providing information about a page and classifying the page content; for example, if is it a recipe page, what are the ingredients, the cooking time and temperature, the calories, and so on.

Be sure to test your structured data using the [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/u/0/) during development, and the [Search Console Structured Data report](https://www.google.com/webmasters/tools/structured-data?pli=1) after deployment, to monitor the health of your pages, which might break after deployment due to templating or serving issues.

### Schema

[Schema.org](http://schema.org/) is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet, on web pages, in email messages, and beyond.

Schema.org vocabulary can be used with many different encodings, including RDFa, Microdata and JSON-LD. These vocabularies cover entities, relationships between entities and actions, and can easily be extended through a well-documented extension model. Over 10 million sites use Schema.org to markup their web pages and email messages.

Founded by Google, Microsoft, Yahoo and Yandex, Schema.org vocabularies are developed by an open community process, using the public-schemaorg@w3.org mailing list and through [GitHub](https://github.com/schemaorg/schemaorg).

[How to Add Schema.org Markup to WordPress for Better SEO](https://premium.wpmudev.org/blog/schema-wordpress-seo/)

Currently we use the version 3.2.

(FUTURE: https://developers.google.com/gmail/markup/)


### Google schoolar

[Google Scholar](https://scholar.google.es/) is a search engine focused specifically on the discovery of scholarly literature as opposed to the broader google.com web search engine. Google Scholar provides search across many disciplines and sources: articles, theses, books, abstracts and court opinions, from academic publishers, professional societies, online repositories, universities and other web sites.

[Google schoolar overview](https://scholar.google.com/intl/en-US/scholar/inclusion.html#overview).

## About All in one metadata vocabularies
### Dublin Core
[Dublin Core](http://dublincore.org/documents/2000/07/16/usageguide/)  is an initiative to create a digital "library card catalog" for the Web. Dublin Core is made up of 15 metadata (data that describes data) elements that offer expanded cataloging information and improved document indexing for search engine programs.

Two forms of Dublin Core exist: [Simple Dublin Core](http://dublincore.org/documents/dces/) and [Qualified Dublin Core](http://dublincore.org/documents/dcmi-terms/). Simple Dublin Core expresses elements as attribute-value pairs using just the 15 metadata elements from the Dublin Core Metadata Element Set. Qualified Dublin Core increases the specificity of metadata by adding information about encoding schemes, enumerated lists of values, or other processing clues. While enabling searches to be more specific, qualifiers are also more complex and can pose challenges to interoperability.

### Coins

COinS (ContextObjects in Spans) is as “a simple, ad hoc community specification for publishing OpenURL references in HTML.” A microformat developed particularly to embed citation information. This extends the types information we can provide to tools that focus more on scholarly needs.

For example, the citation manager [Zotero](http://www.zotero.org/) knows how to read COinS. So, when viewing one of our publications in a browser with Zotero installed, a folder icon will appear in the URL bar.







ogp.me



-----

# Webmasters Rich Snippets FAQ

**Q: Why doesn't my site show rich snippets? I added everything and the test tool shows it's ok.**
A: Google does not guarantee that Rich Snippets will show up for search results from a particular site even if structured data is marked up and can be extracted successfully according to the testing tool. Here are some reasons that marked-up pages might not be shown with Rich Snippets:

    The marked-up structured data is not representative of the main content of the page or potentially misleading.
    Marked-up data is incorrect in a way that the testing tool was not able to catch.
    Marked-up content is hidden from the user.
    The site has very few pages (or very few pages with marked-up structured data) and may not be picked up by Google's Rich Snippets system.


**Q: Does using rich snippets affect my site's ranking?**
A: No.

**Q: How long does it take for rich snippets to be visible?**
A: Once you've marked up your site's content, Google will discover it the next time we crawl your site (although it may take some time for rich snippets to appear in search results, if we do choose to display rich snippets for your site). If you're marking up your content for rich snippets, you can let us know. Google won't be able to individually reply to your message, but we may use the information you supply to improve our detection and display of marked-up content.

**Q: My site has a very specific design and the information that I would like to display in the rich snippets will ruin it. Could I hide it from my site visitors somehow, making it available only to Googlebot?**
A: It can be tempting to add all the content relevant for a rich snippet in one place on the page, mark it up, and then hide the entire block of text using CSS or other techniques. Don't do this! Mark up the content where it already exists. Except in special circumstances (for example when marking the best possible rating for review sites that don't use a 5-point rating scale), Google will not show content from hidden div's in Rich Snippets.

**Q: Is the rating information required for a review markup?**
A: For an individual review the rating can be omitted, if in your marked-up content you have both an author and a review date. For aggregate reviews the average rating must be supplied, otherwise rich snippets will not be displayed.

**Q: Does Google supports tags for multidimensional reviews (hReview)?**
A: At the moment, Google does not use multidimensional review information in any special way, so it is not documented in the Google help pages. However, it doesn't do any harm to follow the hReview spec defined on microformats.org to include this additional markup - Google will simply ignore markup it doesn't understand, and it is certainly possible that we will utilize the information at some point in the future.

**Q: Can I mark up two types of items (for example, reviews and events) on the same page?**
A: Yes.

**Q: My site has information about exhibitions which usually last a month or more. Is it ok to mark up these types of events for rich snippets or does Google recognise only one-day events such as concerts, lectures, etc?**
A: Yes, it's ok to mark up extended events, as long as they have a clearly defined start and end date. However, currently there are no methods to mark up recurrent events (e.g. lectures that happen on Tuesday, Thursday and not on Mondays, Wednesday and Fridays).

**Q: Does Google understand only official microformats specifications? What about the draft ones, e.g. xFolk? Would you have any specific recommendations?**
A: We have published the formats we understand and you can find them in our Help Center articles. Feel free to use any structured mark up format that suits your site's needs - even though we might not currently support it, we may add it in the future. We love structured data!

**Q: Why would anyone want to use Rich Snippets and have Google pull more content from their site? Wouldn't this decrease the clickthrough rate from Google to my website?**
A: To address some of the concerns, we would like to highlight once more that Google's top goal is helping users find the right answer for their queries, not taking away traffic from the best results. Our experiments show that many sites have seen increased clickthrough by showing an enhanced snippet because users better notice all the good content from the site. For example, when searching for reviews, users can more quickly identify sites with a lot of review content. The same is true for results with cooking recipes — users can more easily identify recipes that fit their criteria, and sometimes even see photos of the dish. When searching for events, more links to deeper pages on your site are shown as part of your snippet. You can try testing semantic markup on your site yourself and if you find you are losing traffic, you can always remove the markup, no hard feelings.

**Q: Will rich snippets replace the common site snippets? What's the difference anyway?**
A: Rich snippets is one of many initiatives we have, aimed to improve the appearance of the description of a page's content.
To generate a typical snippet, Google automatically attempts to extract the part of the page that's most relevant to the user query, whereas the information that goes into rich snippets is fully controlled by webmasters through the semantic markup they place on their site.

**Q: What are your plans for the nearest future?**
A: We're planning to add more rich snippet formats to our list of supported formats. We're also working on improving the speed with which we detect and show new rich snippets markup. Expect to see improvements in the rich snippets testing tool and our help pages.



## What a SEO plugin does?
[The SEO Framework](https://wordpress.org/plugins/autodescription/), [All in one SEO](https://wordpress.org/plugins/all-in-one-seo-pack/) or [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) are good solutions for your [SEO](https://moz.com/learn/seo/what-is-seo).

* Titles according to your settings with archive prefixes.
* Descriptions with anti-spam techniques and detection that informs you when it can be improved.
* A canonical URL to prevent duplicated content; with full Domain Mapping, subdomain, and HTTPS support.
* Various Open Graph, Facebook and Twitter tags.
* Special Open Graph descriptions, which organically integrates within the Facebook and Twitter snippets.
* Open Graph images, they are automatically resized and optimized when needed.
* Structured Data for Google Search and Chromium that adds extended on-site search support.
* Structured Data for Google’s Knowledge Graph; like Personal/Business site relations, names, and logos.
* Structured Data for Breadcrumbs that extend pages and categories relationship support in Google Search.
* Structured Data for Google Search that lets it know your preferred site name.
* Publishing and editing dates for Social Sites and Search Engines alike.
* Paginated content relationship links, to help visitors going to the right page.
* A sitemap with all your pages, posts and CPT, which listens to their set settings.
* Feed excerpts and backlinks within, to prevent automated content theft.
* Prevents canonical errors with categories, pages, subdomains and Multisite Domain Mapping.
* Discourages 404 pages and empty categories from being indexed, even if they don’t send a 404 response.
* Automatically notifies Google, Bing, and Yandex on website updates when sitemaps are enabled.
