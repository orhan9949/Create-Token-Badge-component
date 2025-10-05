import { createApp } from 'vue';
import TokenBadge from '../components/TokenBadge.vue';

function tokenBadgeFunction(almSinglePostId) {

    let postDetailTokens = document.querySelector('.post-detail__tokens');

    let postDetailContent = document.querySelector('.post-detail__content');

    if (almSinglePostId) {

        document.querySelectorAll('.alm-single-post').forEach(almSinglePost => {

            if (almSinglePost.dataset.id === almSinglePostId) {

                postDetailTokens = almSinglePost.querySelector('.post-detail__tokens');

                postDetailContent = almSinglePost.querySelector('.post-detail__content');

            }

        });

    }

    if (!postDetailTokens){ return }

    let tokensId = JSON.parse(postDetailTokens.dataset.tokensId);
    let tokensShowChange = JSON.parse(postDetailTokens.dataset.showChange);
    let tokensShowPrice = JSON.parse(postDetailTokens.dataset.showPrice);
    let tokensNameData = JSON.parse(postDetailTokens.dataset.tokensName);

    for (let tokenId of tokensId) {

        if(postDetailTokens.querySelector('div[data-id="'+tokenId+'"]')){ return }

        postDetailTokens.insertAdjacentHTML('beforeend', `<div data-id="${tokenId}"></div>`);

        createApp(TokenBadge,
            {
                tokenId: tokenId,
                showChange: tokensShowChange,
                showPrice: tokensShowPrice
            }).mount(postDetailTokens.querySelector('div[data-id="'+tokenId+'"]'));

        let word = '';

        for (let tokenNameData in tokensNameData) {

            if (tokensNameData[tokenNameData][tokenId] !== undefined) {

                word = ` ${tokensNameData[tokenNameData][tokenId]} `;

            }

        }

        if(!postDetailContent.querySelector('span[data-id="'+tokenId+'"]')){

            let postDetailContentWord = postDetailContent.innerHTML.match(RegExp(word, 'i'));

            if(postDetailContentWord[0] != null){

                postDetailContent.innerHTML = postDetailContent.innerHTML.replace(RegExp(word, 'i'), postDetailContentWord[0] + `<span data-id="${tokenId}" class="post-detail__token"></span>` + " ");

            }

        }


    }

    for (let tokenId of tokensId) {

        createApp(TokenBadge,
            {
                tokenId: tokenId,
                showChange: tokensShowChange,
                showPrice: tokensShowPrice
            }).mount(postDetailContent.querySelector('span[data-id="'+tokenId+'"]'));

    }

}

export { tokenBadgeFunction };