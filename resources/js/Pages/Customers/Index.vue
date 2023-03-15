<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps({
  customers: Object,
});

const search = ref("");

// ref の値を取得するには、.valueが必要
const searchCustomers = () => {
  Inertia.get(route("customers.index", { search: search.value }));
};

</script>

<template>
  <Head title="顧客一覧" />

  <AuthenticatedLayout>
    <template #header>
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
                <div class="flex my-4 lg:w-2/3 w-full mx-auto">
                  <div>
                    <!-- <input type="text" name="search" v-model="search" /> -->
                    <input type="text" name="search" :value="search" @input="search = $event.target.value" placeholder="氏名, カナ, TEL"/>
                    <button class="bg-blue-300 text-white py-2 px-2" @click="searchCustomers">
                      検索
                    </button>
                  </div>
                  <Link as="button" :href="route('customers.create')"
                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                    顧客登録
                  </Link>
                </div>

                <!-- result section -->
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <div v-if="customers.total === 1000">
                    <p>
                      検索結果: {{ 0 }} 件 (全件表示)
                    </p>
                  </div>
                  <div v-if="customers.total < 1000">
                    <p>
                      検索結果: {{ customers.total }} 件
                    </p>
                  </div>
                </div>

                <!-- table section -->
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
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
                      </tr>
                    </thead>
                    <tbody>
                      <tr :key="customer.id" v-for="customer in customers.data">
                        <td class="px-4 py-3 border-b-2 border-gray-200">
                          {{ customer.id }}
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
