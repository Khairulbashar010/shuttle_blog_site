<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-4" v-if="post">
          <img :src="'http://localhost:8000/images/'+ post?.blog_banner" class="card-img-top" alt="Banner Image">
          <div class="card-body text-black pb-4">
            <h1 class="card-title text-black">{{ post?.name }}</h1>
            <p class="text-black">{{ post?.category?.name }}</p>
            <div class="card-text text-black left" v-html="post?.blog_body" style="text-align: left;"></div>
          </div>
          <div class="card-tags pb-4">
						<span class="badge badge-dark custom-tag" v-for="(tag, index) in post?.tags" :key="index">
							{{ tag?.name }}
						</span>
					</div>
        </div>
        <hr>
        <div style="text-align: left;">
          <h2>Comments: {{ comments?.length || 0 }}</h2>
          <form @submit.prevent="submitComment()" class="reply-form">
              <div class="form-group">
                <input v-model="commentName" placeholder="Your Name" required class="form-control">
              </div>
              <div class="form-group">
                <textarea v-model="comment" placeholder="Your Comment" required class="form-control"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          <div v-for="comment in comments" :key="comment.id" class="comment">
            <div class="comment-header">
              <strong>{{ comment?.name }}</strong>
            </div>
            <div class="comment-body">
              <p>{{ comment?.comment_body }}</p>
            </div>
            <button @click="showReplyForm(comment?.id)" class="reply-btn btn btn-link font-weight-bold">Reply</button>
            <form v-if="showReplyFormId === comment?.id" @submit.prevent="submitReply(comment?.id)" class="reply-form">
              <div class="form-group">
                <input v-model="replyName" placeholder="Your Name" required class="form-control">
              </div>
              <div class="form-group">
                <textarea v-model="replyComment" placeholder="Your Reply" required class="form-control"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <ul class="replies">
              <li v-for="reply in comment?.replies" :key="reply.id" class="reply">
                <div class="reply-header">
                  <strong>{{ reply?.name }}</strong>
                </div>
                <div class="reply-body">
                  <p>{{ reply?.comment_body }}</p>
                </div>
              </li>
            </ul>
            <hr> 
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PostRepository from '@/repositories/PostRepository';
import CommentRepository from '@/repositories/CommentRepository';

export default {
  data() {
    return {
      post: null,
      comments: null,
      showReplyFormId: null,
      replyName: '',
      replyComment: '',
      commentName: '',
      comment: '',

    };
  },
  mounted() {
    this.fetchBlogBySlug();
  },
  methods: {
    async fetchBlogBySlug() {
      const slug = this.$route.params.slug;
      PostRepository.getPostBySlug(slug)
        .then(response => {
          this.post = response.data;
          this.fetchComments(this.post.id);
        })
        .catch(error => {
          console.error(error);
        });
    },
    async fetchComments(postId) {
      CommentRepository.getCommentsByPostId(postId)
        .then(response => {
          this.comments = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    showReplyForm(commentId) {
      this.replyName = '';
      this.replyComment = '';
      this.showReplyFormId = this.showReplyFormId ? null : commentId;

    },
    async submitReply(parentId) {
      // Handle the form submission, e.g., send the reply data to the server
      const replyData = {
        name: this.replyName,
        comment: this.replyComment,
        parent_id: parentId,
        postId: this.post.id,
      };
      CommentRepository.addComment(replyData).then(() => {
        // Clear the form and hide it
        this.replyName = '';
        this.replyComment = '';
        this.showReplyFormId = null;
        this.fetchComments(this.post.id)
      })
    },
    async submitComment() {
      // Handle the form submission, e.g., send the reply data to the server
      const replyData = {
        name: this.commentName,
        comment: this.comment,
        postId: this.post.id,
      };
      CommentRepository.addComment(replyData).then(() => {
        // Clear the form and hide it
        this.commentName = '';
        this.comment = '';
        this.fetchComments(this.post.id)
      })
    },
  },
};
</script>

<style scoped>
.text-black {
  color: black;
}
.custom-tag {
	background-color: black;
	color: white;
	margin-right: 0.5rem;
}
.comment {
  margin-bottom: 20px;
  padding: 10px;
  border-radius: 5px;
  text-align: left;
}

.comment-header {
  font-weight: bold;
}
.reply-btn.btn {
  padding-left: 0;
}

.reply {
  margin-top: 10px;
  padding: 10px;
  border-radius: 5px;
  text-align: left;
}

.reply-header {
  font-weight: bold;
  margin-bottom: 5px;
}

.replies {
  list-style-type: none;
  padding-left: 0;
}
.reply-form .form-group {
  margin-bottom: 10px;
}
</style>
