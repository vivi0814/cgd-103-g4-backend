<template>
    <ol class="Breadcrumb">
        <li v-for="(item, i) in breadcrumbList" :key="i" class="font-16">
            {{ item.meta.title }}
            <!-- <router-link :to="item.path">{{ item.meta.title }}</router-link> -->
            <!-- 我還不會聯動修改 Aside ，先不做有連結的麵包屑了 -->
        </li>
    </ol>
</template>

<script>
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
export default {
    name: 'Breadcrumb',
    setup(){
        const route = useRoute()
        const breadcrumbList = ref([])
        const isHome = () => {
            return route.name === 'Home';
        }
        const getBreadcrumbs = () => {
            let matched = route.matched;
            if (!isHome(matched[0])){
                matched = [{ path: '／', meta: { title: '後台' } }].concat(matched);
            }
            breadcrumbList.value = matched;
        }
        watch(route, () => {
            getBreadcrumbs()
        })
        onMounted(() => {
            getBreadcrumbs()
        })
        return {
            breadcrumbList,
            getBreadcrumbs,
        }
    }
}
</script>

<style scoped lang="scss">
@import "../assets/Scss/base/font.scss";
@import "../assets/Scss/components/btn.scss";
ol{
    padding-bottom: 30px;
    display: flex;
    li{
        color: $clr_gray_L2;
        &::after{
            content: '／';
        }
        &:last-child{
            &::after{
                content: '';
            }
        }
    }
}
</style>