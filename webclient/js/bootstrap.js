/* ===================================================
 * bootstrap-transition.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#transitions
 * ===================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  jQuery(function () {

    "use strict"; // jshint ;_;


    /* CSS TRANSITION SUPPORT (http://www.modernizr.com/)
     * ======================================================= */

    jQuery.support.transition = (function () {

      var transitionEnd = (function () {

        var el = document.createElement('bootstrap')
          , transEndEventNames = {
               'WebkitTransition' : 'webkitTransitionEnd'
            ,  'MozTransition'    : 'transitionend'
            ,  'OTransition'      : 'oTransitionEnd otransitionend'
            ,  'transition'       : 'transitionend'
            }
          , name

        for (name in transEndEventNames){
          if (el.style[name] !== undefined) {
            return transEndEventNames[name]
          }
        }

      }())

      return transitionEnd && {
        end: transitionEnd
      }

    })()

  })

}(window.jQuery);
/* =========================================================
 * bootstrap-modal.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#modals
 * =========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* MODAL CLASS DEFINITION
  * ====================== */

  var Modal = function (element, options) {
    this.options = options
    this.jQueryelement = jQuery(element)
      .delegate('[data-dismiss="modal"]', 'click.dismiss.modal', jQuery.proxy(this.hide, this))
    this.options.remote && this.jQueryelement.find('.modal-body').load(this.options.remote)
  }

  Modal.prototype = {

      constructor: Modal

    , toggle: function () {
        return this[!this.isShown ? 'show' : 'hide']()
      }

    , show: function () {
        var that = this
          , e = jQuery.Event('show')

        this.jQueryelement.trigger(e)

        if (this.isShown || e.isDefaultPrevented()) return

        jQuery('body').addClass('modal-open')

        this.isShown = true

        this.escape()

        this.backdrop(function () {
          var transition = jQuery.support.transition && that.jQueryelement.hasClass('fade')

          if (!that.jQueryelement.parent().length) {
            that.jQueryelement.appendTo(document.body) //don't move modals dom position
          }

          that.jQueryelement
            .show()

          if (transition) {
            that.jQueryelement[0].offsetWidth // force reflow
          }

          that.jQueryelement
            .addClass('in')
            .attr('aria-hidden', false)
            .focus()

          that.enforceFocus()

          transition ?
            that.jQueryelement.one(jQuery.support.transition.end, function () { that.jQueryelement.trigger('shown') }) :
            that.jQueryelement.trigger('shown')

        })
      }

    , hide: function (e) {
        e && e.preventDefault()

        var that = this

        e = jQuery.Event('hide')

        this.jQueryelement.trigger(e)

        if (!this.isShown || e.isDefaultPrevented()) return

        this.isShown = false

        jQuery('body').removeClass('modal-open')

        this.escape()

        jQuery(document).off('focusin.modal')

        this.jQueryelement
          .removeClass('in')
          .attr('aria-hidden', true)

        jQuery.support.transition && this.jQueryelement.hasClass('fade') ?
          this.hideWithTransition() :
          this.hideModal()
      }

    , enforceFocus: function () {
        var that = this
        jQuery(document).on('focusin.modal', function (e) {
          if (that.jQueryelement[0] !== e.target && !that.jQueryelement.has(e.target).length) {
            that.jQueryelement.focus()
          }
        })
      }

    , escape: function () {
        var that = this
        if (this.isShown && this.options.keyboard) {
          this.jQueryelement.on('keyup.dismiss.modal', function ( e ) {
            e.which == 27 && that.hide()
          })
        } else if (!this.isShown) {
          this.jQueryelement.off('keyup.dismiss.modal')
        }
      }

    , hideWithTransition: function () {
        var that = this
          , timeout = setTimeout(function () {
              that.jQueryelement.off(jQuery.support.transition.end)
              that.hideModal()
            }, 500)

        this.jQueryelement.one(jQuery.support.transition.end, function () {
          clearTimeout(timeout)
          that.hideModal()
        })
      }

    , hideModal: function (that) {
        this.jQueryelement
          .hide()
          .trigger('hidden')

        this.backdrop()
      }

    , removeBackdrop: function () {
        this.jQuerybackdrop.remove()
        this.jQuerybackdrop = null
      }

    , backdrop: function (callback) {
        var that = this
          , animate = this.jQueryelement.hasClass('fade') ? 'fade' : ''

        if (this.isShown && this.options.backdrop) {
          var doAnimate = jQuery.support.transition && animate

          this.jQuerybackdrop = jQuery('<div class="modal-backdrop ' + animate + '" />')
            .appendTo(document.body)

          if (this.options.backdrop != 'static') {
            this.jQuerybackdrop.click(jQuery.proxy(this.hide, this))
          }

          if (doAnimate) this.jQuerybackdrop[0].offsetWidth // force reflow

          this.jQuerybackdrop.addClass('in')

          doAnimate ?
            this.jQuerybackdrop.one(jQuery.support.transition.end, callback) :
            callback()

        } else if (!this.isShown && this.jQuerybackdrop) {
          this.jQuerybackdrop.removeClass('in')

          jQuery.support.transition && this.jQueryelement.hasClass('fade')?
            this.jQuerybackdrop.one(jQuery.support.transition.end, jQuery.proxy(this.removeBackdrop, this)) :
            this.removeBackdrop()

        } else if (callback) {
          callback()
        }
      }
  }


 /* MODAL PLUGIN DEFINITION
  * ======================= */

  jQuery.fn.modal = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('modal')
        , options = jQuery.extend({}, jQuery.fn.modal.defaults, jQuerythis.data(), typeof option == 'object' && option)
      if (!data) jQuerythis.data('modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option]()
      else if (options.show) data.show()
    })
  }

  jQuery.fn.modal.defaults = {
      backdrop: true
    , keyboard: true
    , show: true
  }

  jQuery.fn.modal.Constructor = Modal


 /* MODAL DATA-API
  * ============== */

  jQuery(function () {
    jQuery('body').on('click.modal.data-api', '[data-toggle="modal"]', function ( e ) {
      var jQuerythis = jQuery(this)
        , href = jQuerythis.attr('href')
        , jQuerytarget = jQuery(jQuerythis.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+jQuery)/, ''))) //strip for ie7
        , option = jQuerytarget.data('modal') ? 'toggle' : jQuery.extend({ remote: !/#/.test(href) && href }, jQuerytarget.data(), jQuerythis.data())

      e.preventDefault()

      jQuerytarget
        .modal(option)
        .one('hide', function () {
          jQuerythis.focus()
        })
    })
  })

}(window.jQuery);
/* ============================================================
 * bootstrap-dropdown.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#dropdowns
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* DROPDOWN CLASS DEFINITION
  * ========================= */

  var toggle = '[data-toggle=dropdown]'
    , Dropdown = function (element) {
        var jQueryel = jQuery(element).on('click.dropdown.data-api', this.toggle)
        jQuery('html').on('click.dropdown.data-api', function () {
          jQueryel.parent().removeClass('open')
        })
      }

  Dropdown.prototype = {

    constructor: Dropdown

  , toggle: function (e) {
      var jQuerythis = jQuery(this)
        , jQueryparent
        , isActive

      if (jQuerythis.is('.disabled, :disabled')) return

      jQueryparent = getParent(jQuerythis)

      isActive = jQueryparent.hasClass('open')

      clearMenus()

      if (!isActive) {
        jQueryparent.toggleClass('open')
        jQuerythis.focus()
      }

      return false
    }

  , keydown: function (e) {
      var jQuerythis
        , jQueryitems
        , jQueryactive
        , jQueryparent
        , isActive
        , index

      if (!/(38|40|27)/.test(e.keyCode)) return

      jQuerythis = jQuery(this)

      e.preventDefault()
      e.stopPropagation()

      if (jQuerythis.is('.disabled, :disabled')) return

      jQueryparent = getParent(jQuerythis)

      isActive = jQueryparent.hasClass('open')

      if (!isActive || (isActive && e.keyCode == 27)) return jQuerythis.click()

      jQueryitems = jQuery('[role=menu] li:not(.divider) a', jQueryparent)

      if (!jQueryitems.length) return

      index = jQueryitems.index(jQueryitems.filter(':focus'))

      if (e.keyCode == 38 && index > 0) index--                                        // up
      if (e.keyCode == 40 && index < jQueryitems.length - 1) index++                        // down
      if (!~index) index = 0

      jQueryitems
        .eq(index)
        .focus()
    }

  }

  function clearMenus() {
    jQuery(toggle).each(function () {
      getParent(jQuery(this)).removeClass('open')
    })
  }

  function getParent(jQuerythis) {
    var selector = jQuerythis.attr('data-target')
      , jQueryparent

    if (!selector) {
      selector = jQuerythis.attr('href')
      selector = selector && /#/.test(selector) && selector.replace(/.*(?=#[^\s]*jQuery)/, '') //strip for ie7
    }

    jQueryparent = jQuery(selector)
    jQueryparent.length || (jQueryparent = jQuerythis.parent())

    return jQueryparent
  }


  /* DROPDOWN PLUGIN DEFINITION
   * ========================== */

  jQuery.fn.dropdown = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('dropdown')
      if (!data) jQuerythis.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call(jQuerythis)
    })
  }

  jQuery.fn.dropdown.Constructor = Dropdown


  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

  jQuery(function () {
    jQuery('html')
      .on('click.dropdown.data-api touchstart.dropdown.data-api', clearMenus)
    jQuery('body')
      .on('click.dropdown touchstart.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
      .on('click.dropdown.data-api touchstart.dropdown.data-api'  , toggle, Dropdown.prototype.toggle)
      .on('keydown.dropdown.data-api touchstart.dropdown.data-api', toggle + ', [role=menu]' , Dropdown.prototype.keydown)
  })

}(window.jQuery);
/* =============================================================
 * bootstrap-scrollspy.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#scrollspy
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* SCROLLSPY CLASS DEFINITION
  * ========================== */

  function ScrollSpy(element, options) {
    var process = jQuery.proxy(this.process, this)
      , jQueryelement = jQuery(element).is('body') ? jQuery(window) : jQuery(element)
      , href
    this.options = jQuery.extend({}, jQuery.fn.scrollspy.defaults, options)
    this.jQueryscrollElement = jQueryelement.on('scroll.scroll-spy.data-api', process)
    this.selector = (this.options.target
      || ((href = jQuery(element).attr('href')) && href.replace(/.*(?=#[^\s]+jQuery)/, '')) //strip for ie7
      || '') + ' .nav li > a'
    this.jQuerybody = jQuery('body')
    this.refresh()
    this.process()
  }

  ScrollSpy.prototype = {

      constructor: ScrollSpy

    , refresh: function () {
        var self = this
          , jQuerytargets

        this.offsets = jQuery([])
        this.targets = jQuery([])

        jQuerytargets = this.jQuerybody
          .find(this.selector)
          .map(function () {
            var jQueryel = jQuery(this)
              , href = jQueryel.data('target') || jQueryel.attr('href')
              , jQueryhref = /^#\w/.test(href) && jQuery(href)
            return ( jQueryhref
              && jQueryhref.length
              && [[ jQueryhref.position().top, href ]] ) || null
          })
          .sort(function (a, b) { return a[0] - b[0] })
          .each(function () {
            self.offsets.push(this[0])
            self.targets.push(this[1])
          })
      }

    , process: function () {
        var scrollTop = this.jQueryscrollElement.scrollTop() + this.options.offset
          , scrollHeight = this.jQueryscrollElement[0].scrollHeight || this.jQuerybody[0].scrollHeight
          , maxScroll = scrollHeight - this.jQueryscrollElement.height()
          , offsets = this.offsets
          , targets = this.targets
          , activeTarget = this.activeTarget
          , i

        if (scrollTop >= maxScroll) {
          return activeTarget != (i = targets.last()[0])
            && this.activate ( i )
        }

        for (i = offsets.length; i--;) {
          activeTarget != targets[i]
            && scrollTop >= offsets[i]
            && (!offsets[i + 1] || scrollTop <= offsets[i + 1])
            && this.activate( targets[i] )
        }
      }

    , activate: function (target) {
        var active
          , selector

        this.activeTarget = target

        jQuery(this.selector)
          .parent('.active')
          .removeClass('active')

        selector = this.selector
          + '[data-target="' + target + '"],'
          + this.selector + '[href="' + target + '"]'

        active = jQuery(selector)
          .parent('li')
          .addClass('active')

        if (active.parent('.dropdown-menu').length)  {
          active = active.closest('li.dropdown').addClass('active')
        }

        active.trigger('activate')
      }

  }


 /* SCROLLSPY PLUGIN DEFINITION
  * =========================== */

  jQuery.fn.scrollspy = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('scrollspy')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.scrollspy.Constructor = ScrollSpy

  jQuery.fn.scrollspy.defaults = {
    offset: 10
  }


 /* SCROLLSPY DATA-API
  * ================== */

  jQuery(window).on('load', function () {
    jQuery('[data-spy="scroll"]').each(function () {
      var jQueryspy = jQuery(this)
      jQueryspy.scrollspy(jQueryspy.data())
    })
  })

}(window.jQuery);
/* ========================================================
 * bootstrap-tab.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#tabs
 * ========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* TAB CLASS DEFINITION
  * ==================== */

  var Tab = function (element) {
    this.element = jQuery(element)
  }

  Tab.prototype = {

    constructor: Tab

  , show: function () {
      var jQuerythis = this.element
        , jQueryul = jQuerythis.closest('ul:not(.dropdown-menu)')
        , selector = jQuerythis.attr('data-target')
        , previous
        , jQuerytarget
        , e

      if (!selector) {
        selector = jQuerythis.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*jQuery)/, '') //strip for ie7
      }

      if ( jQuerythis.parent('li').hasClass('active') ) return

      previous = jQueryul.find('.active a').last()[0]

      e = jQuery.Event('show', {
        relatedTarget: previous
      })

      jQuerythis.trigger(e)

      if (e.isDefaultPrevented()) return

      jQuerytarget = jQuery(selector)

      this.activate(jQuerythis.parent('li'), jQueryul)
      this.activate(jQuerytarget, jQuerytarget.parent(), function () {
        jQuerythis.trigger({
          type: 'shown'
        , relatedTarget: previous
        })
      })
    }

  , activate: function ( element, container, callback) {
      var jQueryactive = container.find('> .active')
        , transition = callback
            && jQuery.support.transition
            && jQueryactive.hasClass('fade')

      function next() {
        jQueryactive
          .removeClass('active')
          .find('> .dropdown-menu > .active')
          .removeClass('active')

        element.addClass('active')

        if (transition) {
          element[0].offsetWidth // reflow for transition
          element.addClass('in')
        } else {
          element.removeClass('fade')
        }

        if ( element.parent('.dropdown-menu') ) {
          element.closest('li.dropdown').addClass('active')
        }

        callback && callback()
      }

      transition ?
        jQueryactive.one(jQuery.support.transition.end, next) :
        next()

      jQueryactive.removeClass('in')
    }
  }


 /* TAB PLUGIN DEFINITION
  * ===================== */

  jQuery.fn.tab = function ( option ) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('tab')
      if (!data) jQuerythis.data('tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.tab.Constructor = Tab


 /* TAB DATA-API
  * ============ */

  jQuery(function () {
    jQuery('body').on('click.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
      e.preventDefault()
      jQuery(this).tab('show')
    })
  })

}(window.jQuery);
/* ===========================================================
 * bootstrap-tooltip.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* TOOLTIP PUBLIC CLASS DEFINITION
  * =============================== */

  var Tooltip = function (element, options) {
    this.init('tooltip', element, options)
  }

  Tooltip.prototype = {

    constructor: Tooltip

  , init: function (type, element, options) {
      var eventIn
        , eventOut

      this.type = type
      this.jQueryelement = jQuery(element)
      this.options = this.getOptions(options)
      this.enabled = true

      if (this.options.trigger == 'click') {
        this.jQueryelement.on('click.' + this.type, this.options.selector, jQuery.proxy(this.toggle, this))
      } else if (this.options.trigger != 'manual') {
        eventIn = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
        eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
        this.jQueryelement.on(eventIn + '.' + this.type, this.options.selector, jQuery.proxy(this.enter, this))
        this.jQueryelement.on(eventOut + '.' + this.type, this.options.selector, jQuery.proxy(this.leave, this))
      }

      this.options.selector ?
        (this._options = jQuery.extend({}, this.options, { trigger: 'manual', selector: '' })) :
        this.fixTitle()
    }

  , getOptions: function (options) {
      options = jQuery.extend({}, jQuery.fn[this.type].defaults, options, this.jQueryelement.data())

      if (options.delay && typeof options.delay == 'number') {
        options.delay = {
          show: options.delay
        , hide: options.delay
        }
      }

      return options
    }

  , enter: function (e) {
      var self = jQuery(e.currentTarget)[this.type](this._options).data(this.type)

      if (!self.options.delay || !self.options.delay.show) return self.show()

      clearTimeout(this.timeout)
      self.hoverState = 'in'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'in') self.show()
      }, self.options.delay.show)
    }

  , leave: function (e) {
      var self = jQuery(e.currentTarget)[this.type](this._options).data(this.type)

      if (this.timeout) clearTimeout(this.timeout)
      if (!self.options.delay || !self.options.delay.hide) return self.hide()

      self.hoverState = 'out'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'out') self.hide()
      }, self.options.delay.hide)
    }

  , show: function () {
      var jQuerytip
        , inside
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp

      if (this.hasContent() && this.enabled) {
        jQuerytip = this.tip()
        this.setContent()

        if (this.options.animation) {
          jQuerytip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, jQuerytip[0], this.jQueryelement[0]) :
          this.options.placement

        inside = /in/.test(placement)

        jQuerytip
          .remove()
          .css({ top: 0, left: 0, display: 'block' })
          .appendTo(inside ? this.jQueryelement : document.body)

        pos = this.getPosition(inside)

        actualWidth = jQuerytip[0].offsetWidth
        actualHeight = jQuerytip[0].offsetHeight

        switch (inside ? placement.split(' ')[1] : placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'top':
            tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        jQuerytip
          .css(tp)
          .addClass(placement)
          .addClass('in')
      }
    }

  , setContent: function () {
      var jQuerytip = this.tip()
        , title = this.getTitle()

      jQuerytip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
      jQuerytip.removeClass('fade in top bottom left right')
    }

  , hide: function () {
      var that = this
        , jQuerytip = this.tip()

      jQuerytip.removeClass('in')

      function removeWithAnimation() {
        var timeout = setTimeout(function () {
          jQuerytip.off(jQuery.support.transition.end).remove()
        }, 500)

        jQuerytip.one(jQuery.support.transition.end, function () {
          clearTimeout(timeout)
          jQuerytip.remove()
        })
      }

      jQuery.support.transition && this.jQuerytip.hasClass('fade') ?
        removeWithAnimation() :
        jQuerytip.remove()

      return this
    }

  , fixTitle: function () {
      var jQuerye = this.jQueryelement
      if (jQuerye.attr('title') || typeof(jQuerye.attr('data-original-title')) != 'string') {
        jQuerye.attr('data-original-title', jQuerye.attr('title') || '').removeAttr('title')
      }
    }

  , hasContent: function () {
      return this.getTitle()
    }

  , getPosition: function (inside) {
      return jQuery.extend({}, (inside ? {top: 0, left: 0} : this.jQueryelement.offset()), {
        width: this.jQueryelement[0].offsetWidth
      , height: this.jQueryelement[0].offsetHeight
      })
    }

  , getTitle: function () {
      var title
        , jQuerye = this.jQueryelement
        , o = this.options

      title = jQuerye.attr('data-original-title')
        || (typeof o.title == 'function' ? o.title.call(jQuerye[0]) :  o.title)

      return title
    }

  , tip: function () {
      return this.jQuerytip = this.jQuerytip || jQuery(this.options.template)
    }

  , validate: function () {
      if (!this.jQueryelement[0].parentNode) {
        this.hide()
        this.jQueryelement = null
        this.options = null
      }
    }

  , enable: function () {
      this.enabled = true
    }

  , disable: function () {
      this.enabled = false
    }

  , toggleEnabled: function () {
      this.enabled = !this.enabled
    }

  , toggle: function () {
      this[this.tip().hasClass('in') ? 'hide' : 'show']()
    }

  , destroy: function () {
      this.hide().jQueryelement.off('.' + this.type).removeData(this.type)
    }

  }


 /* TOOLTIP PLUGIN DEFINITION
  * ========================= */

  jQuery.fn.tooltip = function ( option ) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('tooltip')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.tooltip.Constructor = Tooltip

  jQuery.fn.tooltip.defaults = {
    animation: true
  , placement: 'top'
  , selector: false
  , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
  , trigger: 'hover'
  , title: ''
  , delay: 0
  , html: true
  }

}(window.jQuery);

/* ===========================================================
 * bootstrap-popover.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#popovers
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* POPOVER PUBLIC CLASS DEFINITION
  * =============================== */

  var Popover = function (element, options) {
    this.init('popover', element, options)
  }


  /* NOTE: POPOVER EXTENDS BOOTSTRAP-TOOLTIP.js
     ========================================== */

  Popover.prototype = jQuery.extend({}, jQuery.fn.tooltip.Constructor.prototype, {

    constructor: Popover

  , setContent: function () {
      var jQuerytip = this.tip()
        , title = this.getTitle()
        , content = this.getContent()

      jQuerytip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
      jQuerytip.find('.popover-content > *')[this.options.html ? 'html' : 'text'](content)

      jQuerytip.removeClass('fade top bottom left right in')
    }

  , hasContent: function () {
      return this.getTitle() || this.getContent()
    }

  , getContent: function () {
      var content
        , jQuerye = this.jQueryelement
        , o = this.options

      content = jQuerye.attr('data-content')
        || (typeof o.content == 'function' ? o.content.call(jQuerye[0]) :  o.content)

      return content
    }

  , tip: function () {
      if (!this.jQuerytip) {
        this.jQuerytip = jQuery(this.options.template)
      }
      return this.jQuerytip
    }

  , destroy: function () {
      this.hide().jQueryelement.off('.' + this.type).removeData(this.type)
    }

  })


 /* POPOVER PLUGIN DEFINITION
  * ======================= */

  jQuery.fn.popover = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('popover')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.popover.Constructor = Popover

  jQuery.fn.popover.defaults = jQuery.extend({} , jQuery.fn.tooltip.defaults, {
    placement: 'right'
  , trigger: 'click'
  , content: ''
  , template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
  })

}(window.jQuery);
/* ==========================================================
 * bootstrap-affix.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#affix
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* AFFIX CLASS DEFINITION
  * ====================== */

  var Affix = function (element, options) {
    this.options = jQuery.extend({}, jQuery.fn.affix.defaults, options)
    this.jQuerywindow = jQuery(window).on('scroll.affix.data-api', jQuery.proxy(this.checkPosition, this))
    this.jQueryelement = jQuery(element)
    this.checkPosition()
  }

  Affix.prototype.checkPosition = function () {
    if (!this.jQueryelement.is(':visible')) return

    var scrollHeight = jQuery(document).height()
      , scrollTop = this.jQuerywindow.scrollTop()
      , position = this.jQueryelement.offset()
      , offset = this.options.offset
      , offsetBottom = offset.bottom
      , offsetTop = offset.top
      , reset = 'affix affix-top affix-bottom'
      , affix

    if (typeof offset != 'object') offsetBottom = offsetTop = offset
    if (typeof offsetTop == 'function') offsetTop = offset.top()
    if (typeof offsetBottom == 'function') offsetBottom = offset.bottom()

    affix = this.unpin != null && (scrollTop + this.unpin <= position.top) ?
      false    : offsetBottom != null && (position.top + this.jQueryelement.height() >= scrollHeight - offsetBottom) ?
      'bottom' : offsetTop != null && scrollTop <= offsetTop ?
      'top'    : false

    if (this.affixed === affix) return

    this.affixed = affix
    this.unpin = affix == 'bottom' ? position.top - scrollTop : null

    this.jQueryelement.removeClass(reset).addClass('affix' + (affix ? '-' + affix : ''))
  }


 /* AFFIX PLUGIN DEFINITION
  * ======================= */

  jQuery.fn.affix = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('affix')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('affix', (data = new Affix(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.affix.Constructor = Affix

  jQuery.fn.affix.defaults = {
    offset: 0
  }


 /* AFFIX DATA-API
  * ============== */

  jQuery(window).on('load', function () {
    jQuery('[data-spy="affix"]').each(function () {
      var jQueryspy = jQuery(this)
        , data = jQueryspy.data()

      data.offset = data.offset || {}

      data.offsetBottom && (data.offset.bottom = data.offsetBottom)
      data.offsetTop && (data.offset.top = data.offsetTop)

      jQueryspy.affix(data)
    })
  })


}(window.jQuery);
/* ==========================================================
 * bootstrap-alert.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#alerts
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* ALERT CLASS DEFINITION
  * ====================== */

  var dismiss = '[data-dismiss="alert"]'
    , Alert = function (el) {
        jQuery(el).on('click', dismiss, this.close)
      }

  Alert.prototype.close = function (e) {
    var jQuerythis = jQuery(this)
      , selector = jQuerythis.attr('data-target')
      , jQueryparent

    if (!selector) {
      selector = jQuerythis.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*jQuery)/, '') //strip for ie7
    }

    jQueryparent = jQuery(selector)

    e && e.preventDefault()

    jQueryparent.length || (jQueryparent = jQuerythis.hasClass('alert') ? jQuerythis : jQuerythis.parent())

    jQueryparent.trigger(e = jQuery.Event('close'))

    if (e.isDefaultPrevented()) return

    jQueryparent.removeClass('in')

    function removeElement() {
      jQueryparent
        .trigger('closed')
        .remove()
    }

    jQuery.support.transition && jQueryparent.hasClass('fade') ?
      jQueryparent.on(jQuery.support.transition.end, removeElement) :
      removeElement()
  }


 /* ALERT PLUGIN DEFINITION
  * ======================= */

  jQuery.fn.alert = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('alert')
      if (!data) jQuerythis.data('alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call(jQuerythis)
    })
  }

  jQuery.fn.alert.Constructor = Alert


 /* ALERT DATA-API
  * ============== */

  jQuery(function () {
    jQuery('body').on('click.alert.data-api', dismiss, Alert.prototype.close)
  })

}(window.jQuery);
/* ============================================================
 * bootstrap-button.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#buttons
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* BUTTON PUBLIC CLASS DEFINITION
  * ============================== */

  var Button = function (element, options) {
    this.jQueryelement = jQuery(element)
    this.options = jQuery.extend({}, jQuery.fn.button.defaults, options)
  }

  Button.prototype.setState = function (state) {
    var d = 'disabled'
      , jQueryel = this.jQueryelement
      , data = jQueryel.data()
      , val = jQueryel.is('input') ? 'val' : 'html'

    state = state + 'Text'
    data.resetText || jQueryel.data('resetText', jQueryel[val]())

    jQueryel[val](data[state] || this.options[state])

    // push to event loop to allow forms to submit
    setTimeout(function () {
      state == 'loadingText' ?
        jQueryel.addClass(d).attr(d, d) :
        jQueryel.removeClass(d).removeAttr(d)
    }, 0)
  }

  Button.prototype.toggle = function () {
    var jQueryparent = this.jQueryelement.closest('[data-toggle="buttons-radio"]')

    jQueryparent && jQueryparent
      .find('.active')
      .removeClass('active')

    this.jQueryelement.toggleClass('active')
  }


 /* BUTTON PLUGIN DEFINITION
  * ======================== */

  jQuery.fn.button = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('button')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('button', (data = new Button(this, options)))
      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  jQuery.fn.button.defaults = {
    loadingText: 'loading...'
  }

  jQuery.fn.button.Constructor = Button


 /* BUTTON DATA-API
  * =============== */

  jQuery(function () {
    jQuery('body').on('click.button.data-api', '[data-toggle^=button]', function ( e ) {
      var jQuerybtn = jQuery(e.target)
      if (!jQuerybtn.hasClass('btn')) jQuerybtn = jQuerybtn.closest('.btn')
      jQuerybtn.button('toggle')
    })
  })

}(window.jQuery);
/* =============================================================
 * bootstrap-collapse.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#collapse
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* COLLAPSE PUBLIC CLASS DEFINITION
  * ================================ */

  var Collapse = function (element, options) {
    this.jQueryelement = jQuery(element)
    this.options = jQuery.extend({}, jQuery.fn.collapse.defaults, options)

    if (this.options.parent) {
      this.jQueryparent = jQuery(this.options.parent)
    }

    this.options.toggle && this.toggle()
  }

  Collapse.prototype = {

    constructor: Collapse

  , dimension: function () {
      var hasWidth = this.jQueryelement.hasClass('width')
      return hasWidth ? 'width' : 'height'
    }

  , show: function () {
      var dimension
        , scroll
        , actives
        , hasData

      if (this.transitioning) return

      dimension = this.dimension()
      scroll = jQuery.camelCase(['scroll', dimension].join('-'))
      actives = this.jQueryparent && this.jQueryparent.find('> .accordion-group > .in')

      if (actives && actives.length) {
        hasData = actives.data('collapse')
        if (hasData && hasData.transitioning) return
        actives.collapse('hide')
        hasData || actives.data('collapse', null)
      }

      this.jQueryelement[dimension](0)
      this.transition('addClass', jQuery.Event('show'), 'shown')
      jQuery.support.transition && this.jQueryelement[dimension](this.jQueryelement[0][scroll])
    }

  , hide: function () {
      var dimension
      if (this.transitioning) return
      dimension = this.dimension()
      this.reset(this.jQueryelement[dimension]())
      this.transition('removeClass', jQuery.Event('hide'), 'hidden')
      this.jQueryelement[dimension](0)
    }

  , reset: function (size) {
      var dimension = this.dimension()

      this.jQueryelement
        .removeClass('collapse')
        [dimension](size || 'auto')
        [0].offsetWidth

      this.jQueryelement[size !== null ? 'addClass' : 'removeClass']('collapse')

      return this
    }

  , transition: function (method, startEvent, completeEvent) {
      var that = this
        , complete = function () {
            if (startEvent.type == 'show') that.reset()
            that.transitioning = 0
            that.jQueryelement.trigger(completeEvent)
          }

      this.jQueryelement.trigger(startEvent)

      if (startEvent.isDefaultPrevented()) return

      this.transitioning = 1

      this.jQueryelement[method]('in')

      jQuery.support.transition && this.jQueryelement.hasClass('collapse') ?
        this.jQueryelement.one(jQuery.support.transition.end, complete) :
        complete()
    }

  , toggle: function () {
      this[this.jQueryelement.hasClass('in') ? 'hide' : 'show']()
    }

  }


 /* COLLAPSIBLE PLUGIN DEFINITION
  * ============================== */

  jQuery.fn.collapse = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('collapse')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.collapse.defaults = {
    toggle: true
  }

  jQuery.fn.collapse.Constructor = Collapse


 /* COLLAPSIBLE DATA-API
  * ==================== */

  jQuery(function () {
    jQuery('body').on('click.collapse.data-api', '[data-toggle=collapse]', function (e) {
      var jQuerythis = jQuery(this), href
        , target = jQuerythis.attr('data-target')
          || e.preventDefault()
          || (href = jQuerythis.attr('href')) && href.replace(/.*(?=#[^\s]+jQuery)/, '') //strip for ie7
        , option = jQuery(target).data('collapse') ? 'toggle' : jQuerythis.data()
      jQuerythis[jQuery(target).hasClass('in') ? 'addClass' : 'removeClass']('collapsed')
      jQuery(target).collapse(option)
    })
  })

}(window.jQuery);
/* ==========================================================
 * bootstrap-carousel.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#carousel
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* CAROUSEL CLASS DEFINITION
  * ========================= */

  var Carousel = function (element, options) {
    this.jQueryelement = jQuery(element)
    this.options = options
    this.options.slide && this.slide(this.options.slide)
    this.options.pause == 'hover' && this.jQueryelement
      .on('mouseenter', jQuery.proxy(this.pause, this))
      .on('mouseleave', jQuery.proxy(this.cycle, this))
  }

  Carousel.prototype = {

    cycle: function (e) {
      if (!e) this.paused = false
      this.options.interval
        && !this.paused
        && (this.interval = setInterval(jQuery.proxy(this.next, this), this.options.interval))
      return this
    }

  , to: function (pos) {
      var jQueryactive = this.jQueryelement.find('.item.active')
        , children = jQueryactive.parent().children()
        , activePos = children.index(jQueryactive)
        , that = this

      if (pos > (children.length - 1) || pos < 0) return

      if (this.sliding) {
        return this.jQueryelement.one('slid', function () {
          that.to(pos)
        })
      }

      if (activePos == pos) {
        return this.pause().cycle()
      }

      return this.slide(pos > activePos ? 'next' : 'prev', jQuery(children[pos]))
    }

  , pause: function (e) {
      if (!e) this.paused = true
      if (this.jQueryelement.find('.next, .prev').length && jQuery.support.transition.end) {
        this.jQueryelement.trigger(jQuery.support.transition.end)
        this.cycle()
      }
      clearInterval(this.interval)
      this.interval = null
      return this
    }

  , next: function () {
      if (this.sliding) return
      return this.slide('next')
    }

  , prev: function () {
      if (this.sliding) return
      return this.slide('prev')
    }

  , slide: function (type, next) {
      var jQueryactive = this.jQueryelement.find('.item.active')
        , jQuerynext = next || jQueryactive[type]()
        , isCycling = this.interval
        , direction = type == 'next' ? 'left' : 'right'
        , fallback  = type == 'next' ? 'first' : 'last'
        , that = this
        , e = jQuery.Event('slide', {
            relatedTarget: jQuerynext[0]
          })

      this.sliding = true

      isCycling && this.pause()

      jQuerynext = jQuerynext.length ? jQuerynext : this.jQueryelement.find('.item')[fallback]()

      if (jQuerynext.hasClass('active')) return

      if (jQuery.support.transition && this.jQueryelement.hasClass('slide')) {
        this.jQueryelement.trigger(e)
        if (e.isDefaultPrevented()) return
        jQuerynext.addClass(type)
        jQuerynext[0].offsetWidth // force reflow
        jQueryactive.addClass(direction)
        jQuerynext.addClass(direction)
        this.jQueryelement.one(jQuery.support.transition.end, function () {
          jQuerynext.removeClass([type, direction].join(' ')).addClass('active')
          jQueryactive.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () { that.jQueryelement.trigger('slid') }, 0)
        })
      } else {
        this.jQueryelement.trigger(e)
        if (e.isDefaultPrevented()) return
        jQueryactive.removeClass('active')
        jQuerynext.addClass('active')
        this.sliding = false
        this.jQueryelement.trigger('slid')
      }

      isCycling && this.cycle()

      return this
    }

  }


 /* CAROUSEL PLUGIN DEFINITION
  * ========================== */

  jQuery.fn.carousel = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('carousel')
        , options = jQuery.extend({}, jQuery.fn.carousel.defaults, typeof option == 'object' && option)
        , action = typeof option == 'string' ? option : options.slide
      if (!data) jQuerythis.data('carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action]()
      else if (options.interval) data.cycle()
    })
  }

  jQuery.fn.carousel.defaults = {
    interval: 5000
  , pause: 'hover'
  }

  jQuery.fn.carousel.Constructor = Carousel


 /* CAROUSEL DATA-API
  * ================= */

  jQuery(function () {
    jQuery('body').on('click.carousel.data-api', '[data-slide]', function ( e ) {
      var jQuerythis = jQuery(this), href
        , jQuerytarget = jQuery(jQuerythis.attr('data-target') || (href = jQuerythis.attr('href')) && href.replace(/.*(?=#[^\s]+jQuery)/, '')) //strip for ie7
        , options = !jQuerytarget.data('modal') && jQuery.extend({}, jQuerytarget.data(), jQuerythis.data())
      jQuerytarget.carousel(options)
      e.preventDefault()
    })
  })

}(window.jQuery);
/* =============================================================
 * bootstrap-typeahead.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function(jQuery){

  "use strict"; // jshint ;_;


 /* TYPEAHEAD PUBLIC CLASS DEFINITION
  * ================================= */

  var Typeahead = function (element, options) {
    this.jQueryelement = jQuery(element)
    this.options = jQuery.extend({}, jQuery.fn.typeahead.defaults, options)
    this.matcher = this.options.matcher || this.matcher
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.updater = this.options.updater || this.updater
    this.jQuerymenu = jQuery(this.options.menu).appendTo('body')
    this.source = this.options.source
    this.shown = false
    this.listen()
  }

  Typeahead.prototype = {

    constructor: Typeahead

  , select: function () {
      var val = this.jQuerymenu.find('.active').attr('data-value')
      this.jQueryelement
        .val(this.updater(val))
        .change()
      return this.hide()
    }

  , updater: function (item) {
      return item
    }

  , show: function () {
      var pos = jQuery.extend({}, this.jQueryelement.offset(), {
        height: this.jQueryelement[0].offsetHeight
      })

      this.jQuerymenu.css({
        top: pos.top + pos.height
      , left: pos.left
      })

      this.jQuerymenu.show()
      this.shown = true
      return this
    }

  , hide: function () {
      this.jQuerymenu.hide()
      this.shown = false
      return this
    }

  , lookup: function (event) {
      var items

      this.query = this.jQueryelement.val()

      if (!this.query || this.query.length < this.options.minLength) {
        return this.shown ? this.hide() : this
      }

      items = jQuery.isFunction(this.source) ? this.source(this.query, jQuery.proxy(this.process, this)) : this.source

      return items ? this.process(items) : this
    }

  , process: function (items) {
      var that = this

      items = jQuery.grep(items, function (item) {
        return that.matcher(item)
      })

      items = this.sorter(items)

      if (!items.length) {
        return this.shown ? this.hide() : this
      }

      return this.render(items.slice(0, this.options.items)).show()
    }

  , matcher: function (item) {
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }

  , sorter: function (items) {
      var beginswith = []
        , caseSensitive = []
        , caseInsensitive = []
        , item

      while (item = items.shift()) {
        if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item)
        else if (~item.indexOf(this.query)) caseSensitive.push(item)
        else caseInsensitive.push(item)
      }

      return beginswith.concat(caseSensitive, caseInsensitive)
    }

  , highlighter: function (item) {
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^jQuery|#\s]/g, '\\jQuery&')
      return item.replace(new RegExp('(' + query + ')', 'ig'), function (jQuery1, match) {
        return '<strong>' + match + '</strong>'
      })
    }

  , render: function (items) {
      var that = this

      items = jQuery(items).map(function (i, item) {
        i = jQuery(that.options.item).attr('data-value', item)
        i.find('a').html(that.highlighter(item))
        return i[0]
      })

      items.first().addClass('active')
      this.jQuerymenu.html(items)
      return this
    }

  , next: function (event) {
      var active = this.jQuerymenu.find('.active').removeClass('active')
        , next = active.next()

      if (!next.length) {
        next = jQuery(this.jQuerymenu.find('li')[0])
      }

      next.addClass('active')
    }

  , prev: function (event) {
      var active = this.jQuerymenu.find('.active').removeClass('active')
        , prev = active.prev()

      if (!prev.length) {
        prev = this.jQuerymenu.find('li').last()
      }

      prev.addClass('active')
    }

  , listen: function () {
      this.jQueryelement
        .on('blur',     jQuery.proxy(this.blur, this))
        .on('keypress', jQuery.proxy(this.keypress, this))
        .on('keyup',    jQuery.proxy(this.keyup, this))

      if (jQuery.browser.chrome || jQuery.browser.webkit || jQuery.browser.msie) {
        this.jQueryelement.on('keydown', jQuery.proxy(this.keydown, this))
      }

      this.jQuerymenu
        .on('click', jQuery.proxy(this.click, this))
        .on('mouseenter', 'li', jQuery.proxy(this.mouseenter, this))
    }

  , move: function (e) {
      if (!this.shown) return

      switch(e.keyCode) {
        case 9: // tab
        case 13: // enter
        case 27: // escape
          e.preventDefault()
          break

        case 38: // up arrow
          e.preventDefault()
          this.prev()
          break

        case 40: // down arrow
          e.preventDefault()
          this.next()
          break
      }

      e.stopPropagation()
    }

  , keydown: function (e) {
      this.suppressKeyPressRepeat = !~jQuery.inArray(e.keyCode, [40,38,9,13,27])
      this.move(e)
    }

  , keypress: function (e) {
      if (this.suppressKeyPressRepeat) return
      this.move(e)
    }

  , keyup: function (e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
          break

        case 9: // tab
        case 13: // enter
          if (!this.shown) return
          this.select()
          break

        case 27: // escape
          if (!this.shown) return
          this.hide()
          break

        default:
          this.lookup()
      }

      e.stopPropagation()
      e.preventDefault()
  }

  , blur: function (e) {
      var that = this
      setTimeout(function () { that.hide() }, 150)
    }

  , click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      this.select()
    }

  , mouseenter: function (e) {
      this.jQuerymenu.find('.active').removeClass('active')
      jQuery(e.currentTarget).addClass('active')
    }

  }


  /* TYPEAHEAD PLUGIN DEFINITION
   * =========================== */

  jQuery.fn.typeahead = function (option) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('typeahead')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('typeahead', (data = new Typeahead(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.typeahead.defaults = {
    source: []
  , items: 8
  , menu: '<ul class="typeahead dropdown-menu"></ul>'
  , item: '<li><a href="#"></a></li>'
  , minLength: 1
  }

  jQuery.fn.typeahead.Constructor = Typeahead


 /*   TYPEAHEAD DATA-API
  * ================== */

  jQuery(function () {
    jQuery('body').on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
      var jQuerythis = jQuery(this)
      if (jQuerythis.data('typeahead')) return
      e.preventDefault()
      jQuerythis.typeahead(jQuerythis.data())
    })
  })

}(window.jQuery);
