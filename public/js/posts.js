document.addEventListener("DOMContentLoaded",function () {
    const postsCont = document.querySelector("[data-posts]")
    if (!postsCont) return;
    const query = document.querySelector('.form__input').value
    const comments = postsCont.querySelectorAll(".post__comment")
    for (let comment of comments ) {
        comment.innerHTML = comment.innerHTML.replaceAll(query,`<span class="post__highlight">${query}</span>`)
    }
})