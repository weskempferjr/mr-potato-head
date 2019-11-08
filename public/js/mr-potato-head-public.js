require=(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({"buckets-js":[function(require,module,exports){
/*! buckets - version: 1.98.2 - (c) 2013 - 2016 Mauricio Santos - https://github.com/mauriciosantos/Buckets-JS*/
!function(a,b){"function"==typeof define&&define.amd?define([],b):"object"==typeof exports?module.exports=b():a.buckets=b()}(this,function(){"use strict";var a={};return a.defaultCompare=function(a,b){return a<b?-1:a===b?0:1},a.defaultEquals=function(a,b){return a===b},a.defaultToString=function(b){return null===b?"BUCKETS_NULL":a.isUndefined(b)?"BUCKETS_UNDEFINED":a.isString(b)?b:b.toString()},a.isFunction=function(a){return"function"==typeof a},a.isUndefined=function(a){return void 0===a},a.isString=function(a){return"[object String]"===Object.prototype.toString.call(a)},a.reverseCompareFunction=function(b){return a.isFunction(b)?function(a,c){return b(a,c)*-1}:function(a,b){return a<b?1:a===b?0:-1}},a.compareToEquals=function(a){return function(b,c){return 0===a(b,c)}},a.arrays={},a.arrays.indexOf=function(b,c,d){var e,f=d||a.defaultEquals,g=b.length;for(e=0;e<g;e+=1)if(f(b[e],c))return e;return-1},a.arrays.lastIndexOf=function(b,c,d){var e,f=d||a.defaultEquals,g=b.length;for(e=g-1;e>=0;e-=1)if(f(b[e],c))return e;return-1},a.arrays.contains=function(b,c,d){return a.arrays.indexOf(b,c,d)>=0},a.arrays.remove=function(b,c,d){var e=a.arrays.indexOf(b,c,d);return!(e<0)&&(b.splice(e,1),!0)},a.arrays.frequency=function(b,c,d){var e,f=d||a.defaultEquals,g=b.length,h=0;for(e=0;e<g;e+=1)f(b[e],c)&&(h+=1);return h},a.arrays.equals=function(b,c,d){var e,f=d||a.defaultEquals,g=b.length;if(b.length!==c.length)return!1;for(e=0;e<g;e+=1)if(!f(b[e],c[e]))return!1;return!0},a.arrays.copy=function(a){return a.concat()},a.arrays.swap=function(a,b,c){var d;return!(b<0||b>=a.length||c<0||c>=a.length)&&(d=a[b],a[b]=a[c],a[c]=d,!0)},a.arrays.forEach=function(a,b){var c,d=a.length;for(c=0;c<d;c+=1)if(b(a[c])===!1)return},a.Bag=function(b){var c={},d=b||a.defaultToString,e=new a.Dictionary(d),f=0;return c.add=function(b,d){var g;return(isNaN(d)||a.isUndefined(d))&&(d=1),!(a.isUndefined(b)||d<=0)&&(c.contains(b)?e.get(b).copies+=d:(g={value:b,copies:d},e.set(b,g)),f+=d,!0)},c.count=function(a){return c.contains(a)?e.get(a).copies:0},c.contains=function(a){return e.containsKey(a)},c.remove=function(b,d){var g;return(isNaN(d)||a.isUndefined(d))&&(d=1),!(a.isUndefined(b)||d<=0)&&(!!c.contains(b)&&(g=e.get(b),f-=d>g.copies?g.copies:d,g.copies-=d,g.copies<=0&&e.remove(b),!0))},c.toArray=function(){var a,b,c,d,f,g=[],h=e.values(),i=h.length;for(d=0;d<i;d+=1)for(a=h[d],b=a.value,c=a.copies,f=0;f<c;f+=1)g.push(b);return g},c.toSet=function(){var b,c=new a.Set(d),f=e.values(),g=f.length;for(b=0;b<g;b+=1)c.add(f[b].value);return c},c.forEach=function(a){e.forEach(function(b,c){var d,e=c.value,f=c.copies;for(d=0;d<f;d+=1)if(a(e)===!1)return!1;return!0})},c.size=function(){return f},c.isEmpty=function(){return 0===f},c.clear=function(){f=0,e.clear()},c.equals=function(b){var d;return!a.isUndefined(b)&&"function"==typeof b.toSet&&(c.size()===b.size()&&(d=!0,b.forEach(function(a){return d=c.count(a)===b.count(a)}),d))},c},a.BSTree=function(b){function c(a,b){for(var c,d=a;void 0!==d&&0!==c;)c=g(b,d.element),c<0?d=d.leftCh:c>0&&(d=d.rightCh);return d}function d(a){for(var b=a;void 0!==b.leftCh;)b=b.leftCh;return b}var e,f={},g=b||a.defaultCompare,h=0;return f.add=function(b){function c(a){for(var b,c,d=e;void 0!==d;){if(c=g(a.element,d.element),0===c)return;c<0?(b=d,d=d.leftCh):(b=d,d=d.rightCh)}return a.parent=b,void 0===b?e=a:g(a.element,b.element)<0?b.leftCh=a:b.rightCh=a,a}if(a.isUndefined(b))return!1;var d={element:b,leftCh:void 0,rightCh:void 0,parent:void 0};return void 0!==c(d)&&(h+=1,!0)},f.clear=function(){e=void 0,h=0},f.isEmpty=function(){return 0===h},f.size=function(){return h},f.contains=function(b){return!a.isUndefined(b)&&void 0!==c(e,b)},f.remove=function(a){function b(a,b){void 0===a.parent?e=b:a===a.parent.leftCh?a.parent.leftCh=b:a.parent.rightCh=b,void 0!==b&&(b.parent=a.parent)}function f(a){if(void 0===a.leftCh)b(a,a.rightCh);else if(void 0===a.rightCh)b(a,a.leftCh);else{var c=d(a.rightCh);c.parent!==a&&(b(c,c.rightCh),c.rightCh=a.rightCh,c.rightCh.parent=c),b(a,c),c.leftCh=a.leftCh,c.leftCh.parent=c}}var g;return g=c(e,a),void 0!==g&&(f(g),h-=1,!0)},f.inorderTraversal=function(a){function b(a,c,d){void 0===a||d.stop||(b(a.leftCh,c,d),d.stop||(d.stop=c(a.element)===!1,d.stop||b(a.rightCh,c,d)))}b(e,a,{stop:!1})},f.preorderTraversal=function(a){function b(a,c,d){void 0===a||d.stop||(d.stop=c(a.element)===!1,d.stop||(b(a.leftCh,c,d),d.stop||b(a.rightCh,c,d)))}b(e,a,{stop:!1})},f.postorderTraversal=function(a){function b(a,c,d){void 0===a||d.stop||(b(a.leftCh,c,d),d.stop||(b(a.rightCh,c,d),d.stop||(d.stop=c(a.element)===!1)))}b(e,a,{stop:!1})},f.levelTraversal=function(b){function c(b,c){var d=a.Queue();for(void 0!==b&&d.enqueue(b);!d.isEmpty();){if(b=d.dequeue(),c(b.element)===!1)return;void 0!==b.leftCh&&d.enqueue(b.leftCh),void 0!==b.rightCh&&d.enqueue(b.rightCh)}}c(e,b)},f.minimum=function(){if(!f.isEmpty())return d(e).element},f.maximum=function(){function a(a){for(;void 0!==a.rightCh;)a=a.rightCh;return a}if(!f.isEmpty())return a(e).element},f.forEach=function(a){f.inorderTraversal(a)},f.toArray=function(){var a=[];return f.inorderTraversal(function(b){a.push(b)}),a},f.height=function(){function a(b){return void 0===b?-1:Math.max(a(b.leftCh),a(b.rightCh))+1}function b(b){return void 0===b?-1:Math.max(a(b.leftCh),a(b.rightCh))+1}return b(e)},f.equals=function(b){var c;return!a.isUndefined(b)&&"function"==typeof b.levelTraversal&&(f.size()===b.size()&&(c=!0,b.forEach(function(a){return c=f.contains(a)}),c))},f},a.Dictionary=function(b){var c={},d={},e=0,f=b||a.defaultToString,g="/$ ";return c.get=function(b){var c=d[g+f(b)];if(!a.isUndefined(c))return c.value},c.set=function(b,c){var h,i,j;if(!a.isUndefined(b)&&!a.isUndefined(c))return i=g+f(b),j=d[i],a.isUndefined(j)?(e+=1,h=void 0):h=j.value,d[i]={key:b,value:c},h},c.remove=function(b){var c=g+f(b),h=d[c];if(!a.isUndefined(h))return delete d[c],e-=1,h.value},c.keys=function(){var a,b=[];for(a in d)Object.prototype.hasOwnProperty.call(d,a)&&b.push(d[a].key);return b},c.values=function(){var a,b=[];for(a in d)Object.prototype.hasOwnProperty.call(d,a)&&b.push(d[a].value);return b},c.forEach=function(a){var b,c,e;for(b in d)if(Object.prototype.hasOwnProperty.call(d,b)&&(c=d[b],e=a(c.key,c.value),e===!1))return},c.containsKey=function(b){return!a.isUndefined(c.get(b))},c.clear=function(){d={},e=0},c.size=function(){return e},c.isEmpty=function(){return e<=0},c.equals=function(b,d){var e,f;return!a.isUndefined(b)&&"function"==typeof b.keys&&(c.size()===b.size()&&(e=d||a.defaultEquals,f=!0,b.forEach(function(a,b){return f=e(c.get(a),b)}),f))},c},a.Heap=function(b){function c(b){function c(a){return Math.floor((a-1)/2)}var d;for(d=c(b);b>0&&g(f[d],f[b])>0;)a.arrays.swap(f,d,b),b=d,d=c(b)}function d(b){function c(a){return 2*a+1}function d(a){return 2*a+2}function e(a,b){return b>=f.length?a>=f.length?-1:a:g(f[a],f[b])<=0?a:b}var h;for(h=e(c(b),d(b));h>=0&&g(f[b],f[h])>0;)a.arrays.swap(f,h,b),b=h,h=e(c(b),d(b))}var e={},f=[],g=b||a.defaultCompare;return e.peek=function(){if(f.length>0)return f[0]},e.add=function(b){if(!a.isUndefined(b))return f.push(b),c(f.length-1),!0},e.removeRoot=function(){var a;if(f.length>0)return a=f[0],f[0]=f[f.length-1],f.splice(f.length-1,1),f.length>0&&d(0),a},e.contains=function(b){var c=a.compareToEquals(g);return a.arrays.contains(f,b,c)},e.size=function(){return f.length},e.isEmpty=function(){return f.length<=0},e.clear=function(){f.length=0},e.forEach=function(b){a.arrays.forEach(f,b)},e.toArray=function(){return a.arrays.copy(f)},e.equals=function(b){var c,d,f;return!a.isUndefined(b)&&"function"==typeof b.removeRoot&&(e.size()===b.size()&&(c=e.toArray(),d=b.toArray(),f=a.compareToEquals(g),c.sort(g),d.sort(g),a.arrays.equals(c,d,f)))},e},a.LinkedList=function(){function b(a){var b,e;if(!(a<0||a>=f)){if(a===f-1)return d;for(b=c,e=0;e<a;e+=1)b=b.next;return b}}var c,d,e={},f=0;return e.add=function(e,g){var h,i;return a.isUndefined(g)&&(g=f),!(g<0||g>f||a.isUndefined(e))&&(h={element:e,next:void 0},0===f?(c=h,d=h):g===f?(d.next=h,d=h):0===g?(h.next=c,c=h):(i=b(g-1),h.next=i.next,i.next=h),f+=1,!0)},e.first=function(){if(void 0!==c)return c.element},e.last=function(){if(void 0!==d)return d.element},e.elementAtIndex=function(a){var c=b(a);if(void 0!==c)return c.element},e.indexOf=function(b,d){var e=d||a.defaultEquals,f=c,g=0;if(a.isUndefined(b))return-1;for(;void 0!==f;){if(e(f.element,b))return g;g+=1,f=f.next}return-1},e.contains=function(a,b){return e.indexOf(a,b)>=0},e.remove=function(b,e){var g,h=e||a.defaultEquals,i=c;if(f<1||a.isUndefined(b))return!1;for(;void 0!==i;){if(h(i.element,b))return i===c?(c=c.next,i===d&&(d=void 0)):i===d?(d=g,g.next=i.next,i.next=void 0):(g.next=i.next,i.next=void 0),f-=1,!0;g=i,i=i.next}return!1},e.clear=function(){c=void 0,d=void 0,f=0},e.equals=function(b,d){var f=d||a.defaultEquals,g=!0,h=c;return!a.isUndefined(b)&&"function"==typeof b.elementAtIndex&&(e.size()===b.size()&&(b.forEach(function(a){return g=f(a,h.element),h=h.next,g}),g))},e.removeElementAtIndex=function(a){var e,g;if(!(a<0||a>=f))return 1===f?(e=c.element,c=void 0,d=void 0):(g=b(a-1),void 0===g?(e=c.element,c=c.next):g.next===d&&(e=d.element,d=g),void 0!==g&&(e=g.next.element,g.next=g.next.next)),f-=1,e},e.forEach=function(a){for(var b=c;void 0!==b&&a(b.element)!==!1;)b=b.next},e.reverse=function(){for(var a,b,e=c;void 0!==e;)b=e.next,e.next=a,a=e,e=b;b=c,c=d,d=b},e.toArray=function(){var a=[];return e.forEach(function(b){a.push(b)}),a},e.size=function(){return f},e.isEmpty=function(){return f<=0},e},a.MultiDictionary=function(b,c){var d={},e=new a.Dictionary(b),f=c||a.defaultEquals;return d.get=function(b){var c=e.get(b);return a.isUndefined(c)?[]:a.arrays.copy(c)},d.set=function(b,c){var g;return!a.isUndefined(b)&&!a.isUndefined(c)&&(d.containsKey(b)?(g=e.get(b),!a.arrays.contains(g,c,f)&&(g.push(c),!0)):(e.set(b,[c]),!0))},d.remove=function(b,c){var d,g;return a.isUndefined(c)?(d=e.remove(b),!a.isUndefined(d)):(g=e.get(b),!!a.arrays.remove(g,c,f)&&(0===g.length&&e.remove(b),!0))},d.keys=function(){return e.keys()},d.values=function(){var a,b,c,d=e.values(),f=[];for(a=0;a<d.length;a+=1)for(c=d[a],b=0;b<c.length;b+=1)f.push(c[b]);return f},d.containsKey=function(a){return e.containsKey(a)},d.clear=function(){return e.clear()},d.size=function(){return e.size()},d.isEmpty=function(){return e.isEmpty()},d.forEach=function(a){return e.forEach(a)},d.equals=function(b){var c,e=!0;return!a.isUndefined(b)&&"function"==typeof b.values&&(d.size()===b.size()&&(b.forEach(function(b,g){return c=d.get(b)||[],c.length!==g.length?e=!1:a.arrays.forEach(c,function(b){return e=a.arrays.contains(g,b,f)}),e}),e))},d},a.PriorityQueue=function(b){var c={},d=a.reverseCompareFunction(b),e=new a.Heap(d);return c.enqueue=function(a){return e.add(a)},c.add=function(a){return e.add(a)},c.dequeue=function(){var a;if(0!==e.size())return a=e.peek(),e.removeRoot(),a},c.peek=function(){return e.peek()},c.contains=function(a){return e.contains(a)},c.isEmpty=function(){return e.isEmpty()},c.size=function(){return e.size()},c.clear=function(){e.clear()},c.forEach=function(a){e.forEach(a)},c.toArray=function(){return e.toArray()},c.equals=function(b){var e,f,g;return!a.isUndefined(b)&&"function"==typeof b.dequeue&&(c.size()===b.size()&&(e=c.toArray(),f=b.toArray(),g=a.compareToEquals(d),e.sort(d),f.sort(d),a.arrays.equals(e,f,g)))},c},a.Queue=function(){var b={},c=new a.LinkedList;return b.enqueue=function(a){return c.add(a)},b.add=function(a){return c.add(a)},b.dequeue=function(){var a;if(0!==c.size())return a=c.first(),c.removeElementAtIndex(0),a},b.peek=function(){if(0!==c.size())return c.first()},b.size=function(){return c.size()},b.contains=function(a,b){return c.contains(a,b)},b.isEmpty=function(){return c.size()<=0},b.clear=function(){c.clear()},b.forEach=function(a){c.forEach(a)},b.toArray=function(){return c.toArray()},b.equals=function(c,d){var e,f,g;return!a.isUndefined(c)&&"function"==typeof c.dequeue&&(b.size()===c.size()&&(e=d||a.defaultEquals,f=!0,c.forEach(function(a){return g=b.dequeue(),b.enqueue(g),f=e(g,a)}),f))},b},a.Set=function(b){var c={},d=new a.Dictionary(b);return c.contains=function(a){return d.containsKey(a)},c.add=function(b){return!c.contains(b)&&!a.isUndefined(b)&&(d.set(b,b),!0)},c.intersection=function(a){c.forEach(function(b){a.contains(b)||c.remove(b)})},c.union=function(a){a.forEach(function(a){c.add(a)})},c.difference=function(a){a.forEach(function(a){c.remove(a)})},c.isSubsetOf=function(a){var b=!0;return!(c.size()>a.size())&&(c.forEach(function(c){if(!a.contains(c))return b=!1,!1}),b)},c.remove=function(a){return!!c.contains(a)&&(d.remove(a),!0)},c.forEach=function(a){d.forEach(function(b,c){return a(c)})},c.toArray=function(){return d.values()},c.isEmpty=function(){return d.isEmpty()},c.size=function(){return d.size()},c.clear=function(){d.clear()},c.equals=function(b){var d;return!a.isUndefined(b)&&"function"==typeof b.isSubsetOf&&(c.size()===b.size()&&(d=!0,b.forEach(function(a){return d=c.contains(a)}),d))},c},a.Stack=function(){var b={},c=new a.LinkedList;return b.push=function(a){return c.add(a,0)},b.add=function(a){return c.add(a,0)},b.pop=function(){return c.removeElementAtIndex(0)},b.peek=function(){return c.first()},b.size=function(){return c.size()},b.contains=function(a,b){return c.contains(a,b)},b.isEmpty=function(){return c.isEmpty()},b.clear=function(){c.clear()},b.forEach=function(a){c.forEach(a)},b.toArray=function(){return c.toArray()},b.equals=function(d,e){var f,g,h;return!a.isUndefined(d)&&"function"==typeof d.peek&&(b.size()===d.size()&&(f=e||a.defaultEquals,g=!0,d.forEach(function(a){return h=b.pop(),c.add(h),g=f(h,a)}),g))},b},a});

},{}]},{},[]);

(function( $ ) {
    'use strict';

    var buckets = require('buckets-js');

    var postDataDictionary = buckets.Dictionary();

    var timerDictionary = buckets.Dictionary();


    var posts = [];
    var retrievedPosts = false;
    var count = 5;
    var currentOffset = 0;
    var pgbdCurrentDateString;
    var pgbdCurrentContainerNumber = 0;
    var pgbdContainerSelector = '';
    var noMorePosts = false;



    var resetableTimerThreshold = parseInt( objectl10n.resetable_timer_threshold) * 1000 ;
    var updatePostDataInterval = parseInt( objectl10n.retrieve_post_data_interval ) * 1000 ;
    var bidSoonToCloseThreshold = resetableTimerThreshold + updatePostDataInterval ;
    var closingUpdatePostDataInterval = parseInt( objectl10n.retrieve_post_data_interval_closing ) * 1000 ;


    var spinnerOptions = {
        lines: 9 // The number of lines to draw
        , length: 5 // The length of each line
        , width: 2 // The line thickness
        , radius: 4 // The radius of the inner circle
        , scale: 1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.6 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    }

// var spinner = new Spinner( spinnerOptions );


    $(document).ready( function (){

        // make sure short code is on page before running.
        var shortcodeHTML = $('#pgbd-shortcode').html();

        if ( shortcodeHTML !=  undefined ) {
            count = $('#pgbd-shortcode').data( 'count');

            $('#pgbd-load-more').click( function(){
                if ( !noMorePosts ) {
                    displayPosts();
                }

            });

            formatForMobile();
            displayPosts();
        }

        initAuctionDictionary();
        updateAuctionInfo();
        displayAuctionInfo();

        handleFixedPositionTargets();
        spellingGrammerCorrections();

    });

    
    function spellingGrammerCorrections() {
        // TODO: Hardcoded string
        $('.classiadspro-author .author-content .author-link a').text('View All Listings');

    }


    function handleFixedPositionTargets() {

        var elem = $('.mph-fix-pos-target');
        var classToAdd = 'mph-pos-fixed-top';

        // var w = $( elem ).width();
        // $( elem ).css( "width", w );


        $(window).scroll(function() {

            // TODO: make top distance a plugin option
            if ($(document).scrollTop() > 150) {

                if( typeof handleFixedPositionTargets.widthSet == 'undefined' ) {
                    var w = $( elem ).parent().width();
                    $( elem ).css( "width", w );
                    handleFixedPositionTargets.widthSet = true;
                }

                $( elem ).addClass( classToAdd );
            } else {
                $ ( elem ).removeClass( classToAdd );
            }
        });
    }

    function initAuctionDictionary() {

        $('.mph-expiration-container').each( function(index, elem ){

            var postNumber = $( elem ).data('post');
            var expire = $( elem ).data('expire');
            var bid = $( elem ).data('bid');

            postDataDictionary.set( postNumber, {
                'id' : postNumber,
                'expire' : expire,
                'bid' : bid
            });


        });


    }

    function updateAuctionInfo() {

        var secondsCounter = 0;
        var updateTimer = setInterval( function(){
            getUpdatedPostData( secondsCounter++ );
        }, 1000);

    }

    function getUpdatedPostData( secondsCounter ) {

        var now = new Date().getTime();

        var closingAuctions = buckets.Dictionary();
        var notClosingAuctions = buckets.Dictionary();



        var postKeys = postDataDictionary.keys();
        for( let i = 0 ; i < postKeys.length ; i++ ) {

            var postData = postDataDictionary.get( postKeys[i] );
            var distance = ( postData.expire * 1000 )  - now;
            if ( distance < resetableTimerThreshold ) {
                closingAuctions.set( postData.id, postData  );
            }
            else {
                notClosingAuctions.set( postData.id, postData  );
            }
        }

        var postList = [] ;

        if ( closingAuctions.size() > 0 && secondsCounter % ( closingUpdatePostDataInterval / 1000 ) === 0 ) {
            getClosingAuctionsPostData(closingAuctions);
        }

        if ( notClosingAuctions.size() > 0 && secondsCounter % ( updatePostDataInterval  / 1000 ) === 0 ) {

            getNotClosingAuctionsPostData( notClosingAuctions );
        }
    }

    function updatePosts(  postList ) {
        for ( var i = 0; i < postList.length; i++ ) {

            var postData = {
                'id' : postList[i].id,
                'expire' : postList[i].expire,
                'bid' : postList[i].bid
            }

            postDataDictionary.set( postList[i].id, postData);

        }
    }

    function getClosingAuctionsPostData( auctions ) {
        // Send request for update here
        return getAuctionPostData( auctions );

    }

    function getNotClosingAuctionsPostData( auctions ) {
        // Send request for update here
        getAuctionPostData( auctions );
    }

    function getAuctionPostData ( auctions ) {


        var auctionData = [];
        var auctionKeys = auctions.keys();
        for ( var i = 0 ; i < auctionKeys.length  ; i++ ) {
            auctionData[ i ] = auctions.get( auctionKeys [ i ]);
        }

        $.ajax({
            url:  objectl10n.wpsiteinfo.site_url + '/wp-admin/admin-ajax.php',
            data:{
                'action':'mph_ajax',
                'fn':'get_auction_data',
                'documentURL' : document.URL,
                'auctions' : auctionData
            },
            dataType: 'JSON',
            success:function(data){

                stopSpinner();

                auctions = {};
                if ( data.errorData != null && data.errorData == 'true' ) {
                    reportError( data );
                    return;
                }
                // data is expected to be an array of proposals or false.
                if ( data !== false ) {


                    auctions  = data ;

                    if ( auctions.length == 0 ) {
                        // TODO; hardcode string
                        displayBottomMessage( 'No auctions retrieved.'  );
                        return;
                    }

                    updatePosts( auctions ) ;


                }
                else {
                    console.log('AJAX call to post_proposal returned false');
                }
            },
            error: function(errorThrown){
                stopSpinner();
                console.log( errorThrown.responseText.substring(0,500) );
            }

        });
    }

    function displayAuctionInfo() {


        $('.mph-expiration-container').each( function(index, elem ){

            var postNumber = $( elem ).data('post');

            var auction = postDataDictionary.get( postNumber );


            // Convert expiration time to milliseconds.
            // expire = auction.expire * 1000;
            // expirationTimers [ postNumber ] = setInterval(function( )

            var auctionTimer = setInterval( function() {
                // Get today's date and time
                var now = new Date().getTime();

                var postData = postDataDictionary.get(postNumber);
                var expire = postData.expire * 1000;

                // update current highest bid

                var bidAmountElem = '.current-bid-amt-' + postData.id;
                $(bidAmountElem).empty();

                // TODO: Currency hardcoded
                $(bidAmountElem).prepend('$' + postData.bid)



                // Find the distance between now and the count down date
                var distance = expire - now;


                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // TODO: hardcoded strings and date formats

                var secondsString = seconds;

                if (seconds < 10) {
                    secondsString = '0' + seconds;
                }

                var dateString = days + "d " + hours + "h " + minutes + "m " + secondsString + "s ";
                if (days > 0) {
                    dateString = days + ' days';
                } else if (hours > 0) {
                    dateString = hours + ':' + minutes + ':' + secondsString;
                } else if (minutes > 0) {
                    dateString = minutes + ':' + secondsString;
                } else {
                    dateString = secondsString + ' seconds';
                }


                $(elem).empty();
                $(elem).prepend( dateString) ;


                // If the count down is finished, display time ended.
                if (distance <= 0) {
                    // var interval = timerDictionary.get(postNumber);
                    clearInterval( auctionTimer );

                    // TODO: Hardcoded string. Pass with localization globals.
                    $( elem ).empty();
                    $(elem).prepend("Ended");
                }

            }, 1000);

            timerDictionary.set( postNumber, auctionTimer );


        });


    }


    function runAuctionTimers( index, elem, postNumber ) {

        // Get today's date and time
        var now = new Date().getTime();

        var postData = postDataDictionary.get(postNumber);
        var expire = postData.expire * 1000;

        // update current highest bid

        var bidAmountElem = '.current-bid-amt-' + postData.id;
        $(bidAmountElem).empty();

        // TODO: Currency hardcoded
        $(bidAmountElem).prepend('$' + postData.bid)



        // Find the distance between now and the count down date
        var distance = expire - now;


        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // TODO: hardcoded strings and date formats

        var secondsString = seconds;

        if (seconds < 10) {
            secondsString = '0' + seconds;
        }

        var dateString = days + "d " + hours + "h " + minutes + "m " + secondsString + "s ";
        if (days > 0) {
            dateString = days + ' days';
        } else if (hours > 0) {
            dateString = hours + ':' + minutes + ':' + secondsString;
        } else if (minutes > 0) {
            dateString = minutes + ':' + secondsString;
        } else {
            dateString = secondsString + ' seconds';
        }


        $(elem).empty();
        $(elem).prepend(dateString);


        // If the count down is finished, display time ended.
        if (distance <= 0) {
            clearInterval(timerDictionary.get(postNumber));

            // TODO: Hardcoded string. Pass with localization globals.
            $( elem ).empty();
            $(elem).prepend("Ended");
        }
    }


    function displayPosts() {

        /*
         * Setting currentOffset = 0 only all retrievals will download all of the proposals for the map.
         * Sending lastProposalRefresh will get only those from the last refresh. That
         * needs be combined with the ability to also get updated proposals. For now,
         * all proposals are refreshed (replaced) in order to update the local copies.
         */


        if ( retrievedPosts === false ) {
            showSpinner();
        }


        $.ajax({
            url:  objectl10n.wpsiteinfo.site_url + '/wp-admin/admin-ajax.php',
            data:{
                'action':'mph_ajax',
                'fn':'get_posts',
                'documentURL' : document.URL,
                'count' : count,
                'currentOffset' : currentOffset
            },
            dataType: 'JSON',
            success:function(data){

                stopSpinner();



                if ( data.errorData != null && data.errorData == 'true' ) {
                    reportError( data );
                    return;
                }
                // data is expected to be an array of proposals or false.
                if ( data !== false ) {



                    retrievedPosts = true;
                    // reset time of update
                    posts = data ;

                    if ( posts.length == 0 ) {
                        displayBottomMessage( objectl10n.no_more_posts_msg  );
                        noMorePosts = true;
                        return;
                    }

                    for ( let i = 0 ; i < posts.length ; i++ ) {

                        // Detect a new date

                        var postDate = new Date( posts[i].timestamp * 1000 );

                        var postDateString = getMonthName( postDate.getMonth() ) + ' ' + postDate.getDate() + ', ' + postDate.getFullYear();

                        if ( pgbdCurrentDateString != postDateString ) {
                            pgbdCurrentDateString = postDateString;
                            pgbdContainerSelector = 'pgbd-group-' + pgbdCurrentContainerNumber++;
                            var sectionContent = getDateSectionContent( pgbdContainerSelector, postDateString );
                            $('#pgbd-shortcode').append( sectionContent );
                        }

                        var post = posts[i];
                        var postContent = getPostContent( post );
                        $('#' + pgbdContainerSelector ).append( postContent );
                    }

                    currentOffset += count;

                }
                else {
                    console.log('AJAX call to post_proposal returned false');
                }
            },
            error: function(errorThrown){
                stopSpinner();
                console.log( errorThrown.responseText.substring(0,500) );
            }

        });


    }



    function getPostContent( post ) {

        var content = objectl10n.content_template;
        content = content.replace('__TITLE__', post.title );
        content = content.replace('__EXCERPT__', post.excerpt );
        content = content.replace( '__THUMBNAIL__', post.thumbnail );
        content = content.replace( '__URL__', post.url );

        return content;
    }

    function getDateSectionContent( selector, postDateString ) {

        var content = objectl10n.date_section_template;
        content = content.replace('__GROUP_SECTION_ID__', selector );
        content = content.replace('__GROUP_HEADING__', postDateString );

        return content;

    }


    function displayBottomMessage( message ) {

        $('#pgbd-bottom-msg').empty();
        $('#pgbd-bottom-msg').append('<p class="pgbd-msg">' + message  + '</p>');
    }


    function reportError( errorData ) {
        var errorString = objectl10n.server_error + errorData.errorMessage ;
        alert( errorString );
    }


    function getMonthName ( month ) {
        var monthStrings = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return monthStrings [ month ]

    }

    function showSpinner() {
        // spinner.spin( mapContainer );
    }

    function stopSpinner() {
        // spinner.stop();
    }



    function formatForMobile() {


    }

})( jQuery );
