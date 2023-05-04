<script setup>
  import axios from "axios";
  import { ref, onMounted, reactive } from "vue";
  import Pagination from "./Pagination.vue";
  import { router } from "@inertiajs/vue3";

  const search = ref("");
  const customers = reactive({});

  const props = defineProps({
    customersData: Object,
  });

  // onMounted(() => {
  //   axios.get("/api/user").then((res) => {
  //     console.log(res.data);
  //   }); 
  // });

  const isShow = ref(false);

  const toggleStatus = () => {
    isShow.value = !isShow.value;
  };

  // DBにアクセスし取得するまでに若干時間がかかるため、async-awaitを使って、取得後に表示させる。
  // const searchCustomers = async () => {
  //   try {
  //     await axios.get(`/api/searchCustomers/?search=${search.value}`).then((res) => {
  //       console.log(res.data);
  //       customers.value = res.data;
  //     });
  //     isShow.value = !isShow.value;
  //   } catch (e) {
  //     console.log(e.message);
  //   }
  // };

  const form = reactive({
    search: search.value,
  });
  console.log('search', form.search);

  const customersData = ref(props.customersData)
  console.log('customersData', customersData.value.data);

  const searchCustomers = async () => {
    router.get(route("purchases.create", form));
  };

  // 親コンポーネントに会員IDを渡す(会員検索経由)
  const emit = defineEmits(["update:customerId"]);

  const setCustomer = (e) => {
    // 会員名をinputにセットする
    search.value = e.name;
    emit("update:customerId", e.id);
    toggleStatus();
  };
</script>

<template>
  <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div
        class="modal__container w-full"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-1-title"
      >
        <header class="modal__header">
          <h2 ass="modal__title" id="modal-1-title">顧客検索</h2>
          <button
            @click="toggleStatus"
            type="button"
            class="modal__close"
            aria-label="Close modal"
            data-micromodal-close
          ></button>
        </header>
        <main class="modal__content" id="modal-1-content">
          <div v-if="customersData.value" class="lg:w-4/5 w-full mx-auto overflow-auto">
            <!-- table section -->
            <table class="table-auto w-full text-left whitespace-no-wrap">
              <thead>
                <tr>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                  >
                    ID
                  </th>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                  >
                    氏名
                  </th>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                  >
                    カナ
                  </th>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                  >
                    電話番号
                  </th>
                  <th
                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                  >
                    メールアドレス
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr :key="customer.id" v-for="customer in customersData.value">
                  <td class="px-4 py-3 border-b-2 border-gray-200">
                    <button
                      type="button"
                      @click="setCustomer({ id: customer.id, name: customer.name })"
                      class="text-blue-400"
                    >
                      {{ customer.id }}
                    </button>
                  </td>
                  <td class="px-4 py-3 border-b-2 border-gray-200">
                    {{ customer.name }}
                  </td>
                  <td class="px-4 py-3 border-b-2 border-gray-200">
                    {{ customer.kana }}
                  </td>
                  <td class="px-4 py-3 border-b-2 border-gray-200">
                    {{ customer.tel }}
                  </td>
                  <td class="px-4 py-3 border-b-2 border-gray-200">
                    {{ customer.email }}
                  </td>
                </tr>
              </tbody>
            </table>
            <Pagination
              class="mt-6 flex justify-center items-center"
              :links="customersData.links"
            ></Pagination>
          </div>
        </main>
        <footer class="modal__footer">
          <button
            @click="toggleStatus"
            type="button"
            class="modal__btn"
            data-micromodal-close
            aria-label="Close this dialog window"
          >
            閉じる
          </button>
        </footer>
      </div>
    </div>
  </div>

  <input
    placeholder="氏名、 氏名(カナ)、 電話番号、 もしくは、Email で検索"
    name="customer"
    v-model="search"
    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
  />
  <button
    @click="searchCustomers"
    type="button"
    data-micromodal-trigger="modal-1"
    class="mt-4 flex mx-auto text-white bg-teal-500 border-0 py-2 px-8 focus:outline-none hover:bg-teal-600 rounded text-lg"
  >
    検索する
  </button>
</template>
