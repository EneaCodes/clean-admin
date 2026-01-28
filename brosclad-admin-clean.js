(function () {
    function text(el) {
        return (el.innerText || el.textContent || '').toLowerCase();
    }

    function hideIfMatch(el, words) {
        if (!el || !words || !words.length) return;
        var t = text(el);
        for (var i = 0; i < words.length; i++) {
            if (!words[i]) continue;
            if (t.indexOf(words[i].toLowerCase()) !== -1) {
                el.style.display = 'none';
                return;
            }
        }
    }

    function scan() {
        if (typeof BROSCLAD_SETTINGS === 'undefined') return;

        var promoWords = BROSCLAD_SETTINGS.promoWords ? BROSCLAD_SETTINGS.promoWords.slice() : [];
        var reviewWords = BROSCLAD_SETTINGS.reviewWords ? BROSCLAD_SETTINGS.reviewWords.slice() : [];

        promoWords = promoWords.map(function (w) { return (w || '').toLowerCase(); });
        reviewWords = reviewWords.map(function (w) { return (w || '').toLowerCase(); });

        var notices = document.querySelectorAll('.notice, .update-nag, .error, .updated, .is-dismissible');
        for (var i = 0; i < notices.length; i++) {
            var n = notices[i];

            if (BROSCLAD_SETTINGS.hideDashboardAds || BROSCLAD_SETTINGS.hidePluginPromos) {
                hideIfMatch(n, promoWords);
            }

            if (BROSCLAD_SETTINGS.hideReviewNags) {
                hideIfMatch(n, reviewWords);
            }
        }

        if (BROSCLAD_SETTINGS.hidePluginPromos) {
            var selectors = [
                '.e-notice',
                '.elementor-message',
                '.elementor-notice',
                '.wrap .notice-info',
                '.wrap .promo-box',
                '.wrap .welcome-panel',
                '.wrap .advertisement'
            ];

            selectors.forEach(function (sel) {
                var els = document.querySelectorAll(sel);
                for (var j = 0; j < els.length; j++) {
                    hideIfMatch(els[j], promoWords);
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', scan);
    setInterval(scan, 3000);
})();
