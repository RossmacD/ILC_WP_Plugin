const bookmark = (link, id, action = "add") => {
    fetch(link + '?wpfpaction=' + action + '&postid=' + id + '&ajax=1',)
        .then(response => {
            if (response.status === 200) {
                document.querySelector('#bkmk-' + id).classList.add('active')
                return
            }
            // You must be logged in
            throw new Error('You must be logged in')
        })
        .catch(err => console.error(err));
}

window.addEventListener('load', function () {
    new Splide('.splide', {
        type: 'loop',
        perPage: 1,
        rewind: true,
        // autoplay: true,
        pauseOnHover: true,
    }).mount();

    // console.log('HASOLDHJASLDJHLHJASDASDHJL', uniqninnininininininininininin());
    uniqninnininininininininininin().forEach(post_id => {
        const items = document.querySelector('#bkmk-' + post_id)
        if (items) items.classList.add('active')
    });
})