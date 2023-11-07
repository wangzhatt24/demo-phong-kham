#################################
Documentation

http://flatfull.com/wp/bepop/doc/

#################################
Update

3.2

. Improve the comment form
. Add find_in_set in loop block meta compare
. Add "Featured on" on single station
. Add ads interval option
. Add copyright on front-end upload form
. Fix like on login page


3.1

. Show video and add fullscreen
. Disable autoplay on chrome
. Refresh page when got 404
. Refresh page when logout
. Add no-player class to disable history player on page
. Add no-ajax class to disable ajax on menu item
. Fix login form error


3.0

1. Add bulk upload
2. Add footer on pages
3. No album option on subscriber user
4. No album/upload/station on after login menu on subscriber user
5. Add option to show admin bar for admin user
6. Add remove alert


2.3

1. Add Ad on player.
2. Clear queue to clear cache on player
3. Add css classes on the loop on user page
4. Add editor note and copyright on play block plugin
5. Add exclude tags in upload form to prevent invalid tags. play_exclude_tags
6. Improve the dropdown menu in slider
7. Improve load svg icon on player
8. Fix sidebar, verifed


2.2

1. Add history on player
2. Add front end post playlist to custom post type
3. Add verified user auto publish the upload
4. Remove station endpoint for subscribers. now you can add filter to "pass_user_endpoint" to pass the endpoint
5. Add slider on similar block
6. Improve the avatar img
7. Improve the sidebar


2.1

1. Add shoutcast/icecast current playing title on player
2. Add whatsapp/instgram/snapchat social networks
3. Add user menu location to manage user menus on profile page, you can add other page link to user menu, also you can set the page template to "User" on the "Page attribute"
4. Add playlist type option when user edit a playlist. user can create playlist then change it to album.
5. Add albums endpoint and albums section on user page
6. Add downloads endpoint and downloads section on user page
7. Improve the upload status when click upload button
8. Add loop-post-excerpt.php template in loop block plugin
9. Add orderby "User" to only show posts/stations/products by current loged in user
10. Improve on Woocommerce
   disable play/more button if it's not playable, disable single station template on product page if it's not playable
11. Add sidebar option on "Template:sidebar", you can choose different sidebar for pages.
12. Fix languages on play-block plugin


2.0

1. Improve the search result. add search username, taxonomy
2. Add subtitle on loop block
3. Add play_next_tag filter to change the next play.
4. Hide sidebar if no page config.
5. Add sort in station artist
6. Add like/dislike on product review.
7. Improve the ios autoplay, click once again to play.
8. Improve the play count, only played 25-30 seconds will count.
9. Fix waveform color in Firefox.
10. Fix waveform on upload form.
11. Fix click player video icon to stop play


1.3.3

1. Add like/dislike on comment
2. Fix loop block plugin conflict with WordPress plugins css


1.3.2

1. Add operator/compare on taxonomy/meta query on Loop block
2. Add slider on "More from" on single station
3. Add purchaseable option on upload form
4. Fix ajax issues, no-ajax page to no-ajax page switch and body with id attribute by other plugin
5. Fix meta query not saved on loop block plugin
6. Fix playlist/album empty after update on Play block plugin


1.3.1

1. Add play-block to support custom post type if it's not fully support Gutenberg(eg.EDD)
2. Add play m3u8 in audio tag, default is video, you can add "?audio" to the url or add_filter to "play_single_data" to set the data type to audio.
3. Improve the loop block
4. Improve the ajax comment form
5. Add support youtu.be link
6. Add "verified user" orderby in the loop block to filter only verified user stations
7. Fix youtube play on mobile need click on video(android).


1.3.0

1. Rewrite the Loop Block grid style, 
   replace column with rows and columns, remove slick slider and jscroll and use custom js
2. Add empty content in Loop Block plugin
3. Add meta query in Loop Block plugin
4. Add filter sortable on Loop Block plugin
5. Add loop-waveform.php template in Loop Block plugin
6. Add support play m3u8 stream in Play Block plugin
7. Add Waveform on front-end in Play Block plugin
8, Add sort/remove playlist/album on front-end submit form
9. Add verified artist on user
10. Improve the active state on loop item
11. Improve the user avatar
12. Remove the tag-input plugin


1.2.3

1. Add empty placeholder on user page
2. Add btn-ajax-register to popup register form
3. Add client_id on soundcloud download url.
4. Add logout link on menu
5. Add template override on loop block template
6. Fix playlist endpoint


1.2.2

1. Add Woocommerce product to support Gutenberg
2. Add Play Block on Woocommerce product
3. Fix menu link in demo data
4. Fix header on firefox


1.2.1

1. Fix upload stream file not working on safari
2. Fix edit playlist need stream field on front-end
3. Fix loop block slider option on template with sidebar


1.2.0

1. Add ajax on search form when use "enter"
2. Add auto next play music from same artist or user
3. Change playlist to playlists, you need go to "settings > permalink" to refresh the links
4. Fixed login modal on login page


1.1.3

1. Add "Filter" on Loop Block plugin to create station filter
2. Add product price on product archive page
3. Add product purchase button on player


1.1.2

1. Add "Poster" as required field on upload form
2. Add ajax upload stream on upload form
3. Improved search result for station
4. Add wait cursor when page loading
5. Fixed input border, zoomin issues, center play button on iPhone


1.1.1

1. Add order by "user played/user likes" on loop block to display user played/likes
2. Add disable ajax option on page
3. Add "Playlist auto public" option on "Settings > General"
4. Add option to disable non-admin user to see wp-admin
5. Front-end auto post to "single" type
6. Fix ajax search
7. Fix artist output on "More from"


1.1.0

1. Add download button on mobile
2. Add woocommerce product in search
3. Add message if the stream url or empty music file
4. Fixed the play button on user profile page


1.0.3

1. Add Woocommerce variable product support. Remove the "Apply product station style" in option. all product will use Player style.
2. Add artist in upload form
3. Add price on upload form if it's a product type
4. Add user role control to upload function. "subscriber" can not upload anymore. go to "Settings > General" to set "New User Default Role"
5. Auto publish playlist
6. Add share module
7. Show station/playlist/likes/followers/following count on user profile
8. Player show like/video on mobile, hide random/shuffle button
9. Fixed the seek bar on touch screen(IOS), improve the loading on mobile
10. Fixed album/playlist max tracks and documentation


1.0.2

1. Add membership to upload and download page
   note: you need config the upload and download page on "Settings"
   if you use paid membership pro plugin, edit the "upload/download" page to add "Require Membership"

2. Add tag or category filter in Loop Block front-end url
   This function is alreay in Loop Block back-end filter.
   eg. http://flatfull.com/wp/bepop/charts/?search&genre=rock
       http://flatfull.com/wp/bepop/charts/?search&station_tag=youtube
   or  http://flatfull.com/wp/bepop/charts/?search&genre=rock&station_tag=youtube

3. Fixed user can not change email
4. Fixed must double click to play on mobile
5. Fixed load user playlist/album on profile page


1.0.1

1. Fixed station type not in the loop block type
2. Add new template landing with secondary menu
3. Add Woocommerce support
4. Add frontend submission to product 
5. Add option to apply station style to product

