(function () {
    tinymce.create("tinymce.plugins.youtube_cat_plugin", {

        //url argument holds the absolute url of our plugin directory
        init: function (ed, url) {

            //add new button
            ed.addButton("youtube_cat", {
                title: "YouTube Cat Plugin",
                cmd: "youtube_cat",
                image: "https://m.youtube.com/yts/mobile/img/apple-touch-icon-57x57-precomposed-vflXb--xv.png"
            });

            //button functionality.
            ed.addCommand("youtube_cat", function () {
                // var selected_text = ed.selection.getContent().trim();
                var selected_text = '';
                var return_text = '[youtube_cat url="' + selected_text + '" responsive="no" width="640" height="360" align="center"]';
                ed.execCommand("mceInsertContent", 0, return_text);
            });

        },

        createControl: function (n, cm) {
            return null;
        },

        getInfo: function () {
            return {
                longname: "YouTube Cat Plugin",
                author: "Cathy Fan",
                version: "1"
            };
        }
    });

    tinymce.PluginManager.add("youtube_cat_plugin", tinymce.plugins.youtube_cat_plugin);
})();