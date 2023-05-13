<template>
	<div class="container">
		<h1>Create Post</h1>
		<form @submit="submitForm">
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" id="title" v-model="post.title" required>
			</div>
			<div class="form-group">
				<label for="category">Category</label>
				<select class="form-control" id="category" v-model="post.category_id" required>
					<option value="">Select Category</option>
					<option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}
					</option>
				</select>
			</div>
			<div class="form-group">
				<label for="tags">Tags</label>
				<input type="text" class="form-control" id="tags" v-model="post.tags" required>
			</div>
			<div class="form-group">
				<label for="body">Body</label>
				<ckeditor v-model="post.body" :editor="editorConfig"></ckeditor>
			</div>
			<div class="form-group">
				<label for="banner">Banner Image</label>
				<input type="file" class="form-control-file" id="banner" @change="handleBannerUpload">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</template>
  
<script>


export default {
	data() {
		return {
			post: {
				title: '',
				category_id: '',
				tags: '',
				body: '',
				banner: null,
			},
		};
	},
	methods: {
		submitForm() {
			// Handle form submission and API request here
			console.log('Form submitted:', this.post);
		},
		handleBannerUpload(event) {
			// Handle file upload and assign to the post object
			this.post.banner = event.target.files[0];
		},
	},
};
</script>
  