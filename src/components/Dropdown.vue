<!-- 引入:選單寬度、預設文字、選單項目(陣列) -->
<!-- <Dropdown
    :dropdownWidth="dropdownWidth"
    :activeTxt="activeTxt"
    :dropDownList="dropDownList"
/> -->

<template>
    <div class="dropDown">
        <div class="dropdown-select font-16"
            :style="{ width: dropdownWidth }"
            :class="toggle?'on':''"
            @click="toggle=!toggle"
        >
            <p>{{activeTxt}}</p>
            <span class="Icon material-symbols-outlined">expand_more</span>
        </div>
        <ul class="dropdown-list" :class="toggle?'show':''">
            <li class="dropdown-item font-16"
                :style="{ width: dropdownWidth }"
                v-for="(dropDownItem, index) in dropDownList"
                :key="dropDownItem.text"
                @click.self="changeSelect(index)"
            >
                {{dropDownItem.text}}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
	name: 'Dropdown',
    props: {
        dropdownWidth: String,
        activeTxt: String,
        dropDownList: Array,
    },
	data(){
        return{
            toggle: false,
            // 引入參考
            // dropDownList: [
            //     { text: '會員問題', },
            //     { text: '行程問題', },
            //     { text: '商品問題', },
            // ],
            // activeTxt: '請選擇',
            // dropdownWidth: '120px',
        }
    },
	methods: {
        changeSelect(index){
            this.toggle=!this.toggle;
            this.activeTxt = this.dropDownList[index].text;
            // console.log(event.target.innerHTML);
            // console.log(this);
            // console.log(event);
            // console.log(index);
            // console.log(this.dropDownList);
            // console.log(this.dropDownList[0]);
            // console.log(this.dropDownList[index]);
        }
	},
}
</script>

<style scoped lang="scss">
@import "../assets/Scss/components/btn.scss";
.dropDown{
    $dropDownTrs: 0.5s;
    $dropDownTxtClr: #515a6e;
    $dropDownClr_L1: #2d8cf0;
    $dropDownClr_L2: #57a3f3;
    position: relative;
    width: fit-content;
    .dropdown-select{
        cursor: pointer;
        display: flex;
        justify-content: center;
        min-width: fit-content;
        border: 1px solid #dcdee2;
        border-radius: 4px;
        background: #fff;
        color: $dropDownTxtClr;
        margin-bottom: -5px;
        padding: 3px 10px 3px 15px;
        text-align: center;
        transition: 0.3s;
        &:hover{
            color: $dropDownClr_L1;
            border-color: $dropDownClr_L2;
            transition: 0.3s;
        }
        p{
            padding-top: 3px;
        }
        .Icon{
            transition: 0.3s;
        }
    }
    .dropdown-select.on{
        border-color: $dropDownClr_L2;
        -webkit-box-shadow: 0 0 0 2px rgb(45 140 240 / 20%);
        box-shadow: 0 0 0 2px rgb(45 140 240 / 20%);
        transition: 0.3s;
        .Icon{
            transform: rotate(180deg);
            transition: 0.3s;
        }
    }
    .dropdown-list{
        position: absolute;
        z-index: 100;
        left: -100vw;
        min-width: fit-content;
        box-sizing: border-box;
        margin: 5px 0;
        padding: 5px 0;
        background-color: #fff;
        color: $dropDownTxtClr;
        border-radius: 4px;
        box-shadow: 0 1px 6px rgb(0 0 0 / 20%);
        opacity: 0;
        transition: opacity $dropDownTrs, left 0s $dropDownTrs;
        .dropdown-item{
            cursor: pointer;
            text-align: center;
            padding: 6px 15px;
            color: $dropDownTxtClr;
            white-space: nowrap;
            list-style: none;
            &:hover{
                background: $clr_blue_L4;
            }
            &:active{
                color: $dropDownClr_L1;
            }
        }
    }
    .dropdown-list.show{
        position: absolute;
        left: 0;
        opacity: 1;
        transition: opacity $dropDownTrs;
    }
}
</style>