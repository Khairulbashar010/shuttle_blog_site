<template>
	<div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-5">
			<div class="container">
				<router-link to="/" class="navbar-brand">My Blog</router-link>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
					aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<router-link to="/" class="nav-link">Home</router-link>
						</li>
						<li class="nav-item">
							<router-link to="/create-post" class="nav-link">Create Post</router-link>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</template>
  
<style scoped>
.navbar {
  transition: box-shadow 0.3s;
}

.navbar:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.1);
}
</style>