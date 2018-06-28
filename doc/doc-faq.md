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

---

[Readme](/Readme.md)
