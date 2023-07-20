/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./app/admin.js":
/*!**********************!*\
  !*** ./app/admin.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _handleSettingsPage__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./handleSettingsPage */ \"./app/handleSettingsPage.js\");\n\n\n// Handles store details.\nvar enableStoreDetails = new _handleSettingsPage__WEBPACK_IMPORTED_MODULE_0__[\"default\"]();\nwindow.onload = function (e) {\n  enableStoreDetails.init();\n};\n\n//# sourceURL=webpack://constant-contact-woocommerce/./app/admin.js?");

/***/ }),

/***/ "./app/handleSettingsPage.js":
/*!***********************************!*\
  !*** ./app/handleSettingsPage.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ HandleSettingsPage)\n/* harmony export */ });\nfunction _typeof(obj) { \"@babel/helpers - typeof\"; return _typeof = \"function\" == typeof Symbol && \"symbol\" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && \"function\" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }, _typeof(obj); }\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, \"prototype\", { writable: false }); return Constructor; }\nfunction _toPropertyKey(arg) { var key = _toPrimitive(arg, \"string\"); return _typeof(key) === \"symbol\" ? key : String(key); }\nfunction _toPrimitive(input, hint) { if (_typeof(input) !== \"object\" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || \"default\"); if (_typeof(res) !== \"object\") return res; throw new TypeError(\"@@toPrimitive must return a primitive value.\"); } return (hint === \"string\" ? String : Number)(input); }\n/**\n * GuestCheckoutCapture.\n *\n * @package WebDevStudios\\CCForWoo\n * @since   1.2.0\n */\nvar HandleSettingsPage = /*#__PURE__*/function () {\n  /**\n   * @constructor\n   *\n   * @author Biplav Subedi <biplav.subedi@webdevstudios.com>\n   * @since 2.0.0\n   */\n  function HandleSettingsPage() {\n    _classCallCheck(this, HandleSettingsPage);\n    this.els = {};\n  }\n\n  /**\n   * Init ccWoo admin JS.\n   *\n   * @author Biplav Subedi <biplav.subedi@webdevstudios.com>\n   * @since 2.0.0\n   */\n  _createClass(HandleSettingsPage, [{\n    key: \"init\",\n    value: function init() {\n      this.cacheEls();\n      this.bindEvents();\n      this.enableStoreDetails();\n    }\n\n    /**\n     * Cache some DOM elements.\n     *\n     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>\n     * @since 2.0.0\n     */\n  }, {\n    key: \"cacheEls\",\n    value: function cacheEls() {\n      this.els.enableStoreDetails = document.getElementById('cc_woo_save_store_details');\n      this.els.optionalFields = document.getElementById('cc-optional-fields');\n    }\n\n    /**\n     * Bind callbacks to events.\n     *\n     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>\n     * @since 2.0.0\n     */\n  }, {\n    key: \"bindEvents\",\n    value: function bindEvents() {\n      var _this = this;\n      if (null !== this.els.enableStoreDetails) {\n        this.els.enableStoreDetails.addEventListener('change', function (e) {\n          _this.enableStoreDetails();\n        });\n      }\n    }\n\n    /**\n     * Captures guest checkout if billing email is valid.\n     *\n     * @author Biplav Subedi <biplav.subedi@webdevstudios.com>\n     * @since 2.0.0\n     */\n  }, {\n    key: \"enableStoreDetails\",\n    value: function enableStoreDetails() {\n      if (null !== this.els.enableStoreDetails) {\n        if (this.els.enableStoreDetails.checked) {\n          console.log(this.els.optionalFields.parentElement);\n          this.els.optionalFields.parentElement.style.display = 'block';\n        } else {\n          this.els.optionalFields.parentElement.style.display = 'none';\n        }\n      }\n    }\n  }]);\n  return HandleSettingsPage;\n}();\n\n\n//# sourceURL=webpack://constant-contact-woocommerce/./app/handleSettingsPage.js?");

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
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
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
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./app/admin.js");
/******/ 	
/******/ })()
;