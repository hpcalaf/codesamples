var TexthelpSpeechStream = new function () {
};

// Adding toolbar to the page
TexthelpSpeechStream.g_bAdded = false;
TexthelpSpeechStream.g_strDomain = "customerdemo.speechstream.net";

TexthelpSpeechStream.addToolbar = function () {
    if (!TexthelpSpeechStream.g_bAdded) {
        var elem = document.createElement("script");
        elem.type = "text/javascript";
        elem.src = "//" + TexthelpSpeechStream.g_strDomain + "/SpeechStream/v195/texthelpMain.js";
        document.body.appendChild(elem);
        TexthelpSpeechStream.g_bAdded = true;
    }
};

TexthelpSpeechStream.addToolbar = function () {
    if (!TexthelpSpeechStream.g_bAdded) {
        var elem = document.createElement("script");
        elem.type = "text/javascript";
        elem.src = "//" + TexthelpSpeechStream.g_strDomain + "/SpeechStream/v195/texthelpMain.js";
        document.body.appendChild(elem);
        TexthelpSpeechStream.g_bAdded = true;
    }
};

/* Texthelp Systems, Inc. SpeechStream Toolbar Parameters */
function $rw_userParameters() {
    try {
        eba_icons = main_icons + selectspeed_icon + pause_icon;  // Display the icons
        eba_server = TexthelpSpeechStream.g_strDomain;
        eba_speech_server = "customerdemo.speechstream.net";
        eba_login_name = "breakthroughtechnologies";
        eba_cust_id = 2410;
        eba_use_html5 = true;
        eba_ssl_flag = window.location.protocol == "https:";
        eba_voice = "Vocalizer Expressive Ava Premium High 22kHz";
        eba_math = true;
        eba_play_start_point = "page-title";
        eba_math = false;
        eba_language = ENGLISH_US;
        eba_inline_img = true;

    }
    catch (err) {
    }
}

(function ($) {
    //Drupal.prc_text_to_speech = {};
    Drupal.behaviors.enableTextToSpeechToolbar = {
        attach: function (context) {
            $('.prc_text_to_speech').click(function (event) {
                if ($(this).hasClass('tts_shown')) {
                    // Hide the toolbar
                    $rw_setBarVisibility(false);
                    $(this).removeClass('tts_shown').addClass('tts_hidden');
                    $(this).text('Text to Speech');
                } else if ($(this).hasClass('tts_hidden')) {
                    // Show the toolbar after it's been hidden, not the first show
                    $rw_setBarVisibility(true);
                    $(this).removeClass('tts_hidden').addClass('tts_shown');
                    $(this).text('Hide Text to Speech');
                } else {
                    // This is the initial toolbar show
                    TexthelpSpeechStream.addToolbar();
                    $(this).addClass('tts_shown');
                    $(this).text('Hide Text to Speech');
                }
                event.stopPropagation();
                return false;
            });
        }
    };
})(jQuery);
