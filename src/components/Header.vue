<template>
    <header>
        <div class="title">
            <h2 class="font-32"
                v-for="(item, i) in breadcrumbList" :key="i">{{ item.meta.title }}
            </h2>
        </div>
        <div>
            <span class="font-18">{{$store.state.emp_name}}</span>
            <span class="font-18" @click="logout">登出
                <div v-show="$store.state.emp_no" class="logout" @click="logout"></div>
            </span>
            
        </div>
    </header>
</template>

<script>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
export default {
    name: 'Header',
    data(){
        return{
            out:false,
            result:[],
        }
    },
    created(){
        // this.getAdminName();
    },
    mounted(){
        this.see();
    },
    methods: {
        getAdminName(){
          if(!this.emp_no){
            return 
          }
            this.result = result;
            // fetch(`http://localhost/CGD103_G4_back/public/phpfiles/getEmpInfo.php?empId=${this.emp_no}`)
            fetch(`${BASE_URL}/getEmpInfo.php?empId=${this.emp_no}`)
            .then((res) => res.json())
            .then((json) =>{
                this.result = json[0];
            })
        },
        see(){
            if(this.emp_no){
                this.out = true
            }
        },
        logout(){
            // console.log("編號",this.$store.state.emp_no);
            // console.log("名字",this.$store.state.emp_name);
            this.$router.push("/Login_back");
        },
    },
    computed:{
        // ...mapGetters(['emp_no']),
        emp_no(){
            return this.$store.state.emp_no;
        }
    },
    setup(){
        const route = useRoute()
        const breadcrumbList = ref([])
        const getBreadcrumbs = () => {
            let matched = route.matched;
            breadcrumbList.value = matched;
        }
        watch(route, () => {
            getBreadcrumbs()
        })
        return {
            breadcrumbList,
        }
    }
}
</script>

<style scoped lang="scss">
@import "../assets/Scss/base/font.scss";
@import "../assets/Scss/components/btn.scss";

header{
        width: 100%;
        padding: 20px 40px;
        min-height: 80px;
        background: $clr_blue_L2;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        .title{
            display: flex;
            h2{
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
        span{
            &:last-child{
                cursor: pointer;
                margin-left: 20px;
                &:hover{
                    color: $clr_blue_L3;
                }
            }
        }
    }
</style>