$(document).ready(() => {
    // const urlGetPosts = '/simpleblog/posts'

    $('#add_post_form').hide();
    $('#add_comment_form').hide();

    $('#close_comment').click(() => {$('#add_comment_form').hide()})
    $('#close_post').click(() => {$('#add_post_form').hide()})

    $('#show_post_form').click(() => {$('#add_post_form').show()})

    rerenderPosts()

    $('#submit').click(() => {
        const name = $('#name').val()
        const text = $('#text').val()
        $.post("http://localhost/simpleblog/addPost",
            {
                name: name,
                text: text
            },
            function (data, status) {
                $('#add_post_form').hide();

                rerenderPosts()
                alert("Data: " + data + "\nStatus: " + status);
            });
    })

    $('#comment_submit').click(() => {
        const postId = $('#post_id').val()
        const name = $('#commentator_name').val()
        const comment = $('#comment').val()

        $.post('/simpleblog/addComment', {
            post_id:postId,
            name,
            text:comment
        }, () => {
            console.log('success')
            $('#add_comment_form').hide();
            rerenderPosts()
        })
    })
})

function addHandlers() {
    $('.star').click(function () {
        const data = $(this).data();

        $.post(`/simpleblog/addRate`, {
            value: data.value,
            post_id: data.postId
        }, () => {
            console.log('success')
            rerenderPosts()
        })
    })

    $('.add_comment').click(function () {
        const data = $(this).data();
        $('#post_id').val(data.postId)
        $('#add_comment_form').show();
    })
}

function rerenderPosts() {
    const urlGetPosts = 'http://localhost/simpleblog/posts'
    $.get(urlGetPosts, function (data) {


        const posts = JSON.parse(data)

        const allPosts = posts.length
        const positivePosts = posts.filter((post) => post.rate >= 3).length
        const negativePosts = posts.filter((post) => post.rate < 3).length

        $('#negative').html('Negative:' + negativePosts)
        $('#positive').html('Positive:' + positivePosts)
        $('#all').html('All:' + allPosts)

        $('#posts').empty()

        posts.forEach((post) => {
            let filledStars = ''
            let emptyStars = 5 - Math.round(post.rate)

            for (let i = 0; i < Math.round(post.rate); i++) {
                filledStars += `<img  class="star" data-post-id="${post.id}" data-value="${i + 1}" src="./img/star.png">`
            }

            for (let i = 0; i < emptyStars; i++) {
                filledStars += `<img class="star" data-post-id=${post.id} data-value=${parseInt(post.rate) + i + 1} src="./img/star_empty.png">`
            }

            let commentsBlock = ''

            post.comments.forEach((comment) => {
                commentsBlock += `
                    <div style="border: 1px solid red">
                        ${comment.name}
                        <br>
                        ${comment.text}
                        <br>
                        ${comment.created_at}
                    </div>
                `
            })

            $('#posts')
                .append(`
                    <div class="single-post">
                        ${post.name}
                        <br>
                        ${post.text}
                        <br>
                        ${filledStars}
                        <br>
                        ${post.created_at}
                        <br>
                        <button class="add_comment" data-post-id="${post.id}">Add comment</button>
                        
                        <div class="comments">
                            ${commentsBlock}
                        </div>
                    </div>
                `);
        })

        addHandlers();
    });
}