<template>
  <div>
    <Table
      :row-class-name="rowClassName"
      :columns="columns1"
      :data="result"
      border
    >
      <!-- 意見表編號 -->
      <template #opinion_no="{ row }">
        <span>{{ row.opinion_no }}</span>
      </template>
      <!-- 填寫日期 -->
      <template #opinion_date="{ row }">
        <span>{{ row.opinion_date }}</span>
      </template>
      <!-- 填寫人姓名 -->
      <template #opinion_name="{ row }">
        <span>{{ row.opinion_name }}</span>
      </template>
      <!-- 連絡電話 -->
      <template #opinion_num="{ row }">
        <span>{{ row.opinion_tel }}</span>
      </template>
      <!-- 信箱 -->
      <template #opinion_mail="{ row }">
        <span>{{ row.opinion_mail }}</span>
      </template>
      <!-- 意見表詳情 -->
      <template #table-row="{ row }">
        <Button @click="editOnData(row.opinion_no)">更多資訊</Button>
      </template>
    </Table>
    <div class="morecontent" v-show="show" :result="result">
      <div class="content">
        <div class="content-header">
          <p>意見表詳情</p>
        </div>
        <div class="content-text">
          <p>意見表編號：{{ activeData.opinion_no }}</p>
          <p>填寫日期：{{ activeData.opinion_date }}</p>
          <p>填寫人名字：{{ activeData.opinion_name }}</p>
          <p>填寫人電話：{{ activeData.opinion_tel }}</p>
          <p>填寫人信箱：{{ activeData.opinion_mail }}</p>
          <p>填寫內容：{{activeData.opinion_datail}}</p>
        </div>
        <div class="closebtn">
          <Button @click="editOnData()">關閉</Button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {BASE_URL} from '@/assets/js/common.js'
const result = [];
export default {
  data() {
    return {
      result: [],
      contact: "",
      show: false,
      activeIndex: null,
      columns1: [
        {
          title: "意見表編號",
          width: 120,
          slot: "opinion_no",
        },
        {
          title: "填寫時間",
          slot: "opinion_date",
        },
        {
          title: "填寫人姓名",
          slot: "opinion_name",
        },
        {
          title: "連絡電話",
          slot: "opinion_num",
        },
        {
          title: "信箱",
          slot: "opinion_mail",
        },
        {
          title: "意見表詳情",
          slot: "table-row",
        },
      ],
    };
  },
  created() {
    this.getData();
  },
  methods: {
    rowClassName(index) {
      if (index % 2 === 0) {
        return "demo-table-info-row";
      } else if (!index % 2 === 0) {
        return "demo-table-error-row";
      }
      return "";
    },
    editOnData(no) {
      this.show = !this.show;
      this.activeIndex = no;
    },
    getData() {
      fetch(`${BASE_URL}/getContact.php`)
        .then((res) => res.json())
        .then((json) => {
          this.result = json;
          console.log(this.result);
        });
    },
    saveData() {
      console.log(this.result);
    },
  },
  computed: {
    activeData() {
      return this.result.find((v) => v.opinion_no === this.activeIndex) ?? {};
    },
  },
};
</script>

<style lang="scss" scope>
.ivu-table-header th {
  text-align: center;
}
.ivu-table-cell {
  text-align: center;
}
.ivu-btn {
  background-color: #0c3b59;
  color: #fff;
}
.morecontent {
  width: 100%;
  position: absolute;
  width: 100%;
  z-index: 100;
  top: 17%;
  left: 0;
  padding: 40px;
  .content {
    width: 100%;
    height: 100vh;
    background-color: #4f6573;
    .content-header {
      width: 100%;
      height: 80px;
      background-color: #2d3740;
      line-height: 80px;
      p {
        font-size: 32px;
        font-weight: 900;
        color: #fff;
      }
    }
    .content-text {
      margin: auto;
      font-size: 20px;
      color: #fff;
      padding: 60px 200px;
      p {
        margin: 30px auto;
        text-align: left;
        display: flex;
        flex-wrap: wrap;
      }
    }
    .closebtn {
      padding: 60px 200px;
      text-align: end;
    }
  }
}
.ivu-table .demo-table-info-row td {
  background-color: #e2e9f2;
  color: #444444;
}
.ivu-table .demo-table-error-row td {
  background-color: #ffffff;
  color: #444444;
}
</style>
