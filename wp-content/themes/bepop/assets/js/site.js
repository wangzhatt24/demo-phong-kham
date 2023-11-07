(function ($) {
  'use strict';

  // iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
  var ua = window['navigator']['userAgent'] || window['navigator']['vendor'] || window['opera'];
  if( (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua) ){
      $('body').addClass('is-touch');
  }

  // start pjax
  var pjax = new Pjax({
    cacheBust: false,
    elements: 'a:not(.no-ajax):not(.sub-ajax):not(.ajax_add_to_cart):not(.remove):not(.comment-reply-link):not(#cancel-comment-reply-link), #header form',
    selectors: ['title', '#header', '#content', '#footer'],
    switches: {
      '#content': function(oldEl, newEl, options) {
        var that = this;
        $('html').addClass('page-animating');
        setTimeout(function(){
          oldEl.outerHTML = newEl.outerHTML;
          that.onSwitch();
          $('html').removeClass('page-animating');
        }, 600);
      }
    }
  });

  pjax._handleResponse = pjax.handleResponse;
  pjax.handleResponse = function(responseText, request, href) {
    if (request.responseText.match("<html")) {
      if(!responseText || (responseText && responseText.match(/class="site-content no-ajax/)) ){
        window.location.href = href;
        return;
      }
      pjax._handleResponse(responseText, request, href);
      var is_app = $('body').hasClass('layout-app');
      var classNames = responseText.match(/body([^>]*)class=['|"]([^'|"]*)['|"]/);
      if(classNames){
        setTimeout(function(){
          $('body').attr('class', classNames[2]+(is_app ? ' layout-app' : ''));
        }, 600);
      }
    } else {
      window.location.href = href;
    }
  }

  var sub_pjax = new Pjax({
    cacheBust: false,
    elements: 'a.sub-ajax',
    selectors: ['.sub-content', '.page-header, .navigation']
  });
  
  $(document).on('refresh', function() {
    pjax.refresh();
    sub_pjax.refresh();
  });

  $(document).on('reload', function(event, url) {
    pjax.loadUrl( (event && event.detail && event.detail.url) || url || window.location.href );
  });
  
  // ajax send
  $(document).on('pjax:send', function() {
    $('html').addClass('page-loading');
  });
  // ajax success
  $(document).on('pjax:complete', function() {
    $('#menu-state').prop('checked', false);
    $('#search-state').prop('checked', false);
    $('.modal-backdrop').remove();
    $('html').removeClass('page-loading scrolled');
    $(document).trigger('refresh');
  });

  // no-ajax
  $(document).on('click', '.no-ajax > a:not(.no-ajax)', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var href = $(this).attr('href') ? $(this).attr('href') : $(this).find('a').attr('href');
    window.location = href;
    return false;
  });
  
  // mouse scrolled
  var scroll = function(){
    var $scroll = $('html');
    var top = $(window).scrollTop();
    if(top == 0){
      $scroll.removeClass('scrolled');
    }else{
      $scroll.addClass('scrolled');
    }

    var p = 50;
    var obj = $('.entry:not(.hide-title) .entry-header-container .post-thumbnail img');
    if(obj.length == 0) return;
    var h = obj.closest('.post-thumbnail').height();
    if(h == 0) return;
    var pos = parseFloat(obj.attr('data-pos-y'));
    if(!isNaN( pos ) ) p = pos;
    p = Math.min(top/h*100 + p, 100);
    if(p < 100){obj.attr('style', 'object-position: 50% ' + p +'%' );}
  };

  $(document).on('scroll', debounce(scroll, 10));

  function debounce(func, wait, immediate) {
    var timeout, result;

    return function() {
      var context = this, args = arguments, later, callNow;

      later = function() {
        timeout = null;
        if (!immediate) { result = func.apply(context, args); }
      };

      callNow = immediate && !timeout;

      clearTimeout(timeout);
      timeout = setTimeout(later, wait);

      if (callNow) { result = func.apply(context, args); }

      return result;
    };
  };

})(jQuery);
