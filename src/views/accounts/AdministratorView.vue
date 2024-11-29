<template>
    <div class="backstage-administrator" >
        <div class="backstage-content">
            <div class="btn-add">
                <!-- 要給 type="button"，但是 type 屬性被 iVew 佔用了，不能設定
                    所以我把 iVew 的 Button 改成原生的 button，
                    這樣就可以設定 type="button"
                    然後再給 class btn-blue 設定樣式-->
                <Button type="button" class="ivu-btn-primary btn-blue"
                @click="seenAdd = true">新增帳號</Button>
            </div>
        </div>
        <!------- 列表內容 ------->
        <div class="administrator-manager">
            <Table stripe border :columns="columns" :data="AdList">
                <!-- 員工編號 -->
                <template #emp_no="{ row, index }">
                    <Input type="text" v-if="editIndex === index" />
                        <span v-else>{{ row.emp_no }}</span>
                </template>
                <!-- 員工帳號 -->
                <template #emp_id="{ row, index }">
                    <Input type="text" v-if="editIndex === index" />
                        <span v-else>{{ row.emp_id }}</span>
                </template>
                <!-- 員工姓名 -->
                <template #emp_name="{ row, index }">
                    <Input type="text" v-if="editIndex === index" />
                        <span v-else>{{ row.emp_name }}</span>
                </template>
                <!-- 員工信箱 -->
                <template #emp_email="{ row, index }">
                    <Input type="text" v-if="editIndex === index" />
                        <span v-else>{{ row.emp_email }}</span>
                </template>
                <!-- 帳號狀態 -->
                <template #emp_status="{ row }">
                    <span v-if="row.emp_status == 1">啟用</span>
                    <span v-else-if="row.emp_status == 0">停用</span>
                </template>
                <!-- <template #emp_states="{ row }" >
                    <Switch size="large"
                        v-model="row.emp_status"
                        :true-value = 1
                        :false-value = 0
                        true-color = "#6C9255"
                        false-color = "#E6E6E6"
                        @click="changeStatus(row.emp_status)">
                        <template #open><span>ON</span></template>
                        <template #close><span>OFF</span></template>
                    </Switch>
                </template> -->
                <!-- 編輯 -->
                <template #emp_edit="{ row }">
                    <div class="btn-box">
                        <span class="icon material-symbols-outlined" style="cursor: pointer;" 
                        @click="editForm(row.emp_no)">edit_square</span>
                    </div>
                </template>
                <!-- 刪除 -->
                <!-- <template #delete="{ row, index }">
                    <span class="icon material-symbols-outlined"
                        style="font-size:26px; margin-top: 5px;"
                        @click="delCheck(row, index)"
                    >delete
                    </span>
                </template> -->
                <!-- 彈窗：帳號狀態變更確認 -->
                <div class="modal-mask" :style="modalStyle">
                    <div class="modal-container" @click="toggleModal">
                        <div class="modal-body">
                            <p class="font-16-15em">
                                <span class="icon material-symbols-outlined">error</span>
                                <span>Edit confirmation</span>
                            </p>
                            <p class="font-16-15em">確定要變更嗎？</p>
                            <Button type="button" class="btn-danger_2nd" long :loading="modal_loading" @click="show_delCheck = false">取消</Button>
                            <Button  type="button" class="btn-danger" long :loading="modal_loading" @click="del(index)">確認</Button>
                        </div>
                    </div>
                </div>
                <!-- 刪除帳號 -->
                <template #delete="{ row, index }">
                    <span class="icon material-symbols-outlined"
                        style="font-size:26px; margin-top: 5px; cursor: pointer;"
                        @click="delCheck(row, index)"
                    >delete
                    </span>
                </template>
                <!-- <template #action_error>
                    <span 
                    class="icon material-symbols-outlined" style="font-size:26px; margin-top: 5px; cursor: pointer;" @click="isShow = true">delete</span>
                </template> -->
            </Table>
            <!-- 彈窗：刪除確認 -->
            <!-- <div class="modal-mask" :style="modalStyle"> -->
            <div class="modal-mask" v-show="show_delCheck">
                <div class="modal-container">
                <!-- <div class="modal-container" @click.self="toggleModal"> -->
                    <!-- <div class="ad-check"> -->
                    <div class="modal-body">
                        <p class="font-16-15em">
                            <span class="icon material-symbols-outlined">error</span>
                            <span>Delete confirmation</span>
                        </p>
                        <p
                        class="font-16-15em">確定要刪除嗎？</p>
                        <Button  type="button" class="btn-danger_2nd" long :loading="modal_loading" @click="show_delCheck = false">取消</Button>
                        <Button  type="button" class="btn-danger" long :loading="modal_loading" @click="delAdData(index)">刪除</Button>
                        <!-- <Button  type="button" class="btn-danger" long :loading="modal_loading" @click="delAdData(row.emp_no)">刪除</Button> -->
                    </div>
                </div>
            </div>
            <!-- 彈窗：改狀態確認 -->
            <div class="modal-mask" :style="modalStyle_list">
                <div class="modal-container" @click.self="toggleModal">
                    <div class="modal-body">
                        <p class="font-16-15em">
                            <span class="icon material-symbols-outlined">error</span>
                            <!-- <span>Delete confirmation</span> -->
                        </p>
                        <p class="font-16-15em">確定要修改狀態嗎？</p>
                        <Button class="btn-blue_2nd" long :loading="modal_loading" @click="toggleModal_list">取消</Button>
                        <Button  type="button" class="btn-blue" long :loading="modal_loading" @click="list(index)">確定</Button>
                    </div>
                </div>
            </div>
            <!-- 彈窗：編輯帳號 -->
            <form id="Ad_editForm" method="post" enctype="multipart/form-data">
                <div class="popup-edit " v-show="show_EditForm" >
                    <div class="popup-content font-18">
                        <div class="popup-head font-20">編輯帳號</div>
                        <div class="input-txt">
                            <p class="input-info" name="emp_no">編號：{{editingAd.emp_no}}</p>
                            <div class="input-info">
                                <label for="">員工姓名：
                                    <Input type="text" name="emp_name" id="editingAd_name" 
                                    v-model="editingAd.emp_name"
                                    maxlength="5"
                                    show-word-limit
                                    placeholder="請輸入姓名(最多5個字)" 
                                    required  
                                    style="width: 200px"/>
                                </label>
                            </div>
                            <div class="input-info">
                                <label for="">員工信箱：
                                    <Input type="email"  name="emp_email" 
                                    id="editingAd_email" 
                                    v-model="editingAd.emp_email"
                                    maxlength="100"
                                    show-word-limit
                                    placeholder="請輸入Email" 
                                    required  
                                    style="width: 200px"/>
                                </label>
                            </div>
                        </div>
                        <div class="input-switchs">
                            <label class="state">帳號狀態：
                                <span class="icon material-symbols-outlined" style="font-size:26px; margin-top: 5px; cursor: pointer;">
                                <!-- <span class="icon material-symbols-outlined" style="font-size:26px; margin-top: 5px; cursor: pointer;" @click="isShow_list = true"></span> -->
                                    <Switch name="emp_status"
                                        v-model="editingAd.emp_status"
                                        true-color="#13ce66" false-color="#E6E6E6" 
                                        :true-value = 1
                                        :false-value = 0 />
                                </span>
                            </label>
                        </div>
                        <div class="popup-btn">
                            <Button type="button" class="btn-blue" @click="editAdData">儲存</Button>
                            <Button  type="button" class="btn-blue_2nd" @click="show_EditForm = false;">取消</Button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- <Page :total="40" size="small" /> -->
    <!-- style="display:none" -->

    <!------ 新增表單 ------>
    <form id="newForm" method="post" enctype="multipart/form-data">
        <div class="popup " v-show="seenAdd" >
            <div class="popup-content font-18">
                <div class="popup-head font-20">新增員工帳號</div>
                <div class="input-txt">
                    <div class="input-info-add">
                        <label for="">員工編號：
                            <Input type="text" placeholder="新增後產生"
                            disabled="disabled"
                            clearable style="width: 200px" />
                        </label>
                    </div>
                    <div class="input-info-add">
                        <label for="">員工帳號：
                            <Input type="text" name="emp_id"  id="newForm_id" v-model="newForm_id" 
                            maxlength="10"
                            placeholder="半形英數共10碼"
                            style="width: 200px"/>
                        </label>
                    </div>
                    <div class="input-info-add">
                        <label for="">員工密碼：
                            <Input type="password" name="emp_psw" id="newForm_psw" v-model="newForm_psw" 
                            maxlength="10"
                            placeholder="半形英數最多10碼"  style="width: 200px"/>
                        </label>
                    </div>
                    <div class="input-info-add">
                        <label for="">員工姓名：
                            <Input type="text" name="emp_name" id="newForm_name" v-model="newForm_name" 
                            maxlength="5"
                            placeholder="請輸入姓名(最多五個字)" 
                            clearable  
                            style="width: 200px"/>
                        </label>
                    </div>
                    <div class="input-info-add">
                        <label for="">員工信箱：
                            <Input type="email"  name="emp_email" id="newForm_email" v-model="newForm_email" 
                            maxlength="100"
                            placeholder="請輸入Email" 
                            required
                            style="width: 200px"/>
                        </label>
                    </div>
                </div>
                <div class="input-switchs">
                    <label class="state" for="">帳號狀態：
                        <Switch true-color="#13ce66" false-color="#E6E6E6" v-model="newForm_status"
                                :true-value = 1
                                :false-value = 0 />
                        <!-- <input type="text" name="emp_status"> -->
                    </label>
                </div>
                <div class="popup-btn">
                    <Button type="button" class="btn-blue" @click="addAdData">新增帳號</Button>
                    <Button class="btn-blue_2nd" @click="seenAdd = false;">取消</Button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import {BASE_URL} from "@/assets/js/common.js"
import { Switch } from 'view-ui-plus';

export default {
	name: 'AdministratorView',
	components: {
    Switch
},
    data () {
        return {
            editIndex : -1,
            // ----- 彈窗 -----
            show_statusCheck: false,
            // show_cancelCheck: false,
            show_delCheck:    false,
            show_NewForm:     false,
            alert_Loading:    false,
            
            deleteNo: '',

            isShow: false,
            isShow_list: false,
            modal_loading: false,
            seenAdd:false, //新表格彈窗，綁新表單v-show、按鈕@click="seenAdd"
            show_EditForm:false, //編輯帳號彈窗
            // Ad_editForm:false, //編輯帳號彈窗
            size:'default', //按鈕間距，搭配Space，預設small(無間距)， 可自行調整距離px，詳情請看 https://run.iviewui.com/
            columns: [
                {
                    title: '員工編號',
                    slot: 'emp_no',
                    align: 'center'
                },
                {
                    title: '員工帳號',
                    slot: 'emp_id',
                    align: 'center'
                },
                {
                    title: '員工姓名',
                    slot: 'emp_name',
                    align: 'center'
                },
                {
                    title: '員工信箱',
                    slot: 'emp_email',
                    align: 'center'
                },
                {
                    title: '帳號狀態',
                    slot: 'emp_status',
                    width: 120,
                    align: 'center'
                },
                {
                    title: '編輯帳號',
                    slot: 'emp_edit',
                    width: 120,
                    align: 'center'
                },
                {
                    title: '刪除帳號',
                    slot: 'delete',
                    width: 120,
                    align: 'center'
                }
            ],
            AdList: [
                // {
                //     emp_no: '001',
                //     emp_id: 'A12367',
                //     emp_name: '三個字',
                //     emp_email: 'abc@gmail.com'
                // },
                // {
                //     emp_no: '002',
                //     emp_id: 'B12367',
                //     emp_name: '三個字',
                //     emp_email: 'abc@gmail.com'
                // },
                // {
                //     emp_no: '003',
                //     emp_id: 'C12367',
                //     emp_name: '三個字',
                //     emp_email: 'abc@gmail.com'
                // },
                // {
                //     emp_no: '004',
                //     emp_id: 'A12367',
                //     emp_name: '三個字',
                //     emp_email: 'abc@gmail.com'
                // }
            ],
            formValidate: {
                    mail: '',
            },
            ruleValidate: {
                mail: [
                    { required: true, message: 'Mailbox cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
            },
// ------- 儲存資料 ---------
            AdList: [],
// ------- 編輯帳號 ---------
            newForm_id: '',
            newForm_psw: '',
            newForm_name: '',
            newForm_email: '',
            newForm_status: 1,
 
            editingNo: '', 
            editingAd: [],
        }
    },
    computed: {
        modalStyle(){
            return {
                'display': this.isShow ? '' : 'none'
            };
        },
        modalStyle_list(){
            return {
                'display': this.isShow_list ? '' : 'none'
            };
        },
    },
    methods: {
        show (index) {
            this.$Modal.info({
                title: 'User Info',
                content: `Name：${this.AdList[index].name}<br>Age：${this.AdList[index].age}<br>Address：${this.AdList[index].address}`
            })
        },
        remove (index) {
            this.AdList.splice(index, 1);
        },
// ------- 新增表單 -------
        // addToggle(){ 
        //     this.seenAdd = !this.seenAdd
        // },
        editForm(edit){
            console.log(this.show_EditForm);
            this.editingNo = edit;
            // this.Ad_editForm = true;
            this.show_EditForm = true;
            this.editingAd = this.AdList.find(v=> v.emp_no === this.editingNo) ?? [];
        },

// ----- 關閉彈窗(取消) ------
        cancel(){
            this.alert_Loading = true;
            setTimeout(() => {
                this.show_statusCheck = false;
                // this.show_cancelCheck = false;
                this.show_NewForm = false;
                this.show_EditForm = false;
                this.alert_Loading = false;
                this.newForm_name = '';
                this.newForm_email = '';
                document.getElementById("newForm_name").classList.remove('error');
                document.getElementById("newForm_email").classList.remove('error');
            }, 200);
        },
        
// ----- 新增帳號資料 ------ fetch
        addAdData(){
            console.log(this);
            let newForm_id = document.getElementById("newForm_id");
            let newForm_psw = document.getElementById("newForm_psw");
            let newForm_name = document.getElementById("newForm_name");
            let newForm_email = document.getElementById("newForm_email");
            // let newForm_status = document.getElementById("newForm_status");
            
            if(this.newForm_id == '' || this.newForm_id == undefined || this.newForm_id == null){
                this.$Message.warning('請填寫帳號');
                newForm_id.classList.add('error');
                return;
            }else if(this.newForm_psw == '' || this.newForm_psw == undefined || this.newForm_psw == null){
                this.$Message.warning('請填寫密碼');
                newForm_psw.classList.add('error');
                return;
            }
            else if(this.newForm_name == '' || this.newForm_name == undefined || this.newForm_name == null){
                this.$Message.warning('請填寫姓名');
                newForm_name.classList.add('error');
                return;
            }
            else if(this.newForm_email == '' || this.newForm_email == undefined || this.newForm_email == null){
                this.$Message.warning('請填寫Email');
                newForm_email.classList.add('error');
                return;
            }
            else if(this.newForm_email.indexOf("@") === -1){
                this.$Message.warning('Email格式錯誤');
                newForm_email.classList.add('error');
                return;
            }

            // fetch("http://localhost/cgd103-g4-backend/public/phpfiles/Ad_Insert.php",{
            fetch(`${BASE_URL}/Ad_Insert.php`,{
                method:'POST', body:new URLSearchParams({
                emp_id:this.newForm_id,
                emp_psw:this.newForm_psw,
                emp_name:this.newForm_name,
                emp_email:this.newForm_email,
                emp_status:this.newForm_status,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                if(result.msg == "新增成功"){
                    setTimeout(() => {
                        this.$Notice.success({
                            // title: "新增成功",
                            desc: result.msg,
                        });
                        this.alert_Loading = false;
                        this.show_NewForm = false;
                    }, 600);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }else{
                    setTimeout(() => {
                        this.$Notice.error({
                            title: "新增失敗",
                            desc: result.msg,
                            duration: 0 // 彈窗不消失
                        });
                        this.alert_Loading = false;
                        this.show_NewForm = false;
                    }, 600);
                }
            })
        },
// ----- 編輯帳號資料 ------ fetch
        editAdData(){
            console.log(this.editingAd.emp_no);
            let editAd_name = document.getElementById("editAd_name");
            let editAd_email = document.getElementById("editAd_email");
            
            if(this.editingAd.emp_name == '' || this.editingAd.emp_name == undefined || this.editingAd.emp_name == null){
                this.$Message.warning('請填寫姓名');
                editAd_name.classList.add('error');
                return;
            }
            else if(this.editingAd.emp_email == '' || this.editingAd.emp_email == undefined || this.editingAd.emp_email == null){
                this.$Message.warning('請填寫Email');
                editAd_email.classList.add('error');
                return;
            }
            else if(this.editingAd.emp_email.indexOf("@") === -1){
                this.$Message.warning('Email格式錯誤');
                editingAd_email.classList.add('error');
                return;
            }
            // fetch("http://localhost/cgd103-g4-backend/public/phpfiles/Ad_updata.php",{
            fetch(`${BASE_URL}/Ad_updata.php`,{
                method:'POST', body:new URLSearchParams({
                emp_no:this.editingAd.emp_no,
                emp_name:this.editingAd.emp_name,
                emp_email:this.editingAd.emp_email,                
                emp_status:this.editingAd.emp_status,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                setTimeout(() => {
                    this.alert_Loading = false;
                    this.show_EditForm = false;
                    this.$Message.success(result.msg);
                }, 600);
            })
        },
// ------- 關閉新增編輯表單(取消) -------
        // cancel(){
        //     this.modal_loading = true;

        // },
// ----- 彈窗：刪除確認 ------
        delCheck(row, index){
            // console.log(row.emp_no);
            this.deleteNo = row.emp_no;
            this.rowCount = index;
            this.show_delCheck = true;
        },
// ----- 刪除資料 ------ fetch
        delAdData(){
            // let deleteNo = deleteAdno;
            console.log(this.deleteNo);

            // fetch("http://localhost/cgd103-g4-backend/public/phpfiles/Ad_delete.php",{
            fetch(`${BASE_URL}/Ad_delete.php`,{
                method:'POST', body:new URLSearchParams({
                emp_no:this.deleteNo,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                setTimeout(() => {
                    this.AdList.splice(this.rowCount, 1);
                    this.alert_Loading = false;
                    this.show_delCheck = false;
                    this.$Message.success(result.msg);
                }, 600);
            })
        },
// ------ 刪除帳號彈窗 -------
        del(index){
            this.AdList.splice(index, 1);
            this.modal_loading = true;
            setTimeout(() => {
                this.modal_loading = false;
                this.isShow = false;
                this.$Message.success('已刪除一筆管理者帳號');
            }, 200);
        },
// ------- 編輯帳號彈窗 -------
        // editToggle(){ 
        //     this.Ad_editForm = !this.Ad_editForm;
        //     console.log(this);
        // },
// ------- 變更帳號狀態彈窗 -------
        list(index){
            this.modal_loading = true;
            setTimeout(() => {
                this.modal_loading = false;
                this.isShow_list = false;
                this.$Message.success('已變更一筆管理者帳號狀態');
            }, 200);
        },
        toggleModal(){
            this.isShow = !this.isShow;
            // console.log(this);
        },
        toggleModal_list(){
            this.isShow_list = !this.isShow_list;
            // console.log(this);
        },
// ------- 抓後端資料 --------
        getAdData_Fetch(){
            // fetch('http://localhost/cgd103-g4-backend/public/phpfiles/Ad_getData.php')
            fetch(`${BASE_URL}/Ad_getData.php`)
            .then(res=>res.json())
            .then(json=>{
                this.AdList = json;
            })
        },
        // 測試本地資料庫 fetch
        // getAdData_Fetch(){
        //     fetch('http://localhost/phpLab/list_cgd103.php')
        //     // fetch('http://localhost/phpLab/connectJet_speed.php')
        //     // fetch('../../../../phpLab/connectJet_speed.php')
        //     .then(res=>res.json())
        //     .then(json=>{
        //         this.Addata = json;
        //     })
		// },
        // 測試本地資料庫 XML
        // getAdData_XML(){
        //     let faqVue = this;
		// 	let xhr = new XMLHttpRequest();
        //     // console.log(this);
		// 	xhr.onload = ()=>{
        //         // console.log(this);
        //         if(xhr.status == 200){
        //             // console.log(this);
        //             faqVue.Addata = JSON.parse(xhr.responseText);
		// 		}
		// 	}
		// 	xhr.open("get", "http://localhost/phpLab/getFaqData_XML.php", true);
		// 	// xhr.open("get", "http://localhost/phpLab/list_cgd103.php", true);
		// 	xhr.send(null);
		// },
        // 測試新增資料
        // addAdData(){
        //     let xhr = new XMLHttpRequest();
        //     xhr.onload = function(){
        //         let result = JSON.parse(xhr.responseText);
        //         alert(result.msg);
        //     }
        //     xhr.open("post", "http://localhost/phpLab/faqInsert.php", true);
        //     xhr.send(new FormData(document.getElementById("newForm")));
        // },
        // changeStatus(row){
        //     featch()
        // }

    },
    created(){
		this.getAdData_Fetch();

	},
    mounted(){
        // this.getAdData_XML();
    },
}
</script>

<style scoped lang="scss">
@import "../../assets//Scss/components/btn.scss";
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
/* 更改狀態確認彈窗 */
.modal-container{
    z-index: 10;
}

/* 帳號管理 */
/* 麵包屑 */
.backstage-path{
    text-align: start;
    color: #888888;
    margin: 40px 0 0 40px;
}

/* 新增帳號按鈕 */
.btn-add{
    text-align: end;
}
.ivu-btn-primary{
    text-align: end;
    margin-right: 40px;
    background-color: #0C3B59;
    border: #0C3B59;
    color: #fff;
}
.ivu-btn-primary:hover{
    // background-color: #4F6573;
    background-color: #A3AFBF;
}

/* 管理介面 */

.administrator-manager{
    // height: 45vh;
    // height: calc(100VH - 80px - 19.2px - 32px);
    margin: 30px 40px;
}

/* -------------------新增帳號彈窗 ------------------------*/
.popup{
    position: absolute;
    z-index: 10;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    transition: opacity .3s ease;
}
/* 上方區塊顏色 */
.popup-head{
    background-color: #2D3740;
    height: 40px;
    color: #ccc;
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.popup-content{
    position: absolute;
    top: 60px;
    left: 300px;
    margin: auto;
    z-index: 10;
    width: 40%;
    background-color: #4F6573;
}
.input-txt{
    margin-top: 50px;
    margin-bottom: 40px;
}

.input-info-add{
    margin-bottom: 40px;
    padding-left: 85px;
    &:nth-of-type(1){
        &:deep(.ivu-input::placeholder){
            color: #fff;    
        }
        &:deep(.ivu-input[disabled]){
            background-color: #bcbaba
        }
    }
    
}
    
    // &:deep(.ivu-input){
    //     color: red;
    // }

.input-switchs{
    margin-bottom: 15px;
    padding-left: 85px;
}
.popup-btn{
    margin: 70px 90px 50px 0 ;
    display: flex;
    justify-content: right;

}
.popup-btn button{
    margin: 0 20px;
}

/* 彈窗字顏色 */
.popup label{
    color: #fff;
}
.date{
    color: #ccc;
}


/* -------------------新增帳號彈窗結束----------------- */
/* -------------------刪除彈窗----------------- */
.modal-mask{
    position: absolute;
    z-index: 10;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: table;
    background-color: rgba(0, 0, 0, 0.3);
    transition: opacity .3s ease;
}
.modal-container{
    display: table-cell;
    vertical-align: middle;
}
.modal-body{
    position: absolute;
    top: 50%;
    left: 50%;
    left: calc(50% - 150px);
    transform: translate(-50%, -50%);
    width: fit-content;
    margin: auto;
    padding: 30px 80px;
    border-radius: 10px;
    background-color: #fff;
    p{
        text-align: center;
        margin-bottom: 10px;
        &:first-child{
            margin-bottom: 5px;
            span{
                vertical-align: top;
            }
        }
    }
    button+button{
        margin-left: 30px;
    }
}

// ------------------- 編輯帳號彈窗 -------------------
.popup-edit{
    position: absolute;
    z-index: 6;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    transition: opacity .3s ease;
    /* 上方區塊顏色 */
    .popup-head{
        background-color: #2D3740;
        height: 40px;
        color: #ccc;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }
    .popup-content{
        position: absolute;
        top: 100px;
        left: 300px;
        margin: auto;
        z-index: 5;
        width: 40%;
        background-color: #4F6573;
    }
    .input-txt{
        margin-top: 50px;
    }
    .input-info{
        margin-bottom: 40px;
        padding-left: 85px;
        color: #fff;
    }
    .input-switchs{
        margin-bottom: 15px;
        padding-left: 85px;
        color: #fff;
    }
    .input-txt{
        margin-bottom: 40px;
    }
    .popup-btn{
        margin: 70px 90px 50px 0 ;
        display: flex;
        justify-content: right;

    }

    .popup-btn button{
        margin: 0 20px;
    }
}
</style>