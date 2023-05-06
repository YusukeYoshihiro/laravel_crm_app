<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { reactive } from "vue";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  customers: Object,
});

console.log(props.customers);

const searchId = ref("");
const searchName = ref("");
const searchKana = ref("");
const searchTel = ref("");
const searchEmail = ref("");

// ref の値を取得するには、.valueが必要
const form = reactive({
  searchId: searchId.value,
  searchName: searchName.value,
  searchKana: searchKana.value,
  searchTel: searchTel.value,
  searchEmail: searchEmail.value,
});

const searchCustomers = () => {
  router.get(
    route("customers.index", form)
  );
};

</script>

<template>
  <Head title="顧客一覧" />

  <AuthenticatedLayout>
    <template>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        顧客一覧
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font">
              <div class="container px-5 py-8 mx-auto">
                <FlashMessage />

                <div class="flex my-4 lg:w-4/5 w-full mx-auto">
                  <Link as="button" :href="route('customers.create')"
                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                  顧客登録
                  </Link>
                </div>
                <div>
                  <h2 class="my-4 lg:w-4/5 w-full mx-auto">
                    顧客検索
                  </h2>
                  <div class="flex my-4 lg:w-4/5 w-full mx-auto">
                    <form class="w-full">
                      <div class="grid grid-cols-3 gap-3">
                        <div>
                          <label class="">ID: </label><br />
                          <input type="number" name="searchId" :value="searchId" @input="
                            searchId =
                            $event.target.value
                          " placeholder="ID" class="mb-5 rounded" />
                        </div>

                        <div>
                          <label class="">氏名: </label><br />
                          <input type="text" name="searchName" :value="searchName" @input="
                            searchName =
                            $event.target.value
                          " placeholder="氏名" class="mb-5 rounded" />

                        </div>
                        <div>
                          <label class="">カナ: </label><br />
                          <input type="text" name="searchKana" :value="searchKana" @input="
                            searchKana =
                            $event.target.value
                          " placeholder="カナ" class="rounded" />
                        </div>

                        <div>
                          <label class="">電話番号:</label><br />
                          <input type="tel" name="searchTel" :value="searchTel" @input="
                            searchTel =
                            $event.target.value
                          " placeholder="電話番号" class="mb-5 rounded" />
                        </div>

                        <div>
                          <label class="">Email:</label><br />
                          <input type="email" name="searchEmail" :value="searchEmail" @input="
                            searchEmail =
                            $event.target.value
                          " placeholder="メールアドレス" class="rounded" />
                        </div>
                      </div>

                      <button type="submit"
                        class="flex ml-auto text-white bg-green-700 border-0 py-2 px-6 focus:outline-none hover:bg-green-800 rounded"
                        @click="searchCustomers">
                        検索
                      </button>
                    </form>
                  </div>
                </div>

                <div class="lg:w-4/5 w-full mx-auto overflow-auto"></div>

                <div class="lg:w-4/5 w-full mx-auto overflow-auto">
                  <!-- result section -->
                  <div v-if="customers.total === 1000">
                    <p>検索結果: {{ 0 }} 件 (全件表示)</p>
                  </div>
                  <div v-if="customers.total < 1000">
                    <p>
                      検索結果: {{ customers.total }} 件
                    </p>
                  </div>
                  <!-- table section -->
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th
                          class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                          ID
                        </th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          氏名
                        </th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          カナ
                        </th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          電話番号
                        </th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          メールアドレス
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr :key="customer.id" v-for="customer in customers.data">
                        <td class="px-4 py-3 border-b-2 border-gray-200">
                          <Link class="text-blue-400" :href="
                            route(
                              'customers.show',
                              {
                                customer:
                                  customer.id,
                              }
                            )
                          ">
                          {{ customer.id }}
                          </Link>
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
                </div>
              </div>
              <Pagination class="mt-6 flex justify-center items-center" :links="customers.links"></Pagination>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
