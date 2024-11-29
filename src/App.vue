<template>
	<div class="app_wrapper">
		<Aside/>
		<section class="app_container">
			<Header/>
			<main class="app_main">
				<Breadcrumb/>
				<router-view/>
			</main>
		</section>
	</div>
</template>

<style lang="scss">

@import "../src/assets/Css/Reset.css";
@import "../src/assets/Scss/base/common.scss";
@import "../src/assets/Scss/base/font.scss";
@import "../src/assets/Scss/components/btn.scss";

#app {
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
}
a{
	text-decoration: none;
}

</style>

<script>
// @ is an alias to /src
import Aside from '@/components/Aside.vue'
import Header from '@/components/Header.vue'
import Breadcrumb from '@/components/Breadcrumb.vue'

export default {
	name: 'App',
	components: {
		Aside,
		Header,
		Breadcrumb
	}
}
</script>