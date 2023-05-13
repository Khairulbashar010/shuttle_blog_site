<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h2 class="mb-4">Blogs</h2>
				<div class="card-deck">
					<div v-for="blog in blogs" :key="blog.id" class="card shadow mb-4" style="cursor: pointer;" @click="postDetail(blog.slug)">
						<div class="card-body">
							<h5 class="card-title">{{ blog.name }}</h5>
							<p class="card-text">Category: {{ blog.category.name }}</p>
							<p class="card-text">Comments: {{ blog.comments.length }}</p>
							<div class="card-tags">
								<span class="badge badge-dark custom-tag" v-for="(tag, index) in blog.tags" :key="index">
									{{ tag.name }}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
import PostRepository from '@/repositories/PostRepository';

export default {
	data() {
		return {
			blogs: [],
		};
	},
	mounted() {
		this.fetchBlogs();
	},
	methods: {
		fetchBlogs() {
			PostRepository.getPosts()
				.then(response => {
					this.blogs = response.data;
				})
				.catch(error => {
					console.error(error);
				});
		},
		postDetail(slug) {
			this.$router.push(`/post/${slug}`);
		},
	},
};
</script>
  
<style scoped>

.card {
  transition: box-shadow 0.3s;
}

.card:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.1);
}
.custom-tag {
	background-color: black;
	color: white;
	margin-right: 0.5rem;
}
</style>