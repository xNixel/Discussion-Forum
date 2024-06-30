document.addEventListener("DOMContentLoaded", () => {
    fetchPosts(); // Fetch posts when the page loads

    // Event listener for posting new discussions
    document.getElementById("newPostForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const content = document.getElementById("newPostContent").value;

        fetch("post_new_discussion.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `content=${encodeURIComponent(content)}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log response (optional)
            document.getElementById("newPostContent").value = ''; // Clear the textarea
            fetchPosts(); // Refresh posts after new discussion submission
        });
    });

    // Function to fetch posts and update the UI
    function fetchPosts() {
        fetch("get_posts.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("posts").innerHTML = data;
            });
    }
    // Event listener for posting replies
    document.addEventListener("submit", (e) => {
        if (e.target && e.target.matches(".replyForm")) {
            e.preventDefault();
            const post_id = e.target.dataset.postId;
            const content = e.target.querySelector("textarea").value;

            fetch("post_reply.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `post_id=${post_id}&content=${encodeURIComponent(content)}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Log response
                fetchPosts(); // Refresh posts after reply submission
            });
        }
    });

    // Event listener for reacting to posts (thumbs up/thumbs down)
    document.addEventListener("click", (e) => {
        if (e.target && (e.target.classList.contains("thumbsUpButton") || e.target.classList.contains("thumbsDownButton"))) {
            const post_id = e.target.dataset.postId;
            const reactionType = e.target.dataset.reaction;

            fetch("post_reaction.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `post_id=${post_id}&reaction=${reactionType}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Log response
                fetchPosts(); // Refresh posts after reacting
            });
        }
    });

    // Function to fetch posts and update the UI
    function fetchPosts() {
        fetch("get_posts.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("posts").innerHTML = data;
            });
    }
});
