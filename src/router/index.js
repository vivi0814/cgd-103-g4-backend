import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
{
	path: '/',
	name: 'home',
	component: HomeView,
	meta: { title: '首頁' }
},
{
	path:'/accounts',
	name:'accounts',
	component: HomeView,
	meta: { title: '帳號管理' },
	children:[
		{
			path: 'Administrator',
			name: 'Administrator',
			component: () => import('@/views/accounts/AdministratorView.vue'),
			meta: { title: '管理者帳號' }
		},
		{
			path: 'Membership',
			name: 'Membership',
			component: () => import('@/views/accounts/MembershipView.vue'),
			meta: { title: '會員帳號' }
		},
	]
},
// {
// 	path: '/Administrator',
// 	name: 'Administrator',
// 	component: () => import('../views/AdministratorView.vue'),
// 	meta: { title: '管理者帳號' }
// },
// {
// 	path: '/Membership',
// 	name: 'Membership',
// 	component: () => import('../views/MembershipView.vue'),
// 	meta: { title: '會員帳號' }
// },
{
	path: '/news',
	name: 'news',
	component: () => import('../views/NewsView.vue'),
	meta: { title: '最新消息管理' }
},
{
	path: '/travelcase',
	name: 'travelcase',
	component: () => import('../views/TravelcaseView.vue'),
	meta: { title: '行程方案管理' }
},
{
	path: '/travelmanage',
	name: 'travelmanage',
	component: () => import('../views/TravelmanageView.vue'),
	meta: { title: '行程訂單管理' }
},
{
	path: '/travelopen',
	name: 'travelopen',
	component: () => import('../views/TravelopenView.vue'),
	meta: { title: '開團管理' }
},
{
	path: '/productmanage',
	name: 'productmanage',
	component: () => import('../views/ProductManage.vue'),
	meta: { title: '商品管理' }
},
{
	path: '/shoporder',
	name: 'shoporder',
	component: () => import('../views/ShopOrder.vue'),
	meta: { title: '商品訂單管理' }
},
{
	path: '/faq',
	name: 'faq',
	component: () => import('../views/FaqView.vue'),
	meta: { title: 'FAQ管理' }
},
{
	path: '/about',
	name: 'about',
	component: () => import('../views/AboutView.vue')
},
{
	path: '/contactus',
	name: 'contactus',
	component: () => import('../views/ContactUS.vue'),
	meta: { title: '意見表管理' }
},
{
	path: '/Login_back',
	name: 'Login_back',
	component: () => import('../views/Login_backView.vue'),
	meta: { title: '管理者登入' }
},
]

// router 跳轉畫面後，維持置頂
const scrollBehavior = (to, from, savedPosition) => {
	if(savedPosition && to.meta.keepAlive){
		return savedPosition;
	}
	return {left: 0, top: 0}
}

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior
})

export default router