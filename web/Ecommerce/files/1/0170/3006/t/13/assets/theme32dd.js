(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.Utilities = (function($) {
    var _locationHash, _locationSearch, _newState, _replaceState, _urlParam, arraysEqual, config, delay, getParam, msieVersion, onAjaxError, removeProtocol, screenSize, setParam, switchElement;
    config = Station.App.config;
    $.fn.randomize = function(selector) {
      return (selector ? this.find(selector) : this).parent().each(function() {
        return $(this).children(selector).sort(function() {
          return Math.random() - 0.5;
        });
      });
    };
    $.fn.randomizeInPlace = function(selector) {
      return (selector ? this.find(selector) : this).parent().each(function() {
        return $(this).children(selector).sort(function() {
          return Math.random() - 0.5;
        }).detach().appendTo(this);
      });
    };
    arraysEqual = function(a, b) {
      if (!(typeof a === 'object' && typeof b === 'object')) {
        return;
      }
      return a.length === b.length && a.every(function(elem, i) {
        return elem === b[i];
      });
    };
    delay = function(ms, func) {
      return setTimeout(func, ms);
    };
    getParam = function(param) {
      var m, pattern;
      pattern = new RegExp('[?&]' + param + '((=([^&]*))|(?=(&|$)))', 'i');
      m = window.location.search.match(pattern);
      return m && (typeof m[3] === 'undefined' ? '' : m[3]);
    };
    msieVersion = function() {
      var msie, ua;
      ua = window.navigator.userAgent;
      msie = ua.indexOf('MSIE ');
      if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)));
      }
      return false;
    };
    onAjaxError = function(XMLHttpRequest, textStatus, showError, message) {
      var response, responseMessage;
      response = $.parseJSON(XMLHttpRequest.responseText);
      responseMessage = response.message + ': ' + response.description;
      message || (message = responseMessage);
      console.log(textStatus);
      return console.log(response);
    };
    removeProtocol = function(e) {
      return e.replace(/http(s)?:/, '');
    };
    screenSize = function() {
      var queryMedium, querySmall;
      querySmall = 'screen and (max-width: ' + config.mediumScreen + 'px)';
      queryMedium = 'screen and (min-width: ' + config.mediumScreen + 'px) and (max-width: ' + config.largeScreen + 'px)';
      if (window.matchMedia(querySmall).matches) {
        return 'small';
      } else if (window.matchMedia(queryMedium).matches) {
        return 'medium';
      } else {
        return 'large';
      }
    };
    setParam = function(e, t) {
      if (window.history && window.history.replaceState) {
        _replaceState(_newState(e, t));
      }
    };
    switchElement = function(hide, show, addClass) {
      var $show;
      if (!($show = $(show))) {
        return;
      }
      $(hide).hide();
      $show.addClass(addClass).show();
    };
    _locationSearch = function() {
      return window.location.search;
    };
    _locationHash = function() {
      return window.location.hash;
    };
    _newState = function(e, t) {
      var n;
      n = void 0;
      n = _urlParam(e) ? _locationSearch().replace(RegExp('(' + e + '=)[^&#]+'), '$1' + t) : '' === _locationSearch() ? '?' + e + '=' + t : _locationSearch() + '&' + e + '=' + t;
      return n + _locationHash();
    };
    _replaceState = function(e) {
      window.history.replaceState({}, document.title, e);
    };
    _urlParam = function(e) {
      var t;
      t = RegExp('[?&]' + e + '=([^&#]*)').exec(_locationSearch());
      return t && decodeURIComponent(t[1].replace(/\+/g, ' '));
    };
    $('[data-target-new]').attr('target', '_blank');
    $('[data-click-history-back]').on('click', function() {
      window.history.back();
      return false;
    });
    $('[data-auto-focus]').focus();
    $('form:not([html-validate])').attr('novalidate', '');
    return {
      arraysEqual: arraysEqual,
      delay: delay,
      getParam: getParam,
      msieVersion: msieVersion,
      onAjaxError: onAjaxError,
      removeProtocol: removeProtocol,
      screenSize: screenSize,
      setParam: setParam,
      switchElement: switchElement
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral.Vendor = Station.GrandCentral.Vendor || {};

  Station.GrandCentral.Vendor.Flickity = (function($) {
    var cache, cacheElements, config, init, initCarousel, initCarousels, selectors;
    selectors = {
      attr: {
        options: 'data-flickity-options'
      },
      carousel: '.gc-carousel'
    };
    config = {
      defaultOptions: {
        arrowShape: 'M65.0491632,29.3794051 C66.0536287,28.3749397 66.0536287,26.7677949 65.0491632,25.7633294 L58.3795124,19.0936786 C57.3750469,18.0892131 55.7679022,18.0892131 54.7634367,19.0936786 L24.9509011,48.9062141 C23.9464357,49.9106796 23.9464357,51.5178244 24.9509011,52.5222899 L54.7634367,82.3348254 C55.7679022,83.3392909 57.3750469,83.3392909 58.3795124,82.3348254 L65.0491632,75.6651746 C66.0536287,74.6607091 66.0536287,73.0535643 65.0491632,72.0490989 L43.7143164,50.714252 L65.0491632,29.3794051 Z',
        autoPlay: 5000,
        cellAlign: 'center',
        cellSelector: '.gc-carousel-cell',
        contain: true,
        draggable: true,
        freeScroll: false,
        freeScrollFriction: 0.03,
        friction: 0.28,
        initialIndex: 0,
        lazyLoad: 1,
        pauseAutoPlayOnHover: true,
        pageDots: true,
        prevNextButtons: true,
        selectedAttraction: 0.025,
        wrapAround: true
      }
    };
    cache = {};
    init = function() {
      cacheElements();
      initCarousels();
    };
    cacheElements = function() {
      cache = {
        $carousels: $(selectors.carousel)
      };
    };
    initCarousels = function() {
      if (cache.$carousels.length) {
        cache.$carousels.each(function() {
          return initCarousel($(this));
        });
      }
    };
    initCarousel = function($carousel, options) {
      var inlineOptions;
      if (options == null) {
        options = {};
      }
      inlineOptions = $carousel.attr('data-flickity-options');
      if (inlineOptions) {
        inlineOptions = JSON.parse(inlineOptions);
      }
      options = $.extend(config.defaultOptions, inlineOptions, options);
      $carousel.flickity(options);
    };
    $(function() {
      init();
    });
    return {
      init: init,
      cacheElements: cacheElements,
      initCarousel: initCarousel,
      initCarousels: initCarousels
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.Accordions = (function($) {
    var accordionSelector, closePanels, init, openPanel;
    accordionSelector = '.accordion';
    closePanels = function($accordion, animated) {
      var $openPanels;
      if (animated == null) {
        animated = true;
      }
      $openPanels = $('>dt.open', $accordion);
      if (animated) {
        $openPanels.removeClass('open').next('dd').velocity('slideUp', {
          duration: 400,
          easing: 'easeOutQuint',
          queue: false,
          complete: function() {
            return $accordion.data('locked', false);
          }
        });
      } else {
        $openPanels.removeClass('open').next('dd').hide();
      }
      return false;
    };
    openPanel = function($panel, animated) {
      var $accordion;
      if (animated == null) {
        animated = true;
      }
      $accordion = $panel.closest(accordionSelector);
      $panel.addClass('open');
      if (animated) {
        $panel.addClass('open').next('dd').velocity('slideDown', {
          duration: 400,
          easing: 'easeOutQuint',
          queue: false,
          complete: function() {
            return $accordion.data('locked', false);
          }
        });
      } else {
        $panel.next('dd').show();
      }
      return false;
    };
    init = function() {
      $(accordionSelector).each(function(i) {
        var $openPanels, $panels, self;
        self = this;
        $panels = $('>dt', this);
        $openPanels = $panels.filter('.open');
        $(this).data('locked', false);
        if ($openPanels.length) {
          $openPanels.each(function() {
            return openPanel($(this), false);
          });
        }
        return $panels.each(function() {
          var $panel;
          $panel = $(this).closest('dt');
          return $('>a', this).on('click', function(e) {
            e.preventDefault();
            if (!$(self).data('locked')) {
              $(self).data('locked', true);
              if ($panel.hasClass('open')) {
                closePanels($(self));
              } else {
                closePanels($(self));
                openPanel($panel);
              }
            }
            return false;
          });
        });
      });
      return false;
    };
    $(document).ready(function() {
      return init();
    });
    return {
      init: init,
      closePanels: closePanels,
      openPanel: openPanel
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.AudioPlayer = (function($) {
    var canPlayType, eCancel, eEnd, eMove, eStart, isTouch, secondsToTime;
    isTouch = 'ontouchstart' in window;
    eStart = isTouch ? 'touchstart' : 'mousedown';
    eMove = isTouch ? 'touchmove' : 'mousemove';
    eEnd = isTouch ? 'touchend' : 'mouseup';
    eCancel = isTouch ? 'touchcancel' : 'mouseup';
    canPlayType = function(file) {
      var audioElement;
      audioElement = document.createElement('audio');
      return !!(audioElement.canPlayType && audioElement.canPlayType('audio/' + file.split('.').pop().toLowerCase() + ';').replace(/no/, ""));
    };
    secondsToTime = function(secs) {
      var hours, hoursDiv, minutes, minutesDiv, seconds;
      hoursDiv = secs / 3600;
      hours = Math.floor(hoursDiv);
      minutesDiv = secs % 3600 / 60;
      minutes = Math.floor(minutesDiv);
      seconds = Math.ceil(secs % 3600 % 60);
      if (seconds > 59) {
        seconds = 0;
        minutes = Math.ceil(minutesDiv);
      }
      if (minutes > 59) {
        minutes = 0;
        hours = Math.ceil(hoursDiv);
      }
      return (hours === 0 ? "" : (hours > 0 && hours.toString().length < 2 ? "0" + hours + ":" : hours + ":")) + (minutes.toString().length < 2 ? "0" + minutes : minutes) + ":" + (seconds.toString().length < 2 ? "0" + seconds : seconds);
    };
    $.fn.audioPlayer = function(params) {
      var cssClass, cssClassSub, subName;
      params = $.extend({
        classPrefix: 'audioplayer',
        strPlay: 'Play',
        strPause: 'Pause',
        strVolume: 'Volume'
      }, params);
      cssClass = {};
      cssClassSub = {
        playPause: 'playpause',
        playing: 'playing',
        stopped: 'stopped',
        time: 'time',
        timeCurrent: 'time-current',
        timeDuration: 'time-duration',
        bar: 'bar',
        barLoaded: 'bar-loaded',
        barPlayed: 'bar-played',
        volume: 'volume',
        volumeButton: 'volume-button',
        volumeAdjust: 'volume-adjust',
        noVolume: 'novolume',
        muted: 'muted',
        mini: 'mini'
      };
      for (subName in cssClassSub) {
        cssClass[subName] = params.classPrefix + '-' + cssClassSub[subName];
      }
      return this.each(function() {
        var $this, adjustCurrentTime, adjustVolume, audioFile, audioTag, barLoaded, barPlayed, isAutoPlay, isLoop, isSupport, theAudio, theBar, thePlayer, timeCurrent, timeDuration, updateLoadBar, volumeAdjuster, volumeButton, volumeDefault, volumeTestDefault, volumeTestValue;
        if ($(this).prop('tagName').toLowerCase() !== 'audio') {
          return false;
        }
        $this = $(this);
        audioFile = $this.attr('src');
        isSupport = false;
        isAutoPlay = $this.get(0).getAttribute('autoplay');
        isAutoPlay = (isAutoPlay === "" || isAutoPlay === 'autoplay' ? true : false);
        isLoop = $this.get(0).getAttribute('loop');
        isLoop = (isLoop === "" || isLoop === 'loop' ? true : false);
        if (typeof audioFile === 'undefined') {
          $('source', $this).each(function() {
            audioFile = $(this).attr('src');
            if (typeof audioFile !== 'undefined' && canPlayType(audioFile)) {
              isSupport = true;
              return false;
            }
          });
        } else {
          if (canPlayType(audioFile)) {
            isSupport = true;
          }
        }
        thePlayer = $('<div class="not-fitvid ' + params.classPrefix + '">' + (isSupport ? $('<div>').append($this.eq(0).clone()).html() : '<embed src="' + audioFile + '" width=0 height=0 volume=100 autostart="' + isAutoPlay.toString() + '" type="audio/mpeg" loop="' + isLoop.toString() + '" />') + '<div class="' + cssClass.playPause + '" title="' + params.strPlay + '"><a href="#">"' + params.strPlay + '"</a></div></div>');
        audioTag = isSupport ? 'audio' : 'embed';
        theAudio = $(audioTag, thePlayer).get(0);
        if (isSupport) {
          adjustCurrentTime = function(e) {
            var theRealEvent;
            theRealEvent = (isTouch ? e.originalEvent.touches[0] : e);
            theAudio.currentTime = Math.round((theAudio.duration * (theRealEvent.pageX - theBar.offset().left)) / theBar.width());
          };
          adjustVolume = function(e) {
            var theRealEvent;
            theRealEvent = (isTouch ? e.originalEvent.touches[0] : e);
            theAudio.volume = Math.abs((theRealEvent.pageY - (volumeAdjuster.offset().top + volumeAdjuster.height())) / volumeAdjuster.height());
          };
          updateLoadBar = function() {
            var interval;
            interval = setInterval(function() {
              if (theAudio.buffered.length < 1) {
                return true;
              }
              barLoaded.width((theAudio.buffered.end(0) / theAudio.duration) * 100 + "%");
              if (Math.floor(theAudio.buffered.end(0)) >= Math.floor(theAudio.duration)) {
                clearInterval(interval);
              }
            }, 100);
          };
          volumeDefault = 0;
          $('audio', thePlayer).css({
            width: 0,
            height: 0,
            visibility: 'hidden'
          });
          thePlayer.append('<div class="' + cssClass.time + ' ' + cssClass.timeCurrent + '"></div><div class="' + cssClass.bar + '"><div class="' + cssClass.barLoaded + '"></div><div class="' + cssClass.barPlayed + '"></div></div><div class="' + cssClass.time + ' ' + cssClass.timeDuration + '"></div><div class="' + cssClass.volume + '"><div class="' + cssClass.volumeButton + '" title="' + params.strVolume + '"><a href="#">"' + params.strVolume + '"</a></div><div class="' + cssClass.volumeAdjust + '"><div><div></div></div></div></div>');
          theBar = $('.' + cssClass.bar, thePlayer);
          barPlayed = $('.' + cssClass.barPlayed, thePlayer);
          barLoaded = $('.' + cssClass.barLoaded, thePlayer);
          timeCurrent = $('.' + cssClass.timeCurrent, thePlayer);
          timeDuration = $('.' + cssClass.timeDuration, thePlayer);
          volumeButton = $('.' + cssClass.volumeButton, thePlayer);
          volumeAdjuster = $('.' + cssClass.volumeAdjust + ' > div', thePlayer);
          volumeTestDefault = theAudio.volume;
          volumeTestValue = theAudio.volume = 0.111;
          if (Math.round(theAudio.volume * 1000) / 1000 === volumeTestValue) {
            theAudio.volume = volumeTestDefault;
          } else {
            thePlayer.addClass(cssClass.noVolume);
          }
          timeDuration.html('&hellip;');
          timeCurrent.html(secondsToTime(0));
          theAudio.addEventListener('loadeddata', function() {
            updateLoadBar();
            timeDuration.html(($.isNumeric(theAudio.duration) ? secondsToTime(theAudio.duration) : '&hellip;'));
            volumeAdjuster.find('div').height(theAudio.volume * 100 + '%');
            volumeDefault = theAudio.volume;
          });
          theAudio.addEventListener('timeupdate', function() {
            timeCurrent.html(secondsToTime(theAudio.currentTime));
            barPlayed.width((theAudio.currentTime / theAudio.duration) * 100 + '%');
          });
          theAudio.addEventListener('volumechange', function() {
            volumeAdjuster.find('div').height(theAudio.volume * 100 + '%');
            if (theAudio.volume > 0 && thePlayer.hasClass(cssClass.muted)) {
              thePlayer.removeClass(cssClass.muted);
            }
            if (theAudio.volume <= 0 && !thePlayer.hasClass(cssClass.muted)) {
              thePlayer.addClass(cssClass.muted);
            }
          });
          theAudio.addEventListener('ended', function() {
            thePlayer.removeClass(cssClass.playing).addClass(cssClass.stopped);
          });
          theBar.on(eStart, function(e) {
            adjustCurrentTime(e);
            theBar.on(eMove, function(e) {
              adjustCurrentTime(e);
            });
          }).on(eCancel, function() {
            theBar.unbind(eMove);
          });
          volumeButton.on('click', function() {
            if (thePlayer.hasClass(cssClass.muted)) {
              thePlayer.removeClass(cssClass.muted);
              theAudio.volume = volumeDefault;
            } else {
              thePlayer.addClass(cssClass.muted);
              volumeDefault = theAudio.volume;
              theAudio.volume = 0;
            }
            return false;
          });
          volumeAdjuster.on(eStart, function(e) {
            adjustVolume(e);
            volumeAdjuster.on(eMove, function(e) {
              adjustVolume(e);
            });
          }).on(eCancel, function() {
            volumeAdjuster.unbind(eMove);
          });
        } else {
          thePlayer.addClass(cssClass.mini);
        }
        thePlayer.addClass(isAutoPlay ? cssClass.playing : cssClass.stopped);
        $('.' + cssClass.playPause, thePlayer).on('click', function() {
          if (thePlayer.hasClass(cssClass.playing)) {
            $(this).attr('title', params.strPlay).find('a').html(params.strPlay);
            thePlayer.removeClass(cssClass.playing).addClass(cssClass.stopped);
            if (isSupport) {
              theAudio.pause();
            } else {
              theAudio.Stop();
            }
          } else {
            $(this).attr('title', params.strPause).find('a').html(params.strPause);
            thePlayer.addClass(cssClass.playing).removeClass(cssClass.stopped);
            if (isSupport) {
              theAudio.play();
            } else {
              theAudio.Play();
            }
          }
          return false;
        });
        $this.replaceWith(thePlayer);
      });
    };
    return $(document).ready(function() {
      return $('audio').audioPlayer();
    });
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.Notify = (function($) {
    var $nb, close, easingIn, easingOut, init, nbTimeout, notifyBarHTML, open, pauseDuration, timerClass, transitionSpeed;
    easingIn = 'easeOutCirc';
    easingOut = 'easeInExpo';
    nbTimeout = '';
    notifyBarHTML = '<div id="notify-bar"><div class="message"></div><a href="#" class="close" data-close>&times;</div>';
    pauseDuration = 6000;
    timerClass = 'timer';
    transitionSpeed = 300;
    $nb = {};
    init = function() {
      $('body').prepend(notifyBarHTML);
      $nb = $('#notify-bar');
      return $nb.hide();
    };
    close = function() {
      var inline;
      inline = $nb.hasClass('inline');
      if (inline) {
        return $nb.velocity({
          'margin-top': -$nb.outerHeight()
        }, {
          duration: transitionSpeed / 1.5,
          easing: easingOut,
          queue: false,
          complete: function() {
            return $nb.hide().find('.message').html('');
          }
        });
      } else {
        return $nb.velocity({
          translateY: '-100%'
        }, {
          duration: transitionSpeed / 1.5,
          easing: easingOut,
          queue: false,
          complete: function() {
            clearTimeout(nbTimeout);
            return $nb.removeAttr('style').hide().find('.message').html('');
          }
        });
      }
    };
    open = function(message, type, duration, sticky, inline, showTime) {
      type || (type = 'slate');
      duration || (duration = pauseDuration);
      sticky || (sticky = false);
      inline || (inline = false);
      showTime || (showTime = false);
      clearTimeout(nbTimeout);
      $('.message', $nb).html(message);
      $('.' + timerClass, $nb).remove();
      $nb.removeClass('inline').removeAttr('style').attr('class', type);
      $('a[data-close]', $nb).on('click', function(e) {
        e.preventDefault();
        return close();
      });
      if (inline) {
        $nb.addClass('inline').show().velocity({
          'margin-top': [0, -$nb.outerHeight()]
        }, {
          duration: transitionSpeed,
          easing: easingIn,
          queue: false
        });
      } else {
        $nb.show().velocity({
          translateY: [0, '-100%']
        }, {
          duration: transitionSpeed,
          easing: easingIn,
          queue: false
        });
      }
      if (!sticky) {
        nbTimeout = setTimeout(close, duration);
        if (showTime) {
          return $('<div>').addClass(timerClass).prependTo($nb).velocity({
            width: ['100%', 0]
          }, {
            duration: duration,
            easing: 'linear',
            queue: false
          });
        }
      }
    };
    $(document).ready(function() {
      return init();
    });
    $(document).on('keydown', function(e) {
      if (e.keyCode === 27) {
        close();
      }
    });
    return {
      init: init,
      close: close,
      open: open
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.NavPrimary = (function($) {
    var activeClass, closeNode, defaults, init, levelClass, navPrimarySelector, navToggleSelector, nodeClass, openClass, openNode, reset;
    activeClass = 'nav-active';
    levelClass = 'nav-level';
    navPrimarySelector = '.nav-primary';
    navToggleSelector = '.nav-toggle';
    nodeClass = 'nav-node';
    openClass = 'nav-open';
    defaults = {
      easing: 'easeOutCirc',
      nodeTransitionDuration: 300
    };
    closeNode = function($node) {
      $node.closest('li').removeClass(openClass).end().velocity('stop').velocity({
        height: 0
      }, {
        display: 'none',
        duration: defaults.nodeTransitionDuration,
        easing: defaults.easing,
        queue: false
      });
    };
    openNode = function($node) {
      $node.closest('li').addClass(openClass).end().css({
        'height': 'auto'
      }).velocity('stop').velocity({
        height: [$node.outerHeight(), 0]
      }, {
        display: 'block',
        duration: defaults.nodeTransitionDuration,
        easing: defaults.easing,
        queue: false,
        complete: function() {
          $(this).css('height', 'auto');
        }
      });
    };
    reset = function() {
      $(navPrimarySelector).each(function() {
        $('ul', this).removeAttr('style');
        return $('.' + openClass, this).removeClass(openClass);
      });
    };
    init = function() {
      $(navPrimarySelector).each(function() {
        var $nodes, $rootNode, $toggleSelector, navID, self;
        self = this;
        navID = $(this).data('nav-id');
        $nodes = $('ul', this);
        $rootNode = $('> ul', this).first();
        $toggleSelector = $(navToggleSelector + "[data-nav-id='" + navID + "']");
        $nodes.each(function() {
          var level, node;
          node = this;
          level = parseInt($(this).parentsUntil(self, 'ul').length + 1);
          return $(this).addClass(levelClass + '-' + level).closest('li').addClass(nodeClass).attr('aria-haspopup', true).children(':first-child').on('mouseover', function(e) {
            return e.stopPropagation();
          }).on('click', function(e) {
            var isEmptyLink, isOpen;
            isEmptyLink = $(this).attr('href') === '' || $(this).attr('href') === '#';
            isOpen = $(node).closest('li').hasClass(openClass);
            if ('ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch) {
              if ($(this).data('nav-item-touched') !== true) {
                e.preventDefault();
                $(this).data('nav-item-touched', true);
                openNode($(node));
              } else {
                if (isEmptyLink || !isOpen) {
                  e.preventDefault();
                  $(this).data('nav-item-touched', false);
                  closeNode($(node));
                }
              }
            } else if (Station.GrandCentral.Utilities.screenSize() === 'small') {
              if (isEmptyLink) {
                e.preventDefault();
                if (isOpen) {
                  closeNode($(node));
                } else {
                  openNode($(node));
                }
              } else {
                if ($(this).data('nav-item-touched') !== true) {
                  e.preventDefault();
                  $(this).data('nav-item-touched', true);
                  openNode($(node));
                } else {
                  if (isEmptyLink || !isOpen) {
                    e.preventDefault();
                    $(this).data('nav-item-touched', false);
                    closeNode($(node));
                  }
                }
              }
            }
          });
        });
        $toggleSelector.on('click', function(e) {
          if ($rootNode.hasClass(openClass)) {
            $(this).removeClass(openClass);
            $rootNode.removeClass(openClass);
            return closeNode($rootNode);
          } else {
            $(this).addClass(openClass);
            $rootNode.addClass(openClass);
            return openNode($rootNode);
          }
        });
      });
    };
    $(document).ready(function() {
      var windowWidth;
      windowWidth = $(window).width();
      init();
      return $(window).on('resize', function() {
        if ($(window).width() !== windowWidth) {
          windowWidth = $(window).width();
          return reset();
        }
      });
    });
    return {
      init: init,
      closeNode: closeNode,
      openNode: openNode,
      reset: reset
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.NavSide = (function($) {
    var activeClass, closeKinNodes, closeNode, defaults, init, levelClass, navSideSelector, nodeClass, openClass, openNode, toggleNode;
    activeClass = 'nav-active';
    levelClass = 'nav-level';
    navSideSelector = '.nav-side';
    nodeClass = 'nav-node';
    openClass = 'nav-open';
    defaults = {
      closeKin: false,
      easingKin: 'easeInOutCirc',
      easing: 'easeOutCirc',
      nodeTransitionDuration: 300
    };
    closeKinNodes = function($node) {
      var $nodesToClose, duration;
      duration = $node.closest(navSideSelector).data('node-transition-duration');
      duration || defaults.nodeTransitionDuration;
      $nodesToClose = $node.closest('li').siblings('.' + openClass).find('ul');
      $nodesToClose.each(function() {
        closeNode($(this), duration, true);
      });
    };
    closeNode = function($node, nodeTransitionDuration, closeKin) {
      nodeTransitionDuration = typeof nodeTransitionDuration !== 'undefined' ? nodeTransitionDuration : defaults.nodeTransitionDuration;
      $node.closest('li').removeClass(openClass);
      if (nodeTransitionDuration > 0) {
        $node.velocity('stop').velocity({
          height: 0
        }, {
          display: 'none',
          duration: nodeTransitionDuration,
          easing: closeKin ? defaults.easingKin : defaults.easing,
          queue: false
        });
      } else {
        $node.css({
          'height': 0
        }).hide();
      }
    };
    openNode = function($node, nodeTransitionDuration, closeKin) {
      nodeTransitionDuration = typeof nodeTransitionDuration !== 'undefined' ? nodeTransitionDuration : defaults.nodeTransitionDuration;
      closeKin = typeof closeKin !== 'undefined' ? closeKin : defaults.closeKin;
      $node.closest('li').addClass(openClass).end().css({
        'height': 'auto'
      });
      if (nodeTransitionDuration > 0) {
        $node.velocity('stop').velocity({
          height: [$node.outerHeight(), 0]
        }, {
          display: 'block',
          duration: nodeTransitionDuration,
          easing: closeKin ? defaults.easingKin : defaults.easing,
          queue: false,
          complete: function() {
            $(this).css('height', 'auto');
          }
        });
      } else {
        $node.show();
      }
      if (closeKin) {
        closeKinNodes($node);
      }
    };
    toggleNode = function($node, nodeTransitionDuration, closeKin) {
      nodeTransitionDuration = typeof nodeTransitionDuration !== 'undefined' ? nodeTransitionDuration : defaults.nodeTransitionDuration;
      closeKin = typeof closeKin !== 'undefined' ? closeKin : defaults.closeKin;
      if ($node.closest('li').hasClass(openClass)) {
        closeNode($node, nodeTransitionDuration, closeKin);
      } else {
        openNode($node, nodeTransitionDuration, closeKin);
      }
    };
    init = function() {
      return $(navSideSelector).each(function() {
        var $nodes, closeKin, expanded, nodeTransitionDuration, rootNode;
        rootNode = this;
        closeKin = $(this).data('close-kin');
        expanded = $(this).data('expanded');
        nodeTransitionDuration = $(this).data('node-transition-duration');
        $nodes = $('ul', this);
        $(this).addClass(levelClass + '-' + 1);
        $nodes.each(function() {
          var $openNodes, level, node;
          node = this;
          level = parseInt($(this).parentsUntil(rootNode, 'ul').length + 2);
          $(this).addClass(levelClass + '-' + level);
          if (expanded) {
            $(this).closest('li').addClass(openClass).end().css({
              height: 'auto',
              display: 'block'
            });
          }
          $(this).closest('li').addClass(nodeClass).children(':first-child').on('click', function(e) {
            var isEmptyLink, isOpen;
            isEmptyLink = $(this).attr('href') === '' || $(this).attr('href') === '#';
            isOpen = $(node).closest('li').hasClass(openClass);
            if ('ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch) {
              if ($(this).data('nav-item-touched') !== true) {
                e.preventDefault();
                $(this).data('nav-item-touched', true);
                toggleNode($(node), nodeTransitionDuration, closeKin);
              } else {
                if (isOpen && isEmptyLink) {
                  e.preventDefault();
                  $(this).data('nav-item-touched', false);
                  toggleNode($(node), nodeTransitionDuration, closeKin);
                }
              }
            } else {
              if (isEmptyLink || !isOpen) {
                e.preventDefault();
                toggleNode($(node), nodeTransitionDuration, closeKin);
              }
            }
          });
          if ($(this).closest('li').hasClass(openClass)) {
            $openNodes = $(node).parentsUntil(rootNode, 'ul');
            $openNodes.push($(node));
            return $openNodes.each(function() {
              return openNode($(this), 0, false);
            });
          }
        });
      });
    };
    $(document).ready(function() {
      return init();
    });
    return {
      init: init,
      closeNode: closeNode,
      openNode: openNode,
      toggleNode: toggleNode
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral = Station.GrandCentral || {};

  Station.GrandCentral.Tabs = (function($) {
    var closeTabs, init, openClass, openTab, tabLinkSelector, tabSelector, tabsSelector;
    openClass = 'open';
    tabsSelector = '.tabs';
    tabSelector = '.tab';
    tabLinkSelector = '.tab-title';
    openTab = function($tab) {
      if (!$tab.hasClass(openClass)) {
        return $tab.addClass(openClass);
      }
    };
    closeTabs = function(tabs) {
      var $openTabs;
      $openTabs = $(tabSelector + '.' + openClass, tabs);
      return $openTabs.removeClass(openClass);
    };
    init = function() {
      return $(tabsSelector).each(function(i) {
        var $openTab, self;
        self = this;
        $openTab = $(tabSelector + '.' + openClass, this);
        if (!$openTab.length) {
          openTab($(tabSelector, this).first(), false);
        }
        return $(this).on('click', tabLinkSelector, function(e) {
          var $tab;
          $tab = $(this).closest(tabSelector);
          e.preventDefault();
          if (!$tab.hasClass(openClass)) {
            closeTabs(self);
            return openTab($tab);
          }
        });
      });
    };
    $(document).ready(function() {
      return init();
    });
    return {
      init: init,
      closeTabs: closeTabs,
      openTab: openTab
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.GrandCentral.Vendor = Station.GrandCentral.Vendor || {};

  Station.GrandCentral.Vendor.FancyBox = (function($) {
    var buildCustomTransitions, init, setDefaults;
    buildCustomTransitions = function(F) {
      F.transitions.grandCentralIn = function() {
        var tDistance;
        tDistance = 20;
        F.wrap.velocity({
          opacity: [1, 0],
          translateY: [0, -tDistance]
        }, {
          duration: F.current.openSpeed,
          easing: F.current.openEasing,
          complete: F._afterZoomIn
        });
      };
      F.transitions.grandCentralOut = function() {
        var tDistance;
        tDistance = 20;
        F.wrap.removeClass('fancybox-opened').velocity({
          opacity: 0,
          translateY: -tDistance
        }, {
          duration: F.current.closeSpeed,
          easing: F.current.closeEasing,
          complete: function() {
            return F._afterZoomOut();
          }
        });
      };
      F.transitions.grandCentralChangeIn = function() {
        var direction, tDistance, tX, tY;
        direction = F.direction;
        tDistance = 60;
        if (direction === 'left') {
          tX = [0, tDistance];
          tY = 0;
        }
        if (direction === 'right') {
          tX = [0, -tDistance];
          tY = 0;
        }
        if (direction === 'up') {
          tX = 0;
          tY = [0, tDistance];
        }
        if (direction === 'down') {
          tX = 0;
          tY = [0, -tDistance];
        }
        F.wrap.velocity({
          opacity: [1, 0],
          translateX: tX,
          translateY: tY
        }, {
          duration: F.current.nextSpeed,
          easing: F.current.nextEasing,
          complete: F._afterZoomIn
        });
      };
      F.transitions.grandCentralChangeOut = function() {
        var direction, tDistance, tX, tY;
        direction = F.direction;
        tDistance = 60;
        if (direction === 'left') {
          tX = -tDistance;
          tY = 0;
        }
        if (direction === 'right') {
          tX = tDistance;
          tY = 0;
        }
        if (direction === 'up') {
          tX = 0;
          tY = -tDistance;
        }
        if (direction === 'down') {
          tX = 0;
          tY = tDistance;
        }
        F.previous.wrap.velocity({
          opacity: 0,
          translateX: tX,
          translateY: tY
        }, {
          duration: F.current.prevSpeed,
          easing: F.previous.easing,
          complete: function() {
            return $(this).trigger('onReset').remove();
          }
        });
      };
    };
    setDefaults = function() {
      return $.extend($.fancybox.defaults, {
        closeBtn: false,
        closeEasing: 'easeInCirc',
        closeMethod: 'grandCentralOut',
        closeSpeed: 200,
        nextEasing: 'easeInOutCirc',
        nextMethod: 'grandCentralChangeIn',
        nextSpeed: 300,
        openEasing: 'easeOutCirc',
        openMethod: 'grandCentralIn',
        openSpeed: 500,
        padding: 0,
        prevEasing: 'easeInOutCirc',
        prevMethod: 'grandCentralChangeOut',
        prevSpeed: 300,
        wrapCSS: 'fancybox-grand-central',
        helpers: {
          overlay: {
            css: {
              background: 'rgba(255, 255, 255, 0.94)'
            }
          },
          title: {
            type: 'inside'
          },
          media: {}
        },
        beforeLoad: function() {
          var height, width;
          height = parseInt(this.element.data('fancybox-height'));
          width = parseInt(this.element.data('fancybox-width'));
          if (width) {
            this.width = width;
          }
          if (height) {
            return this.height = height;
          }
        },
        afterLoad: function() {
          $('.fancybox-overlay').addClass(this.wrapCSS);
        },
        afterShow: function() {
          $('[data-modal-close]', this.inner).on('click', function(e) {
            e.preventDefault();
            return $.fancybox.close();
          });
          if (!$('.fancybox-overlay > .fancybox-close-wrap').length) {
            if (this.element.data('modal-type') !== 'modal') {
              $('<div class="fancybox-close-wrap" />').html('<div class="fancybox-close"><i class="fa fa-close"></div>').prependTo($('.fancybox-overlay')).on('click', function(e) {
                e.preventDefault();
                return $.fancybox.close();
              });
            }
          }
          if ($('.fancybox-nav', this.wrap).length) {
            if (!$('.fancybox-overlay > .fancybox-nav-prev-wrap').length) {
              $('<div class="fancybox-nav-prev-wrap" />').html('<div class="fancybox-nav-prev"><i class="fa fa-caret-left"></div>').prependTo($('.fancybox-overlay')).on('click', function() {
                return $.fancybox.prev();
              });
              $('<div class="fancybox-nav-next-wrap" />').html('<div class="fancybox-nav-next"><i class="fa fa-caret-right"></div>').prependTo($('.fancybox-overlay')).on('click', function() {
                return $.fancybox.next();
              });
            }
            if (this.wrap.hasClass('fancybox-type-ajax')) {
              $('.fancybox-nav', this.outer).hide();
            }
          }
        },
        beforeClose: function() {
          $('.fancybox-overlay').addClass('fancybox-closing');
        }
      });
    };
    init = function() {
      $('.fancybox').fancybox();
      return $('.fancybox[data-modal-type="modal"]').fancybox({
        modal: true
      });
    };
    return $(document).ready(function() {
      if (typeof jQuery.fn.fancybox === 'function') {
        buildCustomTransitions(jQuery.fancybox);
        setDefaults();
        return init();
      }
    });
  })(jQuery.noConflict());

}).call(this);

(function() {
  window.Station.Theme = window.Station.Theme || {};

  Station.Theme.Base = (function($) {
    var cache, cacheElements, config, init, initFitVids, initJumpMenus, initNavPrimary, initShopifyExtensions, initToggleTopBarSearch, selectors, setPageTitle, themeConfig, toggleTopBarSearch;
    selectors = {
      navPrimary: '#app-nav .nav-primary',
      pageTitle: '.page-header .title',
      toggleTopBarSearch: 'a[data-toggle-top-bar-search]',
      topBarSearch: '#top-bar-search'
    };
    config = {
      windowResizingID: void 0
    };
    themeConfig = Station.Theme.config;
    cache = {};
    init = function() {
      cacheElements();
      initShopifyExtensions();
      initFitVids();
      initJumpMenus();
      initNavPrimary();
      return initToggleTopBarSearch();
    };
    cacheElements = function() {
      return cache = {
        $navPrimary: $(selectors.navPrimary),
        $pageTitle: $(selectors.pageTitle),
        $toggleTopBarSearch: $(selectors.toggleTopBarSearch),
        $topBarSearch: $(selectors.topBarSearch)
      };
    };
    initFitVids = function() {
      if (typeof $.fn.fitVids === 'function') {
        $('.fit-video').fitVids();
      }
    };
    initJumpMenus = function() {
      return $('select.jump-menu').change(function() {
        window.location = $('option:selected', this).val();
      });
    };
    initNavPrimary = function() {
      $('ul ul', cache.$navPrimary).css('visibility', '').show();
      $('ul.nav-level-3', cache.$navPrimary).each(function() {
        if ($(this).offset().left + $(this).outerWidth() > window.innerWidth) {
          return cache.$navPrimary.addClass('subnav-flyout-left');
        } else {
          return cache.$navPrimary.removeClass('subnav-flyout-left');
        }
      });
      $('ul ul', cache.$navPrimary).css('visibility', 'visible').css('display', '');
    };
    initShopifyExtensions = function() {
      var aCouples, aKeyValue, i;
      Shopify.queryParams = {};
      if (location.search.length) {
        aKeyValue = void 0;
        i = 0;
        aCouples = location.search.substr(1).split('&');
        while (i < aCouples.length) {
          aKeyValue = aCouples[i].split('=');
          if (aKeyValue.length > 1) {
            Shopify.queryParams[decodeURIComponent(aKeyValue[0])] = decodeURIComponent(aKeyValue[1]);
          }
          i++;
        }
      }
    };
    initToggleTopBarSearch = function() {
      cache.$topBarSearch.css('margin-top', -(cache.$topBarSearch.outerHeight()));
      cache.$toggleTopBarSearch.on('click', function(e) {
        e.preventDefault();
        return toggleTopBarSearch();
      });
    };
    setPageTitle = function(text) {
      if (text == null) {
        text = cache.$pageTitle.data('default-text');
      }
      cache.$pageTitle.text(text);
    };
    toggleTopBarSearch = function() {
      var $searchInput, $tb;
      $tb = cache.$topBarSearch;
      $searchInput = $('input:first', $tb);
      if ($tb.is(':visible')) {
        $tb.velocity({
          'margin-top': -$tb.outerHeight()
        }, {
          duration: 400,
          easing: 'easeOutCirc',
          queue: false,
          complete: function() {
            return $tb.hide();
          }
        });
      } else {
        Station.GrandCentral.Utilities.delay(20, function() {
          return $searchInput.focus().on('focusout', function() {
            return toggleTopBarSearch();
          });
        });
        $('body').velocity('scroll', {
          duration: 400,
          offset: 0,
          easing: 'easeOutCirc'
        });
        $tb.show().velocity({
          'margin-top': [0, -$tb.outerHeight()]
        }, {
          duration: 400,
          easing: 'easeOutCirc',
          queue: false
        });
      }
    };
    $(window).resize(function() {
      clearTimeout(window.resizedFinished);
      window.resizedFinished = setTimeout((function() {
        initNavPrimary();
        Station.Theme.Collection.alignRows();
      }), 100);
    });
    $(function() {
      init();
    });
    return {
      init: init,
      initFitVids: initFitVids,
      initJumpMenus: initJumpMenus,
      initNavPrimary: initNavPrimary,
      initShopifyExtensions: initShopifyExtensions,
      initToggleTopBarSearch: initToggleTopBarSearch,
      cacheElements: cacheElements,
      setPageTitle: setPageTitle,
      toggleTopBarSearch: toggleTopBarSearch
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Cart = (function($) {
    var _initAddToCartButtons, addToCart, cache, cacheElements, config, current, init, lineItemAddedConfirmationMessage, selectors, themeConfig, updateCartTotals;
    selectors = {
      attr: {
        cartAction: 'data-cart-action'
      },
      addToCart: '.add-to-cart',
      addToCartForm: 'form[action^=/cart/add]',
      cartBadge: '.cart-badge'
    };
    current = Station.Theme.current;
    themeConfig = Station.Theme.config;
    config = {
      i18n: Station.Theme.i18n,
      notify: Station.GrandCentral.Notify
    };
    cache = {};
    init = function(container) {
      cacheElements();
      return _initAddToCartButtons();
    };
    cacheElements = function() {
      return cache = {
        $addToCart: $(selectors.addToCart),
        $cartBadge: $(selectors.cartBadge)
      };
    };
    addToCart = function(action, triggerElement) {
      var $triggerElement, form, serializedForm;
      if (!(action || triggerElement)) {
        return;
      }
      $triggerElement = $(triggerElement);
      form = $triggerElement.closest(selectors.addToCartForm);
      serializedForm = form.serialize();
      switch (action) {
        case 'notification':
          $triggerElement.blur();
          $.ajax({
            type: 'POST',
            url: '/cart/add.js',
            data: serializedForm,
            dataType: 'json',
            success: function(item) {
              updateCartTotals();
              config.notify.open(lineItemAddedConfirmationMessage(item), 'success');
            },
            error: function(XMLHttpRequest, textStatus) {
              var responseText;
              responseText = JSON.parse(XMLHttpRequest.responseText);
              config.notify.open(responseText['description'], 'error');
            }
          });
          break;
        default:
          return;
      }
    };
    lineItemAddedConfirmationMessage = function(item) {
      var message, viewCartLink;
      viewCartLink = '<div class="actions"><a class="button small" href="/cart">' + config.i18n.cart.notification.viewCartLink + '</a></div>';
      message = config.i18n.cart.notification.productAdded;
      message = message.replace('{{ product_title }}', item.title);
      message = message.replace('{{ view_cart_link }}', viewCartLink);
      return message;
    };
    updateCartTotals = function() {
      $.ajax({
        type: 'GET',
        url: '/cart.js',
        dataType: 'json',
        success: function(data) {
          var count, itemCountText;
          switch (data.item_count) {
            case 0:
              count = 'zero';
              break;
            case 1:
              count = 'one';
              break;
            default:
              count = 'other';
          }
          itemCountText = config.i18n.cart.itemCount[count].replace('{{ count }}', data.item_count);
          $('.cart-item-count').html(data.item_count);
          $('.cart-item-count-items').html(itemCountText);
          $('.cart-total-price').html(Station.Theme.Currency.formatMoney(data.total_price));
          if (data.item_count > 0) {
            return cache.$cartBadge.removeClass('empty');
          } else {
            return cache.$cartBadge.addClass('empty');
          }
        }
      });
    };
    _initAddToCartButtons = function() {
      cache.$addToCart.each(function() {
        return $(this).on('click', function(e) {
          var action;
          action = $(this).attr(selectors.attr.cartAction);
          switch (action) {
            case 'notification':
              e.preventDefault();
              $(this).blur();
              return addToCart(action, this);
          }
        });
      });
    };
    $(function() {
      init();
    });
    return {
      init: init,
      addToCart: addToCart
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Collection = (function($) {
    var alignRows, cache, cacheElements, init, initSortMenus, selectors, themeConfig;
    selectors = {
      listCollections: '.list-collections',
      products: '.collection-products',
      sectionCollectionList: '.section-collection-list',
      sortBy: 'select.sort-collection-by'
    };
    themeConfig = Station.Theme.config;
    cache = {};
    init = function() {
      cacheElements();
      initSortMenus();
      alignRows();
    };
    cacheElements = function() {
      cache = {
        $listCollections: $(selectors.listCollections),
        $products: $(selectors.products),
        $sectionCollectionList: $(selectors.sectionCollectionList),
        $sortBy: $(selectors.sortBy)
      };
    };
    alignRows = function() {
      if (typeof $.fn.matchHeight === 'function') {
        if (cache.$products.length) {
          $(selectors.products + ' .image-container').matchHeight();
          $(selectors.products + ' .title-wrap').matchHeight();
          $(selectors.products + ' .pricing').matchHeight();
        }
        if (cache.$listCollections.length) {
          $('.collection-grid-item .image-container').matchHeight();
          $('.collection-title').matchHeight();
        }
        if (cache.$sectionCollectionList.length) {
          $('.collection-grid-item .image-container').matchHeight();
          $('.collection-title').matchHeight();
        }
      }
    };
    initSortMenus = function() {
      if (cache.$sortBy.length) {
        cache.$sortBy.each(function() {
          var $this, sortBy;
          $this = $(this);
          sortBy = $this.attr('data-sort-by');
          $(this).val(sortBy).on('change', function() {
            Shopify.queryParams.sort_by = $this.val();
            location.search = $.param(Shopify.queryParams).replace(/\+/g, '%20');
          });
        });
      }
    };
    $(function() {
      init();
    });
    return {
      init: init,
      cacheElements: cacheElements,
      alignRows: alignRows,
      initSortMenus: initSortMenus
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.CollectionSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.CollectionSection.prototype = _.assignIn({}, Station.Theme.CollectionSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.Theme.Cart.init();
      Station.Theme.Collection.init();
      return Station.Theme.Currency.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.CollectionListSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.CollectionListSection.prototype = _.assignIn({}, Station.Theme.CollectionListSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.Theme.Collection.alignRows();
    }
  });

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Currency = (function($) {
    var _bindEvents, cache, cacheElements, config, convertAll, formatMoney, init, renderPrice, selectors, setCurrency, themeConfig;
    selectors = {
      attr: {
        basePrice: 'data-base-price'
      },
      currencyCode: '[data-currency-code]',
      currencySelect: '[data-currency-selector]',
      singleOptionSelector: '[name="id"][data-option-selector]',
      price: '[data-price]'
    };
    themeConfig = Station.Theme.config;
    config = {
      currentCurrency: Station.Theme.current.currency,
      moneyFormat: Station.Theme.shop.moneyFormat,
      moneyWithCurrencyFormat: Station.Theme.shop.moneyWithCurrencyFormat,
      shop: Station.Theme.shop,
      shopCurrency: Station.Theme.shop.currency
    };
    cache = {};
    init = function() {
      var currency;
      cacheElements();
      _bindEvents();
      //Currency.moneyFormats[config.shopCurrency].money_format = config.moneyFormat;
      //Currency.moneyFormats[config.shopCurrency].money_with_currency_format = config.moneyWithCurrencyFormat;
      if (themeConfig.enableMultiCurrency && themeConfig.defaultCurrency) {
        currency = themeConfig.defaultCurrency;
      } else {
        currency = config.shopCurrency;
      }
      if (themeConfig.enableMultiCurrency && Currency.cookie.read()) {
        currency = Currency.cookie.read();
      }
      Currency.currentCurrency = currency;
      setCurrency(currency);
    };
    cacheElements = function() {
      return cache = {
        $currencyCode: $(selectors.currencyCode),
        $currencySelect: $(selectors.currencySelect),
        $price: $(selectors.price),
        $singleOptionSelector: $(selectors.singleOptionSelector)
      };
    };
    convertAll = function(currency) {
      if (currency == null) {
        currency = Currency.currentCurrency;
      }
      cache.$price.each(function() {
        return renderPrice(this, $(this).attr(selectors.attr.basePrice), '', currency);
      });
      $('option', cache.$singleOptionSelector).each(function() {
        var amount, hasPrice, text;
        text = $(this).html();
        text = text.substr(0, text.lastIndexOf('—') + 2);
        hasPrice = text.lastIndexOf('—') > 0;
        amount = $(this).attr(selectors.attr.basePrice);
        if (hasPrice) {
          if (amount) {
            amount = formatMoney(amount, null, currency);
          } else {
            amount = Station.Theme.i18n.product.soldOut;
          }
          $(this).html(text + amount);
        }
      });
    };
    formatMoney = function(amount, style, currency) {
      var format, formattedAmount;
      if (isNaN(parseInt(amount))) {
        return;
      }
      amount = amount ? parseInt(amount) : 0;
      currency = currency ? currency : Currency.currentCurrency;
      style = style ? style : themeConfig.moneyStyle;
      format = Currency.moneyFormats[currency][style];
      formattedAmount = Currency.convert(amount, config.shopCurrency, currency);
      return formattedAmount = Currency.formatMoney(formattedAmount, format);
    };
    renderPrice = function(element, amount, style, currency) {
      var $e, formattedAmount, manualStyle;
      $e = $(element);
      manualStyle = $e.attr('data-money-style');
      if (manualStyle === 'money_format' || manualStyle === 'money_with_currency_format') {
        style = manualStyle;
      }
      if (isNaN(parseInt(amount))) {
        formattedAmount = amount;
        amount = '';
      } else {
        formattedAmount = formatMoney(amount, style, currency);
      }
      $e.attr(selectors.attr.basePrice, amount).html(formattedAmount).addClass('converted');
    };
    setCurrency = function(currency) {
      cache.$currencyCode.html(currency);
      cache.$currencySelect.val(currency);
      Currency.currentCurrency = currency;
      Currency.cookie.write(currency);
      convertAll(currency);
    };
    _bindEvents = function() {
      cache.$currencySelect.on('change', function() {
        return setCurrency($(this).val());
      });
    };
    $(function() {
      if (typeof Currency === 'object') {
        init();
      }
    });
    return {
      init: init,
      cacheElements: cacheElements,
      convertAll: convertAll,
      formatMoney: formatMoney,
      renderPrice: renderPrice,
      setCurrency: setCurrency
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  window.Station.Theme = window.Station.Theme || {};

  Station.Theme.Customer = (function($) {
    var Addresses, Login, config, themeConfig;
    config = {
      addressesTemplate: 'customers/addresses',
      loginTemplate: 'customers/login'
    };
    themeConfig = Station.Theme.config;
    Addresses = (function() {
      var _bindEvents, cache, cacheElements, deleteAddress, hideAddressForm, init, initCountryProvinceSelector, initCountryProvinceSelectors, selectors, showAddressForm, showAddressFormsWithErrors, toggleAddress;
      selectors = {
        addAddress: '#add_address',
        addAddressButton: '[data-form-id="add_address"]:first',
        customerAddress: '.customer-address',
        customerAddressForm: '.customer-address form',
        deleteAddress: '.delete-address',
        editAddress: '[id^="edit_address"]',
        errors: '.errors',
        toggleAddress: '.toggle-address'
      };
      cache = {};
      init = function() {
        cacheElements();
        _bindEvents();
        initCountryProvinceSelectors();
        return showAddressFormsWithErrors();
      };
      cacheElements = function() {
        cache = {
          $addAddressButton: $(selectors.addAddressButton),
          $pageHeaderTitle: $(selectors.pageHeaderTitle),
          $customerAddress: $(selectors.customerAddress),
          $customerAddressForm: $(selectors.customerAddressForm),
          $deleteAddress: $(selectors.deleteAddress),
          $toggleAddress: $(selectors.toggleAddress)
        };
      };
      deleteAddress = function(id, confirmMessage) {
        if (confirm(confirmMessage)) {
          Shopify.postLink('/account/addresses/' + id, {
            parameters: {
              _method: 'delete'
            }
          });
        }
      };
      hideAddressForm = function($form) {
        $form.hide();
      };
      initCountryProvinceSelector = function(id) {
        return new Shopify.CountryProvinceSelector('address_country_' + id, 'address_province_' + id, {
          hideElement: 'address_province_row_' + id
        });
      };
      initCountryProvinceSelectors = function() {
        if (Shopify) {
          initCountryProvinceSelector('new');
        }
        cache.$customerAddress.not(selectors.addAddress).each(function() {
          var id;
          id = $(this).attr('id').replace('address_', '');
          if (Shopify) {
            return initCountryProvinceSelector(id);
          }
        });
      };
      showAddressForm = function($form, $scrollToElement) {
        $form.show().addClass('animate-in fade-in-down');
        if ($scrollToElement && $scrollToElement.length) {
          $scrollToElement.velocity('scroll', {
            duration: 500,
            offset: -20,
            easing: 'easeInOutCirc'
          });
        }
        Station.GrandCentral.Utilities.delay(20, function() {
          return $('input[type="text"]', $form).first().focus();
        });
      };
      showAddressFormsWithErrors = function() {
        return cache.$customerAddressForm.each(function() {
          var $form, $formState;
          $form = $(this).closest(selectors.addAddress, selectors.editAddress);
          $formState = $(selectors.errors, $(this));
          if (!$formState.length) {
            return;
          }
          showAddressForm($form, $form);
        });
      };
      toggleAddress = function(id, $scrollToElement) {
        var $form;
        $form = $(id);
        if (!$form.length) {
          return;
        }
        if ($form.is(":visible")) {
          hideAddressForm($form);
          if (id === selectors.addAddress) {
            Station.Theme.Base.setPageTitle();
            cache.$addAddressButton.show();
          }
        } else {
          if (id === selectors.addAddress) {
            $scrollToElement = $('#content-wrap');
            cache.$addAddressButton.hide();
            Station.Theme.Base.setPageTitle(cache.$addAddressButton.text());
          }
          showAddressForm($form, $scrollToElement);
        }
      };
      _bindEvents = function() {
        cache.$toggleAddress.on('click', function(e) {
          e.preventDefault();
          $(this).blur();
          toggleAddress('#' + $(this).data('form-id'), $(this));
        });
        return cache.$deleteAddress.on('click', function(e) {
          e.preventDefault();
          $(this).blur();
          deleteAddress($(this).data('form-id'), $(this).data('confirm-message'));
        });
      };
      if (Station.Theme.current.templateType === config.addressesTemplate) {
        init();
      }
      return {
        init: init,
        cacheElements: cacheElements,
        deleteAddress: deleteAddress,
        hideAddressForm: hideAddressForm,
        initCountryProvinceSelector: initCountryProvinceSelector,
        initCountryProvinceSelectors: initCountryProvinceSelectors,
        showAddressForm: showAddressForm,
        showAddressFormsWithErrors: showAddressFormsWithErrors,
        toggleAddress: toggleAddress
      };
    })();
    Login = (function() {
      var _bindEvents, cache, cacheElements, init, renderRecoverPasswordSuccess, selectors, setInitialSection;
      selectors = {
        loginSection: '#customer-login',
        recoverPasswordSection: '#customer-recover-password',
        recoverPasswordSuccess: '[data-recover-password-success]',
        recoverPasswordSuccessTest: '#recover-password-success',
        togglePasswordRecovery: '.toggle-password-recovery'
      };
      cache = {};
      init = function() {
        cacheElements();
        _bindEvents();
        setInitialSection();
        return renderRecoverPasswordSuccess(cache.$recoverPasswordSuccess.length);
      };
      cacheElements = function() {
        cache = {
          $loginSection: $(selectors.loginSection),
          $recoverPasswordSection: $(selectors.recoverPasswordSection),
          $recoverPasswordSuccess: $(selectors.recoverPasswordSuccess),
          $recoverPasswordSuccessTest: $(selectors.recoverPasswordSuccessTest),
          $togglePasswordRecovery: $(selectors.togglePasswordRecovery)
        };
      };
      renderRecoverPasswordSuccess = function(visible) {
        if (!visible) {
          return;
        }
        cache.$recoverPasswordSuccessTest.show().removeClass('hidden');
      };
      setInitialSection = function() {
        var section;
        section = window.location.hash === '#recover' ? selectors.recoverPasswordSection : selectors.loginSection;
        Station.GrandCentral.Utilities.switchElement(selectors.loginSection + ', ' + selectors.recoverPasswordSection, section);
      };
      _bindEvents = function() {
        return cache.$togglePasswordRecovery.on('click', function(e) {
          e.preventDefault();
          Station.GrandCentral.Utilities.switchElement(selectors.loginSection + ', ' + selectors.recoverPasswordSection, '#' + $(this).data('show-module-id'), 'animate-in fade-in-down');
        });
      };
      $(function() {
        if (Station.Theme.current.templateType === config.loginTemplate) {
          init();
        }
      });
      return {
        init: init,
        cacheElements: cacheElements,
        renderRecoverPasswordSuccess: renderRecoverPasswordSuccess,
        setInitialSection: setInitialSection
      };
    })();
    return {
      Login: Login,
      Addresses: Addresses
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Image = (function($) {
    var Product, current, init, setZoom, themeConfig;
    current = Station.Theme.current;
    themeConfig = Station.Theme.config;
    Product = (function() {
      var _getSecondaryImageContainer, _getVariantByImageID, _isCurrentPrimary, _resetPrimaryImage, _setActiveSecondaryImage, _updatePrimaryImage, cache, cacheElements, init, initPrimaryImage, initSecondaryImages, selectors, update;
      selectors = {
        primaryImage: '.primary-image',
        primaryImageContainer: '.primary-image-container',
        primaryImageSection: '.primary-images',
        secondaryImage: '.secondary-image',
        secondaryImageContainer: '.secondary-image-container'
      };
      cache = {};
      init = function() {
        cacheElements();
        switch (current.templateType) {
          case 'product':
            initPrimaryImage();
            initSecondaryImages();
        }
      };
      cacheElements = function() {
        cache = {
          $primaryImageSection: $(selectors.primaryImageSection),
          $secondaryImageContainers: $(selectors.secondaryImageContainer)
        };
      };
      initPrimaryImage = function($imageContainer) {
        var $image, $seconaryImageContainer, imageID, imageIndex;
        if (!$imageContainer) {
          $imageContainer = $(selectors.primaryImageContainer + ':first-child', cache.$primaryImageSection);
        }
        imageID = $imageContainer.attr('data-image-id');
        $seconaryImageContainer = _getSecondaryImageContainer(imageID);
        imageIndex = cache.$secondaryImageContainers.index($seconaryImageContainer);
        $image = $('img:first', $imageContainer);
        $('a:first', $imageContainer).attr('target', '_blank');
        _setActiveSecondaryImage($seconaryImageContainer);
        if (cache.$primaryImageSection.is('[is-zoomable]')) {
          setZoom($imageContainer, $image.attr('data-src-master'));
        }
        $imageContainer.on('click', function(e) {
          var group, options;
          if (themeConfig.product.enableLightbox) {
            e.preventDefault();
            if (cache.$secondaryImageContainers.length) {
              group = $('a:first', cache.$secondaryImageContainers);
              options = {
                index: imageIndex
              };
            } else {
              group = $('a:first', $imageContainer);
            }
            return $.fancybox(group, options);
          }
        });
      };
      initSecondaryImages = function() {
        cache.$secondaryImageContainers.each(function() {
          var $si, $siLink, $this, imageID, variant;
          $this = $(this);
          $si = $(selectors.secondaryImage, $this);
          $siLink = $('a:first', $this);
          imageID = $si.attr('data-image-id');
          variant = _getVariantByImageID(imageID);
          return $siLink.on('click', function(e) {
            e.preventDefault();
            _setActiveSecondaryImage($this);
            if (variant && themeConfig.product.enableSetVariantFromSecondary) {
              return Station.Theme.Product.setVariantByID(variant.id, themeConfig.product.enableDeepLinking);
            } else {
              return _updatePrimaryImage($this);
            }
          });
        });
      };
      update = function(variant) {
        var $imageContainer;
        if (!variant) {
          _resetPrimaryImage();
          return;
        }
        if (typeof variant === 'string' || typeof variant === 'number') {
          variant = Station.Theme.Product.getVariantByID(parseInt(variant));
        }
        if (typeof variant === 'object' && variant.featured_image) {
          if (!_isCurrentPrimary(variant.featured_image.id) && ($imageContainer = _getSecondaryImageContainer(variant.featured_image.id))) {
            _updatePrimaryImage($imageContainer);
          }
        } else {
          _resetPrimaryImage();
        }
      };
      _getSecondaryImageContainer = function(imageID) {
        var container, containerImageID, i, len, ref;
        ref = cache.$secondaryImageContainers;
        for (i = 0, len = ref.length; i < len; i++) {
          container = ref[i];
          containerImageID = $(container).attr('data-image-id');
          if (containerImageID && imageID && parseInt(containerImageID) === parseInt(imageID)) {
            return $(container);
          }
        }
        return false;
      };
      _getVariantByImageID = function(imageID) {
        var i, len, ref, variant;
        ref = current.product.variants;
        for (i = 0, len = ref.length; i < len; i++) {
          variant = ref[i];
          if (parseInt(variant.featured_image.id) === parseInt(imageID)) {
            return variant;
          }
        }
        return false;
      };
      _isCurrentPrimary = function(newImageID) {
        var currentPrimaryImageID, isCurrentPrimaryImage;
        currentPrimaryImageID = $(selectors.primaryImage).attr('data-image-id');
        isCurrentPrimaryImage = parseInt(currentPrimaryImageID) === parseInt(newImageID);
        return isCurrentPrimaryImage;
      };
      _resetPrimaryImage = function() {
        var $imageContainer, featuredImageID;
        if (featuredImageID = Station.Theme.current.featuredImageID) {
          $imageContainer = _getSecondaryImageContainer(featuredImageID);
        } else {
          $imageContainer = $(cache.$secondaryImageContainers).first();
        }
        _updatePrimaryImage($imageContainer);
      };
      _setActiveSecondaryImage = function($imageContainer) {
        cache.$secondaryImageContainers.removeClass('active');
        if ($imageContainer) {
          $imageContainer.addClass('active');
        }
      };
      _updatePrimaryImage = function($imageContainer) {
        var $newPI, $newPIContainer, $pi, $piContainer, newImageID;
        newImageID = $imageContainer.attr('data-image-id');
        $newPIContainer = $(selectors.primaryImageContainer + '[data-image-id="' + newImageID + '"]', cache.$primaryImageSection);
        if ($newPIContainer.length) {
          $(selectors.primaryImageContainer, cache.$primaryImageSection).hide();
          $newPIContainer.show();
        } else {
          $piContainer = $(selectors.primaryImageContainer, cache.$primaryImageSection);
          $pi = $('img:first', $piContainer);
          $newPIContainer = $imageContainer.clone();
          $newPI = $('img:first', $newPIContainer);
          $newPIContainer.attr('class', $piContainer.attr('class'));
          $newPI.attr('class', $pi.attr('class')).addClass('lazyload');
          $(selectors.primaryImageContainer, cache.$primaryImageSection).hide();
          $(cache.$primaryImageSection).prepend($newPIContainer);
          initPrimaryImage($newPIContainer);
        }
        _setActiveSecondaryImage($imageContainer);
        if (cache.$primaryImageSection.is('[is-zoomable]')) {
          setZoom(cache.$newPIContainer, $('img:first', $newPIContainer).attr('data-src-master'));
        }
      };
      return {
        init: init,
        initSecondaryImages: initSecondaryImages,
        cacheElements: cacheElements,
        update: update
      };
    })();
    init = function() {
      return Product.init();
    };
    setZoom = function($e, src) {
      if (!$e) {
        return;
      }
      $($e).trigger('zoom.destroy');
      $e.zoom({
        url: src,
        touch: false,
        duration: 0,
        callback: function() {
          if (this.naturalWidth <= $e.parent().width()) {
            $e.css('width', this.naturalWidth + 'px');
          } else {
            $e.css('width', 'initial');
          }
          if (this.naturalHeight <= $e.parent().height()) {
            return $e.css('height', this.naturalHeight + 'px');
          } else {
            return $e.css('height', 'initial');
          }
        }
      });
    };
    $(function() {
      init();
    });
    return {
      Product: Product,
      setZoom: setZoom
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Map = (function($) {
    var cache, cacheElements, config, createMap, createMaps, geolocate, init, loadMap, loadMaps, selectors, showMapError, themeConfig;
    selectors = {
      maps: '.google-map'
    };
    themeConfig = Station.Theme.config;
    config = {
      i18n: Station.Theme.i18n,
      scriptURL: 'https://maps.googleapis.com/maps/api/js?key=',
      zoom: 14
    };
    cache = {};
    init = function() {
      cacheElements();
      loadMaps();
    };
    cacheElements = function() {
      cache = {
        $maps: $(selectors.maps)
      };
    };
    createMap = function(map) {
      var $map;
      $map = $(map);
      cache.$currentMapContainer = $map;
      geolocate($map).then((function(results) {
        var center, mapOptions, marker;
        mapOptions = {
          zoom: config.zoom,
          styles: config.styles,
          center: results[0].geometry.location,
          draggable: false,
          clickableIcons: false,
          scrollwheel: false,
          disableDoubleClickZoom: true,
          disableDefaultUI: true
        };
        map = new google.maps.Map($map[0], mapOptions);
        center = map.getCenter();
        marker = new google.maps.Marker({
          map: map,
          position: center
        });
        google.maps.event.addDomListener(window, 'resize', function() {
          google.maps.event.trigger(map, 'resize');
          map.setCenter(center);
        });
      }).bind(this)).fail(function() {
        var errorMessage;
        errorMessage = void 0;
        switch ($map.geocoderStatus) {
          case 'ZERO_RESULTS':
            errorMessage = config.i18n.map.errors.addressNoResults;
            break;
          case 'OVER_QUERY_LIMIT':
            errorMessage = config.i18n.map.errors.addressQueryLimitHTML;
            break;
          default:
            errorMessage = config.i18n.map.errors.addressError;
            break;
        }
        showMapError(errorMessage);
      });
    };
    createMaps = function() {
      cache.$maps.each(function(i) {
        createMap(this);
      });
    };
    geolocate = function($map) {
      var address, deferred, geocoder;
      deferred = $.Deferred();
      geocoder = new google.maps.Geocoder;
      address = $map.data('address');
      geocoder.geocode({
        address: address
      }, function(results, status) {
        if (status !== google.maps.GeocoderStatus.OK) {
          $map.geocoderStatus = status;
          deferred.reject(status);
        }
        deferred.resolve(results);
      });
      return deferred;
    };
    loadMap = function(map) {
      var $map, $script;
      $map = $(map);
      $map.key = $map.data('api-key');
      if (typeof $map.key !== 'string' || $map.key === '') {
        return;
      }
      $script = $('script[src*="' + $map.key + '&"]');
      if ($script.length === 0) {
        $.getScript(config.scriptURL + $map.key).then(function() {
          createMap(map);
        });
      } else {
        createMap(map);
      }
    };
    loadMaps = function() {
      cache.$maps.each(function(i) {
        return loadMap(this);
      });
    };
    showMapError = function(errorMessage, $map) {
      var errorElement;
      if (!$map) {
        $map = cache.$currentMapContainer;
      }
      if ($map) {
        errorElement = '<div class="errors map-errors text-center">' + errorMessage + '</div>';
        $map.html(errorElement);
      }
    };
    window.gm_authFailure = function() {
      if (!Shopify.designMode) {
        return;
      }
      showMapError(config.i18n.map.errors.authErrorHTML);
    };
    $(function() {
      init();
    });
    return {
      init: init,
      cacheElements: cacheElements,
      loadMap: loadMap,
      loadMaps: loadMaps,
      showMapError: showMapError
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.MapSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
      this.$map = $('.google-map', this.$container);
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.MapSection.prototype = _.assignIn({}, Station.Theme.MapSection.prototype, $ = jQuery, {
    onUnload: function(evt) {
      if (typeof window.google !== 'undefined') {
        google.maps.event.clearListeners(this.map, 'resize');
      }
    },
    onSelect: function(evt) {
      Station.Theme.Map.loadMap(this.$map);
    }
  });

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Password = (function($) {
    var _bindEvents, cache, cacheElements, init, selectors, showPasswordEntry, showPasswordNotice, themeConfig;
    selectors = {
      page: 'html.password',
      pageModule: 'html.password .password-module',
      enterLink: 'html.password .enter-link',
      cancelEnterLink: 'html.password .cancel-enter-link',
      input: 'html.password input#password',
      emailInput: 'html.password input#email',
      moduleLogin: '#password-entry',
      moduleNotice: '#opening-soon'
    };
    themeConfig = Station.Theme.config;
    cache = {};
    init = function() {
      cacheElements();
      _bindEvents();
      if (Station.Theme.current.templateType === 'password') {
        if ($('.errors', selectors.moduleLogin).length) {
          showPasswordEntry();
        }
        cache.$enterLink.first().on('click', function() {
          showPasswordEntry();
        });
        cache.$cancelEnterLink.first().on('click', function() {
          showPasswordNotice();
        });
      }
    };
    showPasswordEntry = function() {
      Station.GrandCentral.Utilities.switchElement(selectors.pageModule, '#' + cache.$enterLink.data('show-module-id'), 'animate-in fade-in-down');
      cache.$enterLink.hide();
      cache.$cancelEnterLink.show();
      cache.$input.focus();
    };
    showPasswordNotice = function() {
      Station.GrandCentral.Utilities.switchElement(selectors.pageModule, '#' + cache.$cancelEnterLink.data('show-module-id'), 'animate-in fade-in-down');
      cache.$cancelEnterLink.hide();
      cache.$enterLink.show();
      cache.$emailInput.focus();
    };
    cacheElements = function() {
      cache = {
        $cancelEnterLink: $(selectors.cancelEnterLink),
        $enterLink: $(selectors.enterLink),
        $input: $(selectors.input),
        $emailInput: $(selectors.emailInput),
        $page: $(selectors.page)
      };
    };
    _bindEvents = function() {
      $(document).keyup(function(e) {
        if (e.keyCode === 27) {
          showPasswordNotice();
        }
      });
    };
    $(function() {
      init();
    });
    return {
      init: init,
      cacheElements: cacheElements
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  Station.Theme = Station.Theme || {};

  Station.Theme.Product = (function($) {
    var _initOptionSelectors, _initSelectAnOption, _initVariant, cache, cacheElements, config, current, enableQtyLimit, getVariantByID, getVariantBySelectors, init, isOnBackorder, selectors, setAddToCartButtons, setBackorderNotice, setCompareAtPrice, setQtyAvailable, setSale, setSelectAnOption, setSku, setSmartPaymentButtons, setVariant, setVariantByID, setVariantID, themeConfig;
    selectors = {
      addToCart: '.primary .add-to-cart',
      basePrice: '.primary [data-base-price]',
      backorderNotice: '.primary .backorder-notice',
      currency: '.primary [data-currency]',
      currencyCode: '.primary [data-currency-code]',
      from: '.primary .from',
      optionSelector: '.primary [data-option-selector]',
      price: '.primary [data-price]',
      priceCompareAt: '.primary .compare-at',
      priceSell: '.primary .sell-price',
      qty: '.primary #quantity',
      qtyAvailable: '.primary [data-quantity-available]',
      saleSticker: '.primary .sale-sticker',
      sku: '.primary [data-sku]:not(option)',
      smartPaymentButtonContainer: '.smart-payment-button-container',
      variantID: 'input[name="id"]'
    };
    current = Station.Theme.current;
    themeConfig = Station.Theme.config;
    config = {
      i18n: Station.Theme.i18n,
      currentCurrency: current.currency,
      currentProduct: current.product,
      currentVariant: current.variant,
      renderPrice: Station.Theme.Currency.renderPrice,
      shop: Station.Theme.shop,
      templateType: current.templateType,
      utilities: Station.GrandCentral.Utilities
    };
    cache = {};
    init = function(container) {
      cacheElements();
      if (config.templateType === 'product') {
        _initOptionSelectors();
        _initVariant();
        _initSelectAnOption();
      }
      if (themeConfig.product.enableQtyLimit) {
        return enableQtyLimit();
      }
    };
    cacheElements = function() {
      return cache = {
        $addToCart: $(selectors.addToCart),
        $basePrice: $(selectors.basePrice),
        $backorderNotice: $(selectors.backorderNotice),
        $currency: $(selectors.currency),
        $currencyCode: $(selectors.currencyCode),
        $from: $(selectors.from),
        $optionSelector: $(selectors.optionSelector),
        $price: $(selectors.price),
        $priceCompareAt: $(selectors.priceCompareAt),
        $priceSell: $(selectors.priceSell),
        $qty: $(selectors.qty),
        $qtyAvailable: $(selectors.qtyAvailable),
        $saleSticker: $(selectors.saleSticker),
        $sku: $(selectors.sku),
        $smartPaymentButtonContainer: $(selectors.smartPaymentButtonContainer),
        $variantID: $(selectors.variantID)
      };
    };
    getVariantByID = function(id) {
      var variant;
      variant = null;
      $.each(config.currentProduct.variants, function(i, e) {
        if (e.id === parseInt(id)) {
          variant = e;
          return false;
        }
      });
      return variant;
    };
    getVariantBySelectors = function(product, $optionSelector) {
      var options, variant, variants;
      if ($optionSelector == null) {
        $optionSelector = cache.$optionSelector;
      }
      options = [];
      variant = null;
      variants = product ? product.variants : config.currentProduct.variants;
      $optionSelector.each(function() {
        var position;
        position = parseInt($(this).data('option-number'));
        return options.splice(position, 0, $('option:selected', this).text());
      });
      $.each(variants, function(i, e) {
        if (Station.GrandCentral.Utilities.arraysEqual(options, e.options)) {
          variant = e;
          return false;
        }
      });
      return variant;
    };
    isOnBackorder = function(variant) {
      return variant.inventory_policy === 'continue' && variant.inventory_quantity <= 0;
    };
    enableQtyLimit = function(max, min) {
      min = min > 0 ? min : 1;
      max = max < 0 ? 0 : max;
      cache.$qty.each(function() {
        var $this;
        $this = $(this);
        $this.attr('min', min);
        $this.attr('max', max);
        if (max === 0) {
          $this.removeAttr('max');
        }
        $this.on('change', function() {
          var val;
          min = parseInt($this.attr('min'));
          max = parseInt($this.attr('max'));
          val = parseInt($this.val());
          if (max === 0) {
            val = 0;
          }
          if (val <= min) {
            val = min;
          }
          if (val >= max) {
            val = max;
          }
          return $this.val(val);
        });
        return $(this).trigger('change');
      });
    };
    setAddToCartButtons = function(text, enabled) {
      if (!text) {
        if (enabled) {
          text = config.i18n.product.addToCart;
        } else {
          text = config.i18n.product.soldOut;
        }
      }
      cache.$addToCart.text(text);
      if (enabled) {
        cache.$addToCart.prop('disabled', false).removeClass('disabled');
      } else {
        cache.$addToCart.prop('disabled', true).addClass('disabled');
      }
    };
    setSmartPaymentButtons = function(visible) {
      if (visible === false) {
        cache.$smartPaymentButtonContainer.addClass('hidden');
      } else {
        cache.$smartPaymentButtonContainer.removeClass('hidden');
      }
    };
    setBackorderNotice = function(html, visible) {
      if (html) {
        cache.$backorderNotice.html(html);
      }
      if (visible === false) {
        cache.$backorderNotice.addClass('hidden');
      } else {
        cache.$backorderNotice.removeClass('hidden');
      }
    };
    setCompareAtPrice = function(html, visible) {
      if (html) {
        cache.$priceCompareAt.html(html);
      }
      if (visible === false) {
        cache.$priceCompareAt.addClass('hidden');
      } else {
        cache.$priceCompareAt.removeClass('hidden');
      }
    };
    setQtyAvailable = function(qty, visible) {
      if (qty < 0) {
        qty = 0;
      }
      cache.$qtyAvailable.text(qty);
      if (visible === false) {
        cache.$qtyAvailable.parent().hide();
      } else {
        cache.$qtyAvailable.parent().show();
      }
    };
    setSale = function(sale) {
      if (typeof sale === 'boolean') {
        sale = sale;
      } else {
        sale = sale.compare_at_price > sale.price;
      }
      if (sale) {
        cache.$saleSticker.removeClass('hidden');
        if (themeConfig.product.enableHighlightAddWhenSale) {
          cache.$addToCart.addClass('focus');
        }
      } else {
        cache.$saleSticker.addClass('hidden');
        cache.$addToCart.removeClass('focus');
      }
    };
    setSelectAnOption = function() {
      cache.$optionSelector.each(function() {
        var text;
        if (!$(this).val()) {
          text = $('option:selected', $(this)).text();
          cache.$priceSell.text(text);
          setAddToCartButtons(text);
          return false;
        }
      });
    };
    setSku = function(sku, visible) {
      cache.$sku.text(sku);
      if (visible === false) {
        cache.$sku.parent().hide();
      } else {
        cache.$sku.parent().show();
      }
    };
    setVariant = function(variant, deepLink) {
      if (variant) {
        current.variant = variant;
        setVariantID();
        config.renderPrice(selectors.priceSell, variant.price);
        config.renderPrice(selectors.priceCompareAt, variant.compare_at_price);
        setCompareAtPrice(null, variant.compare_at_price);
        setQtyAvailable(variant.inventory_quantity);
        setSku(variant.sku);
        setSale(variant);
        setBackorderNotice(null, isOnBackorder(variant));
        setAddToCartButtons('', variant.available);
        setSmartPaymentButtons(variant.available);
        Station.Theme.Image.Product.update(variant.id);
        if (themeConfig.product.enableQtyLimit) {
          enableQtyLimit(variant.inventory_quantity);
        }
        if (deepLink) {
          config.utilities.setParam('variant', variant.id);
        }
      } else {
        current.variant = null;
        setVariantID();
        config.renderPrice(selectors.priceSell, config.i18n.product.unavailable);
        config.renderPrice(selectors.priceCompareAt);
        setCompareAtPrice(null, false);
        setQtyAvailable(0);
        setSku('', false);
        setSale(false);
        setBackorderNotice(null, false);
        setAddToCartButtons(config.i18n.product.unavailable, false);
        setSmartPaymentButtons(false);
        Station.Theme.Image.Product.update();
        if (themeConfig.product.enableQtyLimit) {
          enableQtyLimit(0, 0);
        }
      }
      setSelectAnOption();
    };
    setVariantID = function(id, $element) {
      if (!id) {
        if (current.variant !== null) {
          id = current.variant.id;
        } else {
          id = '';
        }
      }
      if (!$element) {
        $element = cache.$variantID;
      }
      $element.val(id);
    };
    setVariantByID = function(id, deepLink) {
      var variant;
      if (!(id && (variant = getVariantByID(id)))) {
        return;
      }
      cache.$optionSelector.each(function(index, value) {
        $(this).val(variant['option' + (index + 1)]);
      });
      setVariant(variant, deepLink);
    };
    _initOptionSelectors = function() {
      cache.$optionSelector.each(function() {
        return $(this).on('change', function() {
          var variant;
          variant = getVariantBySelectors(config.currentProduct, cache.$optionSelector);
          return setVariant(variant, themeConfig.product.enableDeepLinking);
        });
      });
    };
    _initSelectAnOption = function() {
      if (!(themeConfig.product.enableSelectAnOption && cache.$optionSelector.length > 1)) {
        return;
      }
      cache.$optionSelector.each(function(index, value) {
        var $selectedOption, optionName;
        optionName = $(this).data('select-text');
        if (optionName == null) {
          optionName = currentProduct.options[index];
        }
        $selectedOption = '<option value="">' + optionName + '</option>';
        return $(this).prepend($selectedOption).val('');
      });
      cache.$optionSelector.first().trigger('change');
    };
    _initVariant = function() {
      var variantID;
      variantID = Station.GrandCentral.Utilities.getParam('variant');
      if (variantID) {
        config.currentVariant = getVariantByID(variantID);
      }
      setVariant(config.currentVariant, false);
      if (themeConfig.product.showPrimaryImageFirst && !variantID) {
        Station.Theme.Image.Product.update();
      }
    };
    $(function() {
      init();
    });
    return {
      init: init,
      cacheElements: cacheElements,
      getVariantByID: getVariantByID,
      getVariantBySelectors: getVariantBySelectors,
      isOnBackorder: isOnBackorder,
      enableQtyLimit: enableQtyLimit,
      setAddToCartButtons: setAddToCartButtons,
      setBackorderNotice: setBackorderNotice,
      setCompareAtPrice: setCompareAtPrice,
      setQtyAvailable: setQtyAvailable,
      setSale: setSale,
      setSelectAnOption: setSelectAnOption,
      setSku: setSku,
      setVariant: setVariant,
      setVariantByID: setVariantByID
    };
  })(jQuery.noConflict());

}).call(this);

(function() {
  var $;

  window.Station.Theme = window.Station.Theme || {};

  Station.Theme.Sections = function() {
    var $;
    $ = jQuery;
    this.constructors = {};
    this.instances = [];
    $(document).on('shopify:section:load', this._onSectionLoad.bind(this)).on('shopify:section:unload', this._onSectionUnload.bind(this)).on('shopify:section:select', this._onSelect.bind(this)).on('shopify:section:deselect', this._onDeselect.bind(this)).on('shopify:block:select', this._onBlockSelect.bind(this)).on('shopify:block:deselect', this._onBlockDeselect.bind(this));
  };

  (function($) {
    return $(function() {
      var sections;
      sections = new Station.Theme.Sections;
      sections.register('collection', Station.Theme.CollectionSection);
      sections.register('collection-list', Station.Theme.CollectionListSection);
      sections.register('collection-template', Station.Theme.CollectionTemplateSection);
      sections.register('footer', Station.Theme.FooterSection);
      sections.register('header', Station.Theme.HeaderSection);
      sections.register('map', Station.Theme.MapSection);
      sections.register('password-template', Station.Theme.PasswordTemplateSection);
      sections.register('product-template', Station.Theme.ProductTemplateSection);
      sections.register('sidebar', Station.Theme.SidebarSection);
      sections.register('slideshow', Station.Theme.SlideshowSection);
      sections.register('video', Station.Theme.VideoSection);
    });
  })(jQuery.noConflict());

  Station.Theme.Sections.prototype = _.assignIn({}, Station.Theme.Sections.prototype, $ = jQuery, {
    _createInstance: function(container, constructor) {
      var $container, id, instance, type;
      $container = $(container);
      id = $container.attr('data-section-id');
      type = $container.attr('data-section-type');
      constructor = constructor || this.constructors[type];
      if (constructor == null) {
        return;
      }
      instance = _.assignIn(new constructor(container), {
        id: id,
        type: type,
        container: container
      });
      this.instances.push(instance);
      return instance;
    },
    _onSectionLoad: function(evt) {
      var container, instance;
      container = $('[data-section-id]', evt.target)[0];
      if (container) {
        instance = this._createInstance(container);
        if ((instance != null) && _.isFunction(instance.onLoad)) {
          instance.onLoad(evt);
        }
      }
    },
    _onSectionUnload: function(evt) {
      this.instances = _.filter(this.instances, function(instance) {
        var isEventInstance;
        isEventInstance = instance.id === evt.detail.sectionId;
        if (isEventInstance) {
          if (_.isFunction(instance.onUnload)) {
            instance.onUnload(evt);
          }
        }
        return !isEventInstance;
      });
    },
    _onSelect: function(evt) {
      var instance;
      instance = _.find(this.instances, function(instance) {
        return instance.id === evt.detail.sectionId;
      });
      if ((instance != null) && _.isFunction(instance.onSelect)) {
        instance.onSelect(evt);
      }
    },
    _onDeselect: function(evt) {
      var instance;
      instance = _.find(this.instances, function(instance) {
        return instance.id === evt.detail.sectionId;
      });
      if ((instance != null) && _.isFunction(instance.onDeselect)) {
        instance.onDeselect(evt);
      }
    },
    _onBlockSelect: function(evt) {
      var instance;
      instance = _.find(this.instances, function(instance) {
        return instance.id === evt.detail.sectionId;
      });
      if ((instance != null) && _.isFunction(instance.onBlockSelect)) {
        instance.onBlockSelect(evt);
      }
    },
    _onBlockDeselect: function(evt) {
      var instance;
      instance = _.find(this.instances, function(instance) {
        return instance.id === evt.detail.sectionId;
      });
      if ((instance != null) && _.isFunction(instance.onBlockDeselect)) {
        instance.onBlockDeselect(evt);
      }
    },
    register: function(type, constructor) {
      this.constructors[type] = constructor;
      $('[data-section-type=' + type + ']').each((function(index, container) {
        this._createInstance(container, constructor);
      }).bind(this));
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.CollectionTemplateSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.CollectionTemplateSection.prototype = _.assignIn({}, Station.Theme.CollectionTemplateSection.prototype, $ = jQuery, {
    onLoad: function(evt) {
      Station.Theme.Cart.init();
    },
    onSelect: function(evt) {
      Station.Theme.Cart.init();
      Station.Theme.Collection.init();
      return Station.Theme.Currency.init();
    },
    onBlockSelect: function(evt) {
      Station.Theme.Currency.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.FooterSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.FooterSection.prototype = _.assignIn({}, Station.Theme.FooterSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.GrandCentral.Accordions.init();
      Station.GrandCentral.NavSide.init();
      Station.GrandCentral.Notify.init();
      Station.GrandCentral.Tabs.init();
      if (typeof twttr === 'object') {
        twttr.widgets.load();
      }
    },
    onBlockSelect: function(evt) {
      Station.Theme.Currency.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.HeaderSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.HeaderSection.prototype = _.assignIn({}, Station.Theme.HeaderSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.GrandCentral.NavPrimary.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.PasswordTemplateSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.PasswordTemplateSection.prototype = _.assignIn({}, Station.Theme.PasswordTemplateSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.Theme.Password.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.ProductTemplateSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.ProductTemplateSection.prototype = _.assignIn({}, Station.Theme.ProductTemplateSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.Theme.Cart.init();
      Station.Theme.Image.Product.init();
      Station.Theme.Product.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.SidebarSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.SidebarSection.prototype = _.assignIn({}, Station.Theme.SidebarSection.prototype, $ = jQuery, {
    onSelect: function(evt) {
      Station.GrandCentral.Accordions.init();
      Station.GrandCentral.NavSide.init();
      Station.GrandCentral.Notify.init();
      Station.GrandCentral.Tabs.init();
      if (typeof twttr === 'object') {
        twttr.widgets.load();
      }
    },
    onBlockSelect: function(evt) {
      Station.Theme.Currency.init();
    }
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.SlideshowSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
      this.carousel = '#gc-carousel-' + this.sectionId;
      this.$carousel = $(this.carousel);
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.SlideshowSection.prototype = _.assignIn({}, Station.Theme.SlideshowSection.prototype, $ = jQuery, {
    onLoad: function(evt) {
      Station.GrandCentral.Vendor.Flickity.initCarousel(this.$carousel);
    },
    onSelect: function(evt) {
      Station.GrandCentral.Vendor.Flickity.initCarousel(this.$carousel);
    },
    onBlockSelect: function(evt) {
      var $carousel, $cells, $selectedCell, $selectedCellIndex;
      $carousel = this.$carousel;
      $cells = $('.section-block', this.$carousel);
      $selectedCell = $('*[data-block-id="' + evt.detail.blockId + '"]', this.$carousel);
      $selectedCellIndex = $cells.index($selectedCell);
      Station.GrandCentral.Vendor.Flickity.initCarousel(this.$carousel);
      this.$carousel.flickity('pausePlayer').flickity('select', $selectedCellIndex);
    },
    onBlockDeselect: function() {}
  });

}).call(this);

(function() {
  var $;

  Station.Theme = Station.Theme || {};

  Station.Theme.VideoSection = (function($) {
    var init;
    init = function(container) {
      this.$container = $(container);
      this.sectionId = this.$container.attr('data-section-id');
    };
    return init;
  })(jQuery.noConflict());

  Station.Theme.VideoSection.prototype = _.assignIn({}, Station.Theme.VideoSection.prototype, $ = jQuery, {
    onLoad: function(evt) {
      Station.Theme.Base.initFitVids();
    },
    onSelect: function(evt) {
      Station.Theme.Base.initFitFids();
    }
  });

}).call(this);
