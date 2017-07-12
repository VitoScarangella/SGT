(function (root, factory) {
    'use strict';
    if(typeof define === 'function' && define.amd) {
        define(['jquery'], function($){
            factory($);
        });
    } else if(typeof module === 'object' && module.exports) {
        module.exports = (root.EasyZoom = factory(require('jquery')));
    } else {
        root.EasyZoom = factory(root.jQuery);
    }
}(this, function ($) {

    'use strict';

    var dw, dh, rw, rh, lx, ly;



    var defaults = {

        // The text to display within the notice box while loading the zoom image.
        loadingNotice: 'Loading image',

        // The text to display within the notice box if an error occurs when loading the zoom image.
        errorNotice: 'The image could not be loaded',

        // The time (in milliseconds) to display the error notice.
        errorDuration: 2500,

        // Attribute to retrieve the zoom image URL from.
        linkAttribute: 'href',

        // Prevent clicks on the zoom image link.
        preventClicks: true,

        // Callback function to execute before the flyout is displayed.
        beforeShow: $.noop,

        // Callback function to execute before the flyout is removed.
        beforeHide: $.noop,

        // Callback function to execute when the flyout is displayed.
        onShow: $.noop,

        // Callback function to execute when the flyout is removed.
        onHide: $.noop,

        // Callback function to execute when the cursor is moved while over the image.
        onMove: $.noop,

        minWidth: 400

    };

    /**
     * EasyZoom
     * @constructor
     * @param {Object} target
     * @param {Object} options (Optional)
     */
    function EasyZoom(target, options) {
        this.$target = $(target);
        this.opts = $.extend({}, defaults, options, this.$target.data());

        this.isOpen === undefined && this._init();
        this._onEnter(null);
    }

    /**
     * Init
     * @private
     */
    EasyZoom.prototype._init = function() {
        this.$link   = this.$target.find('a');
        this.$image  = this.$target.find('img');

        this.$flyout = $('<div class="easyzoom-flyout" />');
        this.$notice = $('<div class="easyzoom-notice" />');

        this.$target.on({
            'mousemove.easyzoom touchmove.easyzoom': $.proxy(this._onMove, this),
            'mouseleave.easyzoom touchend.easyzoom': $.proxy(this._onLeave, this),
            'mouseenter.easyzoom touchstart.easyzoom': $.proxy(this._onEnter, this),
            'mouseup.easyzoom': $.proxy(this._onClick, this) //EFX
        });
        /*this.opts.preventClicks && this.$target.on('click.easyzoom', function(e) {
            e.preventDefault();
        });*/
    };


    EasyZoom.prototype._show = function(e, testMouseOver) {
      var w1, h1, w2, h2;
      w1 = this.$target.width();
      h1 = this.$target.height();

      w2 = this.$flyout.width();
      h2 = this.$flyout.height();

      dw = this.$zoom.width() - w2;
      dh = this.$zoom.height() - h2;

      // For the case where the zoom image is actually smaller than
      // the flyout.
      if (dw < 0) dw = 0;
      if (dh < 0) dh = 0;

      rw = dw / w1;
      rh = dh / h1;

    };

    /**
     * Show
     * @param {MouseEvent|TouchEvent} e
     * @param {Boolean} testMouseOver (Optional)
     */
    EasyZoom.prototype.show = function(e, testMouseOver) {

        var self = this;
        if (this.opts.beforeShow.call(this) === false) return;

        if (this.$image.css("width") != $("#easyzoom_div").css("width"))
        {
          this.$image.css("width",$("#easyzoom_div").css("width"));
          this.isReady= false;
        }

        if (!this.isReady) {
            return this._loadImage(this.$link.attr(this.opts.linkAttribute), function() {
                if (self.isMouseOver || !testMouseOver) {
                    self.show(e);
                }
            });
        }

        this.$target.append(this.$flyout);

        this._show();
        //this.$image.css("opacity",0.1);

        this.isOpen = true;

        this.opts.onShow.call(this);
        this.zoomfit();

        //if(parseInt(this.$image.css("width"))<parseInt($("#easyzoom_div").css("width")))
        //   this.$image.css({width: $("#easyzoom_div").css("width")});
        e && this._move(e);
    };



    /**
     * On enter
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onClick = function(e) {
        e.preventDefault();
        this._enable = !this._enable;
        this.isMouseOver = this._enable;

        if (this._enable==false) {
          //this.$image.css("opacity",1);
          this.zoomfit();
          e.preventDefault();
          return;
        }
        this.show(e, true);
        this.zoomfit();



    };

    /**
     * On enter
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onEnter = function(e) {
        if (this._enable==false){} else this._enable=true;

        this.isMouseOver = true;

        if (this._enable==false) {
          //this.$image.css("opacity",1);
          e.preventDefault();
          this.zoomfit();
          return;
        }

        var touches = false;
        if(e!=null) touches = e.originalEvent.touches;
        if (!touches || touches.length == 1) {
            if(e!=null) e.preventDefault();
            this.show(e, true);
            this.zoomfit();
        }
    };

    /**
     * On move
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onMove = function(e) {
      if (!this.isOpen) return;
      if (!this._enable) return; //EFX

        e.preventDefault();
        this._move(e);
    };

    /**
     * On leave
     * @private
     */
    EasyZoom.prototype._onLeave = function() {
        this.isMouseOver = false;
        //EFX
        //this.isOpen && this.hide();
    };

    //EFX
    EasyZoom.prototype.resetZoom = function() {
        this.isMouseOver = false;
        this.isOpen && this.hide();
    };

    /**
     * On load
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onLoad = function(e) {
        // IE may fire a load event even on error so test the image dimensions
        if (!e.currentTarget.width) return;

        this.isReady = true;

        this.$notice.detach();
        this.$flyout.html(this.$zoom);
        this.$target.removeClass('is-loading').addClass('is-ready');

        e.data.call && e.data();
    };

    /**
     * On error
     * @private
     */
    EasyZoom.prototype._onError = function() {
        var self = this;

        this.$notice.text(this.opts.errorNotice);
        this.$target.removeClass('is-loading').addClass('is-error');

        this.detachNotice = setTimeout(function() {
            self.$notice.detach();
            self.detachNotice = null;
        }, this.opts.errorDuration);
    };

    /**
     * Load image
     * @private
     * @param {String} href
     * @param {Function} callback
     */
    EasyZoom.prototype._loadImage = function(href, callback) {
        var zoom = new Image;

        this.$target
            .addClass('is-loading')
            .append(this.$notice.text(this.opts.loadingNotice));

        this.$zoom = $(zoom)
            .on('error', $.proxy(this._onError, this))
            .on('load', callback, $.proxy(this._onLoad, this));

        zoom.style.position = 'absolute';
        zoom.src = href;
    };

    /**
     * Move
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._move = function(e) {

        if (e.type.indexOf('touch') === 0) {
            var touchlist = e.touches || e.originalEvent.touches;
            lx = touchlist[0].pageX;
            ly = touchlist[0].pageY;
        } else {
            lx = e.pageX || lx;
            ly = e.pageY || ly;
        }

        var offset  = this.$target.offset();
        var pt = ly - offset.top;
        var pl = lx - offset.left;
        var xt = Math.ceil(pt * rh);
        var xl = Math.ceil(pl * rw);

        // Close if outside
        if (xl < 0 || xt < 0 || xl > dw || xt > dh) {
            //this.hide();
        } else {
            var top = xt * -1;
            var left = xl * -1;

            var hh = parseInt(easyzoom.data('easyZoom').$zoom.css("height"))-parseInt(easyzoom.data('easyZoom').$target.css("height"));
            if (hh<0) top=0;
            else if (-top>hh) top=-hh;

            var ww = parseInt(easyzoom.data('easyZoom').$zoom.css("width"))-parseInt(easyzoom.data('easyZoom').$target.css("width"));
            if (ww<0) left=0;
            else if (-left>ww) left=-ww;

            this.$zoom.css({
                top: top,
                left: left
            });

            this.opts.onMove.call(this, top, left);
        }

    };

    /**
     * Hide
     */
    EasyZoom.prototype.hide = function() {
        if (!this.isOpen) return;
        if (this.opts.beforeHide.call(this) === false) return;

        this.$flyout.detach();
        this.isOpen = false;
        this.isReady = false;
        //this.$image.css("opacity",1);

        this.opts.onHide.call(this);
    };


    /**
     * zoomin
     * EFX
     */
    EasyZoom.prototype.zoomfit = function() {
      var w = parseInt(parseInt(this.$zoom.css("width"))*1.2);
      var h = parseInt(parseInt(this.$zoom.css("height"))*1.2);

      var k = this.opts.minWidth/w;
      console.log(w+".."+h+".."+this.opts.minWidth+".."+k);
      if (k<1) return;
      w = parseInt(w * k);
      h = parseInt(h * k);
      this.$zoom.attr({
        width:  w,
        height: h,
      });
      this._show();
    }


    /**
     * zoomin
     * EFX
     */
    EasyZoom.prototype.zoomin = function() {
      var w = parseInt(parseInt(this.$zoom.css("width"))*1.2);
      var h = parseInt(parseInt(this.$zoom.css("height"))*1.2);
      if (w<parseInt(this.opts.minWidth)) {
        var k = this.opts.minWidth/w;
        w = parseInt(w * k);
        h = parseInt(h * k);
      }
      this.$zoom.attr({
        width: w,
        height: h,
      });
      this._show();
    }

    /**
     * zoomout
     * EFX
     */
    EasyZoom.prototype.zoomout = function() {

      var w = parseInt(parseInt(this.$zoom.css("width"))*0.8);
      var h = parseInt(parseInt(this.$zoom.css("height"))*0.8);
      if (w<parseInt(this.opts.minWidth)) {
        var k = this.opts.minWidth/w;
        w = parseInt(w * k);
        h = parseInt(h * k);
      }
      this.$zoom.attr({
        width: w,
        height: h,
      });

      this._show();

      var hh = parseInt(this.$zoom.css("height"))-parseInt(this.$target.css("height"));
      if (parseInt(this.$zoom.css("top"))<-hh) this.$zoom.css({top:-hh});

      var ww = parseInt(this.$zoom.css("width"))-parseInt(this.$target.css("width"));
      if (parseInt(this.$zoom.css("left"))<-ww) this.$zoom.css({left:-ww});
    }



    /**
     * Swap
     * @param {String} standardSrc
     * @param {String} zoomHref
     * @param {String|Array} srcset (Optional)
     */
    EasyZoom.prototype.swap = function(standardSrc, zoomHref, srcset) {
        this.hide();
        this.isReady = false;

        this.detachNotice && clearTimeout(this.detachNotice);

        this.$notice.parent().length && this.$notice.detach();

        this.$target.removeClass('is-loading is-ready is-error');

        this.$image.css({width: $("#easyzoom_div").css("width")});

        this.$image.attr({
            src: standardSrc,
            srcset: $.isArray(srcset) ? srcset.join() : srcset
        });

        this.$link.attr(this.opts.linkAttribute, zoomHref);

        this.$zoom.css({
            top: 0,
            left: 0
        });
    };

    /**
     * Teardown
     */
    EasyZoom.prototype.teardown = function() {
        this.hide();

        this.$target
            .off('.easyzoom')
            .removeClass('is-loading is-ready is-error');

        this.detachNotice && clearTimeout(this.detachNotice);

        delete this.$link;
        delete this.$zoom;
        delete this.$image;
        delete this.$notice;
        delete this.$flyout;

        delete this.isOpen;
        delete this.isReady;
    };

    // jQuery plugin wrapper
    $.fn.easyZoom = function(options) {
        return this.each(function() {
            var api = $.data(this, 'easyZoom');

            if (!api) {
                $.data(this, 'easyZoom', new EasyZoom(this, options));
            } else if (api.isOpen === undefined) {
                api._init();
            }
        });
    };
}));
