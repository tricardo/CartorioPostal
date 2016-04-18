<html>
<head>
<title>Glyphicons</title>
<meta charset="ISO-8859-1">
<script src="../jquery/jquery-2.1.0.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<link href="../css/font.css" type="text/css" rel="stylesheet" />
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />
<link href="css/bootstrap-glyphicons.css" type="text/css" rel="stylesheet" />
<link href="../css/bootstrap.css" type="text/css" rel="stylesheet" />
</head>
<body style="padding:20px; text-align: center;">
        <?php
        $ico = array('glyphicon-tablet-ico','glyphicon-user-ico','glyphicon-diamond-ico',
        'glyphicon-trophy-ico','glyphicon-cube-ico','glyphicon-puzzle-ico',
        'glyphicon-smiley-ico','glyphicon-happy-ico','glyphicon-download-ico',
        'glyphicon-cloud-ico','glyphicon-thumbs-up-ico','glyphicon-thumbs-down-ico',
        'glyphicon-menu-ico','glyphicon-cars-ico','glyphicon-briefcase-ico',
        'glyphicon-bus-ico','glyphicon-bars-ico','glyphicon-pie-ico',
        'glyphicon-comments-ico','glyphicon-comments-2-ico','glyphicon-user-2-ico',
        'glyphicon-gift-ico','glyphicon-busy-ico','glyphicon-drawer-ico','glyphicon-box-remove-ico',
        'glyphicon-box-add-ico','glyphicon-phone-ico','glyphicon-arrow-down-ico','glyphicon-arrow-right-ico',
        'glyphicon-arrow-up-ico','glyphicon-star-ico','glyphicon-star-2-ico','glyphicon-star-3-ico',
        'glyphicon-heart-ico','glyphicon-heart-2-ico','glyphicon-cloud-2-ico',
        'glyphicon-remove-ico','glyphicon-remove-2-ico','glyphicon-briefcase-2-ico',
        'glyphicon-grid-view-ico','glyphicon-github-ico','glyphicon-github-2-ico',
        'glyphicon-linkedin-ico','glyphicon-lastfm-ico','glyphicon-blogger-ico',
        'glyphicon-tumblr-ico','glyphicon-dribbble-ico','glyphicon-flickr-ico',
        'glyphicon-gplus-ico','glyphicon-facebook-ico','glyphicon-IcoMoon-ico',
        'glyphicon-safari-ico','glyphicon-opera-ico','glyphicon-IE-ico',
        'glyphicon-firefox-ico','glyphicon-chrome-ico','glyphicon-css3-ico',
        'glyphicon-html5-ico','glyphicon-html5-2-ico','glyphicon-file-css-ico',
        'glyphicon-file-xml-ico','glyphicon-file-zip-ico','glyphicon-file-powerpoint-ico',
        'glyphicon-asterisk','glyphicon-plus','glyphicon-euro',
        'glyphicon-minus','glyphicon-cloud','glyphicon-envelope','glyphicon-pencil',
        'glyphicon-glass','glyphicon-music','glyphicon-search',
        'glyphicon-heart','glyphicon-star','glyphicon-star-empty','glyphicon-user',
        'glyphicon-film','glyphicon-th-large','glyphicon-th',
        'glyphicon-th-list','glyphicon-ok','glyphicon-remove',
        'glyphicon-zoom-in','glyphicon-zoom-out','glyphicon-off',
        'glyphicon-signal','glyphicon-cog','glyphicon-trash',
        'glyphicon-home','glyphicon-file','glyphicon-time',
        'glyphicon-road','glyphicon-download-alt','glyphicon-download',
        'glyphicon-upload','glyphicon-inbox','glyphicon-play-circle',
        'glyphicon-repeat','glyphicon-refresh','glyphicon-list-alt',
        'glyphicon-lock','glyphicon-flag','glyphicon-headphones',
        'glyphicon-volume-off','glyphicon-volume-down','glyphicon-volume-up',
        'glyphicon-qrcode','glyphicon-barcode','glyphicon-tag','glyphicon-tags',
        'glyphicon-book','glyphicon-bookmark','glyphicon-print','glyphicon-camera',
        'glyphicon-font','glyphicon-bold','glyphicon-italic','glyphicon-text-height',
        'glyphicon-text-width','glyphicon-align-left','glyphicon-align-center',
        'glyphicon-align-right','glyphicon-align-justify','glyphicon-list',
        'glyphicon-indent-left','glyphicon-indent-right','glyphicon-facetime-video',
        'glyphicon-picture','glyphicon-map-marker','glyphicon-adjust',
        'glyphicon-tint','glyphicon-edit','glyphicon-share',
        'glyphicon-check',
        'glyphicon-move',
        'glyphicon-step-backward',
        'glyphicon-fast-backward',
        'glyphicon-backward',
        'glyphicon-play',
        'glyphicon-pause',
        'glyphicon-stop',
        'glyphicon-forward',
        'glyphicon-fast-forward',
        'glyphicon-step-forward',
        'glyphicon-eject',
        'glyphicon-chevron-left',
        'glyphicon-chevron-right',
        'glyphicon-plus-sign',
        'glyphicon-minus-sign',
        'glyphicon-remove-sign',
        'glyphicon-ok-sign',
        'glyphicon-question-sign',
        'glyphicon-info-sign',
        'glyphicon-screenshot',
        'glyphicon-remove-circle',
        'glyphicon-ok-circle',
        'glyphicon-ban-circle',
        'glyphicon-arrow-left',
        'glyphicon-arrow-right',
        'glyphicon-arrow-up',
        'glyphicon-arrow-down',
        'glyphicon-share-alt',
        'glyphicon-resize-full',
        'glyphicon-resize-small',
        'glyphicon-exclamation-sign',
        'glyphicon-gift',
        'glyphicon-leaf',
        'glyphicon-fire',
        'glyphicon-eye-open',
        'glyphicon-eye-close',
        'glyphicon-warning-sign',
        'glyphicon-plane',
        'glyphicon-calendar',
        'glyphicon-random',
        'glyphicon-comment',
        'glyphicon-magnet',
        'glyphicon-chevron-up',
        'glyphicon-chevron-down',
        'glyphicon-retweet',
        'glyphicon-shopping-cart',
        'glyphicon-folder-close',
        'glyphicon-folder-open',
        'glyphicon-resize-vertical',
        'glyphicon-resize-horizontal',
        'glyphicon-hdd',
        'glyphicon-bullhorn',
        'glyphicon-bell',
        'glyphicon-certificate',
        'glyphicon-thumbs-up',
        'glyphicon-thumbs-down',
        'glyphicon-hand-right',
        'glyphicon-hand-left',
        'glyphicon-hand-up',
        'glyphicon-hand-down',
        'glyphicon-circle-arrow-right',
        'glyphicon-circle-arrow-left',
        'glyphicon-circle-arrow-up',
        'glyphicon-circle-arrow-down',
        'glyphicon-globe',
        'glyphicon-wrench',
        'glyphicon-tasks',
        'glyphicon-filter',
        'glyphicon-briefcase',
        'glyphicon-fullscreen',
        'glyphicon-dashboard',
        'glyphicon-paperclip',
        'glyphicon-heart-empty',
        'glyphicon-link',
        'glyphicon-phone',
        'glyphicon-pushpin',
        'glyphicon-usd',
        'glyphicon-gbp',
        'glyphicon-sort',
        'glyphicon-sort-by-alphabet',
        'glyphicon-sort-by-alphabet-alt',
        'glyphicon-sort-by-order',
        'glyphicon-sort-by-order-alt',
        'glyphicon-sort-by-attributes',
        'glyphicon-sort-by-attributes-alt',
        'glyphicon-unchecked',
        'glyphicon-expand',
        'glyphicon-collapse-down',
        'glyphicon-collapse-up',
        'glyphicon-log-in',
        'glyphicon-flash',
        'glyphicon-log-out',
        'glyphicon-new-window',
        'glyphicon-record',
        'glyphicon-save',
        'glyphicon-open',
        'glyphicon-saved',
        'glyphicon-import',
        'glyphicon-export',
        'glyphicon-send',
        'glyphicon-floppy-disk',
        'glyphicon-floppy-saved',
        'glyphicon-floppy-remove',
        'glyphicon-floppy-save',
        'glyphicon-floppy-open',
        'glyphicon-credit-card',
        'glyphicon-transfer',
        'glyphicon-cutlery',
        'glyphicon-header',
        'glyphicon-compressed',
        'glyphicon-earphone',
        'glyphicon-phone-alt',
        'glyphicon-tower',
        'glyphicon-stats',
        'glyphicon-sd-video',
        'glyphicon-hd-video',
        'glyphicon-subtitles',
        'glyphicon-sound-stereo',
        'glyphicon-sound-dolby',
        'glyphicon-sound-5-1',
        'glyphicon-sound-6-1',
        'glyphicon-sound-7-1',
        'glyphicon-copyright-mark',
        'glyphicon-registration-mark',
        'glyphicon-cloud-download',
        'glyphicon-cloud-upload',
        'glyphicon-tree-conifer',
        'glyphicon-tree-deciduous',

            'glyphicon-glass-ico');

        for($i = 0; $i < count($ico); $i++){
            echo '<div style="text-align:center; width: 100px; height: 100px; display:inline-block; padding:10px; margin-bottom: 10px; margin-right: 10px; border: solid 1px #000">'
                    . '<span style="font-size:30px; margin-bottom:10px;display:block" class="glyphicon '.$ico[$i].'"></span>'
                    . '<span style="font-size:10px">glyphicon '.$ico[$i].'</span>'
                    . '</div>';
        }
        ?>
    </body>
</html>
