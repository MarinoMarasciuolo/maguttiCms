/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/website/app.js":
/*!*************************************!*\
  !*** ./resources/js/website/app.js ***!
  \*************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

window.App = function () {
  function handleBootstrap() {
    /*Bootstrap Carousel*/
    $('.carousel').carousel({
      interval: 5000,
      pause: 'hover'
    });
    /*Tooltips*/

    $('.tooltips').tooltip();
    $('.tooltips-show').tooltip('show');
    $('.tooltips-hide').tooltip('hide');
    $('.tooltips-toggle').tooltip('toggle');
    $('.tooltips-destroy').tooltip('destroy');
    /*Popovers*/

    $('.popovers').popover();
    $('.popovers-show').popover('show');
    $('.popovers-hide').popover('hide');
    $('.popovers-toggle').popover('toggle');
    $('.popovers-destroy').popover('destroy');
  }

  function handleNewsletter() {
    $('#form-newsletter').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: urlAjaxHandler + "/api/newsletter",
        data: $("#form-newsletter").serialize(),
        dataType: 'json',
        success: function success(response) {
          var msgHtml = '';

          if (response.status == 'OK') {
            msgHtml += '<h4>' + response.msg + '</h4>';
          } else {
            $.each(response.errors, function (_key, value) {
              msgHtml += '<h4>' + value[0] + '</h4>'; //showing only the first error.
            });
          }

          updateModalAlertMsg(msgHtml);
        },
        error: function error(_ref) {
          var responseJSON = _ref.responseJSON;
          var msgHtml = '';
          $.each(responseJSON.errors, function (_key, value) {
            msgHtml += '<h4>' + value[0] + '</h4>'; //showing only the first error.
          });
          updateModalAlertMsg(msgHtml);
        }
      });
    });
  }

  function handleLightBox() {
    $().fancybox({
      selector: '.lightbox'
    });
    $(".lightbox-iframe").fancybox({
      type: 'iframe',
      iframe: {
        css: {
          width: '800px'
        }
      }
    });
  }

  function handleScrollTo() {
    $(document).on('click', '.scroll-to', function (e) {
      e.preventDefault();
      App.scrollTo($(this).attr('href'));
    });

    if (window.location.hash) {
      App.scrollTo(window.location.hash);
    }
  }

  function handleGhostInputs() {
    $('.form-ghost').each(function () {
      var elem = $(this);
      elem.data('original', elem.val());
    }).blur(function (e) {
      e.preventDefault();
      var elem = $(this);

      if (elem.val() != elem.data('original')) {
        var id = elem.data('id');
        var model = elem.data('model');
        var field = elem.data('field');
        var value = elem.val();
        $.ajax({
          type: 'POST',
          url: '/api/	update-ghost',
          data: {
            id: id,
            model: model,
            field: field,
            value: value,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          dataType: 'json',
          success: function success(response) {
            elem.data('original', value);
            $.each(response.alerts, function () {
              $.smkAlert({
                text: this.text,
                type: this.type,
                time: this.time
              });
            });
          },
          error: function error() {
            $.smkAlert({
              text: trans('website.ghost.error'),
              type: 'danger',
              time: 5
            });
          }
        });
        return true;
      }
    });
  }

  function handleNavbar() {
    // deprecato

    /*
    let WINDOW = $(window);
    WINDOW.on('scroll', function () {
    	checkNavbar();
    });
    checkNavbar();
    */
    $.pbScrollTriger({
      selector: 'nav',
      "class": 'navbar-scrolled',
      use_element_position: false,
      apply_class_to_body: false
    });
  }

  window.myFunc = function (val) {
    return alert(val);
  };

  function initOverrideInvalid() {
    var offset = $('.navbar.fixed-top').outerHeight() + 30;
    document.addEventListener('invalid', function (e) {
      var elem = $(e.target);
      elem.addClass('override-invalid');

      if ($('.override-invalid:visible').length) {
        $('html, body').animate({
          scrollTop: $('.override-invalid:visible').first().offset().top - offset
        }, 0);
      }
    }, true);
    document.addEventListener('change', function (e) {
      $(e.target).removeClass('override-invalid');
    }, true);
  }

  return {
    init: function init() {
      handleBootstrap();
      handleNewsletter();
      handleLightBox();
      handleScrollTo();
      handleGhostInputs();
      handleNavbar();
      initOverrideInvalid();
    },
    scrollTo: function scrollTo(hash) {
      var margin_top = $("nav").outerHeight();
      var elem_top = $(hash).offset().top;
      $('html, body').stop().animate({
        'scrollTop': elem_top - margin_top
      }, 500);
    },
    formValidation: function formValidation(selector) {
      $('#' + selector).submit(function (event) {
        event.preventDefault();
        $.ajax({
          type: 'POST',
          url: urlAjaxHandler + '/api/' + selector,
          data: $('#' + selector).serialize(),
          dataType: 'json',
          success: function success(response) {
            if (response.status == 'ok') {
              $('#' + selector).hide();
              $('#response').show().text(response.msg);
            } else {
              $.each(response.errors, function (key, _value) {
                $('[name="' + key + '"]').addClass('error');
              });
              $('html, body').animate({
                scrollTop: $('#' + selector).offset().top - $('nav').height()
              }, 1200, 'swing');
            }
          }
        });
      });
    }
  };
}();
/******************************** MODAL ************************/


function updateModalAlertMsg($htmlContent) {
  bootbox.alert($htmlContent, function () {});
}

function updateModalBoxMsg($htmlContent) {
  bootbox.confirm($htmlContent, function () {});
}

window.modalPino = function ($htmlContent) {
  bootbox.alert($htmlContent, function () {});
};
/*********************************  localize *********************/


window.trans = function (keystring) {
  var key_array = keystring.split('.');
  var temp_localization = JS_LOCALIZATION;

  var _iterator = _createForOfIteratorHelper(key_array),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var key = _step.value;

      if (key in temp_localization) {
        temp_localization = temp_localization[key];
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  if (typeof temp_localization == 'string') {
    return temp_localization;
  } else {
    return keystring;
  }
};

/***/ }),

/***/ "./resources/sass/website/app.scss":
/*!*****************************************!*\
  !*** ./resources/sass/website/app.scss ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/website/js/app": 0,
/******/ 			"website/css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["website/css/app"], () => (__webpack_require__("./resources/js/website/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["website/css/app"], () => (__webpack_require__("./resources/sass/website/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;