class BlogManager {
    constructor() {
      this.initEventListeners();
    }

    initEventListeners() {
      // Like button functionality
      document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', this.handleLike);
      });

      // Comment submission
      const commentForm = document.getElementById('commentForm');
      if (commentForm) {
        commentForm.addEventListener('submit', this.handleCommentSubmit);
      }
    }

    handleLike(e) {
      const postId = e.currentTarget.dataset.postId;
      // AJAX call to like/unlike
      console.log(`Liked post ${postId}`);
    }

    handleCommentSubmit(e) {
      e.preventDefault();
      // Handle comment submission
      console.log('Comment submitted');
    }
  }

  // Initialize when DOM is loaded
  document.addEventListener('DOMContentLoaded', () => {
    new BlogManager();
  });
