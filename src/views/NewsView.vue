<template>
    <div class="backstage-news" >
        <div class="backstage-content">
            <div class="btn-add">
                <button class="font-20 btn-blue" @click="newToggle">新增消息</button>
            </div>
            <div class="news-manager">
                <Tabs  type="card" :animated="false">
                    <TabPane class="scrollBar"  label="上架" >
                        <Table  stripe border :columns="columns" :data="dataOn" >
                            <!-- 公告編號 -->
                            <template #news_no="{ row, index }">
                                <Input type="text" v-if="editIndex === index" />
                                <span v-else>{{ row.news_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else :class="{ isNotOnStatus : row.news_time === '9999-12-31'}">{{ row.news_time }}</span> 
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_last_edit="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_last_edit }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_type="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ (row.news_type) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }" >
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else >{{ row.news_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text" v-if="editIndex === index" />
                                <span v-else>{{ row.news_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row }">
                                <div class="btn-box">
                                    <span class="icon material-symbols-outlined"  @click="editOnData(row.news_no)" style="cursor: pointer;">edit_square</span>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                    <TabPane class="scrollBar" label="草稿" >
                        <Table  stripe border :columns="columns" :data="dataDraft" >
                            <!-- 公告編號 -->
                            <template #news_no="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else :class="{ isNotOnStatus : row.news_time === '9999-12-31'}">{{ row.news_time }}</span>
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_last_edit="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_last_edit }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_type="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ (row.news_type) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row  }">
                                <div class="btn-box">
                                    <Space>
                                        <span class="icon material-symbols-outlined"   @click="editDraftData(row.news_no)" style="cursor: pointer;">edit_square</span>
                                        <span class="icon material-symbols-outlined"  @click="delNewsData(row.news_no)" style="cursor: pointer;">delete</span>
                                    </Space>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                    <TabPane class="scrollBar" label="下架" >
                        <Table stripe border :columns="columns" :data="dataOff" >
                            <!-- 公告編號 -->
                            <template #news_no="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_no }}</span>
                            </template>
                            <!-- 上架日期 -->
                            <template #news_time="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else :class="{ isNotOnStatus : row.news_time === '9999-12-31'}">{{ row.news_time }}</span>
                            </template>
                            <!-- 最後編輯 -->
                            <template #news_last_edit="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_last_edit }}</span>
                            </template>
                            <!-- 分類 -->
                            <template #news_type="{ row, index }">
                                <Input type="text" v-if="editIndex === index" />
                                <span v-else>{{ (row.news_type) }}</span>
                            </template>
                            <!-- 標題 -->
                            <template #news_title="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_title }}</span>
                            </template>
                            <!-- 狀態 -->
                            <template #news_status="{ row, index }">
                                <Input type="text"  v-if="editIndex === index" />
                                <span v-else>{{ row.news_status }}</span>
                            </template>
                            <!-- 按鈕 -->
                            <template #action="{ row }">
                                <div class="btn-box">
                                    <span class="material-symbols-outlined"  @click="checkOffData(row.news_no)" style="cursor: pointer;">search</span>
                                </div>
                            </template>
                        </Table>
                    </TabPane>
                </Tabs>
            </div>
        </div>
    </div>

    <!--全新表單 -->
    <keep-alive>
        <Form method="post" id="addNewsForm" enctype="multipart/form-data" ref="formValidate" :model="formValidate" :rules="ruleValidate">
            <div class="popup " v-show="seenNew" >
                <div class="popup-head font-20">
                    <div class="news-no">
                        <span>公告編號</span>
                        <span name=""></span>
                    </div>
                    <!-- <div class="on-date">
                        <span class="date">發布時間</span>
                        <span class="date"></span>
                        <input type="hidden" name="news_time" >
                    </div> -->
                    <div class="last-edit-date">
                        <span class="date">最後更新</span>
                        <span class="date"></span>
                    </div>
                </div>
                <div class="popup-content font-18">
                    <div class="popup-data">
                        <label for="">狀態
                            <select name="news_status" v-model="selectedOnStatus" @click="requiredCheck">
                                <option value="草稿" selected>草稿</option>
                                <option value="上架" >上架</option>
                            </select>
                            <span class="type_on" v-show="selectedOnStatus === '上架'"> *必填</span>
                        </label>
                        <label for="">分類
                            <select name="news_type" id="">
                                <option value="重要">重要</option>
                                <option value="活動">活動</option>
                                <option value="其他">其他</option>
                            </select>
                            <span class="type_on" v-show="selectedOnStatus === '上架'"> *請確認</span>
                        </label>
                    </div>
                    <div class="input-txt">
                        <div class="input-title">
                            <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                            <label for="">標題：
                                <FormItem prop="NewTitle">
                                    <Input v-model="formValidate.NewTitle" name="news_title" placeholder="請輸入標題" clearable style="width: 650px"/>
                                </FormItem>
                            </label>
                        </div>
                        <div class="input-des">
                            <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                            <label for="">引文：
                                <FormItem prop="NewStart">
                                    <Input v-model="formValidate.NewStart" name="news_text_start" clearable type="textarea" :rows="2" placeholder="前台標題敘述" style="width: 650px"/>
                                </FormItem>
                            </label>
                        </div>
                        <div class="input-des">
                            <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                            <label for="">內文：
                                <FormItem prop="NewMiddle">
                                    <Input v-model="formValidate.NewMiddle" name="news_text_middle" clearable type="textarea" :rows="4" placeholder="詳細內文(承)" style="width: 650px"/>
                                </FormItem>
                            </label>
                        </div>
                        <div class="input-des">
                            <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                            <label for="">內文：
                                <FormItem prop="NewTrans">
                                    <Input v-model="formValidate.NewTrans" name="news_text_trans" clearable type="textarea" :rows="4" placeholder="詳細內文(轉)" style="width: 650px"/>
                                </FormItem>
                            </label>
                        </div>
                        <div class="input-des">
                            <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                            <label for="">結尾：
                                <FormItem prop="NewEnd">
                                    <Input v-model="formValidate.NewEnd" name="news_text_end" clearable type="textarea" :rows="2" placeholder="請輸入內容" style="width: 650px"/>
                                </FormItem>
                            </label>
                        </div>
                    </div>
                    <div class="input-pic">
                        <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                        <label class="test" for="">插入圖片(必填)：
                            <FormItem prop="NewImg">
                                <input type="file" name="news_img">
                            </FormItem>
                        </label>
                        <!-- <img src="" alt="" id="showImg" style="width:80px;height:80px">  -->
                        <!-- 圖片預覽 -->
                    </div>
                    <div class="input-pic-des">
                        <span class="type_on" v-show="selectedOnStatus === '上架'">*</span>
                        <label for="">圖片敘述：
                            <FormItem prop="NewImgDes">
                                <Input v-model="formValidate.NewImgDes" name="news_img_des" placeholder="請輸入圖片敘述" clearable style="width: 650px" />
                            </FormItem>
                        </label>
                    </div>
                    <div class="popup-btn">
                        <button type="button" class="btn-blue_2nd" @click="newToggle">取消</button>
                        <button type="button" class="btn-blue" @click="addNewsData">確認</button>
                    </div>
                </div>
            </div>
        </Form>
    </keep-alive>

    <!--表單-編輯  -->
    <Form ref="formValidate" :model="activeData" :rules="ruleValidate">
        <div class="popup on" v-show="seeOnData">
            <div class="popup-head font-20">
                <div class="news-no">
                    <span>公告編號</span>
                    <span >{{activeData.news_no}}</span>
                </div>
                <!-- <div class="on-date">
                    <span class="date">發布時間</span>
                    <span class="date">{{activeData.news_time}}</span>
                </div> -->
                <div class="last-edit-date">
                    <span class="date">最後更新</span>
                    <span class="date">{{activeData.news_last_edit}}</span>
                </div>
            </div>
            <div class="popup-content font-18">
                <div class="popup-data">
                    <label for="">狀態
                        <select class="draftStatus" v-model="editingNews.news_status">
                            <option value="上架" >上架</option>
                            <option value="下架" >下架</option>
                        </select>
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> * 必填</span>
                    </label>
                    <label >分類
                        <select v-model="editingNews.news_type">
                            <option value="重要">重要</option>
                            <option value="活動">活動</option>
                            <option value="其他">其他</option>
                        </select>
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *請確認</span>
                    </label>
                </div>
                <div class="input-txt">
                    <div class="input-title">
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                        <label for="">標題：
                            <FormItem prop="news_title">
                                <Input v-model="activeData.news_title" clearable style="width: 650px" />
                            </FormItem>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                        <label for="">引文：
                            <FormItem prop="news_text_start">
                                <Input v-model="activeData.news_text_start" clearable type="textarea" :rows="2" placeholder="前台標題敘述" style="width: 650px"/>
                            </FormItem>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                        <label for="">內文：
                            <FormItem prop="news_text_middle">
                                <Input v-model="activeData.news_text_middle" clearable type="textarea" :rows="4" placeholder="詳細內文(承)" style="width: 650px"/>
                            </FormItem>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                        <label for="">內文：
                            <FormItem prop="news_text_trans">
                                <Input v-model="activeData.news_text_trans" clearable type="textarea" :rows="4" placeholder="詳細內文(轉)" style="width: 650px"/>
                            </FormItem>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                        <label for="">結尾：
                            <FormItem prop="news_text_end">
                                <Input v-model="activeData.news_text_end" clearable type="textarea" :rows="2" placeholder="請輸入內容" style="width: 650px"/>
                            </FormItem>
                        </label>
                    </div>
                </div>
                <div class="input-pic">
                    <!-- <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span> -->
                    <!-- <label class="test" for=""> -->
                        <!-- 插入圖片： -->
                        <!-- <input type="file"> -->
                        <span style="color:#fff;"> 使用圖片 : {{editingNews.news_img}}</span> <!-- 此筆資圖片名稱 -->
                    <!-- </label> -->
                </div>
                <div class="input-pic-des">
                    <span class="type_on" :class="{ type_on : editingNews.news_status==='上架'}"> *</span>
                    <label for="">圖片敘述：
                        <FormItem prop="news_img_des">
                            <Input v-model="activeData.news_img_des" placeholder="請輸入圖片敘述" clearable style="width: 650px" />
                        </FormItem>
                    </label>
                </div>
                <div class="popup-btn">
                    <button class="btn-blue_2nd" @click="editOnData">取消</button>
                    <button class="btn-blue" @click="editNewsData()">確認</button>
                </div>
            </div>
        </div>
    </Form>

    <!--表單-下架 -->
    <keep-alive>
        <div class="popup used" v-show="seeDraftData">
            <div class="popup-head font-20">
                <div class="news-no">
                    <span>公告編號</span>
                    <span>{{activeDraftData.news_no}}</span>
                </div>
                <!-- <div class="on-date">
                    <span class="date">發布時間</span>
                    <span class="date" >{{activeDraftData.news_time}}</span>
                </div> -->
                <div class="last-edit-date">
                    <span class="date">最後更新</span>
                    <span class="date" >{{activeDraftData.news_last_edit}}</span>
                </div>
            </div>
            <div class="popup-content font-18">
                <div class="popup-data">
                    <label for="">狀態
                        <select name="" id="" v-model="editingNews.news_status" @change="changeStatus">
                            <option value="草稿">草稿</option>
                            <option value="上架">上架</option>
                        </select>
                    </label>
                    <label for="">分類
                        <select name="" id="" v-model="editingNews.news_type">
                            <option value="重要">重要</option>
                            <option value="活動">活動</option>
                            <option value="其他">其他</option>
                        </select>
                        <span class="type_on" v-show="editingNews.news_status === '上架'"> *請確認</span>
                    </label>
                </div>
                <div class="input-txt">
                    <div class="input-title">
                        <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                        <label for="">標題：
                            <Input v-model="activeDraftData.news_title" placeholder="請輸入標題" clearable style="width: 650px" />
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                        <label for="">引文：
                            <Input v-model="activeDraftData.news_text_start" clearable type="textarea" :rows="2" placeholder="前台標題敘述" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                        <label for="">內文：
                            <Input v-model="activeDraftData.news_text_middle" clearable type="textarea" :rows="4" placeholder="詳細內文(承)" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                        <label for="">內文：
                            <Input v-model="activeDraftData.news_text_trans" clearable type="textarea" :rows="4" placeholder="詳細內文(轉)" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                        <label for="">結尾：
                            <Input v-model="activeDraftData.news_text_end" clearable type="textarea" :rows="2" placeholder="請輸入內容" style="width: 650px"/>
                        </label>
                    </div>
                </div>
                <div class="input-pic">
                    <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                    <!-- <label class="test" for=""> -->
                        <!-- 插入圖片： -->
                        <!-- <input type="file"> -->
                        <span style="color:#fff;"> 使用圖片 : {{activeDraftData.news_img}}</span> <!-- 此筆資圖片名稱 -->
                    <!-- </label> -->
                </div>
                <div class="input-pic-des">
                    <span class="type_on" v-show="editingNews.news_status === '上架'">*</span>
                    <label for="">圖片敘述：
                        <Input v-model="activeDraftData.news_img_des"  placeholder="請輸入圖片敘述" clearable style="width: 650px" />
                    </label>
                </div>
                <div class="popup-btn">
                    <button class="btn-blue_2nd" @click="editDraftData">取消</button>
                    <button class="btn-blue" @click="editNewsData">確認</button>
                </div>
            </div>
        </div>
    </keep-alive>

    <!--串聯資料用表單(下架)查看(不可更改內容)，所以無取消鍵，確認僅為回到畫面 -->
    <div class="popup off" v-show="seeOffData">
            <div class="popup-head font-20">
                <div class="news-no">
                    <span>公告編號</span>
                    <span >{{activeOffData.news_no}}</span>
                </div>
                <!-- <div class="on-date">
                    <span class="date">發布時間</span>
                    <span class="date">{{activeOffData.news_time}}</span>
                </div> -->
                <div class="last-edit-date">
                    <span class="date">修改日期</span><!-- 最後更新 -->
                    <span class="date">{{activeOffData.news_last_edit}}</span>
                </div>
            </div>
            <div class="popup-content font-18">
                <div class="popup-data">
                    <label for="">狀態
                        <select disabled name="" id="">
                            <option value="off">下架</option>
                        </select>
                    </label>
                    <label for="">分類
                        <select name="" id="" disabled>
                            <option value="important">重要</option>
                            <option value="action">活動</option>
                            <option value="other" >其他</option>
                        </select>
                    </label>
                </div>
                <div class="input-txt">
                    <div class="input-title">
                        <label for="">標題：
                            <Input disabled v-model="activeOffData.news_title" clearable style="width: 650px" />
                        </label>
                    </div>
                    <div class="input-des">
                        <label for="">引文：
                            <Input disabled v-model="activeOffData.news_text_start" clearable type="textarea" :rows="2" placeholder="前台標題敘述" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <label for="">內文：
                            <Input disabled v-model="activeOffData.news_text_middle" clearable type="textarea" :rows="4" placeholder="詳細內文(承)" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <label for="">內文：
                            <Input disabled v-model="activeOffData.news_text_trans" clearable type="textarea" :rows="4" placeholder="詳細內文(轉)" style="width: 650px"/>
                        </label>
                    </div>
                    <div class="input-des">
                        <label for="">結尾：
                            <Input disabled v-model="activeOffData.news_text_end" clearable type="textarea" :rows="2" placeholder="請輸入內容" style="width: 650px"/>
                        </label>
                    </div>
                </div>
                <div class="input-pic">
                    <!-- <label class="test" for=""> -->
                        <!-- 插入圖片： -->
                        <!-- <input disabled type="file"> -->
                        <span style="color:#fff;"> 使用圖片 : {{activeDraftData.news_img}}</span> <!-- 此筆資圖片名稱 -->
                    <!-- </label> -->
                </div>
                <div class="input-pic-des">
                    <label for="">圖片敘述：
                        <Input disabled v-model="activeOffData.news_img_des" placeholder="請輸入圖片敘述" clearable style="width: 620px; " />
                    </label>
                </div>
                <div class="popup-btn">
                    <button @click="checkOffData" class="btn-blue">確認</button>
                </div>
            </div>
    </div>

    <!-- 新增成功 -->
    <!-- style="display:none" -->
    <div class="popup-box add font-18" v-show="seeCheck">
        <p class="popup-box-close">X</p>
        <p class="check-des">新增資料成功</p>
        <button @click="okToggle" class="btn-success">確認</button>
    </div>


    <!-- 修改成功 -->
    <div class="popup-box fix font-18" v-show="seeCheck" >
        <p class="popup-box-close">X</p>
        <p class="check-des">修改資料成功</p>
        <button @click="okToggle" class="btn-success">確認</button>
    </div>

</template>

<script>
    import {BASE_URL} from '@/assets/js/common.js'

    export default {
        data () {
            return {
                seenNew:false, //新表格彈窗，綁新表單v-show、按鈕@click="newToggle"
                seeOnData:false, //上架資料彈窗，綁上架資料v-show、編輯按鈕@click="editOnData"
                seeDraftData:false, //草稿資料彈窗，綁草稿資料v-show、編輯按鈕@click="editDraftData"
                seeOffData:false, //下架資料彈窗，綁下架資料v-show、編輯按鈕@click="checkOffData"
                seeCheck:false, //確認彈窗、v-show="seeCheck" 按鈕@click="okToggle"
                selectedOnStatus:'草稿',// 如果表單選擇上架，顯示 *
                // 表單驗證 
                formValidate: {
                    // -新增表單
                    NewTitle: '',
                    NewStart: '',
                    NewMiddle: '',
                    NewTrans: '',
                    NewEnd: '',
                    NewImg: '',
                    NewImgDes: '',
                    // 編輯表單
                    news_title:'',
                    news_text_start:'',
                    news_text_middle:'',
                    news_text_trans:'',
                    news_text_end:'',
                    news_img:'',
                    news_img_des:''
                },
                ruleValidate: {
                    // -新增表單
                    NewTitle: [
                        { required: false, message: '請輸入標題', trigger: 'blur' }], 
                    NewStart: [
                        { required: false, message: '請輸入引文', trigger: 'blur' }], 
                    NewMiddle: [
                        { required: false, message: '請輸入內文', trigger: 'blur' }],  
                    NewTrans: [
                        { required: false, message: '請輸入內文', trigger: 'blur' }],   
                    NewEnd: [
                        { required: false, message: '請輸入結尾', trigger: 'blur' }], 
                    NewImg: [
                        { required: false, message: '請插入圖片', trigger: 'blur' }],
                    NewImgDes: [
                        { required: false, message: '請輸入圖片敘述', trigger: 'blur' }],                  
                    // -編輯表單 -上架 (可以放一起)  
                    news_title: [
                        { required: true, message: '請輸入標題', trigger: 'blur' }], 
                    news_text_start: [
                        { required: true, message: '請輸入引文', trigger: 'blur' }],
                    news_text_middle: [
                        { required: true, message: '請輸入內文', trigger: 'blur' }], 
                    news_text_trans: [
                        { required: true, message: '請輸入內文', trigger: 'blur' }],
                    news_text_end: [
                        { required: true, message: '請輸入結尾', trigger: 'blur' }], 
                    news_img: [
                        { required: true, message: '請插入圖片', trigger: 'blur' }],
                    news_img_des: [
                        { required: true, message: '請輸入圖片敘述', trigger: 'blur' }],  
                },
                
                columns: [
            {
                title: '公告編號',
                slot: 'news_no',
                width: 100,
                align: 'center'
            },
            // {
            //     title: '上架日期',
            //     slot: 'news_time',
            //     width: 110,
            //     align: 'center',
            //     "sortable": true // 排序
            // },
            {
                title: '修改日期',
                slot: 'news_last_edit',
                width: 110,
                align: 'center',
                "sortable": true
            },
            {
                title: '分類',
                slot: 'news_type',
                width: 80,
                align: 'center',
                filters: [
                            {
                                label: '重要',
                                value: '重要'
                            },
                            {
                                label: '活動',
                                value: '活動'
                            },
                            {
                                label: '其他',
                                value: '其他'
                            }
                        ],
                        filterMultiple: false, //https://www.iviewui.com/view-ui-plus/component/form/table#Brief_Introduction
                        filterMethod (value,row) { 
                            if (value === '重要') {
                                return row.news_type==='重要';
                            } else if (value === '活動') {
                                return row.news_type==='活動' ;
                            }else if (value === '其他') {
                                return row.news_type==='其他' ;
                            }
                        }
            },
            {
                title: '標題',
                slot: 'news_title',
                align: 'center'
            },
            {
                title: '狀態',
                slot: 'news_status',
                width: 70,
                align: 'center'
            },
            {
                title: '編輯 | 刪除 | 查看',
                slot: 'action',
                width: 180,
                align: 'center'
            }
                ],
                news:[],
                dataOn: [],
                dataDraft: [],
                dataOff: [],
                editIndex: -1,  // 当前聚焦的输入框的行数
                activeIndex:null,
                editingNews:[]
                }
            },
        methods: {  
            // 表單測試
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            },
            // 測試本地資料庫 fetch
            getNews(){
                // fetch('http://localhost/cgd103-g4-backend/public/phpfiles/getNews.php') //本地端
                fetch(`${BASE_URL}/getNews.php`) //線上版
                .then(res=>res.json())
                .then(json=>{
                    // 抓回所有資料
                    this.news = json;
                    // 篩資料放進"重要"陣列
                    this.dataOn = this.news.filter(item => {
                        return item.news_status === "上架";
                    });
                    // 篩資料放進"活動"陣列
                    this.dataDraft = this.news.filter(item => {
                        return item.news_status === "草稿";
                    });
                    // 篩資料放進"其他"陣列
                    this.dataOff = this.news.filter(item => {
                        return item.news_status === "下架";
                    });
                })
            },
            // getNews(){   //取得商品資料 XML方法
            //     let xhr = new XMLHttpRequest();
            //     let data = this;
            //     xhr.onload = function(){
            // 	    if(xhr.status == 200){ //OK
            // 		    data.dataOn = JSON.parse(xhr.responseText);
            // 	    }
            //     }
            //     xhr.open("get",'http://localhost/getNews.php', true);
            //     xhr.send(null);
            // },
        // 新增資料 xhr
            addNewsData(){
                let xhr = new XMLHttpRequest();
                xhr.onload = function(){
                let result = JSON.parse(xhr.responseText);
                alert(result.msg);
                }
                // xhr.open("post", "http://localhost/cgd103-g4-backend/public/phpfiles/news_insert.php", true); //專案裡的檔案 
                xhr.open("post", `${BASE_URL}/news_insert.php`, true); //線上版 

                xhr.send(new FormData(document.getElementById("addNewsForm")));

                // 確認彈窗
                this.$Notice.success({
                    title: '資料狀態',
                    desc: 'The desc will hide when you set render.',
                    render: h => {
                        return h('span', ['新增資料成功 '])
                    }
                });
                
                // 關閉表單
                this.seenNew = !this.seenNew

                // 重新整理頁面
                setTimeout(() => {
                    window.location.reload();
                },500);
            },
            // 編輯資料 fetch
            editNewsData(){
                // 抓取現在的時間
                var now = new Date();
                var year = now.getFullYear();
                var month = now.getMonth()+1;
                var date = now.getDate();
                var news_last_edit= year + '' + month + date;

                // 如果狀態改為上架，需要加入上架時間 
                var news_time = ''; 
                if(this.editingNews.news_status == "草稿"){ //如果是草稿，日期抓9999-12-31，畫面再把這日期隱藏起來
                    news_time = '9999-12-31';
                }else if(this.news_status == "下架"){ //如果是下架，日期抓原本的上架時間 
                    news_time = this.news_time;
                }else{
                    news_time = news_last_edit; //如果是上架，時間抓當日
                };
                console.log(this.editingNews.news_status);

                //上架時的資料驗證 //目前失敗
                if(this.editingNews.news_status == "上架"){
                    if(this.editingNews.news_status == ""){
                        alert("標題沒寫!");
                        return;
                    }
                };
                // fetch('http://localhost/cgd103-g4-backend/public/phpfiles/news_update.php',{ //本地端
                fetch(`${BASE_URL}/news_update.php`,{ //線上版
                method:'POST', body:new URLSearchParams({

                news_no:this.editingNews.news_no, // 為了比對
                news_time:news_time, //不給更新 這段可刪
                news_last_edit:news_last_edit, // 抓取現在時間
                news_type:this.editingNews.news_type,
                news_title:this.editingNews.news_title,
                news_text_start:this.editingNews.news_text_start,
                news_text_middle:this.editingNews.news_text_middle,
                news_text_trans:this.editingNews.news_text_trans,
                news_text_end:this.editingNews.news_text_end,
                // news_img:this.editingNews.news_img,  //圖片狀況先不考慮
                news_img_des:this.editingNews.news_img_des,
                news_status:this.editingNews.news_status
                })})
                .then((res) => res.json())
                .then((result)=> { 
                    console.log(result);
                })
                console.log(this.editingNews.news_no);
                
                // 彈提示
                this.$Notice.success({
                    title: '資料狀態',
                    desc: 'The desc will hide when you set render.',
                    render: h => {
                        return h('span', ['編輯資料成功 '])
                    }
                });

                //關閉表單
                if(this.editingNews.news_type ==="上架"){
                    this.seeOnData = !this.seeOnData;
                }else{ //草稿
                    this.seeDraftData = !this.seeDraftData
                }

                // 重新整理頁面 
                setTimeout(() => {
                    window.location.reload();
                },500);

            },
            // 刪除資料
            delNewsData(deleteNo){
                let deleteIndex = deleteNo;
                // console.log(deleteNo);

                // console.log(deleteIndex);
                // fetch('http://localhost/cgd103-g4-backend/public/phpfiles/news_delete.php',{ //本地端
                fetch(`${BASE_URL}/news_delete.php`,{ //線上版
                    method:'POST', body:new URLSearchParams({
                    news_no:deleteIndex,
                    
                })})
                .then((res) => res.json())
                .then((result)=> { 
                    console.log(result);
                })

                // 彈窗
                this.$Notice.success({
                    title: '資料狀態',
                    desc: 'The desc will hide when you set render.',
                    render: h => {
                        return h('span', ['刪除資料成功 '])
                    }
                });

                // 重新整理頁面
                setTimeout(() => {
                    window.location.reload();
                },500);

            },
            newToggle(){ //新表單
                this.seenNew = !this.seenNew
            },
            editOnData(no){ //上架編輯表單彈窗，將資料editingNews傳入確定編輯function
                this.seeOnData = !this.seeOnData;
                
                this.activeIndex = no;
                this.editingNews = this.dataOn.find(v=> v.news_no === this.activeIndex) ?? [];
            },
            editDraftData(no){ //草稿編輯表單彈窗，將資料editingNews傳入確定編輯function
                this.seeDraftData = !this.seeDraftData

                this.activeIndex = no;
                this.editingNews = this.dataDraft.find(v=> v.news_no === this.activeIndex) ?? [];
                // console.log(this.editingNews);

            },
            checkOffData(no){ //下架資料彈窗
                this.seeOffData = !this.seeOffData
                this.activeIndex = no;
            },
            okToggle () { //確認彈窗
                this.seeCheck = !this.seeCheck
            },
            changeStatus(){ //監聽草稿如果變成上架，要顯示提示字樣 //好像失敗喔?
                var selected = document.querySelector('.draftStatus').value;

                if( selected =="上架"){
                    document.querySelector('.type_on').style.display = 'inline-block';
                    }

            },
            showImg(){ //表單預覽圖片 id="showImg"

            },
            // 表單確認上架的時候要驗證
            requiredCheck(){
                if(this.selectedOnStatus==="上架"){
                    // 新增表單
                    this.ruleValidate.NewTitle[0].required = true;
                    this.ruleValidate.NewStart[0].required = true;
                    this.ruleValidate.NewMiddle[0].required = true;
                    this.ruleValidate.NewTrans[0].required = true;
                    this.ruleValidate.NewEnd[0].required = true;
                    this.ruleValidate.NewImg[0].required = true;
                    this.ruleValidate.NewImgDes[0].required = true;
                    // 編輯表單-上架
                    // 編輯表單-草稿
                }else{
                    // 新增表單
                    this.ruleValidate.NewTitle[0].required = false;
                    this.ruleValidate.NewStart[0].required = false;
                    this.ruleValidate.NewMiddle[0].required = false;
                    this.ruleValidate.NewTrans[0].required = false;
                    this.ruleValidate.NewEnd[0].required = false;
                    this.ruleValidate.NewImg[0].required = false;
                    this.ruleValidate.NewImgDes[0].required = false;
                    // 編輯表單-上架
                    // 編輯表單-草稿
                }
            },
            requiredCheckEdit(){
                if(this.editingNews.news_status==="上架" || this.editingNews.news_status==="下架"){
                    // 編輯表單-上架
                    this.ruleValidate.news_title[0].required = true;
                    this.ruleValidate.news_text_start[0].required = true;
                    this.ruleValidate.news_text_middle[0].required = true;
                    this.ruleValidate.news_text_trans[0].required = true;
                    this.ruleValidate.news_text_end[0].required = true;
                    this.ruleValidate.news_img[0].required = true;
                    this.ruleValidate.news_img_des[0].required = true;
                }else{
                    this.ruleValidate.news_title[0].required = false;
                    this.ruleValidate.news_text_start[0].required = false;
                    this.ruleValidate.news_text_middle[0].required = false;
                    this.ruleValidate.news_text_trans[0].required = false;
                    this.ruleValidate.news_text_end[0].required = false;
                    this.ruleValidate.news_img[0].required = false;
                    this.ruleValidate.news_img_des[0].required = false;
                }
            }
        },
        computed:{
            activeData() {
                return this.dataOn.find(v=> v.news_no === this.activeIndex) ?? {}
            },
            activeDraftData(){
                return this.dataDraft.find(v=> v.news_no === this.activeIndex) ?? {}
            },
            activeOffData(){
                return this.dataOff.find(v=> v.news_no === this.activeIndex) ?? {}
            }
        },
        created(){
            this.getNews();
        },
        mounted(){
        },
    }
</script>

<style scoped lang="scss">
@import "../assets/Scss/components/scrollBar.scss";

/* -------------------表單 ------------------------*/

.ivu-form{ 
    &:deep(.ivu-form-item-label){
        color:#fff;
        display: none;
    }
}



/* -------------------是否上架 ------------------------*/
.type_on{
    color: red;
}
.isNotOnStatus{
    display: none;
}
/* -------------------彈窗 ------------------------*/
.popup{
    position: absolute;
    top: 5px;
    left: 150px;
    margin: auto;
    z-index: 20;

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




/* 新增按鈕 */
.btn-add{
    text-align: end;
    margin-right: 60px;
}
.btn-add button{
    padding: 8px 16px;

}
/* 確認彈窗按鈕 */
.popup-box .btn-success{
    padding: 8px 32px;
}

/* 確認彈窗文字 */
.popup-box .check-des{
    translate:0 -16px ;
}
// class名稱
// .btn-blue        按鈕:藍色
// .btn-blue_2nd    按鈕:白底藍框
// .btn-gold        按鈕:土色
// .btn-gold_2nd    按鈕:白底土框
// .btn-success     按鈕:綠色
// .btn-success_2nd 按鈕:白底綠框
// .btn-danger      按鈕:紅色
// .btn-danger_2nd  按鈕:白底紅框


</style>