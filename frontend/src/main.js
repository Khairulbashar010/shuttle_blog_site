import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from 'vue-router';
import PostList from './components/PostList.vue';
import PostDetail from './components/PostDetail.vue';
import CreatePost from './components/CreatePost.vue';
import 'bootstrap/dist/css/bootstrap.css';

const routes = [
	{ path: '/', component: PostList },
	{ path: '/post/:slug', component: PostDetail },
	{ path: '/create-post', component: CreatePost },
  ];
  
  const router = createRouter({
	history: createWebHistory(),
	routes,
  });
  
  const app = createApp(App);
  app.use(router);
  app.mount('#app');