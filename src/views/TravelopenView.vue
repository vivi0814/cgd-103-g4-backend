<template>
<form id="newForm" method="post" enctype="multipart/form-data">
    <div class="backstage-news" >
        <div class="container">
            <div class="content">
                <div class="type opencode">
                    <p class="qq">開團 :</p>
                </div>
                <div class="type travelcode">
                    <p class="nname">行程方案 :</p>
                    <div class="choose">
                        <select class="choosein" name="package_no" v-model="packageno">
                            <option value="" disabled>-請選擇-</option>
                            <option value="1">方案A</option>
                            <option value="2">方案B</option>
                            <option value="3">方案C</option>
                            <option value="4">方案D</option>
                        </select>
                    </div>
                </div>
                
                <div class="type travelcode">
                    <p class="nname">出發日期 :</p>
                    <Input type="date" name="departure_date" style="width: 300px" v-model="departuredate" class="choose"/>
                    <!-- <Space size="large" wrap>
                        <DatePicker type="date" placeholder="Select date" style="width: 300px" />
                    </Space> -->
                </div>
                
                <div class="type travelcode">
                    <p class="nname">開放報名日期 :</p>
                    <Input type="date" name="registration_date" style="width: 300px" v-model="registrationdate" class="choose"/>
                    <!-- <Space size="large" wrap>
                        <DatePicker type="date" placeholder="Select date" style="width: 300px" />
                    </Space> -->
                </div>
                
                <div class="type travelcode">
                    <p class="nname">截止日期 :</p>
                    <Input type="date" name="closing_date" style="width: 300px" v-model="closingdate" class="succe"/>
                    <!-- <Space size="large" wrap>
                        <DatePicker type="date" placeholder="Select date" style="width: 300px" />
                    </Space> -->
                </div>
                
                <div class="type travelcode">
                    <p class="nname">人數上限 :</p>
                    <Input class="succe" type="text" name="max_attendees" style="width: 300px" v-model="maxattendees"  />
                </div>
                
                <div class="type travelcode">
                    <p class="nname">價格 / 人 :</p>
                    <Input class="succe" type="text" name="package_price" style="width: 300px" v-model="packageprice" />
                </div>
                <div class="delcan">
                    <div class="shure">取消</div>
                    <div class="shure" @click="addData">確認</div>
                </div>
            </div>
        </div>
    </div>
</form>
</template>
<script>
    import {BASE_URL} from '@/assets/js/common.js'
    export default {
        data () {
            return {
                data:[],
                selected:"",
                value:"",
                value2:"",
                packageno:"",
                departuredate:"",
                packageprice:"",
                maxattendees:"",
                registrationdate:"",
                closingdate:"",
            }
        },
        methods:{
            addData(){
                // const myURL = new URL('http://localhost/cgd103-g4-backend/public/phpfiles/setTravelopen.php');
                fetch(`${BASE_URL}/setTravelopen.php`,{method:'POST',body: new URLSearchParams({
                // fetch(myURL,{method:'POST',body: new URLSearchParams({
                    package_no:this.packageno,
                    departure_date:this.departuredate,
                    package_price:this.packageprice,
                    max_attendees:this.maxattendees,
                    registration_date:this.registrationdate,
                    closing_date:this.closingdate,
                })})
                .then((res)=>res.json())
                .then((result)=>{
                    console.log(result);
                    alert("成功開團")
                    this.$router.push("/");
                })
            },
        },
    }
</script>

<style scoped lang="scss">
@import "@/assets/Scss/base/color.scss";

// *{
//     outline: solid 1px;
// }

.backstage-name{
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #4F6573;
    color: #fff;
    text-align: start;
    height: 80px;
}
.backstage-name h2{
    margin-left: 40px;
}
.backstage-account span{
    display: inline-block;
    cursor: pointer;
    margin: 0 20px;
}
.backstage-path{
    text-align: start;
    color: #888888;
    margin: 40px 0 0px 40px;
}
.container{
    padding: 40px 0px;
    width: 100%;
    .content{
        width: 100%;
        max-width: 768px;
        margin: auto;
        background-color: $back_color_active;
        .delcan{
            width: 100%;
            max-width: 30%;
            display: flex;
            justify-content: space-between;
            margin: auto;
            padding: 20px 0px;
            .shure{
                background-color: $back_color_main;
                padding: 5px 30px;
                border-radius: 6px;
                color: #fff;
                cursor: pointer;
                font-size: 16px;
            }
            .shure:nth-child(1){
                background-color: #fff;
                color: $back_color_main;
            }
        }
        .type{
            display: flex;
            color: #fff;
            .qq{
                font-size: 36px;
                width: 50%;
                padding: 30px 0px;
                padding-left: 20%;
            }
            .nname{
                font-size: 16px;
                width: 50%;
                padding: 30px 0px;
                padding-left: 20%;
            }
            .choose{
                font-size: 16px;
                height: 40px;
                display: flex;
                margin: auto auto auto 0px;
                .choosein{
                    height: 35px;
                    width: 300px;
                    font-size: 14px;
                    border-radius: 6px;
                    text-align: center;
                    option{
                        color: #333;
                    }
                }
            }
            .succe{
                font-size: 16px;
                display: flex;
                align-items: center;
            }
        }
    }
}

</style>