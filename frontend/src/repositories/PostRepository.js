import axios from '@/services/axios';

class PostRepository {
	async getPosts() {
		return await axios.get('/api/posts');
	}
  
	async getPostBySlug(slug) {
		return axios.get(`/api/posts/${slug}`);
	}
  }

export default new PostRepository();