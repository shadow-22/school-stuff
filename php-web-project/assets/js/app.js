jQuery.fn.hasDataAttr = function(name) {
  return $(this)[0].hasAttribute('data-'+ name);
};

jQuery.fn.dataAttr = function(name, def) {
  return $(this)[0].getAttribute('data-'+ name) || def;
};

jQuery.fn.outerHTML = function() {
  var html = '';
  this.each(function() {
    html += $(this).prop("outerHTML");
  })
  return html;
};

jQuery.fn.fullHTML = function() {
  var html = '';
  $(this).each(function() {
    html += $(this).outerHTML();
  });
  return html;
};

'use strict';

+function($, window){
  var app = {
    name:       'Team Null.',
    version:    '1.0.0',
    corejs:     $('script[src*="core.min.js"]').attr('src'),
  };

  app.dir = {
    home:   app.corejs.replace('assets/js/core.min.js', ''),
    assets: app.corejs.replace('js/core.min.js', ''),
    vendor: app.corejs.replace('js/core.min.js', 'vendor/')
  }

  var assets_dir_el = $('[data-assets-url]');
  if ( assets_dir_el.length ) {
    var assets_dir = assets_dir_el.data('assets-url');
    if ( '/' !== assets_dir.slice(-1) ) {
      assets_dir += '/';
    }

    app.dir.assets = assets_dir;
    app.dir.vendor = assets_dir + 'vendor/';
  }

  app.defaults = {

    provide: null,

    // Modaler
    modaler: {
      url: '',
      isModal: false,
      html: '',
      target: '',
      type: '',
      size: '',
      title: '',
      backdrop: true,
      headerVisible: true,
      footerVisible: true,
      confirmVisible: true,
      confirmText: 'Έντάξει',
      confirmClass: 'btn btn-w-sm btn-flat btn-primary',
      cancelVisible: false,
      cancelText: 'Άκυρο',
      cancelClass: 'btn btn-w-sm btn-flat btn-secondary',
      bodyExtraClass: '',
      spinner: '<div class="h-200 center-vh"><svg class="spinner-circle-material-svg" viewBox="0 0 50 50"><circle class="circle" cx="25" cy="25" r="20"></svg></div>',

      autoDestroy: true,
    }
  };

  // Breakpoint values
  app.breakpoint = {
    xs: 576,
    sm: 768,
    md: 992,
    lg: 1200
  };

  // Local variables
  var readyCallbacks = [];


  app.getReadyCallbacksString = function() {
    return readyCallbacks.toString();
  }


  app.ready = function(callback) {
    readyCallbacks.push(callback);
  }

  var count = 0;

  app.isReady = function() {
    count++;
    if (count != 2) {
      return;
    }

    $(function() {

      // Init plugins
      provider.callCallbacks();

      // Run ready callbacks
      for (var i = 0; i < readyCallbacks.length; i++) {

        try {
          readyCallbacks[i]();
        }
        catch(e){
          console.error(e);
        }
      }
      readyCallbacks = [];


      // Preloader
      var preloader = $('.preloader');
      if ( preloader.length ) {
        var speed = preloader.dataAttr('hide-spped', 600);
        preloader.fadeOut(speed);
      }

    });
  };

  app.provide = function(vendors) {
    if ( Array.isArray(vendors) ) {
      var len = vendors.length;
      for (var i = 0; i < len; i++) {
        provider.inject(vendors[i]);
      }
    }
    else {
      provider.inject(vendors);
    }
  };

  app.init = function() {

    provider.init();

    app.initCorePlugins();
    app.initThePlugins();
  };

  // Call a function
  app.call = function(functionName /*, args */) {
    if ( functionName == '' || functionName == 'provider.undefined' ) {
      console.log('UNDEFINED FUNC');
      return;
    }

    var args = Array.prototype.slice.call(arguments, 1);
    var context = window;
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
      context = context[namespaces[i]];
    }

    try {
      return context[func].apply(context, args);
    }
    catch (e) {
      console.error(e);
    }
  };

  // Load a JS file
  app.loadScript = function (url, callback) {
    $.getScript(url, callback);
  };


  // Load a CSS file and insert ot after core.css.min
  app.loadStyle = function(url, base) {
    if ( url == '' ) {
      return;
    }

    if ( base === undefined ) {
      base = '';
    }

    if ( Array.isArray(url) ) {
      for (var i = 0; i < url.length; i++) {
        $('head link:first').after( $('<link href="'+ base + url[i] +'" rel="stylesheet">') );
      }
    }
    else {
      $('head link:first').after( $('<link href="'+ base + url +'" rel="stylesheet">') );
    }
  };

  app.getTarget = function(e) {
    var target;
    if ( e.hasDataAttr('target') ) {
      target = e.data('target');
    }
    else {
      target = e.attr('href');
    }

    if ( target == 'next' ) {
      target = $(e).next();
    }
    else if ( target == 'prev' ) {
      target = $(e).prev();
    }

    if ( target == undefined ) {
      return false;
    }

    return target;
  };

  app.getURL = function(e) {
    var url;
    if ( e.hasDataAttr('url') ) {
      url = e.data('url');
    }
    else {
      url = e.attr('href');
    }

    return url;
  };

  // Config application
  app.config = function(options) {

    // Rteurn config value
    if ( typeof options === 'string' ) {
      return app.defaults[options];
    }

    // Save configs
    $.extend(true, app.defaults, options);

    // Provide required plugins
    if ( app.defaults.provide ) {
      app.provide(app.defaults.provide);
    }
  }

  // Convert data-attributes options to Javascript object
  app.getDataOptions = function(el, castList) {
    var options = {};

    $.each( $(el).data(), function(key, value){

      key = app.dataToOption(key);

      // Escape data-provide
      if ( key == 'provide' ) {
        return;
      }

      if ( castList != undefined ) {
        var type = castList[key];
        switch (type) {
          case 'bool':
          value = Boolean(value);
          break;

          case 'num':
          value = Number(value);
          break;

          case 'array':
          value = value.split(',');
          break;

          default:

        }
      }

      options[key] = value;
    });

    return options;
  }

  // Generate an almost unique ID
  app.guid = function(len) {
    if ( len == undefined) {
      len = 5;
    }
    return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, len);
  }

  // Convert fooBarBaz to foo-bar-baz
  app.optionToData = function(name) {
    return name.replace(/([A-Z])/g, "-$1").toLowerCase();
  }

  // Convert foo-bar-baz to fooBarBaz
  app.dataToOption = function(name) {
    return name.replace(/-([a-z])/g, function(x){return x[1].toUpperCase();});
  }

  // Escape HTML strings
  app.htmlEscape = function(html) {
    var escapeMap = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#x27;',
      '`': '&#x60;'
    };
    var source = '(?:' + Object.keys(escapeMap).join('|') + ')',
    testRegexp = new RegExp(source),
    replaceRegexp = new RegExp(source, 'g'),
    string = html == null ? '' : '' + html;
    return testRegexp.test(string) ? string.replace(replaceRegexp, function (match) {
      return escapeMap[match];
    }) : string;
  }
  window.app = app;
}(jQuery, window);

// provider
+function($, window){

  var provider = {};
  provider.callbacks = [];

  var msobservers = [];
  var loaded = [];
  var firstLoad = true;
  var observer;

  var MsObserver = function(selector, callback) {
    this.selector = selector;
    this.callback = callback;
  }

  provider.init = function() {

    $LAB.setGlobalDefaults({
      BasePath: app.dir.vendor,
      AlwaysPreserveOrder: true,
      AllowDuplicates: false,
    });

    provider.inject();
    provider.observeDOM();
  };

  provider.observeDOM = function() {
    app.ready(function() {
      observer = new MutationObserver(function(mutations) {
        provider.inject();
        for (var i = 0; i < msobservers.length; i++) {
          $(msobservers[i].selector).each(msobservers[i].callback);
        }
      });

      observer.observe(document.body, {childList: true, subtree: true, attributes: false});
    });
  }

  // Plugins should initialize using this function
  provider.provide = function(selector, init_callback, isRawSelector) {

    if ( ! isRawSelector === true ) {
      selector = provider.getSelector(provider.list[selector].selector);
    }

    // Call once per element
    var seen = [];
    var callbackOnce = function() {
      // Do not run script if it's provided from a <script> or has data-init="false"
      if ( $(this).is('script') || $(this).data('init') == false ) {
        return;
      }

      if (seen.indexOf(this) == -1) {
        seen.push(this);
        $(this).each(init_callback);
      }
    }

    $(selector).each(callbackOnce);
    msobservers.push(new MsObserver(selector, callbackOnce));
  };

  provider.inject = function(pluginName) {

    if ( pluginName !== undefined ) {
      var vendor = provider.list[pluginName];

      if ( vendor === undefined ) {
        return;
      }

      // Check if it's already loaded
      if ( loaded.indexOf(pluginName) > -1 ) {
        return;
      }

      // Load css files
      if ( 'css' in vendor ) {
        app.loadStyle(vendor.css, app.dir.vendor);
      }

      // Load js files
      if ( 'js' in vendor ) {
        var js = vendor.js;

        if ( Array.isArray(js) ) {
          for (var i = 0; i < js.length; i++) {
            $LAB.queueScript(js[i]);
          }
        }
        else {
          $LAB.queueScript(js);
        }
      }

      // Queue callbacks
      if ( 'callback' in vendor ) {
        //console.log(vendor.callback);
        $LAB.queueWait(function() {
          app.call('provider.'+ vendor.callback);
        });

      }

      // Add to loaded list
      loaded.push(pluginName);

      $LAB.runQueue();

      return;
    }

    var localCallbacks = [];

    // Fetch dependencies from DOM
    $.each(provider.list, function(name, vendor) {

      // Check if it's already loaded
      if ( loaded.indexOf(name) > -1 ) {
        return;
      }

      // Check if any element exists for the plugin
      if ( ! $( provider.getSelector(vendor.selector) ).length ) {
        return;
      }

      // Load css files
      if ( 'css' in vendor ) {
        app.loadStyle(vendor.css, app.dir.vendor);
      }

      // Load js files
      if ( 'js' in vendor ) {
        var js = vendor.js;

        if ( Array.isArray(js) ) {
          for (var i = 0; i < js.length; i++) {
            $LAB.queueScript(js[i]);
          }
        } else {
          $LAB.queueScript(js);
        }
      }

      // Queue callbacks
      if ( 'callback' in vendor ) {
        localCallbacks.push(vendor.callback);
      }

      // Add to loaded list
      loaded.push(name);

    });

    if (firstLoad) {
      provider.injectExtra();

      $LAB.queueWait(function() {
        provider.callbacks = localCallbacks;
        app.isReady();
      });
      firstLoad = false;
    } else {
      $LAB.queueWait(function() {
        for (var i =0; i < localCallbacks.length; i++) {
          app.call('provider.'+ localCallbacks[i]);
        }
      });
    }
    $LAB.runQueue();
  }

  provider.injectExtra = function() {}

  // Inject plugins if they called in app.ready()
  provider.injectCalledVendors = function() {
    var callbacksStr = app.getReadyCallbacksString();
    var localCallbacks = [];

    var searchList = {}

    $.each(searchList, function(name, keyword){
      if ( callbacksStr.indexOf(keyword) == -1 ) {
        return;
      }
      var vendor = provider.list[name];

      // Check if it's already loaded
      if ( loaded.indexOf(name) > -1 ) {
        return;
      }

      // Load css files
      if ( 'css' in vendor ) {
        app.loadStyle(vendor.css, app.dir.vendor);
      }

      // Load js files
      if ( 'js' in vendor ) {
        var js = vendor.js;

        if ( Array.isArray(js) ) {
          for (var i = 0; i < js.length; i++) {
            $LAB.queueScript(js[i]);
          }
        } else {
          $LAB.queueScript(js);
        }
      }

      // Queue callbacks
      if ( 'callback' in vendor ) {
        localCallbacks.push(vendor.callback);
      }

      // Add to loaded list
      loaded.push(name);
    });

    $LAB.queueWait(function() {
      for (var i =0; i < localCallbacks.length; i++) {
        app.call('provider.'+ localCallbacks[i]);
      }
    });

    $LAB.runQueue();
  }

  provider.callCallbacks = function(list) {
    for (var i =0; i < provider.callbacks.length; i++) {
      app.call('provider.'+ provider.callbacks[i]);
    }
    provider.callbacks = [];
  }

  provider.getSelector = function(str) {
    var selector = '[data-provide~="'+ str +'"]';
    if ( str.indexOf('$ ') == 0 ) {
      selector = str.substr(2);
    }
    return selector;
  }

  window.provider = provider;
}(jQuery, window);


// provider list

+function($){

  provider.list = {

    selectpicker: {
      selector: 'selectpicker',
      callback: 'initSelectpicker',
      css:      'bootstrap-select/css/bootstrap-select.min.css',
      js:       'bootstrap-select/js/bootstrap-select.min.js',
    },

    datepicker: {
      selector: 'datepicker',
      callback: 'initDatepicker',
      css:      'bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
      js:       'bootstrap-datepicker/js/bootstrap-datepicker.min.js',
    },

    timepicker: {
      selector: 'timepicker',
      //callback: '',
      css:      'bootstrap-timepicker/bootstrap-timepicker.min.css',
      js:       'bootstrap-timepicker/bootstrap-timepicker.min.js',
    },

    clockpicker: {
      selector: 'clockpicker',
      callback: 'initClockpicker',
      css:      'bootstrap-clockpicker/bootstrap-clockpicker.min.css',
      js:       'bootstrap-clockpicker/bootstrap-clockpicker.min.js',
    },

    maxlength: {
      selector: 'maxlength',
      callback: 'initMaxlength',
      css:      '',
      js:       'bootstrap-maxlength/bootstrap-maxlength.min.js',
    },

    pwstrength: {
      selector: 'pwstrength',
      callback: 'initPwStrength',
      css:      '',
      js:       'bootstrap-pwstrength/pwstrength-bootstrap.min.js',
    },

    tagsinput: {
      selector: 'tagsinput',
      callback: 'initTagsinput',
      css:      'bootstrap-tagsinput/bootstrap-tagsinput.css',
      js:       'bootstrap-tagsinput/bootstrap-tagsinput.min.js',
    },

    slider: {
      selector: 'slider',
      callback: 'initNouislider',
      css:      'nouislider/nouislider.min.css',
      js:       'nouislider/nouislider.min.js',
    },

    switchery: {
      selector: 'switchery',
      callback: 'initSwitchery',
      css:      'switchery/switchery.min.css',
      js:       'switchery/switchery.min.js',
    },

    formatter: {
      selector: '$ [data-format]',
      callback: 'initFormatter',
      css:      '',
      js:       'formatter/jquery.formatter.min.js',
    },

    validation: {
      selector: 'validation',
      callback: 'initValidation',
      css:      '',
      js:       'bootstrap-validator/validator-bs4.min.js',
    },

    wizard: {
      selector: 'wizard',
      callback: 'initWizard',
      css:      '',
      js:       'bootstrap-wizard/bootstrap-wizard.min.js',
    },

    iconMaterial: {
      selector: '$ .material-icons',
      css:      'material-icons/css/material-icons.css',
    },

    icon7Stroke: {
      selector: '$ [class*="pe-7s-"]',
      css:      [
        'pe-icon-7-stroke/css/pe-icon-7-stroke.min.css',
        'pe-icon-7-stroke/css/helper.min.css'
      ]
    },


    iconIon: {
      selector: '$ [class*="ion-"]',
      css:      'ionicons/css/ionicons.min.css',
    },

    iconI8: {
      selector: '$ [data-i8-icon]',
      callback: 'initI8icons',
      css:      '',
      js:       'i8-icon/jquery-i8-icon.min.js',
    },

    jqueryui: {
      selector: 'jqueryui',
      js:       'jqueryui/jquery-ui.min.js',
    },

    fullcalendar: {
      selector: 'fullcalendar',
      callback: 'initFullcalendar',
      css:      'fullcalendar/fullcalendar.min.css',
      js:       [
        'moment/moment.min.js',
        'fullcalendar/fullcalendar.min.js',
      ]
    },

    animate: {
      selector: '$ .animated',
      css:      'animate/animate.min.css',
    },

    intercoolerjs: {
      selector: '$ [ic-get-from], [ic-post-to], [ic-put-to], [ic-patch-to], [ic-delete-from], [data-ic-get-from], [data-ic-post-to], [data-ic-put-to], [data-ic-patch-to], [data-ic-delete-from]',
      js:       'intercoolerjs/intercoolerjs.min.js',
    },

    vuejs: {
      selector: 'vuejs',
      js:       'vuejs/vue.min.js',
    },

    reactjs: {
      selector: 'reactjs',
      js:       [
        'reactjs/react.min.js',
        'reactjs/react-dom.min.js',
      ],
    },
  }
}(jQuery);

// Form plugins
+function($){


  provider.initForms = function() {

    provider.initSelectpicker();
    provider.initDatepicker();
    provider.initClockpicker();
    provider.initMaxlength();
    provider.initStrength();
    provider.initTagsinput();
    provider.initNouislider();
    provider.initSwitchery();
    provider.initFormatter();
    provider.initValidation();
    provider.initWizard();
  };

  // Selectpicker
  provider.initSelectpicker = function() {

    if ( ! $.fn.selectpicker ) {
      return;
    }

    provider.provide('selectpicker', function() {
      $(this).selectpicker({
        iconBase: '',
        tickIcon: 'ti-check',
        style: 'btn-light'
      });
    });

  };

  // Datepicker
  provider.initDatepicker = function() {
    if ( ! $.fn.datepicker ) {
      return;
    }

    $.fn.datepicker.defaults.multidateSeparator = ", ";

    provider.provide('datepicker', function() {
      if ( $(this).prop("tagName") == 'INPUT' ) {
        $(this).datepicker();
      }
      else {
        $(this).datepicker({
          inputs: [$(this).find('input:first'), $(this).find('input:last')]
        });
      }
    });
  };

  // Clockpicker
  provider.initClockpicker = function() {
    if ( ! $.fn.clockpicker ) {
      return;
    }

    provider.provide('clockpicker', function() {
      $(this).clockpicker({
        donetext: 'Done'
      });
    });

  }

  // Max length control
  provider.initMaxlength = function() {
    if ( ! $.fn.maxlength ) {
      return;
    }

    provider.provide('maxlength', function() {
      var options = {
        warningClass: 'badge badge-warning',
        limitReachedClass: 'badge badge-danger',
        placement: 'bottom-right-inside',
      };

      options = $.extend( options, app.getDataOptions( $(this) ));
      $(this).maxlength(options);
    });

  }

  // Password strength
  provider.initPwStrength = function() {
    if ( ! $.fn.pwstrength ) {
      return;
    }

    provider.provide('pwstrength', function() {
      var options = {
        ui : {
          bootstrap4: true,
          progressBarEmptyPercentage: 0,
          showVerdicts: false
        },
        common : {
          usernameField: $(this).dataAttr('username', '#username')
        }
      }

      $(this).pwstrength(options);
      $(this).add( $(this).next() ).wrapAll('<div class="pwstrength"></div>');

      // Vertical progress
      if ( $(this).is('[data-vertical="true"]') ) {
        var height = $(this).outerHeight() - 10,
        right  = -height / 2 + 7,
        bottom = height / 2 + 4;
        $(this).next('.progress').css({
          width: height,
          right: right,
          bottom: bottom
        });
      }
    });
  }

  // Tags input
  provider.initTagsinput = function() {
    if ( ! $.fn.tagsinput ) {
      return;
    }

    provider.provide('tagsinput', function() {
      $(this).tagsinput();
    });
  }

  // NoUiSlider
  provider.initNouislider = function() {
    if ( window['noUiSlider'] === undefined ) {
      return;
    }

    provider.provide('slider', function(index, element){
      var options = {
        range: {
          'min'     : Number( $(this).dataAttr('min', 0) ),
          'max'     : Number( $(this).dataAttr('max', 17) )
        },
        step        : 1,
        start       : $(this).dataAttr('value', 3),
        connect     : 'lower',
        margin      : 0,
        limit       : 20,
        orientation : 'horizontal',
        direction   : 'ltr',
        tooltips    : true,
        animate     : true,
        behaviour   : 'tap',

        format: {
          to: function ( value ) {
            return parseInt(value, 10);
          },
          from: function ( value ) {
            return value;
          }
        }
      }

      options = $.extend( options, app.getDataOptions( $(this) ));

      var target      = $(this).dataAttr('target', 'none');

      // If it's range slider
      if ( typeof options.start === 'string' && options.start.indexOf(',') > -1 ) {
        options.start = options.start.split(",");


        if ( !$(this).hasDataAttr('connect') ) {
          options.connect = true;
        }

        if ( !$(this).hasDataAttr('behaviour') ) {
          options.behaviour = 'tap-drag';
        }
      } else {
        delete options.limit; // Limit option should be available for linear sliders
      }

      // If it's vertical
      if ( options.orientation == 'vertical' ) {
        if ( !$(this).hasDataAttr('direction') ) {
          options.direction = 'rtl';
        }
      }

      // Target
      if ( target != 'none' ) {
        if ( target == 'next' ) {
          target = $(this).next();
        }
        else if ( target == 'prev' ) {
          target = $(this).prev();
        }
      }

      // Create it
      noUiSlider.create(element, options);

      // Event update
      element.noUiSlider.on('update', function(values, handle) {
        var strVal = values.toString();
        $(target).text(strVal).val(strVal);

        if ( $(element).hasDataAttr('on-update') ) {
          app.call( $(element).data('on-update'), values );
        }
      });

      // Event change
      element.noUiSlider.on('change', function(values, handle) {
        if ( $(element).hasDataAttr('on-change') ) {
          app.call( $(element).data('on-change'), values );
        }
      });
    });
  }

  // Switchery
  provider.initSwitchery = function() {
    if ( window['Switchery'] === undefined ) {
      return;
    }

    provider.provide('switchery', function() {
      var options = {
        color: app.colors.primary,
        speed: '0.5s'
      }

      options = $.extend( options, app.getDataOptions( $(this) ));
      new Switchery(this, options);
    });
  }

  // Mask / Formatter
  provider.initFormatter = function() {
    if ( ! $.fn.formatter ) {
      return;
    }

    provider.provide('formatter', function() {
      var options = {
        pattern: $(this).data('format'),
        persistent: $(this).dataAttr('persistent', true),
      }

      $(this).formatter( options );
    });
  }

  // Validator
  provider.initValidation = function() {
    if ( ! $.fn.validator ) {
      return;
    }

    $.fn.validator.Constructor.FOCUS_OFFSET = 100;

    provider.provide('validation', function() {
      $(this).validator();
    });

    $(document).on('click', '[data-perform="validation"]', function() {
      var target = app.getTarget($(this));

      if ( target == undefined) {
        $(this).parents('[data-provide="validation"]').validator('validate');
      } else {
        $(target).parents('[data-provide="validation"]').validator('validate');
      }
    });
  }




  // Wizard
  provider.initWizard = function() {
    if ( ! $.fn.bootstrapWizard ) {
      return;
    }

    provider.provide('wizard', function() {

      var wizard   = $(this);
      var nav_item = $(this).find('.nav-item');
      var tab_pane = $(this).find('.tab-pane');

      wizard.bootstrapWizard({
        tabClass:         'nav-process',
        nextSelector:     '[data-wizard="next"]',
        previousSelector: '[data-wizard="prev"]',
        firstSelector:    '[data-wizard="first"]',
        lastSelector:     '[data-wizard="last"]',
        finishSelector:   '[data-wizard="finish"]',
        backSelector:     '[data-wizard="back"]',

        onTabClick: function(tab, navigation, index) {
          if ( !wizard.is('[data-navigateable="true"]') ) {
            return false;
          }
        },


        onNext: function(tab, navigation, index) {

          var current_index = wizard.bootstrapWizard('currentIndex');
          var curr_tab = tab_pane.eq(current_index);
          var tab = tab_pane.eq(index);

          // Validator
          var validator_selector = '[data-provide="validation"]';
          var validator = curr_tab.find(validator_selector).addBack(validator_selector);
          if ( validator.length ) {
            validator.validator('validate');
            if ( validator.find('.has-error').length ) {
              return false;
            }
          }


          // Callback
          if ( wizard.hasDataAttr('on-next') ) {
            app.call( wizard.data('on-next'), tab, navigation, index );
          }
        },


        onBack: function(tab, navigation, index) {

          // Callback
          if ( wizard.hasDataAttr('on-back') ) {
            app.call( wizard.data('on-back'), tab, navigation, index );
          }
        },


        onPrevious: function(tab, navigation, index) {

          // Callback
          if ( wizard.hasDataAttr('on-previous') ) {
            app.call( wizard.data('on-previous'), tab, navigation, index );
          }
        },

        onTabShow: function(tab, navigation, index) {

          var tab = tab_pane.eq(index);
          var nav = nav_item.eq(index);
          var max = wizard.bootstrapWizard('navigationLength');

          // Finish button
          if ( index == max ) {
            wizard.find('[data-wizard="next"]').addClass('d-none');
            wizard.find('[data-wizard="finish"]').removeClass('d-none');
          } else {
            wizard.find('[data-wizard="next"]').removeClass('d-none');
            wizard.find('[data-wizard="finish"]').addClass('d-none');
          }

          // Nav classes
          navigation.children().removeClass('processing');
          navigation.children(':lt('+ index +'):not(.complete)').addClass('complete');
          nav.addClass('processing');

          if ( !wizard.is('[data-stay-complete="true"]') ) {
            navigation.children(':gt('+ index +').complete').removeClass('complete');
          }

          // Ajax load
          if ( tab.hasDataAttr('url') ) {
            tab.load( tab.data('url') );
          }

          // Callback for tab
          if ( tab.hasDataAttr('callback') ) {
            app.call( tab.data('callback'), tab );
          }

          // Callback for wizard
          if ( wizard.hasDataAttr('on-tab-show') ) {
            app.call( wizard.data('on-tab-show'), tab, navigation, index );
          }

        },

        onFinish: function(tab, navigation, index) {

          var curr_tab = tab_pane.eq(index);

          // Validator
          var validator_selector = '[data-provide="validation"]';
          var validator = curr_tab.find(validator_selector).addBack(validator_selector);
          if ( validator.length ) {
            validator.validator('validate');
            if ( validator.find('.has-error').length ) {
              validator.closest('form').one('submit', function(e) {
                e.preventDefault();
              });
              return false;
            }
          }

          // Navigation
          var nav = nav_item.eq(index);
          nav.addClass('complete').removeClass('processing');

          // Callback
          if ( wizard.hasDataAttr('on-finish') ) {
            app.call( wizard.data('on-finish'), tab, navigation, index );
          }
        },
      });
    });
  }
}(jQuery);

// Icon plugins

+function($) {
  provider.initIcons = function() {

    provider.initI8icons();

  };

  provider.initI8icons = function() {

    provider.provide('iconI8', function() {
      $(document).i8icons(function(icons) {
        icons.defaultIconSetUrl(app.dir.vendor +'i8-icon/i8-color-icons.svg');
      });
    });
  };
}(jQuery);



// UI plugins

+function($){

  provider.initUIs = function() {

    provider.initAnimsition();
    provider.initShepherd();
    provider.initFilterizr();

  };

  // Animsition page transition
  provider.initAnimsition = function() {
    if ( ! $.fn.animsition ) {
      return;
    }

    provider.provide('.animsition', function() {

      $(this).animsition({
        linkElement: '[data-provide~="animsition"], .animsition-link',
        loadingInner: '',
      });
    }, true);

  };

  // Tour
  provider.initShepherd = function() {
    if ( window['Shepherd'] === undefined ) {
      return;
    }

    Shepherd.on('start', function() {
      $('body').prepend('<div class="app-backdrop backdrop-tour"></div>');
    });

    Shepherd.on('inactive', function() {
      $('.app-backdrop.backdrop-tour').remove();
    });
  };
}(jQuery);

// =====================
// Modaler
// =====================
//
+function($) {

  app.modaler = function(options) {

    var setting = $.extend({}, app.defaults.modaler, options);
    var handleCallback = function() {

      // Bootstrap modal events
      if ( setting.onShow ) {
        $('#'+ id).on('show.bs.modal', function(e) {
          app.call( setting.onShow, e);
        });
      }

      if ( setting.onShown ) {
        $('#'+ id).on('shown.bs.modal', function(e) {
          app.call( setting.onShown, e);
        });
      }

      if ( setting.onHide ) {
        $('#'+ id).on('hide.bs.modal', function(e) {
          app.call( setting.onHide, e);
        });
      }

      if ( setting.onHidden ) {
        $('#'+ id).on('hidden.bs.modal', function(e) {
          app.call( setting.onHidden, e);
        });
      }

      // Handle confirm callback
      $('#'+ id).find('[data-perform="confirm"]').on('click', function() {
        // Hasn't set
        if ( setting.onConfirm == null ) {
          return;
        }

        // Is a function
        if ( $.isFunction(setting.onConfirm) ) {
          setting.onConfirm($('#'+ id));
          return;
        }

        // Is string value, so call it
        if ( setting.onConfirm.substring ) {
          app.call( setting.onConfirm, $('#'+ id) );
        }
      });

      // Handle cancel callback
      $('#'+ id).find('[data-perform="cancel"]').on('click', function() {

        // Hasn't set
        if ( setting.onCancel == null ) {
          return;
        }

        // Is a function
        if ( $.isFunction(setting.onCancel) ) {
          setting.onCancel($('#'+ id));
          return;
        }

        // Is string value, so call it
        if ( setting.onCancel.substring ) {
          app.call( setting.onCancel, $('#'+ id) );
        }
      });
    }

    if ( setting.modalId ) {
      $('#'+ setting.modalId).modal('show');
      return;
    }

    var id = 'modal-'+ app.guid();
    if (setting.isModal) {
      $('<div>').load( setting.url, function() {
        $('body').append( $(this).find('.modal').attr('id', id).outerHTML() );
        $('#'+ id).modal('show');
        // Destroy after close
        if ( setting.autoDestroy ) {
          $('#'+ id).on('hidden.bs.modal', function() {
            $('#'+ id).remove();
          });
        } else {
          $(setting.this).attr('data-modal-id', id);
        }

        handleCallback();
      });
    } else {

      switch (setting.size) {
        case 'sm':
        setting.size = 'modal-sm';
        break;

        case 'lg':
        setting.size = 'modal-lg';
        break;

        default:
        //setting.size = '';
      }

      if ( setting.type ) {
        setting.type = 'modal-'+ setting.type;
      }

      // Header code
      var html_header = '';
      if ( setting.headerVisible ) {
        html_header +=
        '<div class="modal-header"> \
        <h5 class="modal-title">'+ setting.title +'</h5> \
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button> \
        </div>';
      }

      // Footer code
      var html_footer = '';
      if ( setting.footerVisible ) {
        html_footer += '<div class="modal-footer">';

        if ( setting.cancelVisible ) {
          html_footer += '<button class="'+ setting.cancelClass +'" data-dismiss="modal" data-perform="cancel">'+ setting.cancelText +'</button>';
        }

        if ( setting.confirmVisible ) {
          html_footer += '<button class="'+ setting.confirmClass +'" data-dismiss="modal" data-perform="confirm">'+ setting.confirmText +'</button>';
        }

        html_footer += '</div>';
      }

      // Modal code
      var modal_html =
      '<div class="modal fade '+ setting.type +'" id="'+ id +'" tabindex="-1"'+ ( !setting.backdrop ? ' data-backdrop="false"' : '') +'> \
      <div class="modal-dialog '+ setting.size +'"> \
      <div class="modal-content"> \
      '+ html_header +' \
      <div class="modal-body '+ setting.bodyExtraClass +'"> \
      '+ setting.spinner +' \
      </div> \
      '+ html_footer +' \
      </div> \
      </div> \
      </div>';

      // Show modal
      $('body').append(modal_html);
      $('#'+ id).modal('show');

      // Destroy after close
      if ( setting.autoDestroy ) {
        $('#'+ id).on('hidden.bs.modal', function() {
          $('#'+ id).remove();
        });
      } else {
        $(setting.this).attr('data-modal-id', id);
      }

      // Load data into the modal
      if ( setting.url ) {
        $('#'+ id).find('.modal-body').load(setting.url, function() {
          //$(this).removeClass('p-a-0');
          handleCallback();
        });
      } else if ( setting.html ) {
        $('#'+ id).find('.modal-body').html(setting.html);
        handleCallback();
      } else if ( setting.target ) {
        $('#'+ id).find('.modal-body').html( $(setting.target).html() );
        handleCallback();
      }
    }
  }

  // Enable data attribute options
  $(document).on('click', '[data-provide~="modaler"]', function() {
    app.modaler( app.getDataOptions($(this)) );
    //app.modaler.apply($(this), options);
  });
}(jQuery);

// =====================
// Quickview
// =====================
//
+function($, window){

  var quickview = {};

  quickview.init = function() {

    $('.quickview-body').perfectScrollbar();

    // Update scrollbar on tab change
    $(document).on('shown.bs.tab', '.quickview-header a[data-toggle="tab"]', function (e) {
      $(this).closest('.quickview').find('.quickview-body').perfectScrollbar('update');
    })

    // Quickview closer
    $(document).on('click', '[data-dismiss="quickview"]', function() {
      quickview.close( $(this).closest('.quickview') );
    });

    // Handle quickview openner
    $(document).on('click', '[data-toggle="quickview"]', function(e) {
      e.preventDefault();
      var target = app.getTarget($(this));

      if (target == false) {
        quickview.close( $(this).closest('.quickview') )
      }
      else {
        quickview.toggle(target);
      }
    });

    // Close quickview when backdrop touches
    $(document).on('click', '.backdrop-quickview', function() {
      var qv = $(this).attr('data-target');
      quickview.close(qv);
    });
    $(document).on('click', '.quickview .close, [data-dismiss="quickview"]', function() {
      var qv = $(this).closest('.quickview');
      quickview.close(qv);
    });

  };

  // Toggle open/close state
  quickview.toggle = function(e) {
    if ( $(e).hasClass('reveal') ) {
      quickview.close(e);
    }
    else {
      quickview.open(e);
    }
  }

  // Open quickview
  quickview.open = function(e) {
    var quickview = $(e);

    // Load content from URL if required
    if ( quickview.hasDataAttr('url') && 'true' !== quickview.data('url-has-loaded') ) {
      quickview.load( quickview.data('url'), function() {
        $('.quickview-body').perfectScrollbar();
        // Don't load it next time, if don't need to
        if ( quickview.hasDataAttr('always-reload') && 'true' === quickview.data('always-reload') ) {

        } else {
          quickview.data('url-has-loaded', 'true');
        }
      });
    }

    // Open it
    quickview.addClass('reveal').not('.backdrop-remove').after('<div class="app-backdrop backdrop-quickview" data-target="'+ e +'"></div>');
  };

  // Close quickview
  quickview.close = function(e) {
    $(e).removeClass('reveal');
    $('.backdrop-quickview').remove();
  };

  window.quickview = quickview;
}(jQuery, window);

// =====================
// Topbar menu (Horizontal menu)
// =====================
//
+function($, window){

  var topbar_menu = {};

  topbar_menu.init = function() {

    // Don't follow in large devices
    var breakon = app.breakpoint.lg;

    if ($('body').hasClass('topbar-toggleable-xs')) {
      breakon = app.breakpoint.xs;
    } else if ($('body').hasClass('topbar-toggleable-sm')) {
      breakon = app.breakpoint.sm;
    } else if ($('body').hasClass('topbar-toggleable-md')) {
      breakon = app.breakpoint.md;
    }

    if ($(document).width() > breakon) {
      return;
    }



    // Slide up/down menu item on click
    //
    $(document).on('click', '.topbar .menu-link', function() {
      var $submenu = $(this).next('.menu-submenu');
      if ($submenu.length < 1)
      return;

      if ($submenu.is(":visible")) {
        $submenu.slideUp(function() {
          $('.topbar .menu-item.open').removeClass('open');
        });
        $(this).removeClass('open');
        return;
      }

      $('.topbar .menu-submenu:visible').slideUp();
      $('.topbar .menu-link').removeClass('open');
      $submenu.slideDown(function() {
        $('.topbar .menu-item.open').removeClass('open');
      });
      $(this).addClass('open');
    });

  };

  window.topbar_menu = topbar_menu;
}(jQuery, window);

// Cards
+function($, window) {
  var cards = {};
  cards.init = function() {
    // Close
    $(document).on('click', '.card-btn-close', function() {
      $(this).parents('.card').fadeOut(600, function() {
        if ($(this).parent().children().length == 1) {
          $(this).parent().remove();
        }
        else {
          $(this).remove();
        }
      });
    });

    // Refresh
    $(document).on('click', '.card-btn-reload', function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var $card = $(this).parents('.card');

      if (url == "#") {
        return;
      }

      $card.find('.card-loading').addClass('reveal');
      $card.find('.card-content').load(url, function() {
        $card.find('.card-loading').removeClass('reveal');
      });
    });
  };

  cards.fix = function() {}
  window.cards = cards;
}(jQuery, window);

// =====================
// App
// =====================
//
+function($){

  // Plugins that embedded inside code.min.js
  app.initCorePlugins = function() {

    provider.initAnimsition();

    // Enable using transform for Popper
    Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false;

    // Enable tooltip
    $('[data-provide~="tooltip"]').each(function() {
      var color = '';

      if ( $(this).hasDataAttr('tooltip-color') ) {
        color = ' tooltip-'+ $(this).data('tooltip-color');
      }

      $(this).tooltip({
        container: 'body',
        trigger: 'hover',
        template: '<div class="tooltip'+ color +'" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
      });
    });

    // Scrollable
    $('.modal-right .modal-body, .modal-left .modal-body').perfectScrollbar();
    $('.scrollable').perfectScrollbar({
      wheelPropagation: false,
      wheelSpeed: .5,
    });

    // Child areas that shouldn't work with Bootstrap's collapse plugin
    $(document).on('click', '.no-collapsing', function(e) {
      e.stopPropagation();
    })
  }

  // Fixes and initializations for the Plugins
  app.initThePlugins = function() {

    // Fix for .nav-tabs dropdown-menu
    $(document).on('click', '.nav-tabs .dropdown-item', function() {
      $(this).siblings('.dropdown-item.active').removeClass('active');
    });

    // Combined group
    var form_combined_selector = '.form-type-combine .form-group, .form-type-combine.form-group, .form-type-combine .input-group-input';
    $(document).on('click', form_combined_selector, function() {
      $(this).find('.form-control').focus();
    });
    $(document).on('focusin', form_combined_selector, function() {
      $(this).addClass('focused');
    });
    $(document).on('focusout', form_combined_selector, function() {
      $(this).removeClass('focused');
    });

    // Material input
    $(document).on('focus', '.form-type-material .form-control:not(.bootstrap-select)', function() {
      materialDoFloat($(this));
    });

    $(document).on('focusout', '.form-type-material .form-control:not(.bootstrap-select)', function() {
      if($(this).val() === "") {
        materialNoFloat($(this));
      }
    });

    $(".form-type-material .form-control").each(function() {
      if ( $(this).val().length > 0 ) {
        if ( $(this).is('[data-provide~="selectpicker"]') ) {
          return;
        }
        materialDoFloat($(this));
      }
    });

    // Select picker
    $(document).on('show.bs.select', '.form-type-material [data-provide~="selectpicker"]', function() {
      materialDoFloat($(this));
    });

    $(document).on('hidden.bs.select', '.form-type-material [data-provide~="selectpicker"]', function() {
      if ( $(this).selectpicker('val').length == 0 ) {
        materialNoFloat($(this));
      }
    });

    $(document).on('loaded.bs.select', '.form-type-material [data-provide~="selectpicker"]', function() {
      if ( $(this).selectpicker('val').length > 0 ) {
        materialDoFloat($(this));
      }
    });

    function materialDoFloat(e) {
      if ( e.parent('.input-group-input').length ) {
        e.parent('.input-group-input').addClass('do-float');
      }
      else {
        e.closest('.form-group').addClass("do-float");
      }
    }

    function materialNoFloat(e) {
      if ( e.parent('.input-group-input').length ) {
        e.parent('.input-group-input').removeClass('do-float');
      }
      else {
        e.closest('.form-group').removeClass("do-float");
      }
    }

    // Sticky block
    $(window).on('scroll', function() {

      var window_top = $(window).scrollTop();

      $('[data-provide~="sticker"]').each(function() {
        if ( !$(this).hasDataAttr('original-top') ) {
          $(this).attr('data-original-top', $(this).offset().top);
        }

        var target      = app.getTarget( $(this) ),
        stick_start = $(this).dataAttr('original-top'),
        stick_end   = $(target).offset().top + $(target).height(),
        el_width    = $(this).width(),
        el_top      = 0;


        if ( topbar.isFixed() ) {
          el_top = $('.topbar').height();
        }


        var styles = {
          left: $(this).offset().left,
          width: el_width,
          top: el_top
        }

        if (window_top > stick_start && window_top <= stick_end) {
          if ( !$(this).hasClass('sticker-stick') ) {
            $(this).addClass('sticker-stick').css(styles);
            $(target).css('margin-top', $(this).height());
          }
        } else {
          $(this).removeClass('sticker-stick');
          $(target).css('margin-top', 0);
        }
      });

    });

    // Media
    // Selectall
    $(document).on('change', '.media-list[data-provide~="selectall"] .media-list-header :checkbox, .media-list[data-provide~="selectall"] .media-list-footer :checkbox', function() {
      var list = $(this).closest('.media-list');
      var checked = $(this).prop("checked");
      $(list).find('.media-list-body .custom-checkbox [type="checkbox"]').each(function() {

        $(this).prop('checked', checked);
        if ( checked ) {
          $(this).closest('.media').addClass('active');
        }
        else {
          $(this).closest('.media').removeClass('active');
        }
      });
    });


    $(document).on('change', '[data-provide~="selectall"] .media .custom-checkbox input', function() {
      if ( $(this).prop("checked") ) {
        $(this).closest('.media').addClass('active');
      }
      else {
        $(this).closest('.media').removeClass('active');
      }
    });

// Click to select
$(document).on('click', '.media[data-provide~="selectable"], .media-list[data-provide~="selectable"] .media:not(.media-list-header):not(.media-list-footer)', function() {
  var input = $(this).find('input');
  input.prop('checked', !input.prop("checked"));

  if ( input.prop("checked") ) {
    $(this).addClass('active');
  }
  else {
    $(this).removeClass('active');
  }
});

// Auto-exapnd textareas
$(document).on('keydown', '.auto-expand', function() {
  var e = $(this);
  setTimeout(function() {
    e.scrollTop(0).css('height', e.prop('scrollHeight') +'px');
  },0);
});

// Input range
//
$(document).on('change mousemove', '.input-range input', function() {
  $(this).closest('.input-range').find('.value').text($(this).val());
});

// Avatar

// Remove button
$(document).on('click', '.avatar-pill .close', function() {
  $(this).closest('.avatar').fadeOut(function() {
    $(this).remove();
  });
});

// More button
$(document).on('click', '[data-provide~="more-avatar"]', function() {
  var list = $(this).closest('.avatar-list');

  $(this).fadeOut(function() {
    $(this).remove();

    if ( $(this).hasDataAttr('url') ) {
      $('<div>').load( $(this).data('url'), function() {
        var avatars = $(this).html();
        list.append(avatars);
      });

    }
  });
});

// Tabs
$(document).on('click', '[data-dismiss="tab"]', function() {
  $(this).closest('.nav-item').fadeOut(function() {
    $(this).remove();
  });
});

// Loader
$(document).on('click', '[data-provide~="loader"]', function(e) {
  e.preventDefault();

  var target  = app.getTarget( $(this) );
  var url     = app.getURL( $(this) );

  if ( $(this).hasDataAttr('spinner') ) {
    var spinner = $(this).data('spinner');
    $(target).html(spinner);
  }

  $(target).load(url);
});
}}(jQuery);


// initialize app
//
+function($) {
  app.init();
  topbar_menu.init();
  quickview.init();

  cards.init();

  app.isReady();

}(jQuery);
