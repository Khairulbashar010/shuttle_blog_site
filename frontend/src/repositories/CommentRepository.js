import axios from '@/services/axios';

class CommentRepository {
	async getCommentsByPostId(id) {
		return await axios.get(`/api/comments/posts/${id}`);
	}
	async addComment(data) {
		return await axios.post(`/api/comments/posts/${data.postId}`, data);
	}
  }

export default new CommentRepository();