<!--
    ?問題
    //1. 新增後，禁止畫面跳轉
    //2. 假的下拉選單取資料
    //3. 假的下拉選單及狀態切換開關，要怎麼回傳值
    //4. 修改資料/刪除資料
    //5. 編輯時，表單對應資料顯示
    //6. 多選
    7. 各個彈窗寫成 component
    //8. 進入頁面預設打開"全部"
    //9. 新增/編輯資料時，若欄位為空則不能送出>>>的彈窗
    10.分頁優化寫法
    //11.輸入框剩餘字數
    //12.iVue的全選第二下沒有動作
    //13.表單：編輯的 ?? []
    14.massChangeState 寫成同一支
    15.分頁
    16.宣傳頁
    17.忘記密碼/重設密碼
    //18.狀態變成沒綁到了?
    
    ?小抄
    摺疊快速鍵 Ctrl K 012345
    打開快速鍵 Ctrl K J
    sass ./src/assets/sass/style.scss ./src/assets/css/style.css
 -->

<!--*  -->
<!--!  -->
<!--?  -->
<!--todo  -->
<!--//  -->

<template>
    <div class="FAQ">
		<main>
            <div class="tools">
<!-- 搜尋吧 -->
                <label class="search">
                    <input
                        class="input-blue"
                        type="text"
                        list="previousSearches"
                        v-model="keyword"
                        @input="faqSearch"
                        @keydown.enter="addToList"
                        placeholder="請輸入您想尋找的內容"/>
                        <!-- 以前的搜尋季紀錄 -->
                        <!-- bug > 要 enter 兩次才有效果 -->
                        <datalist id="previousSearches">
                            <option v-for="keyword in previousSearches" :value="keyword"></option>
                        </datalist>
                        <!-- 叉叉 -->
                        <span class="material-symbols-outlined"
                            v-show="keyword!=''"
                            @click="clearInput"
                            >close
                        </span>
                        <!-- 放大鏡 -->
                        <button type="submit" @click="faqSearch">
                            <i class="material-symbols-outlined">&#xe8b6;</i>
                        </button>
                </label>
<!-- 按鈕 -->
                <div class="btns">
                    <button
                        v-show="selectList.length > 1"
                        value="1"
                        class="btn-blue_2nd"
                        @click="massChangeState_1"
                    >批量顯示
                    </button>
                    <button
                        v-show="selectList.length > 1"
                        value="0"
                        class="btn-blue_2nd"
                        @click="massChangeState_0"
                    >批量隱藏
                    </button>
                    <button class="btn-blue" @click="show_NewForm = true">新增</button>
                    <button class="btn-blue" @click="delCheck">刪除</button>
                </div>
            </div>
<!-- 分頁標籤 -->
            <ul class="tabs">
                <li id="tabAll" class="tab font-16" @click="clickAll">全部</li>
                <li class="tab font-16"
                    v-for="category in categoryList"
                    :key="category.faq_type"
                    :class="{on: category.faq_type == activeCategory.faq_type}"
                    @click="changeTab(category)"
                >
                    {{category.faq_type}}
                </li>
            </ul>
<!-- 表格欄位 -->
            <Table stripe type="selection" border
                :columns="columns"
                :data="activeList"
                @on-select="onSelect"
                @on-select-cancel="onSelectCancel"
                @on-select-all="onSelectAll"
                @on-select-all-cancel="selectList=[]"
            >
                <!-- 編號 -->
                <template #faq_no="{ row, index }">
                    <Input type="text"  v-if="editIndex === index"/>
                    <span v-else>{{ row.faq_no }}</span>
                </template>
                <!-- 分類 -->
                <template #faq_type="{ row, index }">
                    <Input type="text"  v-if="editIndex === index"/>
                    <span v-else>{{ (row.faq_type) }}</span>
                </template>
                <!-- 問題 -->
                <template #faq_q="{ row }" >
                    <span class="font-14" v-html="renderHtml(row.faq_q)" id="q-{{ row.faq_no }}"></span>
                </template>
                <!-- 回答 -->
                <template #faq_a="{ row }" >
                    <span class="font-14" v-html="renderHtml(row.faq_a)" id="q-{{ row.faq_no }}"></span>
                </template>
                <!-- 狀態 -->
                <template #faq_state="{ row }" >
                    <Switch size="large"
                        v-model="row.faq_status"
                        :true-value = 1
                        :false-value = 0
                        true-color = "#6C9255"
                        false-color = "#E6E6E6"
                        @click="changeStatus(row)"
                    >
                        <template #open><span>ON</span></template>
                        <template #close><span>OFF</span></template>
                    </Switch>
                </template>
                <!-- 編輯 -->
                <template #edit="{ row }">
                    <div class="btn-box">
                        <span class="icon material-symbols-outlined" @click="editForm(row.faq_no)">edit_square</span>
                    </div>
                </template>
                <!-- 刪除 -->
                <template #delete="{ row, index }">
                    <span v-if="selectList.length > 1"
                        class="icon material-symbols-outlined"
                        style="font-size:26px; margin-top: 5px;"
                        @click="delCheck"
                    >delete
                    </span>
                    <span v-else
                        class="icon material-symbols-outlined"
                        style="font-size:26px; margin-top: 5px;"
                        @click="delCheck(row, index)"
                    >delete
                    </span>
                </template>
            </Table>
		</main>
<!-- 新增表單 -->
        <form id="newForm" method="post" enctype="multipart/form-data">
            <div class="alert-mask" v-show="show_NewForm">
                <div class="alert-container faq-form newForm">
                    <!-- 標題 -->
                    <div class="form-head">
                        <p class="font-20">新增 FAQ</p>
                        <span class="material-symbols-outlined" @click="show_cancelCheck = true">close</span>
                    </div>
                    <!-- 內容 -->
                    <div class="form-body">
                        <div>
                            <!-- 下拉選單 -->
                            <p class="font-16">＊類別：</p>
                            <Select name="faq_type"
                                id="newFaq_type"
                                v-model="newFaq_type"
                                placeholder="請選擇"
                                style="width: 120px"
                            >
                                <Option v-for="dropDownItem in dropDownList"
                                    :value="dropDownItem.faq_type"
                                    :key="dropDownItem.faq_type"
                                >
                                    {{dropDownItem.faq_type}}
                                </Option>
                            </Select>
                            <!-- 狀態開關 -->
                            <p class="font-16">＊狀態：</p>
                            <Switch name="faq_status"
                                size="large"
                                v-model="newFaq_status"
                                :true-value = 1
                                :false-value = 0
                                true-color = "#6C9255"
                                false-color = "#E6E6E6"
                            >
                                <template #open><span>ON</span></template>
                                <template #close><span>OFF</span></template>
                            </Switch>
                            <!-- 編號 -->
                            <p class="font-16">編號：新增後生成</p>
                        </div>
                        <!-- 輸入框 -->
                        <div>
                            <p ref="" class="font-16">＊問題：</p>
                            <Input name="faq_q"
                                id="newFaq_q"
                                v-model="newFaq_q"
                                maxlength="100"
                                show-word-limit
                                placeholder="請輸入問題"
                                type="textarea"
                                :autosize="{minRows: 4,maxRows: 4}"/>
                        </div>
                        <div>
                            <p class="font-16">＊回答：</p>
                            <Input name="faq_a"
                                id="newFaq_a"
                                v-model="newFaq_a"
                                maxlength="300"
                                show-word-limit
                                placeholder="請輸入回答"
                                type="textarea"
                                :autosize="{minRows: 8.6,maxRows: 8.6}"/>
                        </div>
                        <!-- 按鈕 -->
                        <div>
                            <p class="font-16">＊為必填／必選項目</p>
                            <button type="button" class="btn-blue_2nd" @click="show_cancelCheck = true">取消</button>
                            <button type="button" class="btn-blue" @click="addFaqData">新增</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
<!-- 編輯表單 -->
        <form id="editForm" method="post" enctype="multipart/form-data">
            <div class="alert-mask" v-show="show_EditForm">
                <div class="alert-container faq-form editForm">
                    <!-- 標題 -->
                    <div class="form-head">
                        <p class="font-20">編輯 FAQ</p>
                        <span class="material-symbols-outlined" @click="show_cancelCheck = true">close</span>
                    </div>
                    <!-- 內容 -->
                    <div class="form-body">
                        <!-- 上面那排 -->
                        <div>
                            <p class="font-16">＊類別：</p>
                            <!-- 下拉選單 -->
                            <Select name="faq_type"
                                v-model="editingFaq.faq_type"
                                placeholder="請選擇"
                                style="width: 120px"
                            >
                                <Option v-for="dropDownItem in dropDownList"
                                    :value="dropDownItem.faq_type"
                                    :key="dropDownItem.faq_type"
                                >
                                    {{dropDownItem.faq_type}}
                                </Option>
                            </Select>
                            <!-- 狀態開關 -->
                            <p class="font-16">＊狀態：</p>
                            <Switch size="large"
                                name="faq_status"
                                v-model="editingFaq.faq_status"
                                :true-value = 1
                                :false-value = 0
                                true-color = "#6C9255"
                                false-color = "#E6E6E6"
                            >
                                <template #open><span>ON</span></template>
                                <template #close><span>OFF</span></template>
                            </Switch>
                            <!-- 編號 -->
                            <p class="font-16">編號：{{editingFaq.faq_no}}</p>
                        </div>
                        <!-- 輸入框 -->
                        <div>
                            <p class="font-16">＊問題：</p>
                            <Input name="faq_q"
                                id="editFaq_q"
                                v-model="editingFaq.faq_q"
                                maxlength="100"
                                show-word-limit
                                placeholder="請輸入問題"
                                type="textarea"
                                :autosize="{minRows: 4,maxRows: 4}"/>
                        </div>
                        <div>
                            <p class="font-16">＊回答：</p>
                            <Input name="faq_a"
                                id="editFaq_a"
                                v-model="editingFaq.faq_a"
                                maxlength="300"
                                show-word-limit
                                placeholder="請輸入回答"
                                type="textarea"
                                :autosize="{minRows: 8.6,maxRows: 8.6}"/>
                        </div>
                        <!-- 按鈕 -->
                        <div>
                            <p class="font-16">＊為必填／必選項目</p>
                            <button type="button" class="btn-blue_2nd" @click="show_cancelCheck = true">取消</button>
                            <button type="button" class="btn-blue" @click="editFaqData">儲存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
<!-- 彈窗：刪除確認 -->
        <div class="alert-mask"
            v-show="show_delCheck"
            @click.self="show_delCheck = false"
        >
            <div class="alert-container delCheck" >
                <div class="faq-check">
                    <p class="font-16-15em">
                        <span class="icon material-symbols-outlined">error</span>
                        <span>Delete confirmation</span>
                    </p>
                    <p v-if="selectList.length > 1" class="font-16-15em">確定要刪除多筆常見問題嗎？</p>
                    <p v-else class="font-16-15em">確定要刪除嗎？</p>
                    <Button class="btn-danger_2nd"
                        long :loading="alert_Loading"
                        @click.self="show_delCheck = false">取消
                    </Button>
                    <Button v-if="selectList.length > 0"
                        class="btn-danger"
                        long :loading="alert_Loading"
                        @click="massDelete">刪除
                    </Button>
                    <Button v-else
                        class="btn-danger"
                        long :loading="alert_Loading"
                        @click="delFaqData(index)">刪除
                    </Button>
                </div>
            </div>
        </div>
<!-- 彈窗：修改狀態確認 -->
        <div class="alert-mask"
            v-show="show_statusCheck"
            @click.self="show_statusCheck = false"
        >
            <div class="alert-container statusCheck">
                <div class="faq-check">
                    <p class="font-16-15em">
                        <span class="icon material-symbols-outlined">error</span>
                        <span>Change confirmation</span>
                    </p>
                    <p class="font-16-15em">確定要變更多筆常見問題的狀態？</p>
                    <Button class="btn-blue_2nd"
                        long :loading="alert_Loading"
                        @click="show_statusCheck = false">取消
                    </Button>
                    <Button class="btn-blue"
                        long :loading="alert_Loading"
                        @click="massChangeStatus">確認
                    </Button>
                </div>
            </div>
        </div>
<!-- 彈窗：取消確認 -->
        <div class="alert-mask"
            v-show="show_cancelCheck"
            @click.self="show_cancelCheck = false"
        >
            <div class="alert-container cancelCheck">
                <div class="faq-check">
                    <p class="font-16-15em">
                        <span class="icon material-symbols-outlined">error</span>
                        <span>Cancel confirmation</span>
                    </p>
                    <p class="font-16-15em">取消後，內容將不會儲存，請問是否取消？</p>
                    <Button class="btn-blue_2nd"
                        long :loading="alert_Loading"
                        @click.self="show_cancelCheck = false">繼續編輯
                    </Button>
                    <Button class="btn-blue"
                        long :loading="alert_Loading"
                        @click="cancel">確定取消
                    </Button>
                </div>
            </div>
        </div>
<!-- 分頁頁碼 -->
        <!-- <Page :total=this.activeList.length size="small" show-elevator show-sizer/> -->
	</div>
</template>
<script>
import {BASE_URL} from "@/assets/js/common.js"
import faq from '@/assets/js/faq.js'

export default {
    components: {

    },
    data(){
        return {
            // loading: true,
            keyword:'', // 搜尋的關鍵字
// ----- 表格：選取 ------
            status: '',     // 要批量修改的狀態(0/1)
            deleteNo: '',   // 要刪除的資料編號(單筆)
            rowCount: [],   // 選中的列(次序)
            selectList: [], // 選中的列(編號)
// ----- 分頁 tab ------
            activeCategory: '', // 點到的分類
            activeList: [],     // 與分類相符的資料
            categoryList:[
                // { faq_type: '會員問題' },
                // { faq_type: '行程問題' },
                // { faq_type: '商品問題' },
            ],
// ----- 分頁 page ------
            dataCount:'',
// ----- 表格欄位 ------
            editIndex: -1,
            columns: [
                {
                    type: 'selection',
                    name: 'fruit',
                    width: 60,
                    align: 'center'
                },
                {
                    title: '編號',
                    slot: 'faq_no',
                    width: 80,
                    align: 'center',
                },
                {
                    title: '分類',
                    slot: 'faq_type',
                    width: 120,
                    align: 'center',
                },
                {
                    title: '問題',
                    slot: 'faq_q',
                },
                {
                    title: '回答',
                    slot: 'faq_a',
                },
                {
                    title: '狀態',
                    slot: 'faq_state',
                    width: 100,
                    align: 'center'
                },
                {
                    title: '編輯',
                    slot: 'edit',
                    width: 70,
                    align: 'center'
                },
                {
                    title: '刪除',
                    slot: 'delete',
                    width: 70,
                    align: 'center'
                }
            ],
// ----- 存資料 ------
            faqList: [],
// ----- 表單：新增資料 ------
            newFaq_type: '',
            newFaq_q: '',
            newFaq_a: '',
            newFaq_status: 1,
// ----- 表單：修改資料 ------
            editingNo: '',  // 在修改的資料編號
            editingFaq: [], // 要回傳的陣列
// ----- 表單：下拉選單 ------
            dropDownList: [
                // { faq_type: '會員問題' },
                // { faq_type: '行程問題' },
                // { faq_type: '商品問題' },
            ],
// ----- 彈窗 ------
            show_statusCheck: false,
            show_cancelCheck: false,
            show_delCheck:    false,
            show_NewForm:     false,
            show_EditForm:    false,
            alert_Loading:    false,
        }
    },
    computed: {
    },
    methods: {
        faqSearch(){
                this.activeList = this.faqList.filter(item =>
                    item.faq_q.includes(this.keyword) || 
                    item.faq_a.includes(this.keyword)
                );
            },
            renderHtml(text){
                return text.replace(new RegExp(this.keyword, 'gi'), `<mark class="keyword">${this.keyword}</mark>`);
            },
            clearInput(){
                this.activeList = this.faqList;
                this.keyword = '';
            },
// ----- 分頁切換 ------
        clickAll(e){
            this.activeList = this.faqList;
            e.target.classList.add('on');
            e.target.parentNode.childNodes[2].classList.remove('on');
            e.target.parentNode.childNodes[3].classList.remove('on');
            e.target.parentNode.childNodes[4].classList.remove('on');
        },
        changeTab(tab){
            this.activeCategory = tab;
            this.activeList = this.faqList.filter(item => {
                return item.faq_type === tab.faq_type;
            });
            let tabAll = document.getElementById("tabAll");
            tabAll.classList.remove('on');
        },
// ----- 單選/多選事件 ------
        onSelect(index){
            this.selectList=[];
            for(let i=0; i<index.length; i++){
                if( this.selectList.includes(index[i].faq_no) == 0 )
                this.selectList.push(index[i].faq_no);
            }
            console.log(this.selectList);
        },
        onSelectCancel(index){
            if(index.length < 2){
                this.show_statusCheck = false;
            }
            this.selectList=[];
            for(let i=0; i<index.length; i++){
                if( this.selectList.includes(index[i].faq_no) == 0 )
                    this.selectList.push(index[i].faq_no);
            }
        },
// ----- 全選事件 ------
        onSelectAll(index){
            for(let i=0; i<index.length; i++){
                this.selectList.push(index[i].faq_no);
            }

            // if( this.selectAll == true){  // 全選   
            //     console.log('全選   ',this.selectList);
            //     this.selectList=[];
            //     this.selectAll = false;
            // }
            // if(this.selectAll == false && this.selectAll.length == 0){  // 一個都沒選
            //         console.log('一個都沒選',this.selectList);
            //         for(let i=0; i<index.length; i++){
            //             this.selectList.push(index[i].faq_no);
            //         }
            //         this.selectAll = true; 
            // }
            // if(this.selectAll == false && this.selectAll.length >= 0){  // 選了一部分
            //     console.log('選了一部分',this.selectList)
            //     for(let i=0; i<index.length; i++){
            //         if( this.selectList.includes(index[i].faq_no) == 0 )
            //             this.selectList.push(index[i].faq_no);
            //     }
            //     this.selectAll = true;
            // }
        },
// ----- 表單：編輯 ------
        editForm(edit){
            this.editingNo = edit;
            this.show_EditForm = true;
            this.editingFaq = this.activeList.find(v=> v.faq_no === this.editingNo) ?? [];
        },
// ----- 關閉彈窗(取消) ------
        cancel(){
            this.alert_Loading = true;
            setTimeout(() => {
                this.show_statusCheck = false;
                this.show_cancelCheck = false;
                this.show_NewForm = false;
                this.show_EditForm = false;
                this.alert_Loading = false;
                this.newFaq_type = '';
                this.newFaq_q = '';
                this.newFaq_a = '';
                document.getElementById("newFaq_type").classList.remove('error');
                document.getElementById("newFaq_q").classList.remove('error');
                document.getElementById("newFaq_a").classList.remove('error');
            }, 200);
        },
// ----- 撈資料 ------ XML
        // getFaqData_XML(){
        //     let faqVue = this;
		// 	let xhr = new XMLHttpRequest();
		// 	xhr.onload = ()=>{
        //         if(xhr.status == 200){
        //             faqVue.faqList = JSON.parse(xhr.responseText);
        //             faqVue.activeList = faqVue.faqList;
		// 		}
		// 	}
		// 	xhr.open("get", "http://localhost/CGD103_G4_back/public/php/Faq_getData_02.php", true);
		// 	xhr.send(null);
		// },
// ----- 新增資料 ------ XML
        // addFaqData(){
        //     let xhr = new XMLHttpRequest();
        //     xhr.onload = function(){
        //         let result = JSON.parse(xhr.responseText);
        //         alert(result.msg);
        //     }
        //     xhr.open("post", "http://localhost/CGD103_G4_back/public/php/Faq_insert.php", true);
        //     xhr.send(new FormData(document.getElementById("newForm")));
        //     this.show_NewForm = false;
        // },
// ----- 撈資料 ------ fetch
        getFaqData_Fetch(){
            // fetch('http://localhost/CGD103_G4_back/public/phpfiles/Faq_getData.php')
            fetch(`${BASE_URL}/Faq_getData.php`)
            .then(res=>res.json())
            .then(json=>{
                this.faqList = json;
                this.activeList = this.faqList;
                this.categoryList = [...new Set(this.faqList.map(item => item.faq_type))].map(faqType => ({ faq_type: faqType }));
                this.dropDownList = [...new Set(this.faqList.map(item => item.faq_type))].map(faqType => ({ faq_type: faqType }));
            })
		},
// ----- 新增資料 ------ fetch
        addFaqData(){
            let newFaq_type = document.getElementById("newFaq_type");
            let newFaq_q = document.getElementById("newFaq_q");
            let newFaq_a = document.getElementById("newFaq_a");
            
            if(this.newFaq_type == '' || this.newFaq_type == undefined || this.newFaq_type == null){
                this.$Message.warning('請選擇類別');
                newFaq_type.classList.add('error');
                return;
            }else if(this.newFaq_q == '' || this.newFaq_q == undefined || this.newFaq_q == null){
                this.$Message.warning('請填寫問題');
                newFaq_q.classList.add('error');
                return;
            }
            else if(this.newFaq_a == '' || this.newFaq_a == undefined || this.newFaq_a == null){
                this.$Message.warning('請填寫回答');
                newFaq_a.classList.add('error');
                return;
            }

            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_getData.php",{
            fetch(`${BASE_URL}/Faq_insert.php`,{
                method:'POST', body:new URLSearchParams({
                faq_type:this.newFaq_type,
                faq_q:this.newFaq_q,
                faq_a:this.newFaq_a,
                faq_status:this.newFaq_status,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                if(result.msg == "已成功新增一筆常見問題"){
                    setTimeout(() => {
                        this.$Notice.success({
                            title: "新增成功",
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
// ----- 測試修改資料 ------ XML(不能用)
        // editFaqData(){
        //     console.log(this.editingFaq);
        //     let xhr = new XMLHttpRequest();
        //     xhr.onload = function(){
        //         let result = JSON.parse(xhr.responseText);
        //         console.log(result);
        //         alert(result.msg);
        //     }
        //     xhr.open("post", "http://localhost/CGD103_G4_back/public/php/Faq_update.php", true);
        //     xhr.send(new FormData(document.getElementById("editForm")));
        // },
// ----- 單筆修改資料 ------ fetch
        editFaqData(){
            let editFaq_q = document.getElementById("editFaq_q");
            let editFaq_a = document.getElementById("editFaq_a");
            
            if(this.editingFaq.faq_q == '' || this.editingFaq.faq_q == undefined || this.editingFaq.faq_q == null){
                this.$Message.warning('請填寫問題');
                editFaq_q.classList.add('error');
                return;
            }
            else if(this.editingFaq.faq_a == '' || this.editingFaq.faq_a == undefined || this.editingFaq.faq_a == null){
                this.$Message.warning('請填寫回答');
                editFaq_a.classList.add('error');
                return;
            }
            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_update.php",{
            fetch(`${BASE_URL}/Faq_update.php`,{
                method:'POST', body:new URLSearchParams({
                faq_no:this.editingFaq.faq_no,
                faq_type:this.editingFaq.faq_type,
                faq_q:this.editingFaq.faq_q,
                faq_a:this.editingFaq.faq_a,
                faq_status:this.editingFaq.faq_status,
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
// ----- 單筆狀態切換 ------
        changeStatus(row){
            console.log(row.faq_status);
            row.faq_status
            ? this.$Message.info('狀態：已成功將該筆問題狀態變更為「顯示」')
            : this.$Message.info('狀態：已成功將該筆問題狀態變更為「隱藏」');

            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_changeState.php",{
            fetch(`${BASE_URL}/Faq_changeState.php`,{
                method:'POST', body:new URLSearchParams({
                faq_no:row.faq_no,
                faq_status:row.faq_status,
            })})
            .then((res) => res.json())
        },
// ----- 彈窗：多筆狀態切換 ------
        massChangeState_1(){
            this.status = 1;
            this.show_statusCheck = true;
        },
        massChangeState_0(){
            this.status = 0;
            this.show_statusCheck = true;
        },
// ----- 多筆狀態切換 ------
        massChangeStatus(){
            console.log(this.selectList,);
            let faqVue = this;
            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_massChangeState.php",{
            fetch(`${BASE_URL}/Faq_massChangeState.php`,{
                method:'POST', body:new URLSearchParams({
                items: this.selectList,
                status: this.status,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                // alert(result.msg)

                setTimeout(() => {
                    let arr = this.activeList;
                    this.selectList.forEach(function(no){
                        const onPick = arr.filter(function(item){
                            return item.faq_no === no;
                        });
                        onPick.forEach(function(item){
                            item.faq_status = faqVue.status;
                        });
                    });
                    this.alert_Loading = false;
                    this.show_statusCheck = false;
                    this.$Message.success(result.msg);
                    this.selectList=[];
                }, 600);
            })
        },
// ----- 彈窗：刪除確認 ------
        delCheck(row, index){
            this.deleteNo = row.faq_no,
            this.rowCount = index,
            this.show_delCheck = true;
        },
// ----- 單筆刪除資料 ------ fetch
        delFaqData(){
            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_delete.php",{
            fetch(`${BASE_URL}/Faq_delete.php`,{
                method:'POST', body:new URLSearchParams({
                faq_no:this.deleteNo,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;
                setTimeout(() => {
                    this.activeList.splice(this.rowCount, 1);
                    this.alert_Loading = false;
                    this.show_delCheck = false;
                    this.$Message.success(result.msg);
                }, 600);
            })
        },
// ----- 刪除多筆資料 ------ fetch
        massDelete(){
            // fetch("http://localhost/CGD103_G4_back/public/phpfiles/Faq_massDelete.php",{
            fetch(`${BASE_URL}/Faq_massDelete.php`,{
                method:'POST', body:new URLSearchParams({
                items: this.selectList,
            })})
            .then((res) => res.json())
            .then((result)=> {
                this.alert_Loading = true;

                setTimeout(() => {
                    this.alert_Loading = false;
                    this.show_delCheck = false;
                    this.$Message.success(result.msg);
                }, 600);
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
        }
    },
    created(){
		this.getFaqData_Fetch();
	},
	mounted(){
        // this.getFaqData_XML();
    },
}

</script>

<style scoped lang="scss">
@import "../assets/Scss/pages/faq.scss";
@import "../assets/Scss/components/scrollBar.scss";
:deep(mark){
    // background: $clr_gold_L2;
    background: yellow;
}
</style>