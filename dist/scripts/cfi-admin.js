/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/css/cfi-admin.scss":
/*!***********************************!*\
  !*** ./assets/css/cfi-admin.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./assets/js/admin/cfi-admin.js":
/*!**************************************!*\
  !*** ./assets/js/admin/cfi-admin.js ***!
  \**************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_cfiApp_jsx__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/cfiApp.jsx */ "./assets/js/admin/components/cfiApp.jsx");

var _wp$element = wp.element,
    render = _wp$element.render,
    createElement = _wp$element.createElement;

jquery__WEBPACK_IMPORTED_MODULE_0___default()(function () {
  'use strict';

  jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).ready(function () {
    // Grab the initial data that WP loads
    // This is essentially the current post's terms
    var initialData = window.CFI_DATA; // Make sure we have some initial data

    if (initialData) {
      // Render the UI, always handy
      render(createElement(_components_cfiApp_jsx__WEBPACK_IMPORTED_MODULE_1__["cfiApp"], {
        initialData: initialData
      }), document.getElementById('cfiApp'));
    }
  });
});

/***/ }),

/***/ "./assets/js/admin/components/cfiApp.jsx":
/*!***********************************************!*\
  !*** ./assets/js/admin/components/cfiApp.jsx ***!
  \***********************************************/
/*! exports provided: cfiApp */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cfiApp", function() { return cfiApp; });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }


var Component = wp.element.Component;
var frame;
/**
 * A quick and dirty React app to handle
 * the UI in WordPress.
 * 
 * It's easier than jQuery/JS IMO.
 * 
 * @since 1.0.0
 */

var cfiApp =
/*#__PURE__*/
function (_Component) {
  _inherits(cfiApp, _Component);

  function cfiApp(props) {
    var _this;

    _classCallCheck(this, cfiApp);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(cfiApp).call(this, props)); // Assign initial state

    _this.state = {
      isLoaded: false,
      isSelected: false,
      isProcessing: false,
      hasCustomImage: false,
      statusMessage: '',
      error: false,
      termSelectData: props.initialData,
      activeTerm: 'none',
      activeTermData: {},
      workingData: {},
      currentPost: cfi_ajax.current_post
    };
    _this.handleTermSelect = _this.handleTermSelect.bind(_assertThisInitialized(_this));
    _this.handleSetImageClick = _this.handleSetImageClick.bind(_assertThisInitialized(_this));
    _this.handleRemoveImageClick = _this.handleRemoveImageClick.bind(_assertThisInitialized(_this));
    _this.handleImageUpload = _this.handleImageUpload.bind(_assertThisInitialized(_this));
    _this.handleImageRemove = _this.handleImageRemove.bind(_assertThisInitialized(_this));
    _this.loadTermData = _this.loadTermData.bind(_assertThisInitialized(_this));
    return _this;
  } // Update state when a term is selected


  _createClass(cfiApp, [{
    key: "handleTermSelect",
    value: function handleTermSelect(event) {
      var _this2 = this;

      if (event.target.value === 'none') {
        this.setState({
          activeTerm: event.target.value,
          isSelected: false,
          hasCustomImage: false
        }, function () {// once state is ready, update the new state??
        });
      } else {
        // here we need to fetch the data for the featured image
        this.setState({
          activeTerm: event.target.value,
          isSelected: true
        }, function () {
          // once state is ready, update the new state??
          _this2.loadTermData(_this2.state.currentPost);
        });
      }
    } // Update state when a term is selected

  }, {
    key: "handleSetImageClick",
    value: function handleSetImageClick(event) {
      event.preventDefault();
      var that = this; // If the media frame already exists, reopen it.

      if (frame) {
        frame.open();
        return;
      } // Create a new media frame


      frame = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false,
        // Set to true to allow multiple files to be selected
        library: {
          type: 'image'
        }
      }); // Pre-select image

      frame.on('open', function () {
        var selection = frame.state().get('selection');
        var selected = that.state.workingData.id; // the ID of the image

        if (selected) {
          selection.add(wp.media.attachment(selected));
        }
      }); // When an image is selected in the media frame...

      frame.on('select', function () {
        // Get media attachment details from the frame state
        var attachment = frame.state().get('selection').first().toJSON();
        that.handleImageUpload(attachment);
      }); // Finally, open the modal on click

      frame.open();
    }
  }, {
    key: "handleImageUpload",
    value: function handleImageUpload(attachment_data) {
      var that = this; // First we update the state, this displays the image to the user

      this.setState({
        workingData: attachment_data,
        isProcessing: true,
        hasCustomImage: true
      }); // Next, setup the POST data

      var ajax_data = {
        'action': 'save_custom_image',
        'security': cfi_ajax.nonce,
        'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
        'cfi_post_id': cfi_ajax.current_post,
        'cfi_attachment_id': attachment_data.id
      }; // Send the meta to database through AJAX
      // TODO: replace with wp.ajax.send or similar

      jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
        method: 'POST',
        url: cfi_ajax.url,
        data: ajax_data
      }) // Once it's done, update state again
      .success(function (response) {
        that.setState({
          isProcessing: false,
          statusMessage: response.data.message ? response.data.message : ''
        });
      }).error(function (response) {
        that.setState({
          error: true,
          isProcessing: false,
          hasCustomImage: false,
          statusMessage: response.data.message ? response.data.message : ''
        });
      });
    } // Update state when a term is selected

  }, {
    key: "handleRemoveImageClick",
    value: function handleRemoveImageClick(event) {
      event.preventDefault();
      var that = this;
      that.handleImageRemove(this.state.workingData);
    }
  }, {
    key: "handleImageRemove",
    value: function handleImageRemove(old_data) {
      var that = this; // First we update the state, this displays the image to the user

      this.setState({
        hasCustomImage: false,
        isProcessing: true
      }); // Next, setup the POST data

      var ajax_data = {
        'action': 'remove_custom_image',
        'security': cfi_ajax.nonce,
        'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
        'cfi_post_id': cfi_ajax.current_post,
        'cfi_attachment_id': old_data.id
      }; // Send the meta to database through AJAX

      jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
        method: 'POST',
        url: cfi_ajax.url,
        data: ajax_data
      }) // Once it's done, update state again
      .success(function (response) {
        that.setState({
          isProcessing: false,
          hasCustomImage: false,
          statusMessage: response.data.message ? response.data.message : '',
          workingData: {}
        }); // Maybe trigger a "Saved" notice?
      }).error(function (response) {
        that.setState({
          error: true,
          isProcessing: false,
          hasCustomImage: true,
          statusMessage: response.data.message ? response.data.message : ''
        });
      });
    }
  }, {
    key: "loadTermData",
    value: function loadTermData(post_id) {
      var that = this; // First we update the state, this displays the image to the user

      this.setState({
        hasCustomImage: false,
        isProcessing: true
      }); // Next, setup the POST data

      var ajax_data = {
        'action': 'get_custom_image_ajax',
        'security': cfi_ajax.nonce,
        'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
        'cfi_post_id': post_id
      }; // Fetch the meta to database through AJAX

      jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
        method: 'POST',
        url: cfi_ajax.url,
        data: ajax_data
      }) // Once it's done, update state again
      .success(function (response) {
        if (response.data.attachment) {
          that.setState({
            isProcessing: false,
            hasCustomImage: true,
            statusMessage: response.data.message ? response.data.message : '',
            workingData: response.data.attachment
          });
        } else {
          that.setState({
            isProcessing: false,
            hasCustomImage: false,
            statusMessage: response.data.message ? response.data.message : '',
            workingData: response.data.attachment
          });
        }
      }).error(function (response) {
        that.setState({
          error: true,
          isProcessing: false,
          hasCustomImage: false,
          statusMessage: response.data.message ? response.data.message : ''
        });
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this$state = this.state,
          error = _this$state.error,
          isLoaded = _this$state.isLoaded,
          isProcessing = _this$state.isProcessing,
          isSelected = _this$state.isSelected,
          activeTerm = _this$state.activeTerm,
          activeTermData = _this$state.activeTermData,
          termSelectData = _this$state.termSelectData,
          workingData = _this$state.workingData,
          hasCustomImage = _this$state.hasCustomImage,
          statusMessage = _this$state.statusMessage;
      return React.createElement("div", {
        id: "cfiWrap"
      }, React.createElement("div", {
        className: "cfi-container"
      }, React.createElement("div", {
        id: "cfiConditions"
      }, React.createElement("p", null, React.createElement("strong", null, "Select a term")), React.createElement("select", {
        value: activeTerm,
        className: "cfi-select",
        onChange: this.handleTermSelect
      }, React.createElement("option", {
        value: "none"
      }, "-- Select Term --"), termSelectData.map(function (term) {
        return React.createElement("option", {
          key: term.id,
          value: term.id
        }, term.name);
      })), React.createElement("p", {
        className: "cfi-notif cfi-info"
      }, React.createElement("small", null, "If you don't see any terms listed, make sure to first assign this post to a term, and then update the post and/or refresh the page to see the term in the dropdown."))), React.createElement("div", {
        id: "cfiMedia"
      }, isSelected ? React.createElement("div", null, React.createElement("p", null, React.createElement("strong", null, "Set or update featured image")), React.createElement("div", {
        id: "cfi_custom_img_container",
        className: hasCustomImage ? 'show' : 'hidden'
      }, React.createElement("button", {
        type: "button",
        "aria-lable": "Edit or update the image",
        className: "editor-post-featured-image__preview",
        onClick: this.handleSetImageClick
      }, React.createElement("div", {
        className: "cfi-img-wrapper"
      }, React.createElement("img", {
        src: workingData ? workingData.url : '',
        alt: ""
      })))), React.createElement("div", {
        id: "cfi_loader",
        className: isProcessing ? 'show' : 'hidden'
      }, React.createElement("span", {
        className: "spinner"
      })), React.createElement("p", {
        "class": "hide-if-no-js"
      }, React.createElement("button", {
        className: "upload-custom-img button components-button is-button is-default",
        id: "cfi_upload_img_btn",
        onClick: this.handleSetImageClick
      }, hasCustomImage ? 'Replace image' : 'Set custom image'), React.createElement("button", {
        className: "delete-custom-img components-button is-link is-destructive button-link-delete",
        id: "cfi_remove_img_btn",
        onClick: this.handleRemoveImageClick
      }, "Remove this image")), React.createElement("input", {
        id: "cfi_meta_key",
        name: "cfi_meta_key",
        type: "hidden",
        value: '_cfi_catch_' + activeTerm
      }), React.createElement("input", {
        id: "cfi_cat_id",
        name: "cfi_cat_id",
        type: "hidden",
        value: activeTerm
      }), React.createElement("input", {
        id: "cfi_attachment_id",
        name: "cfi_attachment_id",
        type: "hidden",
        value: workingData ? workingData.id : ''
      }), React.createElement("input", {
        id: "cfi_post_id",
        name: "cfi_post_id",
        type: "hidden",
        value: ""
      })) : React.createElement("p", null, React.createElement("em", null, "Select a term first...")))));
    }
  }]);

  return cfiApp;
}(Component);

/***/ }),

/***/ 0:
/*!************************************************************************!*\
  !*** multi ./assets/js/admin/cfi-admin.js ./assets/css/cfi-admin.scss ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/zachary/Sites/wp-sandbox/src/wp-content/plugins/contextual-featured-images/assets/js/admin/cfi-admin.js */"./assets/js/admin/cfi-admin.js");
module.exports = __webpack_require__(/*! /Users/zachary/Sites/wp-sandbox/src/wp-content/plugins/contextual-featured-images/assets/css/cfi-admin.scss */"./assets/css/cfi-admin.scss");


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ })

/******/ });