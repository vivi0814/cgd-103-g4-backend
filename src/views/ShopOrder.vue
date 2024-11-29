<template>
  <div class="backstage-order">
    <div class="order-table">
      <Table stripe border :columns="columns" :data="dataOn">
        <!-- 訂單編號 -->
        <template #order_no="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.order_no }}</span>
        </template>
        <!-- 訂單日期 -->
        <template #order_date="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.order_date }}</span>
        </template>
        <!-- 會員編號 -->
        <template #mem_no="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.mem_no }}</span>
        </template>
        <!-- 訂單金額 -->
        <template #order_price="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.order_price }}</span>
        </template>
        <!-- 付款狀態 -->
        <template #payment_status="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.payment_status }}</span>
        </template>
        <!-- 出貨狀態 -->
        <template #order_status="{ row, index }">
          <Input type="text" v-if="editIndex === index" />
          <span v-else>{{ row.order_status }}</span>
          <select name="" id="" style="width: 80px">
            <option value="yet">未出貨</option>
            <option value="send">已出貨</option>
            <option value="done">完成訂單</option>
          </select>
        </template>
        <!-- 按鈕訂單明細 -->
        <template #order_action="{ row }">
          <div class="btn-box">
            <button class="btn-success" @click="editOnData(row.order_no)">
              訂單明細
            </button>
          </div>
        </template>
      </Table>
    </div>
    <div class="popup on" v-show="seeOnData">
      <div class="popup-head font-20">
        <div class="order_no">
          <span>訂單編號:{{ activeData.order_no }}</span>
        </div>
      </div>
      <div class="popup-content font-18">
        <div class="input-txt">
          <div class="input-title">
            收件人姓名:
            <span>
              {{ activeData.receive_name }}
            </span>
          </div>
          <div class="input-title">
            收件人電話:
            <span>
              {{ activeData.receive_phone }}
            </span>
          </div>
          <div class="input-title">
            收件人地址:
            <span>
              {{ activeData.receive_address }}
            </span>
          </div>
        </div>
        <Table stripe border :columns="columns1" :data="dataOn">
          <template #pro_no="{ row, index }">
            <Input type="text" v-if="editIndex === index" />
            <span v-else>{{ row.pro_no }}</span>
          </template>
          <template #pro_name="{ row, index }">
            <Input type="text" v-if="editIndex === index" />
            <span v-else>{{ row.pro_name }}</span>
          </template>
          <template #pro_price="{ row, index }">
            <Input type="text" v-if="editIndex === index" />
            <span v-else>{{ row.pro_price }}</span>
          </template>
          <template #pro_amount="{ row, index }">
            <Input type="text" v-if="editIndex === index" />
            <span v-else>{{ row.pro_amount }}</span>
          </template>
          <template #pro_littletotal="{ row, index }">
            <Input type="text" v-if="editIndex === index" />
            <span v-else>{{ row.pro_littletotal }}</span>
          </template>
        </Table>

        <div class="popup-btn">
          <button class="btn-blue_2nd" @click="editOnData">回到列表</button>
          <!-- 確認鍵功能待補，暫放toggle -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ShopOrder",
  props: {},
  components: {},
  data() {
    return {
      seeOnData: false,
      size: "default",
      seeCheck: false,
      columns: [
        {
          title: "訂單編號",
          slot: "order_no",
          align: "center",
        },
        {
          title: "訂單日期",
          slot: "order_date",
          align: "center",
          sortable: true,
        },
        {
          title: "會員編號",
          slot: "mem_no",
          align: "center",
        },
        {
          title: "訂單金額",
          slot: "order_price",
          align: "center",
        },
        {
          title: "付款狀態",
          slot: "payment_status",
          align: "center",
        },
        {
          title: "出貨狀態",
          slot: "order_status",
          align: "center",
        },
        {
          title: "操作",
          slot: "order_action",
          align: "center",
        },
      ],
      dataOn: [
        {
          order_no: "11112120001",
          order_date: "2022-12-12",
          mem_no: "001",
          order_price: "1080",
          payment_status: "未付款",
          receive_name: "曾小足",
          receive_phone: "0912345678",
          receive_address: "台北市信義區忠孝東路四段123號5弄4號3樓之1",
        },
        {
          order_no: "11112120002",
          order_date: "2022-12-12",
          mem_no: "002",
          order_price: "900",
          payment_status: "已付款",
          receive_name: "張小容",
          receive_phone: "0987548548",
          receive_address: "桃園市中壢區復興路46號8樓之2",
        },
        {
          order_no: "11112130001",
          order_date: "2022-12-13",
          mem_no: "003",
          order_price: "700",
          payment_status: "未付款",
          receive_name: "余大哥",
          receive_phone: "0955123456",
          receive_address: "桃園市中壢區中壢火車站3樓",
        },
        {
          order_no: "11112130002",
          order_date: "2022-12-13",
          mem_no: "004",
          order_price: "1280",
          payment_status: "未付款",
          receive_name: "林組長",
          receive_phone: "0922123456",
          receive_address: "桃園市復興區內壢火車站",
        },
        {
          order_no: "11112130003",
          order_date: "2022-12-13",
          mem_no: "001",
          order_price: "980",
          payment_status: "未付款",
          receive_name: "曾小小",
          receive_phone: "0933123456",
          receive_address: "台中市西區逢甲夜市旁邊5樓",
        },
      ],
      columns1:[
        {
            title: "商品編號",
            slot: "pro_no",
            align: "center",
        },
        {
            title: "商品名稱",
            slot: "pro_name",
            align: "center",
        },
        {
            title: "商品單價",
            slot: "pro_price",
            align: "center",
        },
        {
            title: "數量",
            slot: "pro_amount",
            align: "center",
        },
        {
            title: "小計",
            slot: "pro_littletotal",
            align: "center",
        },
      ],
      //   editIndex: -1,
      activeIndex: null,
    };
  },
  methods: {
    editOnData(no) {
      //上架編輯表單彈窗
      this.seeOnData = !this.seeOnData;
      this.activeIndex = no;
    },
    okToggle() {
      //確認彈窗
      this.seeCheck = !this.seeCheck;
    },
  },
  computed: {
    activeData() {
      return this.dataOn.find((v) => v.order_no === this.activeIndex) ?? {};
    },
  },
};
</script>

<style scoped lang="scss">
@import "@/assets/Scss/base/color.scss";

/* -------------------彈窗 ------------------------*/
.popup {
  position: absolute;
  top: 100px;
  left: 150px;
  margin: auto;
  z-index: 20;
  width: 80%;
  height: 80%;
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
  padding: 30px;
  margin: auto;
}

.input-title {
  color: #fff;
  width: 60%;
  text-align: start;
  margin: auto;
  margin-bottom: 20px;
}
.popup-btn {
  width: 100%;
  //   max-width: 30%;
  display: flex;
  justify-content: center;
  padding: 20px 0px;
}
</style>