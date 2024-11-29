<template>
  <div class="backstage-pro">
    <div class="btn-add">
      <button class="font-20 btn-blue" @click="newToggle">新增商品</button>
    </div>
    <div class="pro-table">
      <Table stripe border :columns="columns" :data="dataOn">
        <!-- 商品編號 -->
        <template #product_no="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_id }}</span>
        </template>
        <!-- 商品圖片 -->
        <!-- <template #product_pic="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_pic_main }}</span>
        </template> -->
        <!-- 商品名稱 -->
        <template #product_name="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_name }}</span>
        </template>
        <!-- 主類別 -->
        <template #product_series="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_series_idx }}</span>
        </template>
        <!-- 子類別 -->
        <template #product_type="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_type_id }}</span>
        </template>
        <!-- 商品價格 -->
        <template #product_price="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_price }}</span>
        </template>
        <!-- 商品狀態 -->
        <template #product_status="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.prod_status }}</span>
        </template>
        <!-- 按鈕 -->
        <template #product_action="{ index }">
          <div class="btn-box">
            <button class="btn-success" @click="editOnData(index)">編輯</button>
          </div>
        </template>
      </Table>
    </div>

    <!-- style="display:none" -->
    <!--新增商品 -->
    <keep-alive>
      <form ref="test" id="myForm" enctype="multipart/form-data">
        <div class="popup" v-show="seenNew" :model="addItem">
          <div class="popup-head font-20">商品資訊</div>
          <div class="popup-content font-18">
            <div class="input-txt">
              <div class="input-title">
                <label for=""
                  >商品編號：
                  <Input
                    placeholder="預設"
                    clearable
                    style="width: 300px"
                    disabled
                    v-model="addItem.prod_id"
                    name="prod_id"
                  />
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >主類別:
                  <select
                    
                    id=""
                    style="width: 300px"
                    v-model="addItem.prod_series_idx"
                    name="prod_series_idx"
                  >
                    <option value="p001">紀念品系列p001</option>
                    <option value="p002">特產系列p002</option>
                  </select>
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >子類別:
                  <select
                    name="prod_type_id"
                    id=""
                    style="width: 300px"
                    v-model="addItem.prod_type_id"
                  >
                    <option value="s001">水壺s001</option>
                    <option value="s002">便當盒s002</option>
                    <option value="s003">零食s003</option>
                    <option value="s004">調味料s004</option>
                  </select>
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >商品名稱：
                  <Input
                    placeholder="請輸入商品名稱"
                    clearable
                    style="width: 300px"
                    v-model="addItem.prod_name"
                    name="prod_name"
                  />
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >商品價格：
                  <Input
                    type="number"
                    number="true"
                    placeholder="請輸入商品價格"
                    style="width: 300px"
                    v-model="addItem.prod_price"
                    name="prod_price"
                  />
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >商品介紹：
                  <Input
                    clearable
                    type="textarea"
                    :rows="4"
                    placeholder="請輸入商品介紹"
                    style="width: 300px"
                    v-model="addItem.prod_intro"
                    name="prod_intro"
                  />
                </label>
              </div>
              <div class="input-title">
                <label for=""
                  >商品狀態:
                  <select
                    name="prod_status"
                    id=""
                    style="width: 300px"
                    v-model="addItem.prod_status"
                  >
                    <option value="1">上架1</option>
                    <option value="0">下架0</option>
                  </select>
                </label>
              </div>
            </div>
            <div class="pro-pic">
              <div class="input-title-pic">
                <label class="picpic" for=""
                  >商品主圖：
                  <input
                    type="file"
                    @change="previewImage"
                    class="pic-input"
                    id="prod_pic_intro_0"
                    name="prod_pic_intro_0"
                  />
                  <div v-if="preview" class="pro-pic-preview">
                    <img :src="preview" />
                  </div>
                </label>
              </div>

              <div class="input-title-pic">
                <label class="picpic" for=""
                  >商品副圖：
                  <input
                    type="file"
                    @change="previewImage1"
                    class="pic-input"
                    id="prod_pic_intro_1"
                    name="prod_pic_intro_1"
                  />
                  <div v-if="preview1" class="pro-pic-preview">
                    <img :src="preview1" />
                  </div>
                </label>
              </div>
              <div class="input-title-pic">
                <label class="picpic" for=""
                  >商品副圖：
                  <input
                    type="file"
                    @change="previewImage2"
                    class="pic-input"
                    id="prod_pic_intro_2"
                    name="prod_pic_intro_2"
                  />
                  <div v-if="preview2" class="pro-pic-preview">
                    <img :src="preview2" />
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="popup-btn">
            <button class="btn-blue_2nd" @click="addCancel">取消</button>
            <div class="btn-blue" @click="addOk">確認</div>
            <!-- 確認鍵功能待補，暫放toggle -->
          </div>
        </div>
      </form>
    </keep-alive>

    <!-- 編輯商品 -->
    <div class="popup on" v-show="seeOnData" :model="addItem[index]">
      <div class="popup-head font-20">商品資訊</div>
      <div class="popup-content font-18">
        <div class="input-txt">
          <div class="input-title">
            <label for=""
              >商品編號：
              <Input v-model="addItem.prod_id" style="width: 300px" disabled />
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >主類別:
              <select
                name=""
                id=""
                style="width: 300px"
                v-model="addItem.prod_series_id"
              >
                <option value="紀念品系列">紀念品系列</option>
                <option value="特產系列">特產系列</option>
              </select>
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >子類別:
              <select
                name=""
                id=""
                style="width: 300px"
                v-model="addItem.prod_type_id"
              >
                <option value="水壺">水壺</option>
                <option value="便當盒">便當盒</option>
                <option value="零食">零食</option>
                <option value="調味料">調味料</option>
              </select>
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >商品名稱：
              <Input
                v-model="addItem.prod_name"
                clearable
                style="width: 300px"
              />
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >商品價格：
              <Input
                type="number"
                number="true"
                v-model="addItem.prod_price"
                style="width: 300px"
              />
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >商品介紹：
              <Input
                clearable
                type="textarea"
                :rows="4"
                v-model="addItem.prod_intro"
                style="width: 300px"
              />
            </label>
          </div>
          <div class="input-title">
            <label for=""
              >商品狀態:
              <select
                name=""
                id=""
                style="width: 300px"
                v-model="addItem.prod_status"
              >
                <option value="上架">上架</option>
                <option value="下架">下架</option>
              </select>
            </label>
          </div>
        </div>
        <div class="pro-pic">
          <div class="input-title">
            <label class="picpic" for=""
              >商品主圖：
              <input type="file" />
            </label>
          </div>
          <div class="input-title">
            <label class="picpic" for=""
              >商品副圖：
              <input type="file" />
            </label>
          </div>
          <div class="input-title">
            <label class="picpic" for=""
              >商品副圖：
              <input type="file" />
            </label>
          </div>
        </div>
      </div>
      <div class="popup-btn">
        <button class="btn-blue_2nd" @click="editCancel">取消</button>
        <button class="btn-blue" @click="editOk">確認</button>
        <!-- 確認鍵功能待補，暫放toggle -->
      </div>
    </div>
  </div>

  <!-- 新增成功 -->
  <!-- style="display:none" -->
  <!-- <div class="popup-box add font-18" v-show="seeCheck">
    <p class="popup-box-close">X</p>
    <p class="check-des">新增資料成功</p>
    <button @click="okToggle" class="btn-success">確認</button>
  </div> -->

  <!-- 修改成功 -->
  <!-- <div class="popup-box fix font-18" v-show="seeCheck">
    <p class="popup-box-close">X</p>
    <p class="check-des">修改資料成功</p>
    <button @click="okToggle" class="btn-success">確認</button>
  </div> -->
</template>

<script>
import { BASE_URL } from "@/assets/js/common.js";
export default {
  name: "ProductManage",
  props: {},
  components: {},
  data() {
    return {
      file: null,
      preview: null, //預覽主圖片
      preview1: null, //預覽圖片a
      preview2: null, //預覽圖片b

      seenNew: false, //新表格彈窗，綁新表單v-show、按鈕@click="newToggle"
      seeOnData: false, //上架資料彈窗，綁上架資料v-show、編輯按鈕@click="editOnData"
      size: "default", //按鈕間距，搭配Space，預設small(無間距)， 可自行調整距離px，詳情請看 https://run.iviewui.com/
      seeCheck: false, //確認彈窗、v-show="seeCheck" 按鈕@click="okToggle"

      columns: [
        {
          title: "商品編號",
          slot: "product_no",
          width: 120,
          align: "center",
        },
        // {
        //   title: "商品圖片",
        //   slot: "product_pic",
        //   align: "center",
        // },
        {
          title: "商品名稱",
          slot: "product_name",
          align: "center",
        },
        {
          title: "主類別",
          slot: "product_series",
          width: 120,
          align: "center",
          filters: [
            {
              label: "紀念品",
              value: 1,
            },
            {
              label: "特產",
              value: 2,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.product_series === "紀念品";
            } else if (value === 2) {
              return row.product_series === "特產";
            }
          },
        },
        {
          title: "子類別",
          slot: "product_type",
          width: 120,
          align: "center",
          filters: [
            {
              label: "水壺",
              value: 3,
            },
            {
              label: "便當盒",
              value: 4,
            },
            {
              label: "零食",
              value: 5,
            },
            {
              label: "調味料",
              value: 6,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 3) {
              return row.product_type === "水壺";
            } else if (value === 4) {
              return row.product_type === "便當盒";
            } else if (value === 5) {
              return row.product_type === "零食";
            } else if (value === 6) {
              return row.product_type === "調味料";
            }
          },
        },
        {
          title: "商品價格",
          slot: "product_price",
          width: 180,
          align: "center",
        },
        {
          title: "商品狀態",
          slot: "product_status",
          width: 150,
          align: "center",
        },
        {
          title: "操作",
          slot: "product_action",
          width: 150,
          align: "center",
        },
      ],
      dataOn: [
        // {
        //   product_no: "001",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "零食",
        //   product_name: "九州福砂屋長崎蛋糕",
        //   product_price: "460",
        //   product_intro:
        //     "採用精選雞蛋、砂糖、糖漿和小麥粉的簡單材料，全程不用攪拌機，完全靠師傅手感攪拌，製作出口味道地且香甜綿潤的蛋糕點心。長崎蛋糕底砂糖結晶顆粒的粗糖，是攪拌蛋糕材料時留下來的，也是福砂屋長崎蛋糕的特徵。作為長崎蛋糕的傑作，特製五三燒長崎蛋糕的風味更濃，且香氣更濃郁。它由技術熟練的糕點師傅以高超技術製成，生量數量少，是福砂屋的特製長崎蛋糕，廣受長崎 蛋糕饕客們喜愛。",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "002",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "零食",
        //   product_name: "JS怪奇薯條",
        //   product_price: "290",
        //   product_intro:
        //     "怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃怪奇薯條好好吃哦怎麼這麼好吃",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "003",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "調味料",
        //   product_name: "透明醬油",
        //   product_price: "320",
        //   product_intro:
        //     "透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃透明醬油好好吃哦怎麼這麼好吃",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "004",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "零食",
        //   product_name: "七彩洋芋片",
        //   product_price: "250",
        //   product_intro:
        //     "七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片七彩洋芋片",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "005",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "紀念品",
        //   product_type: "水壺",
        //   product_name: "九州切子",
        //   product_price: "850",
        //   product_intro:
        //     "九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子九州切子",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "006",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "紀念品",
        //   product_type: "便當盒",
        //   product_name: "火車便當盒",
        //   product_price: "480",
        //   product_intro:
        //     "火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒火車便當盒",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "007",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "調味料",
        //   product_name: "九州昆布湯包",
        //   product_price: "320",
        //   product_intro:
        //     "九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包九州昆布湯包",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
        // {
        //   product_no: "008",
        //   product_pic: require(`@/assets/img/products/pro4.jpg`),
        //   product_series: "特產",
        //   product_type: "調味料",
        //   product_name: "九州黑醋",
        //   product_price: "220",
        //   product_intro:
        //     "九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋九州黑醋",
        //   product_status: "上架",
        //   product_pica: require(`@/assets/img/products/pro5.jpg`),
        //   product_picb: require(`@/assets/img/products/pro6.jpg`),
        // },
      ],
      // 新增表單insert
      // prodid: "",
      // prodseriesidx: "",
      // prodtypeid: "",
      // prodname: "",
      // prodprice: "",
      // prodintro: "",
      // prodstatus: "",
      // prodpicmain: "",
      // prodpicintro1: "",
      // prodpicintro2: "",

      addItem: {
        prod_id: "",
        prod_pic_intro_0: "",
        prod_series_idx: "",
        prod_type_id: "",
        prod_name: "",
        prod_price: "",
        prod_intro: "",
        prod_status: "",
        prod_pic_intro_1: "",
        prod_pic_intro_2: "",
      },
      resetItem: {
        prod_id: "",
        prod_pic_intro_0: "",
        prod_series_idx: "",
        prod_type_id: "",
        prod_name: "",
        prod_price: "",
        prod_intro: "",
        prod_status: "",
        prod_pic_intro_1: "",
        prod_pic_intro_2: "",
      },
      editIndex: -1,
      // activeIndex: NaN,
    };
  },
  created() {
    this.getData();
  },
  methods: {
    //預覽主圖片
    previewImage: function (event) {
      this.file - event.target.file[0];
      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    //預覽圖片a
    previewImage1: function (event) {
      this.file - event.target.file[0];
      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview1 = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    //預覽圖片b
    previewImage2: function (event) {
      this.file - event.target.file[0];
      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview2 = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    getData() {
      // fetch("http://localhost/g4-backend/public/phpfiles/getProducts.php")
        fetch(`${BASE_URL}/getProducts.php`)
        .then((res) => res.json())
        .then((json) => {
          this.dataOn = json;
          // console.log(this.dataOn);
        });
    },
    saveData() {
      console.log(this.dataOn);
    },

    newToggle() {
      //新表單
      this.seenNew = !this.seenNew;
    },
    addCancel() {
      this.addItem = { ...this.resetItem };
      this.seenNew = !this.seenNew;
    },
    addOk() {
      this.insertData(this.addItem);

      // this.dataOn.push({ ...this.addItem });
      // this.addItem = { ...this.resetItem };

      this.seenNew = !this.seenNew;

     


      // setTimeout(() => {
      //   this.dataOn.push({ ...this.addItem });
      //   this.addItem = { ...this.resetItem };
      // }, 5);

      // console.log(this.addItem);
      // console.log(this.dataOn);
    },

    // const url = "http://localhost/cgd103-g4/public/phpfiles/ContactInsert.php";
    //       formData.append("opinion_name", this.opinionname);
    //       formData.append("opinionmail", this.opinionmail);
    //       formData.append("opiniontel", this.opiniontel);
    //       formData.append("opiniondetail", this.opiniondetail);
    //       formData.append("opinionselecttopic", this.opinionselecttopic);
    //       fetch( url , {
    //         method: "POST",
    //         body: formData,
    //       })
    //         .then((res) => res.json())
    //         .then((result) => {
    //           console.log(result);
    //         })
    //         /* .catch((error) => {
    //           // console.log(error);
    //         }); */
    //     },
    insertData() {
      const formData = new FormData(document.getElementById('myForm'));
      
      // const formDataKey = Object.slots(this.addItem);
      // formDataKey.forEach((slot) => {
      //   formData.append(`${slot}`, this.addItem[slot]);
      // });

      // const imgName = document.getElementById("prod_pic_main").files[0];

      // formData.set("prod_pic_main", imgName);

      // console.log(formData.get("prod_pic_main"));

      // fetch("http://localhost/g4-backend/public/phpfiles/insertProducts.php", {
      fetch(`${BASE_URL}/insertProducts.php`, {
        method: "POST",
        body: formData,
      })
      .then((res) => res.json())
      .then((result) => {
        console.log(result);
        // const result = res;
        // this.addItem.prod_pic_main = result.prod_pic_main;
        // console.log(result.prod_pic_main);
        // console.log(this.addItem);
        this.dataOn.push({ ...this.addItem });
        this.addItem = { ...this.resetItem };
      })
      .catch((error) => {
        console.log(error);
      });
    },

    
    editOnData(index) {
      //上架編輯表單彈窗
      this.seeOnData = true;
      this.addItem = { ...this.dataOn[index] };

      // this.dataOn = prod_id;
      // this.addItem={...this.activeData};
      // console.log(this.activeData);
    },
    editOk() {
      const index = this.dataOn.findIndex(
        (item) => item.prod_id === this.addItem.prod_id
      );
      this.seeOnData = !this.seeOnData;
      this.dataOn[index] = this.addItem;
      this.addItem = { ...this.resetItem };
    },
    editCancel() {
      this.seeOnData = !this.seeOnData;
    },
    okToggle() {
      //確認彈窗
      this.seeCheck = !this.seeCheck;
    },
    // confirm() {
    //   this.dataOn.push({ ...this.activeData });
    //   this.activeData = { ...this.restItem };
    //   this.seenNew = !this.seenNew;
    // },
    // cancelEdit() {
    //   // this.activeData = {...this.resetItem};
    //   this.seeOnData = !this.seeOnData;
    //   console.log(this.resetItem);
    //   this.activeIndex = no;
    // },
  },
  // computed: {
  //   activeData() {
  //     return this.dataOn.find((v) => v.prod_id === this.activeIndex) ?? {};
  //   },
  // },
};
</script>


<style scoped lang="scss">
@import "@/assets/Scss/base/color.scss";

/* 新增按鈕 */
.btn-add {
  text-align: end;
  margin-right: 60px;
}
.btn-add button {
  padding: 8px 16px;
}
.pro-table {
  height: 45vh;
  margin: 30px 20px;
}
// .type {
//   display: flex;
//   color: #fff;
//   align-items: center;
// }

/* -------------------彈窗 ------------------------*/
.popup {
  position: absolute;
  top: 90px;
  left: 80px;
  margin: auto;
  z-index: 20;
  width: 90%;
  // height: 0%;
  background-color: #4f6573;
}

/* 上方區塊顏色 */
.popup-head {
  background-color: #2d3740;
  height: 50px;
  color: #ccc;
  display: flex;
  justify-content: center;
  align-items: center;
}
.popup-content {
  display: flex;
  padding: 30px;
  justify-content: center;
}
.input-title {
  margin-bottom: 20px;
}
.input-title-pic {
  margin-bottom: 20px;
}
.input-txt {
  width: 45%;
  margin: 20px;
  text-align: end;
}
.pro-pic {
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  width: 60%;
  margin: 20px;
}
.picpic {
  display: flex;
  align-items: center;
}
.pic-input {
  width: 40%;
}
.pro-pic-preview {
  width: 30%;
  img {
    width: 70%;
  }
}

.popup-btn {
  width: 100%;
  max-width: 30%;
  display: flex;
  justify-content: space-between;
  margin: auto;
  padding: 20px 0px;
}

.popup-btn button {
  padding: 5px 30px;
}

/* 彈窗字顏色 */
.popup label {
  color: #fff;
}
.date {
  color: #ccc;
}

/* -------------------彈窗結束----------------- */

/* -------------------新增修改box ------------------------*/
.popup-box {
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

.popup-box-close {
  text-align: end;
  margin-top: 10px;
  padding-right: 20px;
}

// .check-des {
//   margin-top: 70px;
// }

.popup-box button {
  margin-top: 30px;
}

/* -------------------新增修改結束 ------------------------*/

/* 確認彈窗按鈕 */
.popup-box .btn-success {
  padding: 8px 32px;
}

/* 確認彈窗文字 */
.popup-box {
  translate: 0 -16px;
}

/* 彈窗背景 */

.modal-mask {
  position: absolute;
  z-index: 10;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: table;
  background-color: rgba(0, 0, 0, 0.5);
  transition: opacity 0.3s ease;
}
</style>