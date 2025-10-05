import { tokenBadgeFunction } from './theme/tokenBadge.js';

window.onload = function(){

    tokenBadgeFunction();

    window.almComplete = function (alm) {

        tokenBadgeFunction(alm.listing.lastChild.dataset.id);

    };

}