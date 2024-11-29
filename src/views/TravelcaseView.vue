<template>

    <div class="popup" v-show="seenAdd" >
        <form action="post" enctype="multipart/form-data">
            <div class="popup-head font-20">編輯資料</div>
            <div class="popup-content font-18">
            <div class="input-txt">
                <div class="input-info">
                    <label for="">前台區塊：
                    </label>
                        <Input type="text" name="package_name" v-model="data.package_name" clearable style="width: 300px" />
                </div>
                <div class="input-info">
                    <label for="">活動標籤：
                    </label>
                        <Input type="text" name="package_tag" v-model="data.package_tag" clearable  style="width: 300px"/>
                </div>
                <div class="input-info">
                    <label for="">價格：
                    </label>
                        <Input type="" name="package_price" v-model="data.package_price" clearable  style="width: 300px"/>
                </div>
                <div class="input-info">
                    <label for="">標題：
                    </label>
                        <Input type="email" name="package_title" v-model="data.package_title" clearable  style="width: 300px"/>
                </div>
                <div class="input-info">
                    <label for="">推薦商品：
                    </label>
                        <Input type="tel" name="package_buy" v-model="data.package_buy" clearable  style="width: 300px"/>
                </div>
                <div class="input-info">
                    <label for="">狀態：
                    </label>
                        <!-- <Input type="tel" name="package_status" v-model="data.package_status" clearable  style="width: 300px"/> -->
                        <select class="choosein" name="package_status" v-model="data.package_status" style="width: 300px;text-align:center">
                            <option value="" disabled>-請選擇-</option>
                            <option value="上架">上架</option>
                            <option value="草稿">草稿</option>
                            <option value="下架">下架</option>
                        </select>
                </div>
            </div>
            </div> 
            <div class="popup-btn">
                <!-- <Button type="primary">新增帳號</Button> -->
                <Button @click="seenAdd=!seenAdd">取消</Button>
                <Button @click="editData">確認</Button>
            </div>
        </form>
    </div>

    <div class="backstage-newss" v-show="addnew" >
        <form id="addNewsForm" method="post" enctype="multipart/form-data">
        <div class="container" @click.self="dbcheck">
            <div class="content">
                <div class="type opencode">
                    <p class="nncode font-20"></p>
                </div>
                <div class="type travelcode">
                    <p class="nname">狀態 :</p>
                    <div class="choose">
                        <select class="choosein" name="package_status" v-model="selected">
                            <option value="" disabled>-請選擇-</option>
                            <option value="上架">上架</option>
                            <option value="草稿">草稿</option>
                            <option value="下架">下架</option>
                        </select>
                    </div>
                </div>
                
                <div class="type travelcode">
                    <p class="nname">前台位置 :</p>
                    <div class="choose">
                        <select class="choosein" name="package_name" v-model="selected2">
                            <option value="" disabled>-請選擇-</option>
                            <option value="方案A">方案A</option>
                            <option value="方案B">方案B</option>
                            <option value="方案C">方案C</option>
                            <option value="方案D">方案D</option>
                        </select>
                    </div>
                </div>
                
                <div class="type travelcode">
                    <p class="nname">推薦特產 :</p>
                    <div class="success">
                        <Input class="succe" type="text" name="package_buy" v-model="value1" style="width: 300px"/>
                    </div>
                </div>
                <div class="title2 font-18">方案列表區圖文設定 :</div>
                <div class="type travelcode">
                    <p class="nname">標題(必填) :</p>
                    <Input class="succe" type="text" name="package_title" v-model="value4" style="width: 300px" />
                </div>
                <div class="type travelcode">
                    <p class="nname">副標題(必填) :</p>
                    <Input class="succe" type="text" name="package_subtitle" v-model="value5" style="width: 300px" />
                </div>
                <div class="type travelcode">
                    <p class="nname">介紹頁內文(必填) :</p>
                    <!-- <Form :model="formItem">
                        <FormItem label="Text"> -->
                            <Input name="package_indes" v-model="textarea" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..." style="width: 300px"></Input>
                        <!-- </FormItem>
                    </Form> -->
                </div>
                <div class="type travelcode">
                    <p class="nname">詳情頁內文(必填) :</p>
                    <!-- <Form :model="formItem2">
                        <FormItem label="Text"> -->
                            <Input name="package_des" v-model="textarea2" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..." style="width: 300px"></Input>
                        <!-- </FormItem>
                    </Form> -->
                </div>
                <div class="type travelcode">
                    <p class="nname">價格 (請輸入數字):</p>
                    <Input class="succe" type="text" name="package_price" v-model="value6" style="width: 300px" />
                </div>
                <div class="type travelcode">
                    <p class="nname">標籤 :</p>
                    <Input class="succe" type="text" name="package_tag" v-model="tager" style="width: 300px" />
                </div>
                <div class="type travelcode">
                    <p class="nname">插入圖片 :</p>
                    <Input class="succe" type="file" name="package_pic" style="width: 300px" />
                    <!-- v-model="valuex" -->
                    <!-- v-model="value3" -->
                    <!-- <Upload class="succe" action="//jsonplaceholder.typicode.com/posts/">
                        <Button icon="ios-cloud-upload-outline">Upload files</Button>
                    </Upload> -->
                </div>
                <div class="delcan">
                    <div class="shure" @click="addnew=false">取消</div>
                    <div class="shure" @click="addData()">確認</div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="backstage-news" >
        <div class="backstage-content">
            <div class="btn-add">
                <button class="font-20 btn-blue" @click="addnew=!addnew">新增方案</button>
            </div>
            <div class="news-manager">
                <Tabs  type="card" :animated="false">
                    <TabPane label="上架" >
                        <Table stripe border :columns="columns" :data="dataOn" >
                            <!-- 公告編號 -->
                            <template #news_no="{ row, index }">
                                <Input type="text" v-model="editnews_no" v-if="editIndex === index" />
                                <span v-else>{{ row.package_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text" v-model="editnews_time" v-if="editIndex === index" />
                                <span v-else>{{ row.package_create_date }}</span>
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_session="{ row, index }">
                                <Input type="text" v-model="editIndex_session" v-if="editIndex === index" />
                                <span v-else>{{ row.package_name }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_class="{ row, index }">
                                <Input type="text" v-model="editnews_class" v-if="editIndex === index" />
                                <span v-else>{{ (row.package_price) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }">
                                <Input type="text" v-model="editnews_title" v-if="editIndex === index" />
                                <span v-else>{{ row.package_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text" v-model="editnews_status" v-if="editIndex === index" />
                                <span v-else>{{ row.package_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row }">
                                <div class="btn-box">
                                    <Button @click="activeData(row.package_no)">編輯</Button>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                    <TabPane label="草稿" >
                        <Table stripe border :columns="columns" :data="dataDraft" >
                            <!-- 公告編號 -->
                            <template #news_no="{ row, index }">
                                <Input type="text" v-model="editnews_no" v-if="editIndex === index" />
                                <span v-else>{{ row.package_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text" v-model="editnews_time" v-if="editIndex === index" />
                                <span v-else>{{ row.package_create_date }}</span>
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_session="{ row, index }">
                                <Input type="text" v-model="editIndex_session" v-if="editIndex === index" />
                                <span v-else>{{ row.package_name }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_class="{ row, index }">
                                <Input type="text" v-model="editnews_class" v-if="editIndex === index" />
                                <span v-else>{{ (row.package_price) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }">
                                <Input type="text" v-model="editnews_title" v-if="editIndex === index" />
                                <span v-else>{{ row.package_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text" v-model="editnews_status" v-if="editIndex === index" />
                                <span v-else>{{ row.package_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row }">
                                <div class="btn-box">
                                    <Button @click="activeDataDr(row.package_no)">編輯</Button>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                    <TabPane label="下架" >
                        <Table stripe border :columns="columns" :data="dataOff" >
                            <!-- 公告編號 -->
                                                        <template #news_no="{ row, index }">
                                <Input type="text" v-model="editnews_no" v-if="editIndex === index" />
                                <span v-else>{{ row.package_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text" v-model="editnews_time" v-if="editIndex === index" />
                                <span v-else>{{ row.package_create_date }}</span>
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_session="{ row, index }">
                                <Input type="text" v-model="editIndex_session" v-if="editIndex === index" />
                                <span v-else>{{ row.package_name }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_class="{ row, index }">
                                <Input type="text" v-model="editnews_class" v-if="editIndex === index" />
                                <span v-else>{{ (row.package_price) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }">
                                <Input type="text" v-model="editnews_title" v-if="editIndex === index" />
                                <span v-else>{{ row.package_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text" v-model="editnews_status" v-if="editIndex === index" />
                                <span v-else>{{ row.package_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row }">
                                <div class="btn-box">
                                    <Button @click="activeDataFr(row.package_no)">編輯</Button>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                </Tabs>
            </div>
        </div>
    </div>
</template>
<script>
    import {BASE_URL} from '@/assets/js/common.js'
    export default {
        data () {
            return {
                seenAdd:false,
                selected:"",
                selected2:"",
                value1:"",
                value3:"",
                value4:"",
                value5:"",
                value6:"",
                valuex:"",
                tager:"",
                textarea: '',
                textarea2: '',
                // formItem: {
                //     textarea: '',
                // },
                // formItem2: {
                //     textarea2: '',
                // },
                addnew: false,
                columns: [ 
                {
                    title: '前台區塊',
                    slot: 'news_session',
                    width: 100,
                    align: 'center'
                },
                {
                    title: '方案編號',
                    slot: 'news_no',
                    width: 100,
                    align: 'center'
                },
                {
                    title: '上架日期',
                    slot: 'news_time',
                    width: 110,
                    align: 'center'
                },
                {
                    title: '標題',
                    slot: 'news_title',
                    align: 'center'
                },
                {
                    title: '價格',
                    slot: 'news_class',
                    width: 150,
                    align: 'center'
                },
                {
                    title: '操作',
                    slot: 'action',
                    width: 100,
                    align: 'center'
                },
                {
                    title: '狀態',
                    slot: 'news_status',
                    width: 70,
                    align: 'center'
                }
                ],
                data:[],
                newdataOn:[],
                dataOn: [],
                dataDraft: [
                    // {
                    //     news_no: 'A1100005',
                    //     news_time: '2022/11/23',
                    //     news_session:'E',
                    //     news_class: '火車佐便當',
                    //     news_title: '高千穗-夜神樂',
                    //     news_status:'草稿',
                    // },
                    // {
                    //     news_no: 'A1100006',
                    //     news_time: '2022/11/24',
                    //     news_session:'F',
                    //     news_class: '火車佐便當',
                    //     news_title: '列車停駛',
                    //     news_status:'草稿',
                    // }
                ],
                dataOff: [
                    // {
                    //     news_no: 'A1100007',
                    //     news_time: '2022/11/25',
                    //     news_session:'G',
                    //     news_class: '火車佐便當',
                    //     news_title: '「鹿兒島沙浴」體驗活動報名',
                    //     news_status:'下架',
                    // },
                    // {
                    //     news_no: 'A1100008',
                    //     news_time: '2022/11/26',
                    //     news_session:'H',
                    //     news_class: '火車佐便當',
                    //     news_title: '商城新品上市!!',
                    //     news_status:'下架',
                    // }
                ],
                editIndex: -1,  // 当前聚焦的输入框的行数
                editnews_no: '',  // 第一列输入框，当然聚焦的输入框的输入内容，与 data 分离避免重构的闪烁
                editnews_time: '',  // 第二列输入框
                editnews_class: '',  // 第三列输入框
                editnews_title: '',  // 第四列输入框
                editnews_status: '',
                editnews_session: '',
                activeIndex:"",
                fileName:"",
                }
            },
        created(){
            this.getData();
        },
        methods: {
            // onChange() {
            //     this.value3 = this.valuex.split(':').pop().split('\\').pop();
            //     return this.value3;
            // },
            getData(){
                // const gege = new URL('http://localhost/cgd103-g4-backend/public/phpfiles/getTravelcase.php');
                fetch(`${BASE_URL}/getTravelcase.php`)
                // fetch(gege)
                .then((res)=>res.json())
                .then((json)=>{
                    this.data = json;
                    this.dataOn = this.data.filter(item => {
                        return item.package_status === "上架";
                    });
                    this.dataDraft = this.data.filter(item => {
                        return item.package_status === "草稿";
                    })
                    this.dataOff = this.data.filter(item => {
                        return item.package_status === "下架";
                    })
                })
            },

            // addData(){
            //     let xhr = new XMLHttpRequest();
            //     xhr.onload = function(){
            //     let result = JSON.parse(xhr.responseText);
            //     // alert("新增成功");
                    
            //     }
            //     xhr.open("post", "http://localhost/cgd103-g4-backend/public/phpfiles/setTravelcase.php", true); //專案裡的檔案 
            //     // xhr.open("post", `${BASE_URL}/setTravelcase.php`, true); //線上版 

            //     xhr.send(new FormData(document.getElementById("addNewsForm")));
            //     this.addnew=false
            //     alert("新增成功");
            //     location.reload();
            // },
            addData(){
                const formData = new FormData(document.getElementById('addNewsForm'));
                // const addURL = new URL('http://localhost/cgd103-g4-backend/public/phpfiles/setTravelcase.php');
                fetch(`${BASE_URL}/setTravelcase.php`,{ method:'post',body: formData
                // fetch(addURL,{ method:'post',body: formData
                })
                .then((rt)=>rt.json())
                .then((result)=>{
                    console.log(result);
                    this.addnew=false;
                    alert("新增成功");
                    location.reload();
                })
            },
            editData(){
                // const addURL = new URL('http://localhost/cgd103-g4-backend/public/phpfiles/updateTravelcase.php');
                fetch(`${BASE_URL}/updateTravelcase.php`,{ method:'post',body: new URLSearchParams({
                // fetch(addURL,{ method:'post',body: new URLSearchParams({
                   
                    package_status:this.data.package_status,
                    package_name:this.data.package_name,
                    package_buy:this.data.package_buy,
                    package_title:this.data.package_title,
                    package_price:this.data.package_price,
                    package_tag:this.data.package_tag,
                    package_no:this.data.package_no,

                })})
                .then((rb)=>rb.json())
                .then((resultb)=>{
                    console.log(resultb);
                    this.seenAdd = false;
                    alert("編輯成功");
                    location.reload()
                })
            },
            handleEdit (row, index) {
                this.editnews_no = row.package_name;
                this.editnews_time = row.package_create_date;
                this.editnews_title = row.package_title;
                this.editnews_class = row.package_des;
                this.editnews_status = row.package_status;
                this.editnews_session = row.package_price;
                this.editIndex = index;
            },
            handleSave (index) {
                this.data[index].package_name = this.editnews_no;
                this.data[index].package_create_date = this.editnews_time;
                this.data[index].package_des = this.editnews_class;
                this.data[index].package_title = this.editnews_title;
                this.data[index].package_status = this.editnews_status;
                this.data[index].package_price = this.editnews_session;
                this.editIndex = -1;
            },
            dbcheck(){
                if(this.addnew == true){
                    this.addnew = false;
                    return this.addnew;
                }
            },
            activeData(ed) {
                this.activeIndex = ed;
                this.seenAdd = true;
                this.data = this.dataOn.find((v) => v.package_no === this.activeIndex) ?? {};
            },
            activeDataDr(ed) {
                this.activeIndex = ed;
                this.seenAdd = true;
                this.data = this.dataDraft.find((v) => v.package_no === this.activeIndex) ?? {};
            },
            activeDataFr(ed) {
                this.activeIndex = ed;
                this.seenAdd = true;
                this.data = this.dataOff.find((v) => v.package_no === this.activeIndex) ?? {};
            },
        },
    }
</script>

<style scoped lang="scss">
/* -------------------彈窗 ------------------------*/
@import "@/assets/Scss/base/color.scss";

.popup{
    .popup-content{
    text-align: center;
        .input-txt{
            width: 50%;
            margin: auto;
            .input-info{
                display: flex;
                justify-content: space-between;
                padding: 20px 0px;
            }
        }
    }
}
.backstage-newss{
    width: calc(100vw - 300px);
    background-color: rgba(#000,0.3);
    height: 100vh;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    position: absolute;
    z-index: 99;
}
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
        height: 650px;
        overflow-y: scroll;
        width: 100%;
        max-width: 768px;
        margin: 0px auto;
        background-color: $back_color_active;
        .delcan{
            width: 100%;
            max-width: 30%;
            display: flex;
            justify-content: space-between;
            margin: 0px auto;
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
        .title2{
            color: #fff;
            padding: 50px;
        }
        .type{
            display: flex;
            color: #fff;
            align-items: center;
            .nncode{
                width: 100%;
                background-color: #2D3740;
                text-align: left;
                padding: 30px 30px;
            }
            .nname{
                font-size: 16px;
                width: 50%;
                padding: 30px 0px;
            }
            .choose{
                width: 50%;
                height: 40px;
                display: flex;
                margin: auto auto auto 0px;
                .choosein{
                    border-radius: 5px;
                    width: 300px;
                    text-align: center;
                }
            }
            .success{
                gap: 10px;
                .succe{
                    display: flex;
                    align-items: center;
                    margin-bottom: 10px;
                }
            }
        }
    }
}






.popup{
    position: absolute;
    top: 5px;
    left: 150px;
    margin: auto;
    z-index: 10;
    width: 70%;
    background-color: #4F6573;
}

/* 上方區塊顏色 */
.popup-head{
    background-color: #2D3740;
    height: 80px;
    color: #ccc;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.popup-data{
    margin: 30px 0;
    display: flex;
    justify-content: space-around;
}
.input-title{
    margin-bottom: 40px;
    padding-left: 85px;
}
.input-des,
.input-pic,
.input-pic-des{
    margin-bottom: 15px;
    padding-left: 85px;

}
.input-txt{
    margin-bottom: 40px;
}
.popup-btn{
    margin: 90px 0 50px 0 ;
    display: flex;
    justify-content: center;

}

.popup-btn button{
    margin: 0 100px;
}

/* 彈窗字顏色 */
.popup label{
    color: #fff;
}
.date{
    color: #ccc;
}


/* -------------------彈窗結束----------------- */

/* -------------------新增修改box ------------------------*/
.popup-box{
    position: absolute;
    top: 200px;
    left: 400px;
    width: 400px;
    height: 230px;
    border: 1px solid #6c9255;
    border-radius: 10px;
    background-color: #ffffff;
    text-align: center;
}   

.popup-box-close{
    text-align: end;
    margin-top: 10px;
    padding-right: 20px;
}

.check-des{
    margin-top: 70px;
}

.popup-box button{
    margin-top: 30px;
}

/* -------------------新增修改結束 ------------------------*/

/* 後台header */
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
/* 帳號狀態 */
.backstage-account span{
    display: inline-block;
    cursor: pointer;
    margin: 0 20px;
}

/* 消息管理 */
/* 麵包屑 */
.backstage-path{
    text-align: start;
    color: #888888;
    margin: 40px 0 0 40px;
}

/* 新增按鈕 */
.btn-add{
    text-align: end;
    margin-right: 60px;
    .font-20{
        padding: 8px 16px;
    }
}
/* 管理介面 */
.news-manager{
    height: 45vh;
    margin: 30px 20px;
}

/* 上下頁 */
.btn-bottom{
    text-align: end;
    margin:100px 60px 0 0 ;
    margin-right: 60px;
}

.btn-bottom button{
    margin-left: 80px;
}
</style>