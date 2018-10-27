/**
 * jqKeyboard - jQuery-based virtual keyboard
 * @version v1.0.1
 * @link https://github.com/hAWKdv/jqKeyboard#readme
 * @license MIT
 */
/* globals -jqKeyboard */
var jqKeyboard = jqKeyboard || {};

(function (jqKeyboard, $) {
  'use strict';

  // CONSTANTS
  var DEF_ALLOWED_ELEMENTS = 'input[type="text"], textarea, input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="password"], input[type="search"], input[type="month"], inpu[type="url"], input[type="time"], input[type="tel"], input[type="week"], input[type="number"]',
    NORM_BTN_CLASS = 'normal',
    SHFT_BTN_CLASS = 'shift-b',
    SPEC_BTN_CLASS = 'special',
    BUTTON_CLASS = 'jqk-btn',
    LANG_BTN_CLASS = 'jqk-lang-btn',
    SELECTED_ITEM_CLASS = 'selected',
    CLICKED_CLASS = 'clicked',
    MIN_BTN_CLASS = 'minimize-btn',
    TOGGLE_JQK_ID = 'jqk-toggle-btn',
    BTN_ROW_CLASS = 'btn-row',
    HIDE_CLASS = 'jqk-hide',
    DARK_ICN_CLASS = 'dark',
    BASE_ID = 'jq-keyboard',
    LANG_CONT_ID = 'jqk-lang-cont',
    LNG_CLASS_POSTFIX = '-lang',
    CONT_START_POINT = 0,
    LAYOUTS_LIMIT = 3,

    // MODULES
    Visualization = {},
    EventManager = {},
    Helpers = {},
    UIController = {},
    Core = {};

  /*
   * HELPERS MODULE
   * */
  Helpers = {

    // Returns the result string after a new character is inserted/added.
    insertCharacter: function (string, selection, char) {
      return string.slice(0, selection.start) + char + string.slice(selection.end);
    },

    // Returns the result string after using backspace.
    backspaceStrManipulation: function (string, selection, caretOffset) {
      if (selection.start === 0 && selection.end === 0) {
        return string;
      }

      return string.slice(0, selection.start - caretOffset) + string.slice(selection.end);
    },

    // Returns the currently selected language class.
    getSelectedLangClass: function () {
      return '.' + Core.selectedLanguage + LNG_CLASS_POSTFIX;
    },

    /*
     * Credits goes to kd7
     * Source: http://stackoverflow.com/questions/512528/set-cursor-position-in-html-textbox
     * */
    setCaretPosition: function (elem, caretPos) {
      var range;

      if (elem !== null) {
        if (elem.createTextRange) {
          range = elem.createTextRange();

          range.move('character', caretPos);
          range.select();
        } else {
          if (elem.selectionStart) {
            elem.focus();
            elem.setSelectionRange(caretPos, caretPos);
          } else {
            elem.focus();
          }
        }
      }
    }
  };


	/*
	 * VISUALIZATION MODULE
	 * The module purpose is to render all the keyboard layouts - frame, buttons, etc.
	 * */
  Visualization = {

    // ENTRY POINT
    // Creates the main frame/base of the keyboard and attaches the drag event to it.
    $$createBase: function () {
      var $body = $('body'),
          contDefaultX,
          contDefaultY;

      this.$base = $('<div>').attr('id', BASE_ID);
      this.$langCont = $('<div>').attr('id', LANG_CONT_ID);
      this.$minBtn = $('<div>').addClass(MIN_BTN_CLASS).prop('title', 'Minimize');
      this.$toggleBtn = $('<div>').attr('id', TOGGLE_JQK_ID);

      if (Core.options && Core.options.icon === 'dark') {
        this.$toggleBtn.addClass(DARK_ICN_CLASS);
      }

      this.$langCont.append(this.$minBtn);
      this.$base.append(this.$langCont);
      $body.append(this.$toggleBtn);

      // Creates all defined layouts
      this.createLayout();

      if (Core.options && Core.options.containment) {
        this.containment = $(Core.options.containment);
        this.containment.append(this.$base);
      } else {
        $body.append(this.$base);

        contDefaultX = $(window).outerWidth() - this.$base.outerWidth();
        contDefaultY = $(window).outerHeight() - this.$base.outerHeight();

        this.containment = [CONT_START_POINT, CONT_START_POINT, contDefaultX, contDefaultY];

        this.maintainContainment();
      }
    },

    // Keeps the user defined containment of the keyboard on window resize.
    maintainContainment: function () {
      var resizeTimer;

      $(window).resize(function () {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(function () {
          var contDefaultX = $(window).outerWidth() - Visualization.$base.outerWidth(),
              contDefaultY = $(window).outerHeight() - Visualization.$base.outerHeight(),
              updatedContainment = [CONT_START_POINT, CONT_START_POINT, contDefaultX, contDefaultY];

          Visualization.$base.draggable('option', 'containment', updatedContainment);
        }, 100);
      });
    },

    // Creates all defined layouts
    createLayout: function () {
      var layoutsNum = jqKeyboard.layouts.length,
          $generatedLayout,
          layoutObj,
          i;

      for (i = 0; i < layoutsNum && i < LAYOUTS_LIMIT; i += 1) {
        layoutObj = jqKeyboard.layouts[i];

        $generatedLayout = this.createButtons(layoutObj, i);
        this.createLangSwitchBtn(layoutObj.lang, i);

        this.$base.append($generatedLayout);
      }
    },

    // Creates the buttons for the specified layout.
    createButtons: function (layoutObj, idx) {
      var $layoutCont = $('<div>').addClass(layoutObj.lang + LNG_CLASS_POSTFIX),
          $row,
          $button,
          buttons,
          i, j;

      if (idx > 0) {
        $layoutCont.addClass(HIDE_CLASS);
      }

      for (i = 0; i < layoutObj.layout.length; i += 1) {
        $row = $('<div>').addClass(BTN_ROW_CLASS);
        buttons = layoutObj.layout[i].split(' ');

        for (j = 0; j < buttons.length; j += 1) {
          $button = this.buildButtonFromString(buttons[j]);
          $row.append($button);
        }

        $layoutCont.append($row);
      }

      return $layoutCont;
    },

    // Returns <button> from a given command string.
    buildButtonFromString: function (button) {
      var $button = $('<button>').addClass(BUTTON_CLASS);

      // Normal/regular
      if (button.length === 1) {
        $button.addClass(NORM_BTN_CLASS)
          .data('val', button) // Container for the value.
          .html(button);
      }
      // Shift-active
      else if (button.length === 3) {
        $button.addClass(SHFT_BTN_CLASS)
          .data('val', button[0]) // Container for the current value. 'Normal' by default.
          .data('shift', button[2]) // Defines the shift value
          .data('normal', button[0]) // Defines the normal value
          .html(button[0]);
      }
      // Special
      else if (button.indexOf('<<') !== -1 && button.indexOf('>>') !== -1) {
        $button = this.createSpecialBtn($button, button);
      }

      return $button;
    },

    /* Creates a special button.
     * Special buttons: Space, Backspace, Enter, Tab, Shift, CapsLock
     * */
    createSpecialBtn: function ($button, button) {
      var buttonStr = button.replace('<<', '').replace('>>', '');

      switch (buttonStr) {
        case 'space':
          $button.data('val', ' ');
          break;
        case 'tab':
          $button.data('val', '\t');
          break;
        case 'enter':
          $button.data('val', '\n');
          break;
      }

      $button.addClass(SPEC_BTN_CLASS + ' ' + buttonStr).html('&nbsp;');
      // NB space is needed for visual purposes .............. ^^^^^^

      return $button;
    },

    // Renders the language/layout switcher
    createLangSwitchBtn: function (language, idx) {
      var $button = $('<button>')
        .addClass(LANG_BTN_CLASS)
        .data('lang', language)
        .html(language.toUpperCase());

      if (idx === 0) {
        $button.addClass(SELECTED_ITEM_CLASS);
        Core.selectedLanguage = language;
      }

      this.$langCont.append($button);
    }
  };


  /*
   * EVENTMANAGER MODULE
   * Manages all keyboard related events - button functionality, language switching, etc.
   *
   * Function description:
   * - $$....() - Entry point / module runner.
   * - _.....() - Functions out of module runner scope (sort of helpers).
   * */
  EventManager = {
    // Module-specific constants
    SHIFT_CLASS: '.' + SPEC_BTN_CLASS + '.shift',
    CPSLCK_CLASS: '.' + SPEC_BTN_CLASS + '.capslock',

    // Module-specific variables

    /* Keeps track if language/layout specific events are already loaded.
     * Language-specific events: CapsLock and Shift */
    areLangEventsLoaded: {},

    // Language/layout switching functionality.
    loadLanguageSwitcher: function () {
      $('.' + LANG_BTN_CLASS).on('click', function () {
        var $this = $(this),
            newLang = $this.data('lang'),
            newLangClass = '.' + newLang + LNG_CLASS_POSTFIX,
            currentLngClass = Helpers.getSelectedLangClass();

        EventManager._resetCaretOfActiveElem();

        // If already selected - abort
        if (currentLngClass === newLangClass) {
          return;
        }

        // Visually update the language bar
        $(currentLngClass).addClass(HIDE_CLASS);
        $(newLangClass).removeClass(HIDE_CLASS);
        $('.' + LANG_BTN_CLASS + '.' + SELECTED_ITEM_CLASS).removeClass(SELECTED_ITEM_CLASS);
        $this.addClass(SELECTED_ITEM_CLASS);

        Core.selectedLanguage = newLang;

        // Assign CapsLock and Shift events to their corresponding layout/language
        if (!EventManager.areLangEventsLoaded[Core.selectedLanguage]) {
          EventManager.loadCapsLockEvent();
          EventManager.loadShiftEvent();

          EventManager.areLangEventsLoaded[Core.selectedLanguage] = true;
        }
      });
    },

    // CAPSLOCK functionality.
    loadCapsLockEvent: function () {
      var lngClass = Helpers.getSelectedLangClass();

      this._onLocalButtonClick(EventManager.CPSLCK_CLASS, function () {
        var $this, $parent;

        EventManager._resetCaretOfActiveElem();

        if (Core.shift[Core.selectedLanguage]) {
          return;
        }

        $this = $(this);
        $parent = $this.closest(lngClass); // Modify only selected layout

        if (Core.capsLock[Core.selectedLanguage]) {
          $this.removeClass(SELECTED_ITEM_CLASS);
          Core.capsLock[Core.selectedLanguage] = false;
        } else {
          $this.addClass(SELECTED_ITEM_CLASS);
          Core.capsLock[Core.selectedLanguage] = true;
        }

        // Set all buttons to upper or lower case
        EventManager._traverseLetterButtons($parent, Core.capsLock[Core.selectedLanguage]);
      });
    },

    // SHIFT functionality.
    loadShiftEvent: function () {
      var lngClass = Helpers.getSelectedLangClass();

      this._onLocalButtonClick(EventManager.SHIFT_CLASS, function () {
        var $lngClass = $(lngClass),
            $shiftButtons = $lngClass.find(EventManager.SHIFT_CLASS),
            $capsLock = $lngClass.find(EventManager.CPSLCK_CLASS),
            $parent;

        EventManager._resetCaretOfActiveElem();

        if (Core.shift[Core.selectedLanguage]) {
          EventManager._unshift();
          return;
        }

        if (Core.capsLock[Core.selectedLanguage]) {
          $capsLock.removeClass(SELECTED_ITEM_CLASS);
          Core.capsLock[Core.selectedLanguage] = false;
        }

        $parent = $(this).closest(lngClass);

        EventManager._traverseInputButtons($parent, true, 'shift');

        Core.shift[Core.selectedLanguage] = true;
        // Not using $(this) since we have to change all shift buttons
        $shiftButtons.addClass(SELECTED_ITEM_CLASS);
      });
    },

    // BACKSPACE functionality.
    loadBackspaceEvent: function () {
      $('.' + SPEC_BTN_CLASS + '.backspace').on('click', function () {
        EventManager._onActiveElemTextManipulation(
          function (selection, currentContent) {
            var backspaceCaretOffset;

            if (selection.start === selection.end) {
              backspaceCaretOffset = 1;
            } else {
              backspaceCaretOffset = 0;
            }

            return {
              updatedContent: Helpers.backspaceStrManipulation(currentContent, selection, backspaceCaretOffset),
              caretOffset: -backspaceCaretOffset
            };
          }
        );
      });
    },

    // INPUT BUTTONS functionality (All those who are entering text).
    loadInputButtonEvent: function () {
      Visualization.$base
        .find('.' + NORM_BTN_CLASS) // Normal
        .add('.' + SHFT_BTN_CLASS) // Shift-active
        .add('.' + SPEC_BTN_CLASS + '.space')
        .add('.' + SPEC_BTN_CLASS + '.tab')
        .add('.' + SPEC_BTN_CLASS + '.enter')
        .on('click', function () {
          var selectedBtnVal = $(this).data('val');

          EventManager._onActiveElemTextManipulation(function (selection, currentContent) {
            return {
              updatedContent: Helpers.insertCharacter(currentContent, selection, selectedBtnVal),
              caretOffset: 1
            };
          });

          if (Core.shift[Core.selectedLanguage]) {
            EventManager._unshift();
          }
        });
    },

    // Changes the active element on each new cursor focus
    activeElementListener: function () {
      var allowedElements;

      // Pick user-assigned allowed elements or default ones
      if (Core.options && Core.options.allowed) {
        allowedElements = Core.options.allowed.join(', ');
      } else {
        allowedElements = DEF_ALLOWED_ELEMENTS;
      }

      // Set
      $(allowedElements).focus(function () {
        EventManager.$activeElement = $(this);
      });
    },

    /* Modifies the current active element content according the requested operation.
     * Used on text manipulation - entering or deleting content (text). */
    _onActiveElemTextManipulation: function (btnFunctionality) {
      var activeElemNative,
          currentContent,
          btnPressResult,
          selection;

      if (EventManager.$activeElement) {
        currentContent = EventManager.$activeElement.val() || '';
        activeElemNative = EventManager.$activeElement[0];

        selection = {
          start: activeElemNative.selectionStart,
          end: activeElemNative.selectionEnd
        };

        btnPressResult = btnFunctionality(selection, currentContent);

        EventManager.$activeElement.val(btnPressResult.updatedContent);
        Helpers.setCaretPosition(activeElemNative, selection.start + btnPressResult.caretOffset);
      }
    },

    // Resets the caret to the same position of the currently selected active element.
    _resetCaretOfActiveElem: function () {
      if (!this.$activeElement) {
        return;
      }

      Helpers.setCaretPosition(this.$activeElement[0], this.$activeElement[0].selectionStart);
    },

    // Returns all the buttons in their normal state (Opposite of .loadShiftEvent())
    _unshift: function () {
      var lngClass = Helpers.getSelectedLangClass(),
          $shiftButtons = $(Helpers.getSelectedLangClass()).find(EventManager.SHIFT_CLASS),
          $parent = $shiftButtons.closest(lngClass);

      this._traverseInputButtons($parent, false, 'normal');

      Core.shift[Core.selectedLanguage] = false;
      $shiftButtons.removeClass(SELECTED_ITEM_CLASS);
    },

    // Provides layout/language localized click event of a provided button.
    _onLocalButtonClick: function (button, handler) {
      Visualization.$base
        .find(Helpers.getSelectedLangClass())
        .find(button)
        .on('click', handler);
    },

    // Traverses through all of the letter/normal buttons.
    _traverseLetterButtons: function ($parent, shouldBeUpper) {
      $parent.find('.' + NORM_BTN_CLASS).each(function () {
        var $this = $(this),
            value = $this.data('val');

        if (shouldBeUpper) {
          value = value.toUpperCase();
        } else {
          value = value.toLowerCase();
        }

        $this.html(value).data('val', value);
      });
    },

    // Traverses through all input buttons.
    _traverseInputButtons: function ($parent, shouldBeUpper, shiftBtnValueSource) {
      // Normal
      this._traverseLetterButtons($parent, shouldBeUpper);

      // Shift-active
      $parent.find('.' + SHFT_BTN_CLASS).each(function () {
        var $this = $(this),

          /* Select the source of the wanted button state
           * Can be 'normal' or in 'shift' mode */
          value = $this.data(shiftBtnValueSource);

        $this.html(value).data('val', value);
      });
    },

    // ENTRY POINT
    // Used for selecting which events to load at once.
    $$loadEvents: function () {
      this.activeElementListener();
      this.loadLanguageSwitcher();
      this.loadInputButtonEvent();
      this.loadBackspaceEvent();
      this.loadCapsLockEvent(); // ev1
      this.loadShiftEvent(); // ev2

      // 'ev1' and 'ev2' are loaded for default language/layout
      this.areLangEventsLoaded[Core.selectedLanguage] = true;
    }
  };


  /*
   * UI CONTROLLER MODULE
   * Keeps all the ui-related stuff like movement, clicks, dragging.
   * */
  UIController = {

    // Attaches drag event to the keyboard
    attachDragToBase: function () {
      Visualization.$base.draggable({
        containment: Visualization.containment,
        cursor: 'move',
        stop: function () {
          // Tweak: reassigns the auto-resize feature of the keyboard. (Needed on layout/language switch)
          $(this).css({
            width: 'auto',
            height: 'auto'
          });
        }
      });
    },

    // Used for visual representation of button clicking.
    attachOnClickBtnEvent: function () {
      $('.' + BUTTON_CLASS).on('mousedown', function () {
        var $this = $(this);

        $this.addClass(CLICKED_CLASS);

        // Used if the user moves the mouse cursor away from a button when holding clicked.
        // The following code will un-click the button.
        setTimeout(function () {
          $this.removeClass(CLICKED_CLASS);
        }, 500);
      })
        .on('mouseup', function () {
          $(this).removeClass(CLICKED_CLASS);
        });
    },

    // Minimization feature
    minimizeKeyboard: function () {
      Visualization.$minBtn.on('click', function () {
        //Visualization.$base.slideUp();
        Visualization.$base.removeClass('show');

        Visualization.$toggleBtn.fadeIn();
      });
    },

    // Maximization feature
    maximizeKeyboard: function () {
      Visualization.$toggleBtn.on('click', function () {
        //Visualization.$base.slideDown();
        Visualization.$base.addClass('show');

        $(this).hide();
      });
    },

    // ENTRY POINT
    $$load: function () {
      this.attachDragToBase();
      this.attachOnClickBtnEvent();
      this.minimizeKeyboard();
      this.maximizeKeyboard();
    }
  };


  /*
   * CORE MODULE
   * Entry point of the application
   * */
  Core = {
    isReadyToRun: function () {
      // Checks whether a layout script is loaded.
      if (!jqKeyboard.layouts) {
        console.error('jqKeyboard: The keyboard layout configuration file hasn\'t been loaded.');
        return false;
      }

      // Checks if the library is already running in the current context.
      if (this.isRunning) {
        console.error('jqKeyboard: The library is already used/running in the current context/page.');
        return false;
      }

      return true;
    },

    init: function (options) {
      if (!Core.isReadyToRun()) {
        return;
      }

      // Variables
      Core.options = options;
      Core.isRunning = true;
      Core.selectedLanguage = null;
      Core.shift = {};
      Core.capsLock = {};

      // Load modules
      Visualization.$$createBase();
      EventManager.$$loadEvents();
      UIController.$$load();
    }
  };


  // exports
  jqKeyboard.init = Core.init;
}(jqKeyboard, jQuery));