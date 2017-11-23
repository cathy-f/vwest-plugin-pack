<?php
defined('ABSPATH') or die('No script kiddies please!');

/*
Plugin Name:  Cathy's Youtube Plugin
*/
// Function to add subscribe text to posts and pages
function cathys_youtube_shortcode($atts) {
	$atts = shortcode_atts(array(
	  'url' => false,
	  'width' => 600,
	  'height' => 400,
	  'startTime' => 0,
	  'responsive' => 'no',
	  'class' => '',
	  'align' => 'left'
	), $atts, 'youtube_cat');

	if (!$atts['url'])
		return new WP_Error('empty_youtube_url', 'The url is empty.');

	$id = (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match)) ? $match[1] : false;
	if (!$id)
		return new WP_Error('invalid_youtube_url', 'please specify correct url');

	$widthHeight = 'width=' . $atts['width'] . 'px height="' . $atts['height'] . 'px"';

	// Create the style
	$return[] = '<style>
        @media all and (max-width: 50em) {
          .cathys-youtube {
            width: 100% !important;
            height: auto !important;
          }
        }
        .cathys-youtube-parent { width: 100%; text-align: ' . $atts['align'] . '}
        .cathys-youtube {display:inline-block;' . ($atts['responsive'] === 'yes' ? '' : 'width:' . $atts['width'] . 'px; height:' . $atts['height'] . 'px') . '}';
	$return[] = '</style>';
	// Create player
	$return[] = '<div class="cathys-youtube-parent">';
	$return[] = '<div class="cathys-youtube">';
	$return[] = '<iframe ' . $widthHeight . '" src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen="true"></iframe>';
	$return[] = '</div>';
	$return[] = '</div>';

	// Return result
	return implode('', $return);
}

add_shortcode('youtube_cat', 'cathys_youtube_shortcode');


function shortcode_button_script() {
	if (wp_script_is("quicktags")) {
		?>
        <script type="text/javascript">

            //this function is used to retrieve the selected text from the text editor
            function getSel() {
                var txtarea = document.getElementById("content");
                var start = txtarea.selectionStart;
                var finish = txtarea.selectionEnd;
                return txtarea.value.substring(start, finish);
            }

            QTags.addButton(
                "code_shortcode",
                "Code",
                callback
            );

            function callback() {
                var selected_text = getSel();
                QTags.insertContent("[code]" + selected_text + "[/code]");
            }
        </script>
		<?php
	}
}

add_action("admin_print_footer_scripts", "shortcode_button_script");

function enqueue_plugin_scripts($plugin_array) {
	//enqueue TinyMCE plugin script with its ID.
	$plugin_array["youtube_cat_plugin"] = plugin_dir_url(__FILE__) . "index.js";
	return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons) {
	//register buttons with their id.
	array_push($buttons, "youtube_cat");
	return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");